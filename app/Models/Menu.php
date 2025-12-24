<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    protected $primaryKey = 'id_menu';
    
    protected $fillable = [
        'nama_menu',
        'harga',
        'stok',
        'kategori',
        'gambar',
        'deskripsi',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'integer',
    ];

    // Relasi ke Detail Transaksi
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_menu', 'id_menu');
    }

    // Accessor untuk format harga
    public function getHargaFormatAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    // Scope untuk filter kategori
    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    // Scope untuk cek stok tersedia
    public function scopeTersedia($query)
    {
        return $query->where('stok', '>', 0);
    }
}