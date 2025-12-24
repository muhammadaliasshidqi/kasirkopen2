@extends('components.app')

@section('title', 'Laporan Penjualan - Sistem Kasir Modern')

@push('styles')
<style>
    @media print {
        .no-print {
            display: none !important;
        }
        body {
            background: white !important;
        }
        .card {
            box-shadow: none !important;
            border: 1px solid #000;
        }
    }
    
    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        border: 1px solid transparent;
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
    
    .gradient-bg {
        background: #f9fafb;
    }
    
    .pulse-animation {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: .7; }
    }
</style>
@endpush

@section('content')
<div class="min-h-screen gradient-bg py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8 no-print">
            <div class="glass-card rounded-xl p-6 shadow-sm">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-4xl font-black text-gray-900">
                            📊 Laporan Penjualan
                        </h1>
                        <p class="text-xl text-gray-500 font-medium">Analisis dan laporan penjualan lengkap</p>
                        <p class="text-sm text-gray-400 mt-1 font-mono">
                            <i class="fas fa-calendar-alt mr-2"></i>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <button onclick="window.print()" class="flex items-center gap-2 bg-black text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-800 transition-all uppercase tracking-wide text-sm">
                            <i class="fas fa-print"></i>
                            Print
                        </button>
                        <a href="{{ route('laporan.pdf', request()->all()) }}" 
                           class="flex items-center gap-2 bg-white text-gray-900 border-2 border-gray-200 px-6 py-3 rounded-lg font-bold hover:border-black hover:text-black transition-all uppercase tracking-wide text-sm">
                            <i class="fas fa-file-pdf"></i>
                            Export PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="mb-6 glass-card rounded-xl p-4 border-l-4 border-black shadow-sm no-print">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-black rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                    </div>
                    <p class="text-gray-900 font-bold">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('info'))
            <div class="mb-6 glass-card rounded-xl p-4 border-l-4 border-gray-500 shadow-sm no-print">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-info-circle text-gray-600 text-xl"></i>
                    </div>
                    <p class="text-gray-700 font-bold">{{ session('info') }}</p>
                </div>
            </div>
        @endif

        <!-- Filter -->
        <div class="glass-card rounded-xl p-8 mb-8 shadow-sm no-print">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-900 flex items-center">
                    <div class="w-10 h-10 bg-black rounded-lg flex items-center justify-center mr-3 shadow-sm">
                        <i class="fas fa-filter text-white"></i>
                    </div>
                    Filter Laporan
                </h3>
            </div>
            <form method="GET" action="{{ route('laporan.index') }}" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Periode -->
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-3 uppercase tracking-wide">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            Periode
                        </label>
                        <select name="periode" id="periodeSelect" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-black focus:border-black transition font-bold bg-white text-gray-900">
                            <option value="harian" {{ $periode == 'harian' ? 'selected' : '' }}>📅 Harian</option>
                            <option value="bulanan" {{ $periode == 'bulanan' ? 'selected' : '' }}>📆 Bulanan</option>
                            <option value="tahunan" {{ $periode == 'tahunan' ? 'selected' : '' }}>📊 Tahunan</option>
                        </select>
                    </div>

                    <!-- Tanggal (untuk harian) -->
                    <div id="tanggalInput" class="{{ $periode != 'harian' ? 'hidden' : '' }}">
                        <label class="block text-sm font-bold text-gray-900 mb-3 uppercase tracking-wide">
                            <i class="fas fa-calendar-day mr-2"></i>
                            Tanggal
                        </label>
                        <input type="date" name="tanggal" value="{{ $tanggal }}" 
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-black focus:border-black transition font-bold bg-white text-gray-900">
                    </div>

                    <!-- Bulan (untuk bulanan/tahunan) -->
                    <div id="bulanInput" class="{{ $periode == 'harian' ? 'hidden' : '' }}">
                        <label class="block text-sm font-bold text-gray-900 mb-3 uppercase tracking-wide">
                            <i class="fas fa-calendar mr-2"></i>
                            {{ $periode == 'tahunan' ? 'Tahun' : 'Bulan' }}
                        </label>
                        <input type="month" name="bulan" value="{{ $bulan }}" 
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-black focus:border-black transition font-bold bg-white text-gray-900">
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="flex items-center gap-2 bg-black text-white px-8 py-3 rounded-lg font-bold hover:bg-gray-800 transition-all uppercase tracking-wide text-sm">
                        <i class="fas fa-search"></i>
                        Tampilkan Laporan
                    </button>
                    <a href="{{ route('laporan.index') }}" class="flex items-center gap-2 bg-white text-gray-900 px-8 py-3 rounded-lg font-bold hover:bg-gray-50 transition-all border-2 border-gray-200 uppercase tracking-wide text-sm">
                        <i class="fas fa-redo"></i>
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="stat-card glass-card rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-black rounded-lg flex items-center justify-center shadow-sm">
                        <i class="fas fa-money-bill-wave text-white text-lg"></i>
                    </div>
                    <span class="text-xs font-bold text-black bg-gray-200 px-3 py-1.5 rounded-full pulse-animation border border-gray-300">
                        PENDAPATAN
                    </span>
                </div>
                <h3 class="text-gray-500 text-xs font-bold mb-2 uppercase tracking-widest">Total Penjualan</h3>
                <p class="text-3xl font-black text-gray-900 mb-1">
                    Rp {{ number_format($data['totalPenjualan'], 0, ',', '.') }}
                </p>
                <div class="flex items-center text-gray-900 text-sm font-bold mt-2">
                    <i class="fas fa-arrow-up mr-1"></i>
                    <span>Pendapatan Periode Ini</span>
                </div>
            </div>

            <div class="stat-card glass-card rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gray-800 rounded-lg flex items-center justify-center shadow-sm">
                        <i class="fas fa-shopping-cart text-white text-lg"></i>
                    </div>
                    <span class="text-xs font-bold text-gray-800 bg-gray-200 px-3 py-1.5 rounded-full pulse-animation border border-gray-300">
                        TRANSAKSI
                    </span>
                </div>
                <h3 class="text-gray-500 text-xs font-bold mb-2 uppercase tracking-widest">Total Transaksi</h3>
                <p class="text-3xl font-black text-gray-900 mb-1">{{ $data['totalTransaksi'] }}</p>
                <div class="flex items-center text-gray-800 text-sm font-bold mt-2">
                    <i class="fas fa-receipt mr-1"></i>
                    <span>Jumlah Transaksi</span>
                </div>
            </div>

            <div class="stat-card glass-card rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gray-600 rounded-lg flex items-center justify-center shadow-sm">
                        <i class="fas fa-chart-line text-white text-lg"></i>
                    </div>
                    <span class="text-xs font-bold text-gray-600 bg-gray-100 px-3 py-1.5 rounded-full border border-gray-300">
                        RATA-RATA
                    </span>
                </div>
                <h3 class="text-gray-500 text-xs font-bold mb-2 uppercase tracking-widest">Rata-rata Transaksi</h3>
                <p class="text-3xl font-black text-gray-900 mb-1">
                    Rp {{ $data['totalTransaksi'] > 0 ? number_format($data['totalPenjualan'] / $data['totalTransaksi'], 0, ',', '.') : 0 }}
                </p>
                <div class="flex items-center text-gray-600 text-sm font-bold mt-2">
                    <i class="fas fa-calculator mr-1"></i>
                    <span>Per Transaksi</span>
                </div>
            </div>
        </div>

        <!-- Metode Pembayaran -->
        <div class="glass-card rounded-xl p-8 mb-8 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                    <div class="w-10 h-10 bg-black rounded-lg flex items-center justify-center mr-3 shadow-lg">
                        <i class="fas fa-credit-card text-white"></i>
                    </div>
                    Metode Pembayaran
                </h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @forelse($data['metodePembayaran'] as $metode => $info)
                    <div class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-all border border-gray-200 hover:border-black">
                        <div class="flex items-center mb-4">
                            @if($metode == 'tunai')
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-money-bill text-gray-600 text-lg"></i>
                                </div>
                            @elseif($metode == 'debit')
                                <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-credit-card text-gray-700 text-lg"></i>
                                </div>
                            @elseif($metode == 'kredit')
                                <div class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-credit-card text-white text-lg"></i>
                                </div>
                            @else
                                <div class="w-10 h-10 bg-black rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-qrcode text-white text-lg"></i>
                                </div>
                            @endif
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-500">{{ $metode }}</p>
                        </div>
                        <p class="text-3xl font-black text-gray-900 mb-1">{{ $info['jumlah'] }}</p>
                        <p class="text-xs text-gray-500 font-bold font-mono">Rp {{ number_format($info['total'], 0, ',', '.') }}</p>
                    </div>
                @empty
                    <div class="col-span-4 text-center py-12">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-inbox text-gray-400 text-4xl"></i>
                        </div>
                        <p class="text-gray-500 text-lg font-bold">Belum ada data metode pembayaran</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Menu Terlaris -->
        <div class="glass-card rounded-xl p-8 mb-8 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                    <div class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                        <i class="fas fa-fire text-white"></i>
                    </div>
                    Menu Terlaris (Top 10)
                </h2>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-black text-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Ranking</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Nama Menu</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Terjual</th>
                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider">Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($data['menuTerlaris'] as $menu)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="w-10 h-10 bg-black rounded-lg flex items-center justify-center text-white font-black text-base shadow-sm">
                                            {{ $loop->iteration }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-gray-900 text-base">{{ $menu->nama_menu }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-full text-xs font-bold shadow-sm border border-gray-200 uppercase tracking-wide">
                                            {{ $menu->kategori }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="font-black text-lg text-gray-900">{{ $menu->total_terjual }}</span>
                                        <span class="text-xs text-gray-500 font-bold uppercase"> item</span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-black text-lg text-gray-900">
                                        Rp {{ number_format($menu->total_pendapatan, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <i class="fas fa-chart-bar text-gray-400 text-4xl"></i>
                                            </div>
                                            <p class="text-gray-500 text-lg font-bold">Belum ada data menu terlaris</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Daftar Transaksi -->
        <div class="glass-card rounded-xl p-8 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                    <div class="w-10 h-10 bg-black rounded-lg flex items-center justify-center mr-3 shadow-lg">
                        <i class="fas fa-list text-white"></i>
                    </div>
                    {{ $data['judul'] }}
                </h2>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-black text-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Tanggal & Waktu</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Kasir</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Metode</th>
                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($data['transaksis'] as $transaksi)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="font-mono font-bold text-gray-900 border-b border-gray-300">#{{ $transaksi->id_transaksi }}</span>
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
                                            <span class="font-medium text-gray-900">{{ $transaksi->kasir->nama_kasir }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1.5 text-xs font-bold rounded-lg shadow-sm border border-gray-200 uppercase tracking-wide
                                            @if($transaksi->metode_pembayaran === 'tunai') bg-white text-gray-900
                                            @elseif($transaksi->metode_pembayaran === 'debit') bg-gray-100 text-gray-700
                                            @elseif($transaksi->metode_pembayaran === 'kredit') bg-gray-800 text-white
                                            @else bg-black text-white
                                            @endif">
                                            {{ ucfirst($transaksi->metode_pembayaran) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-black text-lg text-gray-900">
                                        Rp {{ number_format($transaksi->total, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <i class="fas fa-receipt text-gray-400 text-4xl"></i>
                                            </div>
                                            <p class="text-gray-500 text-lg font-bold">Belum ada transaksi pada periode ini</p>
                                            <p class="text-gray-400 text-sm mt-1 font-medium">Transaksi akan muncul di sini</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($data['transaksis']->count() > 0)
                            <tfoot class="bg-black text-white">
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-right font-bold text-base uppercase tracking-wider">Grand Total:</td>
                                    <td class="px-6 py-4 text-right font-black text-xl">
                                        Rp {{ number_format($data['totalPenjualan'], 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('periodeSelect').addEventListener('change', function() {
        const periode = this.value;
        const tanggalInput = document.getElementById('tanggalInput');
        const bulanInput = document.getElementById('bulanInput');
        
        if (periode === 'harian') {
            tanggalInput.classList.remove('hidden');
            bulanInput.classList.add('hidden');
        } else {
            tanggalInput.classList.add('hidden');
            bulanInput.classList.remove('hidden');
        }
    });
</script>
@endpush
@endsection