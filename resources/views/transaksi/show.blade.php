@extends('components.app')

@section('title', 'Detail Transaksi - Sistem Kasir Modern')

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
    <div class="container mx-auto px-4 max-w-5xl">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('transaksi.history') }}" 
               class="inline-flex items-center text-gray-500 hover:text-black mb-4 font-semibold transition-all">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Riwayat
            </a>
            <div class="glass-card rounded-2xl p-6 shadow-sm">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-black rounded-2xl flex items-center justify-center shadow-lg mr-4">
                            <i class="fas fa-receipt text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-4xl font-black text-gray-900 tracking-tight">
                                Detail Transaksi
                            </h1>
                            <p class="text-gray-500 mt-1">ID: <span class="font-mono font-bold text-black">#{{ $transaksi->id_transaksi }}</span></p>
                        </div>
                    </div>
                    <a href="{{ route('transaksi.print', $transaksi) }}" 
                       target="_blank"
                       class="bg-black text-white px-6 py-3 rounded-xl font-bold hover:shadow-xl hover:bg-gray-800 transition-all">
                        <i class="fas fa-print mr-2"></i>Print Struk
                    </a>
                </div>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Info Transaksi -->
            <div class="glass-card rounded-2xl p-6 shadow-sm">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center mr-3 border border-gray-200">
                        <i class="fas fa-info-circle text-black"></i>
                    </div>
                    Informasi Transaksi
                </h2>
                <div class="space-y-3">
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg border border-gray-100">
                        <span class="text-gray-600 font-semibold">Tanggal:</span>
                        <span class="font-bold text-gray-900">{{ $transaksi->tanggal->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg border border-gray-100">
                        <span class="text-gray-600 font-semibold">Waktu:</span>
                        <span class="font-bold text-gray-900">{{ $transaksi->created_at->format('H:i:s') }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg border border-gray-100">
                        <span class="text-gray-600 font-semibold">Kasir:</span>
                        <span class="font-bold text-gray-900">{{ $transaksi->kasir->nama_kasir }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg border border-gray-100">
                        <span class="text-gray-600 font-semibold">Metode:</span>
                        <span class="px-3 py-1.5 text-xs font-bold rounded-full shadow-sm border border-gray-200
                            @if($transaksi->metode_pembayaran === 'tunai') bg-white text-gray-900
                            @elseif($transaksi->metode_pembayaran === 'debit') bg-gray-100 text-gray-800
                            @elseif($transaksi->metode_pembayaran === 'kredit') bg-gray-800 text-white
                            @else bg-black text-white
                            @endif">
                            {{ ucfirst($transaksi->metode_pembayaran) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Info Pembayaran -->
            <div class="glass-card rounded-2xl p-6 shadow-sm">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center mr-3 border border-gray-200">
                        <i class="fas fa-money-bill-wave text-black"></i>
                    </div>
                    Informasi Pembayaran
                </h2>
                <div class="space-y-3">
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg border border-gray-100">
                        <span class="text-gray-600 font-semibold">Total:</span>
                        <span class="text-2xl font-black text-gray-900">{{ $transaksi->total_format }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg border border-gray-100">
                        <span class="text-gray-600 font-semibold">Bayar:</span>
                        <span class="font-bold text-gray-900 text-lg">{{ $transaksi->bayar_format }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-100 rounded-lg border-2 border-gray-200">
                        <span class="text-gray-800 font-bold">Kembalian:</span>
                        <span class="text-2xl font-black text-black">{{ $transaksi->kembalian_format }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Items -->
        <div class="glass-card rounded-2xl p-6 shadow-sm border border-gray-200">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center mr-3 border border-gray-200">
                    <i class="fas fa-list text-black"></i>
                </div>
                Item Transaksi
            </h2>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-black text-white">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Menu</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Kategori</th>
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wider">Jumlah</th>
                            <th class="px-4 py-3 text-right text-xs font-bold uppercase tracking-wider">Harga</th>
                            <th class="px-4 py-3 text-right text-xs font-bold uppercase tracking-wider">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($transaksi->detailTransaksi as $detail)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-sm font-bold text-gray-900">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3">
                                    <div class="font-bold text-gray-900">{{ $detail->menu->nama_menu }}</div>
                                    @if($detail->menu->deskripsi)
                                        <div class="text-xs text-gray-500 mt-1">{{ Str::limit($detail->menu->deskripsi, 50) }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 border border-gray-200 rounded-full text-xs font-bold">
                                        {{ $detail->menu->kategori }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-black text-white font-bold rounded-lg shadow-sm">
                                        {{ $detail->jumlah }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right font-semibold text-gray-900">{{ $detail->harga_satuan_format }}</td>
                                <td class="px-4 py-3 text-right font-bold text-lg text-gray-900">{{ $detail->subtotal_format }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-right font-bold text-gray-900 uppercase tracking-wide">Total:</td>
                            <td class="px-4 py-4 text-right font-black text-2xl text-black">
                                {{ $transaksi->total_format }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Action Buttons -->
        @if($transaksi->tanggal->isToday())
            <div class="mt-6">
                <form method="POST" action="{{ route('transaksi.cancel', $transaksi) }}"
                      onsubmit="return confirm('Yakin ingin membatalkan transaksi ini? Stok akan dikembalikan.')"
                      class="glass-card rounded-2xl p-6 shadow-sm border border-red-100 bg-red-50/30">
                    @csrf
                    @method('DELETE')
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-white border-2 border-red-100 rounded-xl flex items-center justify-center mr-4 shadow-sm">
                                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 text-lg">Batalkan Transaksi</p>
                                <p class="text-sm text-gray-500">Stok akan dikembalikan ke menu</p>
                            </div>
                        </div>
                        <button type="submit" 
                                class="bg-white border-2 border-red-200 text-red-600 px-8 py-3 rounded-xl font-bold hover:shadow-lg hover:bg-red-50 hover:border-red-500 transition-all">
                            <i class="fas fa-times-circle mr-2"></i>Batalkan
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection