<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['mt_roles_name' => 'Admin'],
            ['mt_roles_name' => 'Mod'],
            ['mt_roles_name' => 'User'],
        ]);
    }
}
