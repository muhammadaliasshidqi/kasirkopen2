<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Menu;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        // Data statistik
        $penjualanHariIni = Transaksi::whereDate('tanggal', $today)->sum('total');
        $transaksiHariIni = Transaksi::whereDate('tanggal', $today)->count();
        $totalMenu = Menu::count();
        $penjualanBulanIni = Transaksi::whereMonth('tanggal', $today->month)
                                      ->whereYear('tanggal', $today->year)
                                      ->sum('total');
        
        // Menu terlaris (dummy data untuk sementara)
        $menuTerlaris = collect([]);
        
        // Chart data 7 hari terakhir (dummy data)
        $chartData = collect([]);
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $total = Transaksi::whereDate('tanggal', $date)->sum('total');
            $chartData->push([
                'tanggal' => $date->format('d M'),
                'total' => $total
            ]);
        }
        
        // Transaksi terbaru
        $transaksiTerbaru = Transaksi::with('kasir')
                                     ->latest('tanggal')
                                     ->take(5)
                                     ->get();
        
        return view('dashboard.index', compact(
            'penjualanHariIni',
            'transaksiHariIni',
            'totalMenu',
            'penjualanBulanIni',
            'menuTerlaris',
            'chartData',
            'transaksiTerbaru'
        ));
    }
}