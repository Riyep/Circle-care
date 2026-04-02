<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('positions')->insert([
            ['mt_positions_name' => 'Manager'],
            ['mt_positions_name' => 'Supervisor'],
            ['mt_positions_name' => 'Staff'],
            ['mt_positions_name' => 'Intern'],
            ['mt_positions_name' => 'Vendor'],
        ]);
    }
}
