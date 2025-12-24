@extends('components.app')

@section('title', 'Kelola Menu - Sistem Kasir Modern')

@push('styles')
<style>
    .gradient-bg {
        background: #f9fafb;
    }
    
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    .menu-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid transparent;
    }
    
    .menu-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        border-color: #000;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen gradient-bg py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <div class="glass-card rounded-xl p-6 shadow-sm">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-black rounded-xl flex items-center justify-center shadow-lg mr-4">
                            <i class="fas fa-utensils text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-4xl font-black text-gray-900">
                                Kelola Menu
                            </h1>
                            <p class="text-gray-500 mt-1 font-medium">Manajemen menu makanan dan minuman</p>
                        </div>
                    </div>
                    <a href="{{ route('menu.create') }}" 
                       class="bg-black text-white px-6 py-3 rounded-lg font-bold shadow-sm hover:bg-gray-800 transition-all uppercase tracking-wide text-sm">
                        <i class="fas fa-plus mr-2"></i>Tambah Menu
                    </a>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="mb-6 glass-card rounded-xl p-5 shadow-sm border-l-4 border-black">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-check text-white text-sm"></i>
                    </div>
                    <p class="text-gray-900 font-bold">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Search & Filter -->
        <div class="glass-card rounded-xl p-6 mb-8 shadow-sm">
            <form method="GET" action="{{ route('menu.index') }}" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Cari menu..."
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-black focus:border-black transition font-medium"
                    >
                </div>
                <select 
                    name="kategori"
                    class="px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-black focus:border-black transition font-medium"
                >
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                            {{ $kategori }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="bg-black text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-800 transition uppercase tracking-wide text-sm">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
                <a href="{{ route('menu.index') }}" class="bg-white border-2 border-gray-200 text-gray-700 px-6 py-3 rounded-lg font-bold hover:border-black hover:text-black transition text-center uppercase tracking-wide text-sm">
                    <i class="fas fa-redo mr-2"></i>Reset
                </a>
            </form>
        </div>

        <!-- Menu Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($menus as $menu)
                <div class="menu-card glass-card rounded-xl overflow-hidden shadow-sm">
                    <!-- Gambar Menu -->
                    <div class="relative h-56 overflow-hidden bg-gray-100">
                        @if($menu->gambar)
                            <img src="{{ asset('storage/' . $menu->gambar) }}" 
                                 alt="{{ $menu->nama_menu }}"
                                 class="w-full h-full object-cover transition-all duration-500 hover:scale-105"
                                 onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full bg-gray-200 flex items-center justify-center\'><div class=\'text-center\'><i class=\'fas fa-image text-gray-400 text-6xl mb-3\'></i><p class=\'text-gray-500 text-sm font-bold\'>Gambar tidak ditemukan</p></div></div>'">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <div class="text-center">
                                    <i class="fas fa-utensils text-gray-400 text-6xl mb-3"></i>
                                    <p class="text-gray-500 text-sm font-bold">Tidak ada gambar</p>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Badge Kategori -->
                        <div class="absolute top-3 left-3">
                            <span class="px-3 py-1.5 bg-white text-black border border-gray-200 rounded-lg text-xs font-bold shadow-sm uppercase tracking-wide">
                                <i class="fas fa-tag mr-1"></i>{{ $menu->kategori }}
                            </span>
                        </div>

                        <!-- Badge Stok -->
                        <div class="absolute top-3 right-3">
                            <span class="px-3 py-1.5 {{ $menu->stok > 10 ? 'bg-black text-white' : ($menu->stok > 0 ? 'bg-gray-800 text-white' : 'bg-white text-black border-2 border-black') }} rounded-lg text-xs font-bold shadow-sm uppercase tracking-wide">
                                <i class="fas fa-box mr-1"></i>{{ $menu->stok }}
                            </span>
                        </div>
                    </div>

                    <!-- Info Menu -->
                    <div class="p-6">
                        <h3 class="text-lg font-black text-gray-900 mb-3 leading-tight">{{ $menu->nama_menu }}</h3>
                        
                        <div class="mb-4">
                            <p class="text-xs text-gray-500 uppercase tracking-widest font-bold mb-1">Harga</p>
                            <p class="text-2xl font-black text-black">
                                {{ $menu->harga_format }}
                            </p>
                        </div>

                        @if($menu->deskripsi)
                            <p class="text-sm text-gray-600 mb-4 line-clamp-2 font-medium">{{ $menu->deskripsi }}</p>
                        @endif

                        <!-- Update Stok -->
                        <div class="mb-4 bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <form method="POST" action="{{ route('menu.updateStok', $menu) }}">
                                @csrf
                                <label class="text-xs font-bold text-gray-900 uppercase tracking-wide flex items-center mb-3">
                                    <i class="fas fa-warehouse mr-2"></i>
                                    Kelola Stok
                                </label>
                                <div class="flex items-stretch gap-2">
                                    <input 
                                        type="number" 
                                        name="stok" 
                                        value="{{ $menu->stok }}"
                                        min="0"
                                        class="w-20 px-3 py-2 border-2 border-gray-300 rounded-lg text-center font-bold text-gray-900 focus:ring-2 focus:ring-black focus:border-black transition bg-white"
                                    >
                                    <button type="submit" class="flex-1 bg-black text-white rounded-lg hover:bg-gray-800 transition font-bold text-xs uppercase tracking-wide">
                                        <i class="fas fa-save mr-1"></i>Simpan
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3">
                            <a href="{{ route('menu.edit', $menu) }}" 
                               class="flex-1 bg-white border-2 border-gray-200 text-gray-900 py-2.5 rounded-lg text-center hover:border-black hover:text-black transition font-bold text-sm uppercase tracking-wide">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>
                            <form method="POST" action="{{ route('menu.destroy', $menu) }}" 
                                  onsubmit="return confirm('Yakin ingin menghapus menu ini?')"
                                  class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-white border-2 border-gray-200 text-gray-900 py-2.5 rounded-lg hover:bg-black hover:text-white hover:border-black transition font-bold text-sm uppercase tracking-wide">
                                    <i class="fas fa-trash mr-1"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="glass-card rounded-xl p-16 text-center shadow-sm">
                        <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-utensils text-gray-400 text-6xl"></i>
                        </div>
                        <p class="text-gray-900 text-2xl font-black mb-2">Belum ada menu</p>
                        <p class="text-gray-500 mb-6 font-medium">Mulai tambahkan menu pertama Anda</p>
                        <a href="{{ route('menu.create') }}" 
                           class="inline-flex items-center bg-black text-white px-8 py-4 rounded-lg hover:bg-gray-800 transition font-bold uppercase tracking-wide text-sm">
                            <i class="fas fa-plus mr-2"></i>Tambah Menu Pertama
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($menus->hasPages())
            <div class="mt-8">
                {{ $menus->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
</style>
@endsection