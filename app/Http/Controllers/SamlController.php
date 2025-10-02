<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use OneLogin\Saml2\Auth as Saml2Auth;
use OneLogin\Saml2\Error as Saml2Error;

class SamlController extends Controller
{
    /**
     * Get SAML configuration array for OneLogin library
     */
    private function getSamlConfig(): array
    {
        // Ensure SAML library uses the correct HTTPS scheme
        if (request()->secure()) {
            $_SERVER['HTTPS'] = 'on';
            $_SERVER['SERVER_PORT'] = 443;
        }

        $config = config('saml');

        return [
            'sp' => [
                'entityId' => $config['sp']['entityId'],
                'assertionConsumerService' => [
                    'url' => $config['sp']['assertionConsumerService']['url'],
                    'binding' => $config['sp']['assertionConsumerService']['binding'],
                ],
                'singleLogoutService' => [
                    'url' => $config['sp']['singleLogoutService']['url'],
                    'binding' => $config['sp']['singleLogoutService']['binding'],
                ],
                'NameIDFormat' => $config['sp']['NameIDFormat'],
                'x509cert' => $config['sp']['x509cert'],
                'privateKey' => $config['sp']['privateKey'],
            ],
            'idp' => [
                'entityId' => $config['idp']['entityId'],
                'singleSignOnService' => [
                    'url' => $config['idp']['singleSignOnService']['url'],
                    'binding' => $config['idp']['singleSignOnService']['binding'],
                ],
                'singleLogoutService' => [
                    'url' => $config['idp']['singleLogoutService']['url'],
                    'binding' => $config['idp']['singleLogoutService']['binding'],
                ],
                'x509cert' => $config['idp']['x509cert'],
            ],
            'security' => $config['security'],
        ];
    }

    /**
     * Initiate SAML login
     */
    public function login(Request $request): RedirectResponse
    {
        try {
            $auth = new Saml2Auth($this->getSamlConfig());
            $returnTo = $request->query('next', route('index'));

            // Store the return URL in session
            session(['saml_return_to' => $returnTo]);

            $auth->login($returnTo);

            // This line won't be reached as login() redirects
            return redirect('/');
        } catch (Saml2Error $e) {
            Log::error('SAML login error: ' . $e->getMessage());
            return redirect()->route('login_page')->withErrors(['saml' => 'SAML authentication failed.']);
        }
    }

    /**
     * Assertion Consumer Service - Handle SAML response
     */
    public function acs(Request $request): RedirectResponse
    {
        try {
            $auth = new Saml2Auth($this->getSamlConfig());
            $auth->processResponse();

            $errors = $auth->getErrors();

            if (!empty($errors)) {
                Log::error('SAML ACS errors: ' . implode(', ', $errors));
                Log::error('Last error reason: ' . $auth->getLastErrorReason());
                return redirect()->route('login_page')->withErrors(['saml' => 'SAML authentication failed.']);
            }

            if (!$auth->isAuthenticated()) {
                return redirect()->route('login_page')->withErrors(['saml' => 'User not authenticated.']);
            }

            // Get user attributes from SAML assertion
            $attributes = $auth->getAttributes();
            $nameId = $auth->getNameId();

            // Map SAML attributes to user fields
            $mapping = config('saml.user_mapping');

            $username = $this->getAttribute($attributes, $mapping['username'], $nameId);
            $email = $this->getAttribute($attributes, $mapping['email']);
            $firstName = $this->getAttribute($attributes, $mapping['first_name']);
            $lastName = $this->getAttribute($attributes, $mapping['last_name']);

            // Find or create user
            $user = User::where('username', $username)->first();

            if (!$user) {
                if (!config('saml.auto_provision')) {
                    Log::warning('SAML user not found and auto-provisioning is disabled: ' . $username);
                    return redirect()->route('login_page')->withErrors(['saml' => 'User account not found.']);
                }

                // Auto-provision new user
                $user = User::create([
                    'username' => $username,
                    'email' => $email,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'password' => bcrypt(bin2hex(random_bytes(32))), // Random password
                ]);

                Log::info('SAML user auto-provisioned: ' . $username);
            } else {
                // Update existing user's information
                $user->update([
                    'email' => $email ?: $user->email,
                    'first_name' => $firstName ?: $user->first_name,
                    'last_name' => $lastName ?: $user->last_name,
                ]);
            }

            // Log the user in
            Auth::login($user);
            $request->session()->regenerate();

            // Get return URL from session or default
            $returnTo = session('saml_return_to', route('index'));
            session()->forget('saml_return_to');

            return redirect($returnTo);

        } catch (Saml2Error $e) {
            Log::error('SAML ACS error: ' . $e->getMessage());
            return redirect()->route('login_page')->withErrors(['saml' => 'SAML authentication failed.']);
        }
    }

    /**
     * Initiate SAML logout
     */
    public function logout(Request $request): RedirectResponse
    {
        try {
            $auth = new Saml2Auth($this->getSamlConfig());

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $returnTo = route('index');
            $auth->logout($returnTo);

            // This line won't be reached as logout() redirects
            return redirect($returnTo);
        } catch (Saml2Error $e) {
            Log::error('SAML logout error: ' . $e->getMessage());

            // Fallback to local logout
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('index');
        }
    }

    /**
     * Single Logout Service - Handle SAML logout response
     */
    public function sls(Request $request): RedirectResponse
    {
        try {
            $auth = new Saml2Auth($this->getSamlConfig());
            $auth->processSLO();

            $errors = $auth->getErrors();

            if (!empty($errors)) {
                Log::error('SAML SLS errors: ' . implode(', ', $errors));
            }

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('index');
        } catch (Saml2Error $e) {
            Log::error('SAML SLS error: ' . $e->getMessage());

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('index');
        }
    }

    /**
     * Provide SAML metadata
     */
    public function metadata(): Response
    {
        try {
            $auth = new Saml2Auth($this->getSamlConfig());
            $settings = $auth->getSettings();
            $metadata = $settings->getSPMetadata();
            $errors = $settings->validateMetadata($metadata);

            if (!empty($errors)) {
                Log::error('SAML metadata errors: ' . implode(', ', $errors));
                abort(500, 'Error generating metadata');
            }

            return response($metadata, 200, ['Content-Type' => 'text/xml']);
        } catch (Saml2Error $e) {
            Log::error('SAML metadata error: ' . $e->getMessage());
            abort(500, 'Error generating metadata');
        }
    }

    /**
     * Helper method to get attribute value from SAML response
     */
    private function getAttribute(array $attributes, string $key, ?string $default = null): ?string
    {
        if (!isset($attributes[$key])) {
            return $default;
        }

        $value = $attributes[$key];

        // SAML attributes can be arrays
        if (is_array($value)) {
            return $value[0] ?? $default;
        }

        return $value ?: $default;
    }
}
