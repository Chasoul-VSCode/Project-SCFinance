<?php

namespace Database\Seeders;

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
        DB::table('users')->insert([
            [
                'username' => 'chasoul',
                'password' => Hash::make('131122'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'cia',
                'password' => Hash::make('131122'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}