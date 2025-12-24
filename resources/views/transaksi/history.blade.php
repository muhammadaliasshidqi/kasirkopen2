@extends('components.app')

@section('title', 'Riwayat Transaksi - Sistem Kasir Modern')

@push('styles')
<style>
    .monochrome-bg {
        background: #f3f4f6;
    }
    
    .glass-card {
        background: white;
        border: 1px solid #e5e7eb;
    }
    .glass-card:hover {
        border-color: #000;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen monochrome-bg py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <div class="glass-card rounded-2xl p-6 shadow-sm">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-black rounded-2xl flex items-center justify-center shadow-lg mr-4">
                        <i class="fas fa-history text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-4xl font-black text-gray-900 tracking-tight">
                            Riwayat Transaksi
                        </h1>
                        <p class="text-gray-500 mt-1">Daftar semua transaksi yang telah dilakukan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="mb-6 glass-card rounded-xl p-5 shadow-sm border-l-4 border-black">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-black rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-check-circle text-white text-lg"></i>
                    </div>
                    <p class="text-gray-900 font-bold">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 glass-card rounded-xl p-5 shadow-sm border-l-4 border-gray-500">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-200 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-exclamation-circle text-gray-700 text-lg"></i>
                    </div>
                    <p class="text-gray-900 font-bold">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Filter -->
        <div class="glass-card rounded-2xl p-6 mb-8 shadow-sm">
            <form method="GET" action="{{ route('transaksi.history') }}" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input 
                        type="date" 
                        name="tanggal" 
                        value="{{ request('tanggal') }}"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-gray-200 focus:border-black transition"
                    >
                </div>
                <select 
                    name="metode"
                    class="px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-gray-200 focus:border-black transition"
                >
                    <option value="">Semua Metode</option>
                    <option value="tunai" {{ request('metode') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                    <option value="debit" {{ request('metode') == 'debit' ? 'selected' : '' }}>Debit</option>
                    <option value="kredit" {{ request('metode') == 'kredit' ? 'selected' : '' }}>Kredit</option>
                    <option value="qris" {{ request('metode') == 'qris' ? 'selected' : '' }}>QRIS</option>
                </select>
                <button type="submit" class="bg-black text-white px-6 py-3 rounded-xl font-bold hover:shadow-lg hover:bg-gray-800 transition">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
                <a href="{{ route('transaksi.history') }}" class="bg-white border-2 border-gray-300 text-gray-700 px-6 py-3 rounded-xl font-bold hover:bg-gray-50 hover:text-black hover:border-black transition text-center">
                    <i class="fas fa-redo mr-2"></i>Reset
                </a>
            </form>
        </div>

        <!-- Table -->
        <div class="glass-card rounded-2xl shadow-sm overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-black text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Tanggal & Waktu</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Kasir</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Total</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Metode</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Bayar</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Kembalian</th>
                            <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($transaksis as $transaksi)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-mono font-bold text-black">#{{ $transaksi->id_transaksi }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-gray-900">{{ $transaksi->tanggal->format('d/m/Y') }}</span>
                                        <span class="text-xs text-gray-500 font-mono">{{ $transaksi->created_at->format('H:i:s') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gray-900 rounded-full flex items-center justify-center mr-3 shadow-md">
                                            <span class="text-white text-xs font-bold">{{ substr($transaksi->kasir->nama_kasir, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <div class="font-bold text-sm text-gray-900">{{ $transaksi->kasir->nama_kasir }}</div>
                                            <div class="text-xs text-gray-500">{{ $transaksi->kasir->username }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-black text-lg text-gray-900">{{ $transaksi->total_format }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1.5 text-xs font-bold rounded-full shadow-sm border border-gray-200
                                        @if($transaksi->metode_pembayaran === 'tunai') bg-white text-gray-900
                                        @elseif($transaksi->metode_pembayaran === 'debit') bg-gray-100 text-gray-800
                                        @elseif($transaksi->metode_pembayaran === 'kredit') bg-gray-800 text-white
                                        @else bg-black text-white
                                        @endif">
                                        {{ ucfirst($transaksi->metode_pembayaran) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $transaksi->bayar_format }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $transaksi->kembalian_format }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('transaksi.show', $transaksi) }}" 
                                           class="w-9 h-9 bg-black text-white rounded-xl hover:bg-gray-800 hover:shadow-lg transition flex items-center justify-center"
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('transaksi.print', $transaksi) }}" 
                                           target="_blank"
                                           class="w-9 h-9 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 hover:text-black hover:border-black transition flex items-center justify-center"
                                           title="Print Struk">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        @if($transaksi->tanggal->isToday())
                                            <form method="POST" action="{{ route('transaksi.cancel', $transaksi) }}"
                                                  onsubmit="return confirm('Yakin ingin membatalkan transaksi ini?')"
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="w-9 h-9 bg-white border border-red-200 text-red-600 rounded-xl hover:bg-red-50 hover:border-red-500 transition flex items-center justify-center"
                                                        title="Batalkan">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-receipt text-gray-400 text-4xl"></i>
                                        </div>
                                        <p class="text-gray-500 text-lg font-medium">Belum ada transaksi</p>
                                        <p class="text-gray-400 text-sm mt-1">Transaksi akan muncul di sini</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($transaksis->hasPages())
            <div class="mt-8">
                {{ $transaksis->links() }}
            </div>
        @endif

        <!-- Summary -->
        @if($transaksis->count() > 0)
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="glass-card rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-bold uppercase tracking-wide">Total Transaksi</p>
                            <p class="text-3xl font-black text-gray-900 mt-1">{{ $transaksis->total() }}</p>
                        </div>
                        <div class="w-16 h-16 bg-black rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-shopping-cart text-white text-2xl"></i>
                        </div>
                    </div>
                </div>
                <div class="glass-card rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-bold uppercase tracking-wide">Total Penjualan</p>
                            <p class="text-3xl font-black text-gray-900 mt-1">
                                Rp {{ number_format($transaksis->sum('total'), 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="w-16 h-16 bg-black rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-money-bill-wave text-white text-2xl"></i>
                        </div>
                    </div>
                </div>
                <div class="glass-card rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-bold uppercase tracking-wide">Rata-rata</p>
                            <p class="text-3xl font-black text-gray-900 mt-1">
                                Rp {{ number_format($transaksis->avg('total'), 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="w-16 h-16 bg-gray-800 rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-chart-line text-white text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection