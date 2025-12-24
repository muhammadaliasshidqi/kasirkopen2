<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('menu')->insert([
            [
                'nama_menu' => 'Nasi Goreng',
                'kategori' => 'Makanan',
                'harga' => 15000.00,
                'stok' => 50,
                'gambar' => null,
                'deskripsi' => 'Nasi goreng spesial dengan telur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu' => 'Mie Goreng',
                'kategori' => 'Makanan',
                'harga' => 12000.00,
                'stok' => 40,
                'gambar' => null,
                'deskripsi' => 'Mie goreng pedas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu' => 'Es Teh Manis',
                'kategori' => 'Minuman',
                'harga' => 5000.00,
                'stok' => 100,
                'gambar' => null,
                'deskripsi' => 'Es teh manis segar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu' => 'Ayam Goreng',
                'kategori' => 'Makanan',
                'harga' => 20000.00,
                'stok' => 30,
                'gambar' => null,
                'deskripsi' => 'Ayam goreng crispy',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu' => 'Jus Jeruk',
                'kategori' => 'Minuman',
                'harga' => 8000.00,
                'stok' => 50,
                'gambar' => null,
                'deskripsi' => 'Jus jeruk segar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}