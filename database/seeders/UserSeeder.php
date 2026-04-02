<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'mt_role_id' => 1, // Admin
                'mt_departements_id' => 1, // HR
                'mt_positions_id' => 1, // Manager
                'mt_username' => 'admin',
                'mt_useremail' => 'admin@example.com',
                'mt_userpass' => Hash::make('123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mt_role_id' => 2, // Mod
                'mt_departements_id' => 2, // IT
                'mt_positions_id' => 2, 
                'mt_username' => 'user',
                'mt_useremail' => 'user@example.com',
                'mt_userpass' => Hash::make('123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mt_role_id' => 2, // Mod
                'mt_departements_id' => 2, // IT
                'mt_positions_id' => 2, 
                'mt_username' => 'Moderator',
                'mt_useremail' => 'mod@example.com',
                'mt_userpass' => Hash::make('123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mt_role_id' => 3, 
                'mt_departements_id' => 5, 
                'mt_positions_id' => 4, 
                'mt_username' => 'Jepri',
                'mt_useremail' => 'jepri@example.com',
                'mt_userpass' => Hash::make('123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'mt_role_id' => 3, 
                'mt_departements_id' => 3, 
                'mt_positions_id' => 4,
                'mt_username' => 'Supri',
                'mt_useremail' => 'supri@example.com',
                'mt_userpass' => Hash::make('123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'mt_role_id' => 3, 
                'mt_departements_id' => 4, 
                'mt_positions_id' => 3, 
                'mt_username' => 'Kapri',
                'mt_useremail' => 'kapri@example.com',
                'mt_userpass' => Hash::make('123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'mt_role_id' => 3, 
                'mt_departements_id' => 6, 
                'mt_positions_id' => 4, 
                'mt_username' => 'Bonpri',
                'mt_useremail' => 'bonpri@example.com',
                'mt_userpass' => Hash::make('123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'mt_role_id' => 3, // User
                'mt_departements_id' => 2, // IT
                'mt_positions_id' => 2, // Staff
                'mt_username' => 'Popri',
                'mt_useremail' => 'popri@example.com',
                'mt_userpass' => Hash::make('123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
