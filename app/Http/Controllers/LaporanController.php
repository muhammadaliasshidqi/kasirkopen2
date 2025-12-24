<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->get('periode', 'harian');
        $tanggal = $request->get('tanggal', Carbon::today()->format('Y-m-d'));
        $bulan   = $request->get('bulan', Carbon::now()->format('Y-m'));

        $data = $this->getLaporanData($periode, $tanggal, $bulan);

        return view('laporan.index', compact('data', 'periode', 'tanggal', 'bulan'));
    }

    private function getLaporanData($periode, $tanggal, $bulan)
    {
        $query = Transaksi::with(['detailTransaksi.menu', 'kasir']);

        switch ($periode) {
            case 'harian':
                $query->whereDate('tanggal', $tanggal);
                $judul = 'Laporan Harian - ' . Carbon::parse($tanggal)->translatedFormat('d F Y');
                break;

            case 'bulanan':
                $query->whereYear('tanggal', Carbon::parse($bulan)->year)
                      ->whereMonth('tanggal', Carbon::parse($bulan)->month);
                $judul = 'Laporan Bulanan - ' . Carbon::parse($bulan)->translatedFormat('F Y');
                break;

            case 'tahunan':
                $tahun = Carbon::parse($bulan)->year;
                $query->whereYear('tanggal', $tahun);
                $judul = 'Laporan Tahunan - ' . $tahun;
                break;

            default:
                $query->whereDate('tanggal', $tanggal);
                $judul = 'Laporan Harian - ' . Carbon::parse($tanggal)->translatedFormat('d F Y');
        }

        $transaksis = $query->get();
        $totalPenjualan = $transaksis->sum('total');
        $totalTransaksi = $transaksis->count();

        // Metode pembayaran
        $metodePembayaran = $transaksis->groupBy('metode_pembayaran')
            ->map(fn($items) => [
                'jumlah' => $items->count(),
                'total'  => $items->sum('total')
            ]);

        // Menu terlaris - PERBAIKAN: Gunakan nama kolom yang benar
        $menuTerlaris = DB::table('detail_transaksi')
            ->join('menu', 'detail_transaksi.id_menu', '=', 'menu.id_menu') // ✅ Gunakan id_menu
            ->join('transaksi', 'detail_transaksi.id_transaksi', '=', 'transaksi.id_transaksi') // ✅ Gunakan id_transaksi
            ->when($periode == 'harian', fn($q) => $q->whereDate('transaksi.tanggal', $tanggal))
            ->when($periode == 'bulanan', fn($q) => $q->whereYear('transaksi.tanggal', Carbon::parse($bulan)->year)
                                                    ->whereMonth('transaksi.tanggal', Carbon::parse($bulan)->month))
            ->when($periode == 'tahunan', fn($q) => $q->whereYear('transaksi.tanggal', Carbon::parse($bulan)->year))
            ->selectRaw('
                menu.nama_menu,
                menu.kategori,
                SUM(detail_transaksi.jumlah) as total_terjual,
                SUM(detail_transaksi.subtotal) as total_pendapatan
            ')
            ->groupBy('menu.id_menu', 'menu.nama_menu', 'menu.kategori') // ✅ Gunakan id_menu
            ->orderByDesc('total_terjual')
            ->limit(10)
            ->get();

        return [
            'judul'            => $judul,
            'transaksis'       => $transaksis,
            'totalPenjualan'   => $totalPenjualan,
            'totalTransaksi'   => $totalTransaksi,
            'metodePembayaran' => $metodePembayaran,
            'menuTerlaris'     => $menuTerlaris,
        ];
    }

    // Export PDF
    public function exportPdf(Request $request)
    {
        $periode = $request->get('periode', 'harian');
        $tanggal = $request->get('tanggal', Carbon::today()->format('Y-m-d'));
        $bulan   = $request->get('bulan', Carbon::now()->format('Y-m'));

        $data = $this->getLaporanData($periode, $tanggal, $bulan);

        $pdf = Pdf::loadView('laporan.pdf', $data)
                  ->setPaper('a4', 'landscape');

        $filename = 'Laporan_' . ucfirst($periode) . '_' . date('Ymd_His') . '.pdf';

        return $pdf->download($filename);
    }

    public function exportExcel(Request $request)
    {
        return back()->with('info', 'Fitur export Excel akan segera hadir!');
    }

    public function save(Request $request)
    {
        $periode = $request->get('periode', 'harian');
        $tanggal = $request->get('tanggal', Carbon::today()->format('Y-m-d'));
        $bulan   = $request->get('bulan', Carbon::now()->format('Y-m'));

        $data = $this->getLaporanData($periode, $tanggal, $bulan);

        $start = $end = $tanggal;
        if ($periode == 'bulanan') {
            $start = Carbon::parse($bulan)->startOfMonth()->format('Y-m-d');
            $end   = Carbon::parse($bulan)->endOfMonth()->format('Y-m-d');
        } elseif ($periode == 'tahunan') {
            $tahun = Carbon::parse($bulan)->year;
            $start = "$tahun-01-01";
            $end   = "$tahun-12-31";
        }

        Laporan::create([
            'periode'          => $periode,
            'total_penjualan'  => $data['totalPenjualan'],
            'total_transaksi'  => $data['totalTransaksi'],
            'tanggal_mulai'    => $start,
            'tanggal_akhir'    => $end,
        ]);

        return back()->with('success', 'Laporan berhasil disimpan ke database!');
    }
}