<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use function Laravel\Prompts\password;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class ResetUserPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:reset-password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset a user password';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $username = text('What is the username of the account? (This is usually the computing ID.)', required: true);
        $password = password('What is the new password of the account?', required: true);
        $password_confirmation = password('Type the password again to confirm:', required: true);

        $data = compact('username', 'password', 'password_confirmation');

        $validator = Validator::make($data, [
            'username' => ['required', 'exists:users,username'],
            'password' => ['required', 'confirmed'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        User::where('username', $username)->update(
            [
                'password' => Hash::make($password),
            ]
        );

        $this->info("The password for user $username was successfully changed!");
        return 0;
    }
}
