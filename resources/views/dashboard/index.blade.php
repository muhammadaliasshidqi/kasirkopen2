@extends('components.app')

@section('title', 'Dashboard - Sistem Kasir Modern')

@push('styles')
<style>
    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: rgba(0, 0, 0, 0.05);
        border-radius: 50%;
        transform: translate(30%, -30%);
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        border-color: #000;
    }
    
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    .pulse-animation {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: .7; }
    }
    
    .gradient-bg {
        background: #f9fafb;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen gradient-bg py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <div class="glass-card rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-black text-gray-900 mb-2">
                            👋 Selamat Datang!
                        </h1>
                        <p class="text-xl text-gray-700 font-medium">
                            {{ auth()->guard('kasir')->user()->nama_kasir }}
                        </p>
                        <p class="text-sm text-gray-500 mt-1 font-mono">
                            <i class="fas fa-calendar-alt mr-2"></i>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                        </p>
                    </div>
                    <div class="hidden md:block">
                        <div class="w-24 h-24 bg-black rounded-xl flex items-center justify-center shadow-lg transform rotate-3 transition-transform hover:rotate-6">
                            <span class="text-white text-4xl font-bold">{{ substr(auth()->guard('kasir')->user()->nama_kasir, 0, 1) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Penjualan Hari Ini -->
            <div class="stat-card glass-card rounded-xl p-6 shadow-sm border border-transparent">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-black rounded-lg flex items-center justify-center shadow-sm">
                        <i class="fas fa-money-bill-wave text-white text-lg"></i>
                    </div>
                    <span class="text-xs font-bold text-black bg-gray-200 px-3 py-1.5 rounded-full pulse-animation">
                        HARI INI
                    </span>
                </div>
                <h3 class="text-gray-500 text-xs font-bold mb-2 uppercase tracking-widest">Penjualan Hari Ini</h3>
                <p class="text-3xl font-black text-gray-900 mb-1">
                    Rp {{ number_format($penjualanHariIni, 0, ',', '.') }}
                </p>
                <div class="flex items-center text-gray-900 text-sm font-bold mt-2">
                    <i class="fas fa-arrow-up mr-1"></i>
                    <span>{{ $transaksiHariIni }} Transaksi</span>
                </div>
            </div>

            <!-- Transaksi Hari Ini -->
            <div class="stat-card glass-card rounded-xl p-6 shadow-sm border border-transparent">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gray-800 rounded-lg flex items-center justify-center shadow-sm">
                        <i class="fas fa-shopping-cart text-white text-lg"></i>
                    </div>
                    <span class="text-xs font-bold text-gray-700 bg-gray-100 px-3 py-1.5 rounded-full pulse-animation">
                        HARI INI
                    </span>
                </div>
                <h3 class="text-gray-500 text-xs font-bold mb-2 uppercase tracking-widest">Total Transaksi</h3>
                <p class="text-3xl font-black text-gray-900 mb-1">{{ $transaksiHariIni }}</p>
                <div class="flex items-center text-gray-900 text-sm font-bold mt-2">
                    <i class="fas fa-receipt mr-1"></i>
                    <span>Transaksi Selesai</span>
                </div>
            </div>

            <!-- Menu Tersedia -->
            <div class="stat-card glass-card rounded-xl p-6 shadow-sm border border-transparent">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gray-700 rounded-lg flex items-center justify-center shadow-sm">
                        <i class="fas fa-utensils text-white text-lg"></i>
                    </div>
                    <span class="text-xs font-bold text-gray-600 bg-gray-100 px-3 py-1.5 rounded-full">
                        STOK
                    </span>
                </div>
                <h3 class="text-gray-500 text-xs font-bold mb-2 uppercase tracking-widest">Menu Tersedia</h3>
                <p class="text-3xl font-black text-gray-900 mb-1">{{ $totalMenu }}</p>
                <div class="flex items-center text-gray-700 text-sm font-bold mt-2">
                    <i class="fas fa-box mr-1"></i>
                    <span>Item Menu</span>
                </div>
            </div>

            <!-- Penjualan Bulan Ini -->
            <div class="stat-card glass-card rounded-xl p-6 shadow-sm border border-transparent">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gray-900 rounded-lg flex items-center justify-center shadow-sm">
                        <i class="fas fa-chart-line text-white text-lg"></i>
                    </div>
                    <span class="text-xs font-bold text-gray-800 bg-gray-200 px-3 py-1.5 rounded-full">
                        BULAN INI
                    </span>
                </div>
                <h3 class="text-gray-500 text-xs font-bold mb-2 uppercase tracking-widest">Penjualan Bulan Ini</h3>
                <p class="text-3xl font-black text-gray-900 mb-1">
                    Rp {{ number_format($penjualanBulanIni, 0, ',', '.') }}
                </p>
                <div class="flex items-center text-gray-800 text-sm font-bold mt-2">
                    <i class="fas fa-calendar-alt mr-1"></i>
                    <span>{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Chart Penjualan 7 Hari -->
            <div class="lg:col-span-2 glass-card rounded-xl p-8 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                        <div class="w-10 h-10 bg-black rounded-lg flex items-center justify-center mr-3 shadow-sm">
                            <i class="fas fa-chart-bar text-white"></i>
                        </div>
                        Grafik Penjualan 7 Hari
                    </h2>
                    <span class="text-xs font-bold text-black bg-gray-100 px-3 py-1.5 rounded-full border border-gray-200">
                        TREN MINGGUAN
                    </span>
                </div>
                <div class="bg-white rounded-lg p-4 border border-gray-100">
                    <canvas id="salesChart" height="100"></canvas>
                </div>
            </div>

            <!-- Menu Terlaris -->
            <div class="glass-card rounded-xl p-8 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                        <div class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                            <i class="fas fa-fire text-white"></i>
                        </div>
                        Top Menu
                    </h2>
                </div>
                <div class="space-y-3">
                    @forelse($menuTerlaris as $menu)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-black transition-colors">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-black rounded-lg flex items-center justify-center text-white font-black text-lg shadow-sm">
                                    {{ $loop->iteration }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $menu->nama_menu }}</p>
                                    <p class="text-xs text-gray-600 font-bold uppercase tracking-wide">
                                        {{ $menu->total_terjual }} terjual
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-utensils text-gray-400 text-3xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Belum ada data menu terlaris</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Transaksi Terbaru -->
        <div class="mt-6 glass-card rounded-xl p-8 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                    <div class="w-10 h-10 bg-black rounded-lg flex items-center justify-center mr-3 shadow-sm">
                        <i class="fas fa-history text-white"></i>
                    </div>
                    Transaksi Terbaru
                </h2>
                <a href="{{ route('transaksi.history') }}" class="flex items-center gap-2 bg-black text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-800 transition-all text-sm uppercase tracking-wide">
                    Lihat Semua 
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-black text-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">ID Transaksi</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Tanggal & Waktu</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Kasir</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Total</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Metode</th>
                                <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($transaksiTerbaru as $transaksi)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="font-mono font-bold text-black border-b-2 border-gray-200">#{{ $transaksi->id_transaksi }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-gray-900">{{ $transaksi->tanggal->format('d/m/Y') }}</span>
                                            <span class="text-xs text-gray-500 font-mono">{{ $transaksi->tanggal->format('H:i:s') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center mr-2">
                                                <span class="text-gray-700 font-bold text-xs">{{ substr($transaksi->kasir->nama_kasir, 0, 1) }}</span>
                                            </div>
                                            <span class="font-bold text-gray-900">{{ $transaksi->kasir->nama_kasir }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-black text-lg text-gray-900">
                                            Rp {{ number_format($transaksi->total, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 text-xs font-bold rounded border border-gray-200 shadow-sm
                                            @if($transaksi->metode_pembayaran === 'tunai') bg-white text-gray-900
                                            @elseif($transaksi->metode_pembayaran === 'qris') bg-gray-800 text-white
                                            @else bg-gray-100 text-gray-600
                                            @endif uppercase tracking-wide">
                                            {{ ucfirst($transaksi->metode_pembayaran) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('transaksi.show', $transaksi) }}" 
                                           class="inline-flex items-center justify-center w-10 h-10 bg-white border-2 border-gray-200 text-gray-700 rounded-lg hover:border-black hover:text-black transition-all">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <i class="fas fa-receipt text-gray-400 text-4xl"></i>
                                            </div>
                                            <p class="text-gray-500 text-lg font-bold">Belum ada transaksi hari ini</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart Penjualan dengan styling modern monochrome
    const ctx = document.getElementById('salesChart').getContext('2d');
    const chartData = @json($chartData);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.map(item => item.tanggal),
            datasets: [{
                label: 'Penjualan',
                data: chartData.map(item => item.total),
                borderColor: '#000000', // Black
                backgroundColor: function(context) {
                    const chart = context.chart;
                    const {ctx, chartArea} = chart;
                    if (!chartArea) {
                        return null;
                    }
                    const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                    gradient.addColorStop(0, 'rgba(0, 0, 0, 0.2)'); // Light gray
                    gradient.addColorStop(1, 'rgba(0, 0, 0, 0.0)');
                    return gradient;
                },
                tension: 0.3,
                fill: true,
                borderWidth: 2,
                pointBackgroundColor: '#000000',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#000000',
                    padding: 12,
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    titleFont: {
                        family: "'Inter', sans-serif",
                        size: 13,
                        weight: 'bold'
                    },
                    bodyFont: {
                        family: "'Inter', sans-serif",
                        size: 12
                    },
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f3f4f6',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#6b7280',
                        font: {
                            family: "'Inter', sans-serif",
                            weight: 'bold',
                            size: 11
                        },
                        callback: function(value) {
                            return 'Rp ' + (value/1000) + 'K';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        color: '#6b7280',
                        font: {
                            family: "'Inter', sans-serif",
                            weight: 'bold',
                            size: 11
                        }
                    }
                }
            }
        }
    });
</script>
@endpush