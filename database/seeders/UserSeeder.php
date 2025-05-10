<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'username' => 'admin',
                'email' => 'root@localhost',
                'password' => Hash::make('password1234'),
                'hidden' => true,
                'is_admin' => true
            ],
            [
                'first_name' => 'Karan',
                'last_name' => 'Rawat',
                'username' => 'rce9je',
                'email' => 'rce9je@virginia.edu',
                'password' => Hash::make('password1234'),
                'hidden' => false,
                'is_admin' => false
            ],
            [
                'first_name' => 'Varun',
                'last_name' => 'Vejalla',
                'username' => 'cgm5sa',
                'email' => 'cgm5sa@virginia.edu',
                'password' => Hash::make('password1234'),
                'hidden' => false,
                'is_admin' => false
            ],
            [
                'first_name' => 'Chloe',
                'last_name' => 'Hutchinson',
                'username' => 'ekm5sd',
                'email' => 'ekm5sd@virginia.edu',
                'password' => Hash::make('password1234'),
                'hidden' => false,
                'is_admin' => false
            ],
            [
                'first_name' => 'Miya',
                'last_name' => 'Livingston',
                'username' => 'jqk5ct',
                'email' => 'jqk5ct@virginia.edu',
                'password' => Hash::make('password1234'),
                'hidden' => false,
                'is_admin' => false
            ],
            [
                'first_name' => 'Shreyas',
                'last_name' => 'Mayya',
                'username' => 'eav6vg',
                'email' => 'eav6vg@virginia.edu',
                'password' => Hash::make('password1234'),
                'hidden' => false,
                'is_admin' => false
            ],
            [
                'first_name' => 'Yafet',
                'last_name' => 'Getachew',
                'username' => 'dxw2ds',
                'email' => 'dxw2ds@virginia.edu',
                'password' => Hash::make('password1234'),
                'hidden' => false,
                'is_admin' => false
            ],
            [
                'first_name' => 'Oscar',
                'last_name' => 'Ingram',
                'username' => 'bkh3jf',
                'email' => 'bkh3jf@virginia.edu',
                'password' => Hash::make('password1234'),
                'hidden' => false,
                'is_admin' => false
            ],
            [
                'first_name' => 'Hari',
                'last_name' => 'Gajjala',
                'username' => 'uyf9an',
                'email' => 'uyf9an@virginia.edu',
                'password' => Hash::make('password1234'),
                'hidden' => false,
                'is_admin' => false
            ],
            [
                'first_name' => 'Nicholas',
                'last_name' => 'Winschel',
                'username' => 'pvz6tx',
                'email' => 'pvz6tx@virginia.edu',
                'password' => Hash::make('password1234'),
                'hidden' => false,
                'is_admin' => false
            ],
        ];
        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
