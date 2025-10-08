<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SAML Service Provider Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for your application as a SAML Service Provider (SP).
    |
    */

    'sp' => [
        // Service Provider entity ID (usually your app URL)
        'entityId' => env('SAML_SP_ENTITY_ID', env('APP_URL')),

        // Service Provider Assertion Consumer Service endpoint
        'assertionConsumerService' => [
            'url' => env('SAML_SP_ACS_URL', env('APP_URL') . '/saml/acs'),
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
        ],

        // Service Provider Single Logout Service endpoint
        'singleLogoutService' => [
            'url' => env('SAML_SP_SLS_URL', env('APP_URL') . '/saml/sls'),
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ],

        // NameID format
        'NameIDFormat' => env('SAML_SP_NAME_ID_FORMAT', 'urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified'),

        // X.509 certificate and private key for SP
        'x509cert' => env('SAML_SP_CERT', ''),
        'privateKey' => env('SAML_SP_PRIVATE_KEY', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | SAML Identity Provider Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the SAML Identity Provider (IdP) you're connecting to.
    |
    */

    'idp' => [
        // Identity Provider entity ID
        'entityId' => env('SAML_IDP_ENTITY_ID'),

        // Identity Provider Single Sign-On Service endpoint
        'singleSignOnService' => [
            'url' => env('SAML_IDP_SSO_URL'),
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ],

        // Identity Provider Single Logout Service endpoint
        'singleLogoutService' => [
            'url' => env('SAML_IDP_SLS_URL'),
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ],

        // Identity Provider X.509 certificate
        'x509cert' => env('SAML_IDP_CERT'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Configuration
    |--------------------------------------------------------------------------
    |
    | Security settings for SAML authentication.
    |
    */

    'security' => [
        'nameIdEncrypted' => env('SAML_SECURITY_NAME_ID_ENCRYPTED', false),
        'authnRequestsSigned' => env('SAML_SECURITY_AUTHN_REQUESTS_SIGNED', false),
        'logoutRequestSigned' => env('SAML_SECURITY_LOGOUT_REQUEST_SIGNED', false),
        'logoutResponseSigned' => env('SAML_SECURITY_LOGOUT_RESPONSE_SIGNED', false),
        'signMetadata' => env('SAML_SECURITY_SIGN_METADATA', false),
        'wantMessagesSigned' => env('SAML_SECURITY_WANT_MESSAGES_SIGNED', false),
        'wantAssertionsEncrypted' => env('SAML_SECURITY_WANT_ASSERTIONS_ENCRYPTED', false),
        'wantAssertionsSigned' => env('SAML_SECURITY_WANT_ASSERTIONS_SIGNED', false),
        'wantNameId' => env('SAML_SECURITY_WANT_NAME_ID', true),
        'wantNameIdEncrypted' => env('SAML_SECURITY_WANT_NAME_ID_ENCRYPTED', false),
        'requestedAuthnContext' => env('SAML_SECURITY_REQUESTED_AUTHN_CONTEXT', true),
        'wantXMLValidation' => env('SAML_SECURITY_WANT_XML_VALIDATION', true),
        'relaxDestinationValidation' => env('SAML_SECURITY_RELAX_DESTINATION_VALIDATION', false),
        'destinationStrictlyMatches' => env('SAML_SECURITY_DESTINATION_STRICTLY_MATCHES', false),
        'allowRepeatAttributeName' => env('SAML_SECURITY_ALLOW_REPEAT_ATTRIBUTE_NAME', false),
        'rejectUnsolicitedResponsesWithInResponseTo' => env('SAML_SECURITY_REJECT_UNSOLICITED_RESPONSES_WITH_IN_RESPONSE_TO', false),
        'signatureAlgorithm' => env('SAML_SECURITY_SIGNATURE_ALGORITHM', 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256'),
        'digestAlgorithm' => env('SAML_SECURITY_DIGEST_ALGORITHM', 'http://www.w3.org/2001/04/xmlenc#sha256'),
        'lowercaseUrlencoding' => env('SAML_SECURITY_LOWERCASE_URL_ENCODING', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | User Attribute Mapping
    |--------------------------------------------------------------------------
    |
    | Map SAML attributes to User model fields. Configure these based on
    | the attributes your IdP sends in the SAML assertion.
    |
    */

    'user_mapping' => [
        'username' => env('SAML_ATTR_USERNAME', 'uid'),
        'email' => env('SAML_ATTR_EMAIL', 'mail'),
        'first_name' => env('SAML_ATTR_FIRST_NAME', 'givenName'),
        'last_name' => env('SAML_ATTR_LAST_NAME', 'sn'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Auto-provisioning
    |--------------------------------------------------------------------------
    |
    | Automatically create users if they don't exist in the database.
    |
    */

    'auto_provision' => env('SAML_AUTO_PROVISION', true),

    /*
    |--------------------------------------------------------------------------
    | SAML Enabled
    |--------------------------------------------------------------------------
    |
    | Determines if SAML authentication is enabled. SAML is considered enabled
    | only if the IDP entity ID is configured.
    |
    */

    'enabled' => !empty(env('SAML_IDP_ENTITY_ID')),
];
