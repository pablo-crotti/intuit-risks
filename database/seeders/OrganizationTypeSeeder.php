<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('organization_types')->insert([
            [
                'name' => 'Entreprise',
                'created_at' => now(),
            ], [
                'name' => 'Administration publique',
                'created_at' => now(),
            ], [
                'name' => 'Institution médico-sociale',
                'created_at' => now(),
            ],
        ]);
    }
}
