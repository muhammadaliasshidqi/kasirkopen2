@extends('components.app')

@section('title', 'Tambah Menu - Sistem Kasir Modern')

@push('styles')
<style>
    .gradient-bg {
        background: #f9fafb;
    }
    
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    .form-input {
        transition: all 0.3s ease;
    }
    
    .form-input:focus {
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen gradient-bg py-8">
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('menu.index') }}" 
               class="inline-flex items-center text-gray-500 hover:text-black mb-4 font-bold transition-all uppercase tracking-wide text-xs">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Menu
            </a>
            <div class="glass-card rounded-xl p-6 shadow-sm">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-black rounded-xl flex items-center justify-center shadow-lg mr-4">
                        <i class="fas fa-utensils text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-4xl font-black text-gray-900">
                            Tambah Menu Baru
                        </h1>
                        <p class="text-gray-500 mt-1 font-medium">Lengkapi informasi menu yang ingin ditambahkan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="glass-card rounded-xl shadow-sm overflow-hidden">
            <form method="POST" action="{{ route('menu.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="p-8 space-y-6">
                    <!-- Nama Menu -->
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2 uppercase tracking-wide">
                            <i class="fas fa-utensils mr-2"></i>Nama Menu *
                        </label>
                        <input 
                            type="text" 
                            name="nama_menu" 
                            value="{{ old('nama_menu') }}"
                            class="form-input w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-black focus:border-black transition font-medium"
                            placeholder="Contoh: Nasi Goreng Spesial"
                            required
                        >
                        @error('nama_menu')
                            <p class="text-black text-sm mt-2 flex items-center font-bold">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Harga & Stok -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Harga -->
                        <div>
                            <label class="block text-sm font-bold text-gray-900 mb-2 uppercase tracking-wide">
                                <i class="fas fa-money-bill-wave mr-2"></i>Harga *
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-bold">Rp</span>
                                <input 
                                    type="number" 
                                    name="harga" 
                                    value="{{ old('harga') }}"
                                    min="0"
                                    step="0.01"
                                    class="form-input w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-black focus:border-black transition font-bold"
                                    placeholder="15000"
                                    required
                                >
                            </div>
                            @error('harga')
                                <p class="text-black text-sm mt-2 flex items-center font-bold">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Stok -->
                        <div>
                            <label class="block text-sm font-bold text-gray-900 mb-2 uppercase tracking-wide">
                                <i class="fas fa-box mr-2"></i>Stok Awal *
                            </label>
                            <input 
                                type="number" 
                                name="stok" 
                                value="{{ old('stok', 0) }}"
                                min="0"
                                class="form-input w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-black focus:border-black transition font-bold"
                                placeholder="50"
                                required
                            >
                            @error('stok')
                                <p class="text-black text-sm mt-2 flex items-center font-bold">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2 uppercase tracking-wide">
                            <i class="fas fa-tag mr-2"></i>Kategori *
                        </label>
                        <div class="flex gap-3">
                            <select 
                                name="kategori" 
                                id="kategoriSelect"
                                class="form-input flex-1 px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-black focus:border-black transition font-medium"
                                required
                            >
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kat)
                                    <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>
                                        {{ $kat }}
                                    </option>
                                @endforeach
                                <option value="custom">+ Kategori Baru</option>
                            </select>
                            <input 
                                type="text" 
                                id="kategoriCustom"
                                class="hidden form-input flex-1 px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-black focus:border-black transition font-medium"
                                placeholder="Nama kategori baru"
                            >
                        </div>
                        @error('kategori')
                            <p class="text-black text-sm mt-2 flex items-center font-bold">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Gambar -->
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2 uppercase tracking-wide">
                            <i class="fas fa-image mr-2"></i>Gambar Menu
                        </label>
                        <div class="grid md:grid-cols-2 gap-4">
                            <label class="cursor-pointer">
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-black transition-all bg-gray-50">
                                    <div class="w-16 h-16 bg-gray-200 rounded-xl flex items-center justify-center mx-auto mb-3 shadow-sm">
                                        <i class="fas fa-cloud-upload-alt text-gray-500 text-2xl"></i>
                                    </div>
                                    <p class="text-gray-900 font-bold mb-1">Klik untuk upload</p>
                                    <p class="text-xs text-gray-500 font-medium">JPG, PNG, GIF (Max: 2MB)</p>
                                </div>
                                <input 
                                    type="file" 
                                    name="gambar" 
                                    accept="image/*"
                                    class="hidden"
                                    onchange="previewImage(event)"
                                >
                            </label>
                            <div id="imagePreview" class="hidden">
                                <div class="relative h-full rounded-xl overflow-hidden shadow-md">
                                    <img src="" alt="Preview" class="w-full h-full object-cover">
                                </div>
                            </div>
                        </div>
                        @error('gambar')
                            <p class="text-black text-sm mt-2 flex items-center font-bold">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2 uppercase tracking-wide">
                            <i class="fas fa-align-left mr-2"></i>Deskripsi
                        </label>
                        <textarea 
                            name="deskripsi" 
                            rows="4"
                            class="form-input w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-black focus:border-black resize-none font-medium"
                            placeholder="Deskripsi singkat tentang menu..."
                        >{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="text-black text-sm mt-2 flex items-center font-bold">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="bg-gray-50 px-8 py-6 flex gap-4 border-t border-gray-100">
                    <button 
                        type="submit"
                        class="flex-1 bg-black text-white py-3 rounded-lg font-bold hover:bg-gray-800 transition-all uppercase tracking-wide text-sm"
                    >
                        <i class="fas fa-save mr-2"></i>Simpan Menu
                    </button>
                    <a 
                        href="{{ route('menu.index') }}"
                        class="flex-1 bg-white border-2 border-gray-200 text-gray-700 py-3 rounded-lg font-bold hover:border-black hover:text-black transition-all text-center uppercase tracking-wide text-sm"
                    >
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const kategoriSelect = document.getElementById('kategoriSelect');
    const kategoriCustom = document.getElementById('kategoriCustom');

    kategoriSelect.addEventListener('change', function() {
        if (this.value === 'custom') {
            kategoriCustom.classList.remove('hidden');
            kategoriCustom.required = true;
            kategoriSelect.removeAttribute('name');
            kategoriCustom.setAttribute('name', 'kategori');
            kategoriCustom.focus();
        } else {
            kategoriCustom.classList.add('hidden');
            kategoriCustom.required = false;
            kategoriCustom.removeAttribute('name');
            kategoriSelect.setAttribute('name', 'kategori');
        }
    });

    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('imagePreview');
        const img = preview.querySelector('img');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush
@endsection