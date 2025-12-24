<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KasirSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kasir')->insert([
            [
                'nama_kasir' => 'Admin Kasir',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kasir' => 'Azis',
                'username' => 'azis',
                'password' => Hash::make('azis123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}