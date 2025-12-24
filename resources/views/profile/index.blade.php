@extends('components.app')

@section('title', 'Profile - Sistem Kasir Modern')

@push('styles')
<style>
    .gradient-bg {
        background: #f9fafb;
    }
    
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    .input-field {
        transition: all 0.3s ease;
    }
    
    .input-field:focus {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen gradient-bg py-8">
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- Header -->
        <div class="mb-8">
            <div class="glass-card rounded-xl p-6 shadow-sm">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-black rounded-xl flex items-center justify-center shadow-lg mr-4">
                        <i class="fas fa-user text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-4xl font-black text-gray-900">
                            Profile Saya
                        </h1>
                        <p class="text-gray-500 mt-1 font-medium">Kelola informasi akun Anda</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="mb-6 glass-card rounded-xl p-5 border-2 border-green-500 bg-green-50 shadow-sm animate__animated animate__fadeInDown">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
                <div class="flex-1">
                    <p class="text-green-900 font-bold">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-green-600 hover:text-green-800 font-bold text-2xl">
                    ×
                </button>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 glass-card rounded-xl p-5 border-2 border-red-500 bg-red-50 shadow-sm animate__animated animate__fadeInDown">
            <div class="flex items-start">
                <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                    <i class="fas fa-exclamation-circle text-white text-xl"></i>
                </div>
                <div class="flex-1">
                    @foreach($errors->all() as $error)
                    <p class="text-red-900 font-bold mb-1">{{ $error }}</p>
                    @endforeach
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-red-600 hover:text-red-800 font-bold text-2xl">
                    ×
                </button>
            </div>
        </div>
        @endif

        <!-- Info Kasir -->
        <div class="glass-card rounded-xl p-6 shadow-sm mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <div class="w-10 h-10 bg-black rounded-lg flex items-center justify-center mr-3 shadow-sm">
                    <i class="fas fa-info-circle text-white"></i>
                </div>
                Informasi Akun
            </h2>
            <div class="space-y-3">
                <div class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-100">
                    <div class="w-16 h-16 bg-gray-900 rounded-full flex items-center justify-center text-white font-bold text-2xl mr-4 shadow-sm">
                        {{ strtoupper(substr($kasir->nama_kasir, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Nama Kasir</p>
                        <p class="text-xl font-block text-gray-900">{{ $kasir->nama_kasir }}</p>
                    </div>
                </div>
                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg border border-gray-100">
                    <span class="text-gray-600 font-bold">Username:</span>
                    <span class="font-bold text-gray-900 font-mono">{{ $kasir->username }}</span>
                </div>
            </div>
        </div>

        <!-- Form Update Nama Kasir -->
        <div class="glass-card rounded-xl p-6 shadow-sm mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <div class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                    <i class="fas fa-id-card text-white"></i>
                </div>
                Update Nama Kasir
            </h2>
            
            <form action="{{ route('profile.updateNamaKasir') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="flex-1 w-full">
                        <label for="nama_kasir" class="block text-sm font-bold text-gray-900 mb-2 uppercase tracking-wide">
                            Nama Kasir Baru
                        </label>
                        <input 
                            type="text" 
                            id="nama_kasir" 
                            name="nama_kasir" 
                            value="{{ old('nama_kasir', $kasir->nama_kasir) }}"
                            class="input-field w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-black focus:outline-none font-bold"
                            placeholder="Masukkan nama kasir baru"
                            required
                        >
                        @error('nama_kasir')
                            <p class="text-black text-sm mt-2 font-bold">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <button 
                        type="submit" 
                        class="w-full md:w-auto bg-black text-white px-8 py-3 rounded-lg font-bold hover:bg-gray-800 transition-all whitespace-nowrap uppercase tracking-wide text-sm"
                    >
                        <i class="fas fa-save mr-2"></i>Simpan Nama
                    </button>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Form Update Username -->
            <div class="glass-card rounded-xl p-6 shadow-sm">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <div class="w-10 h-10 bg-gray-700 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                        <i class="fas fa-user-edit text-white"></i>
                    </div>
                    Update Username
                </h2>
                
                <form action="{{ route('profile.updateUsername') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="username" class="block text-sm font-bold text-gray-900 mb-2 uppercase tracking-wide">
                            Username Baru
                        </label>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            value="{{ old('username', $kasir->username) }}"
                            class="input-field w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-black focus:outline-none font-bold"
                            placeholder="Masukkan username baru"
                            required
                        >
                        @error('username')
                            <p class="text-black text-sm mt-2 font-bold">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <button 
                        type="submit" 
                        class="w-full bg-black text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-800 transition-all uppercase tracking-wide text-sm"
                    >
                        <i class="fas fa-save mr-2"></i>Simpan Username
                    </button>
                </form>
            </div>

            <!-- Form Update Password -->
            <div class="glass-card rounded-xl p-6 shadow-sm">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <div class="w-10 h-10 bg-gray-600 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                        <i class="fas fa-lock text-white"></i>
                    </div>
                    Update Password
                </h2>
                
                <form action="{{ route('profile.updatePassword') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="password_lama" class="block text-sm font-bold text-gray-900 mb-2 uppercase tracking-wide">
                            Password Lama
                        </label>
                        <input 
                            type="password" 
                            id="password_lama" 
                            name="password_lama" 
                            class="input-field w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-black focus:outline-none font-bold"
                            placeholder="Masukkan password lama"
                            required
                        >
                        @error('password_lama')
                            <p class="text-black text-sm mt-2 font-bold">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="password_baru" class="block text-sm font-bold text-gray-900 mb-2 uppercase tracking-wide">
                            Password Baru
                        </label>
                        <input 
                            type="password" 
                            id="password_baru" 
                            name="password_baru" 
                            class="input-field w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-black focus:outline-none font-bold"
                            placeholder="Masukkan password baru (min. 6 karakter)"
                            required
                        >
                        @error('password_baru')
                            <p class="text-black text-sm mt-2 font-bold">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label for="password_baru_confirmation" class="block text-sm font-bold text-gray-900 mb-2 uppercase tracking-wide">
                            Konfirmasi Password Baru
                        </label>
                        <input 
                            type="password" 
                            id="password_baru_confirmation" 
                            name="password_baru_confirmation" 
                            class="input-field w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-black focus:outline-none font-bold"
                            placeholder="Konfirmasi password baru"
                            required
                        >
                    </div>
                    
                    <button 
                        type="submit" 
                        class="w-full bg-black text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-800 transition-all uppercase tracking-wide text-sm"
                    >
                        <i class="fas fa-key mr-2"></i>Simpan Password
                    </button>
                </form>
            </div>
        </div>

        <!-- Kelola Akun Kasir -->
        <div class="mt-6 glass-card rounded-xl p-6 shadow-sm">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <div class="w-10 h-10 bg-black rounded-lg flex items-center justify-center mr-3 shadow-sm">
                    <i class="fas fa-users text-white"></i>
                </div>
                Kelola Akun Kasir
            </h2>
            
            <!-- Form Tambah Akun Baru -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg border-2 border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-user-plus text-black mr-2"></i>
                    Tambah Akun Kasir Baru
                </h3>
                
                <form action="{{ route('profile.createAccount') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label for="new_nama_kasir" class="block text-sm font-bold text-gray-900 mb-2 uppercase tracking-wide">
                                Nama Kasir
                            </label>
                            <input 
                                type="text" 
                                id="new_nama_kasir" 
                                name="nama_kasir" 
                                value="{{ old('nama_kasir') }}"
                                class="input-field w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-black focus:outline-none font-bold"
                                placeholder="Masukkan nama kasir"
                                required
                            >
                        </div>
                        
                        <div>
                            <label for="new_username" class="block text-sm font-bold text-gray-900 mb-2 uppercase tracking-wide">
                                Username
                            </label>
                            <input 
                                type="text" 
                                id="new_username" 
                                name="username" 
                                value="{{ old('username') }}"
                                class="input-field w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:border-blue-600 focus:outline-none font-bold"
                                placeholder="Username login"
                                required
                            >
                        </div>
                        
                        <div>
                            <label for="new_password" class="block text-sm font-bold text-gray-900 mb-2 uppercase tracking-wide">
                                Password
                            </label>
                            <input 
                                type="password" 
                                id="new_password" 
                                name="password" 
                                class="input-field w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:border-blue-600 focus:outline-none font-bold"
                                placeholder="Min. 6 karakter"
                                required
                            >
                        </div>
                    </div>
                    
                    <button 
                        type="submit" 
                        class="w-full bg-black text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-800 transition-all uppercase tracking-wide text-sm shadow-lg"
                    >
                        <i class="fas fa-plus-circle mr-2"></i>Tambah Akun Kasir
                    </button>
                </form>
            </div>
            
            <!-- Daftar Akun Kasir -->
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-list text-gray-700 mr-2"></i>
                Daftar Semua Akun ({{ $allKasir->count() }} Akun)
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($allKasir as $account)
                <div class="relative p-4 bg-white rounded-lg border-2 {{ $account->id_kasir === $kasir->id_kasir ? 'border-black bg-gray-50' : 'border-gray-200' }} hover:shadow-md transition-all">
                    @if($account->id_kasir === $kasir->id_kasir)
                    <div class="absolute top-2 right-2">
                        <span class="bg-black text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                            <i class="fas fa-user-check mr-1"></i>Aktif
                        </span>
                    </div>
                    @endif
                    
                    <div class="flex items-center mb-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-gray-700 to-black rounded-full flex items-center justify-center text-white font-bold text-xl mr-3 shadow-md">
                            {{ strtoupper(substr($account->nama_kasir, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <p class="font-bold text-gray-900 text-lg">{{ $account->nama_kasir }}</p>
                        </div>
                    </div>
                    
                    <div class="text-xs text-gray-500 mb-3">
                        <i class="fas fa-calendar mr-1"></i>
                        Dibuat: {{ $account->created_at ? $account->created_at->format('d M Y') : 'N/A' }}
                    </div>
                    
                    @if($account->id_kasir !== $kasir->id_kasir)
                    <form action="{{ route('profile.deleteAccount', $account->id_kasir) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun {{ $account->nama_kasir }}?')">
                        @csrf
                        @method('DELETE')
                        <button 
                            type="submit" 
                            class="w-full bg-red-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-red-700 transition-all text-sm"
                        >
                            <i class="fas fa-trash-alt mr-2"></i>Hapus Akun
                        </button>
                    </form>
                    @else
                    <div class="text-center text-sm text-gray-500 font-bold py-2">
                        <i class="fas fa-lock mr-1"></i>Akun Sedang Digunakan
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <!-- Security Tips -->
        <div class="mt-6 glass-card rounded-xl p-6 shadow-sm">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <div class="w-10 h-10 bg-gray-500 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                    <i class="fas fa-shield-alt text-white"></i>
                </div>
                Tips Keamanan
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-start p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-black transition-colors">
                    <i class="fas fa-check-circle text-gray-800 text-xl mr-3 mt-1"></i>
                    <div>
                        <p class="font-bold text-gray-900">Gunakan Password Kuat</p>
                        <p class="text-sm text-gray-600 font-medium">Minimal 6 karakter dengan kombinasi huruf dan angka</p>
                    </div>
                </div>
                <div class="flex items-start p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-black transition-colors">
                    <i class="fas fa-check-circle text-gray-800 text-xl mr-3 mt-1"></i>
                    <div>
                        <p class="font-bold text-gray-900">Jangan Bagikan Password</p>
                        <p class="text-sm text-gray-600 font-medium">Jaga kerahasiaan password Anda</p>
                    </div>
                </div>
                <div class="flex items-start p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-black transition-colors">
                    <i class="fas fa-check-circle text-gray-800 text-xl mr-3 mt-1"></i>
                    <div>
                        <p class="font-bold text-gray-900">Update Berkala</p>
                        <p class="text-sm text-gray-600 font-medium">Ganti password secara berkala untuk keamanan</p>
                    </div>
                </div>
                <div class="flex items-start p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-black transition-colors">
                    <i class="fas fa-check-circle text-gray-800 text-xl mr-3 mt-1"></i>
                    <div>
                        <p class="font-bold text-gray-900">Username Unik</p>
                        <p class="text-sm text-gray-600 font-medium">Gunakan username yang mudah diingat tapi unik</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
