<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;



class IntuitRisksAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@intuit-risks.ch',
            'password' => Hash::make('1n7ui7-r1sK'),
            'is_admin' => true,
            'is_active' => true,
            'is_intuitrisks_admin' => true
        ]);
    }
}
