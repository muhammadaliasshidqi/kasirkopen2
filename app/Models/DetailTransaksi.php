<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi';
    
    protected $fillable = [
        'id_transaksi',
        'id_menu',
        'jumlah',
        'harga_satuan',
        'subtotal',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'harga_satuan' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Relasi ke Transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }

    // Relasi ke Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu', 'id_menu');
    }

    // Accessor untuk format harga satuan
    public function getHargaSatuanFormatAttribute()
    {
        return 'Rp ' . number_format($this->harga_satuan, 0, ',', '.');
    }

    // Accessor untuk format subtotal
    public function getSubtotalFormatAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }
}