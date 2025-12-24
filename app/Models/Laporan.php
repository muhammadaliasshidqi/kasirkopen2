<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';
    protected $primaryKey = 'id_laporan';
    
    protected $fillable = [
        'periode',
        'total_penjualan',
        'total_transaksi',
        'tanggal_mulai',
        'tanggal_akhir',
    ];

    protected $casts = [
        'total_penjualan' => 'decimal:2',
        'total_transaksi' => 'integer',
        'tanggal_mulai' => 'date',
        'tanggal_akhir' => 'date',
    ];

    public static function generateLaporan($tanggalMulai, $tanggalAkhir, $periode = 'custom')
    {
        $transaksi = Transaksi::byPeriode($tanggalMulai, $tanggalAkhir)->get();
        
        $laporan = self::create([
            'periode' => $periode,
            'total_penjualan' => $transaksi->sum('total'),
            'total_transaksi' => $transaksi->count(),
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_akhir' => $tanggalAkhir,
        ]);

        return $laporan;
    }

    public function tampilkan()
    {
        return [
            'periode' => $this->periode,
            'total_penjualan' => $this->total_penjualan,
            'total_transaksi' => $this->total_transaksi,
            'tanggal_mulai' => $this->tanggal_mulai->format('d/m/Y'),
            'tanggal_akhir' => $this->tanggal_akhir->format('d/m/Y'),
        ];
    }
}