<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;
use function Laravel\Prompts\password;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $firstName = text('What is the user\'s first name?', required: true);
        $lastName = text('What is the user\'s last name?', required: true);
        $username = text('What is the username of the new account? (This is usually the computing ID.)', required: true);
        $email = text('What is the user\'s email?', default: ($username . '@virginia.edu'), required: true);
        $password = password('What is the password of the new account?', required: true);
        $passwordConfirmation = password('Type the password again to confirm:', required: true);
        $isAdmin = select('Is this user an administrator?', options: [
            true => 'Yes',
            false => 'No'
        ], default: false);

        $data = compact('firstName', 'lastName', 'username', 'email', 'password', 'passwordConfirmation');

        $validator = Validator::make($data, [
            'firstName' => ['required'],
            'lastName' => ['required'],
            'username' => ['required', 'unique:users,username'],
            'email' => ['required', 'email:rfc'],
            'password' => ['required', 'confirmed:passwordConfirmation'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password),
            'is_admin' => $isAdmin,
        ]);

        $this->info("The user $username was successfully created!");
        return 0;
    }

}
