<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartementSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('departements')->insert([
            ['mt_departements_name' => 'IT'],
            ['mt_departements_name' => 'Human Resource'],
            ['mt_departements_name' => 'Accounting'],
            ['mt_departements_name' => 'Operational'],
            ['mt_departements_name' => 'Area'],
            ['mt_departements_name' => 'Marketing'],
            ['mt_departements_name' => 'Fleet'],
        ]);
    }
}
