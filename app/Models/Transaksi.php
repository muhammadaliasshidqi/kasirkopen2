<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    
    protected $fillable = [
        'tanggal',
        'total',
        'id_kasir',
        'metode_pembayaran',
        'bayar',
        'kembalian',
        'bukti_pembayaran',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'total' => 'decimal:2',
        'bayar' => 'decimal:2',
        'kembalian' => 'decimal:2',
    ];

    // Relasi ke Kasir
    public function kasir()
    {
        return $this->belongsTo(Kasir::class, 'id_kasir', 'id_kasir');
    }

    // Relasi ke Detail Transaksi
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id_transaksi');
    }

    // Accessor untuk format total
    public function getTotalFormatAttribute()
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    // Accessor untuk format bayar
    public function getBayarFormatAttribute()
    {
        return 'Rp ' . number_format($this->bayar, 0, ',', '.');
    }

    // Accessor untuk format kembalian
    public function getKembalianFormatAttribute()
    {
        return 'Rp ' . number_format($this->kembalian, 0, ',', '.');
    }

    // Scope untuk filter berdasarkan tanggal
    public function scopeByTanggal($query, $tanggal)
    {
        return $query->whereDate('tanggal', $tanggal);
    }

    // Scope untuk filter berdasarkan periode
    public function scopeByPeriode($query, $start, $end)
    {
        return $query->whereBetween('tanggal', [$start, $end]);
    }
}