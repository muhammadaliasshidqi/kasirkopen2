{{-- Pastikan Alpine.js sudah dimuat di layout utama --}}
{{-- Tambahkan ini di head jika belum ada: --}}
{{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

<nav class="shadow-sm sticky top-0 z-50 backdrop-blur-md bg-white border-b border-gray-200" x-data="{ open: false, profileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo Section -->
            <div class="flex items-center space-x-8">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                    <div class="w-12 h-12 bg-black rounded-lg flex items-center justify-center shadow-sm transform group-hover:scale-110 transition-all duration-300 ease-out">
                        <i class="fas fa-cash-register text-white text-xl group-hover:scale-110 transition-transform duration-300"></i>
                    </div>
                    <div class="hidden sm:block">
                        <span class="text-2xl font-bold text-gray-900 group-hover:text-black transition-all duration-300">Kasir Kopen</span>
                    </div>
                </a>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex space-x-2">
                    <a href="{{ route('dashboard') }}" class="relative px-5 py-2.5 rounded-lg font-medium transition-all duration-300 group {{ request()->routeIs('dashboard') ? 'text-black bg-gray-100' : 'text-gray-500 hover:text-black hover:bg-gray-50' }}">
                        <span class="relative z-10 flex items-center">
                            <i class="fas fa-home mr-2 transition-transform group-hover:scale-110 duration-300"></i>
                            Dashboard
                        </span>
                        @if(request()->routeIs('dashboard'))
                        <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-1/2 h-0.5 bg-black rounded-full"></span>
                        @endif
                    </a>
                    
                    <a href="{{ route('transaksi.index') }}" class="relative px-5 py-2.5 rounded-lg font-medium transition-all duration-300 group {{ request()->routeIs('transaksi.*') ? 'text-black bg-gray-100' : 'text-gray-500 hover:text-black hover:bg-gray-50' }}">
                        <span class="relative z-10 flex items-center">
                            <i class="fas fa-shopping-cart mr-2 transition-transform group-hover:scale-110 duration-300"></i>
                            Transaksi
                        </span>
                        @if(request()->routeIs('transaksi.*'))
                        <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-1/2 h-0.5 bg-black rounded-full"></span>
                        @endif
                    </a>
                    
                    <a href="{{ route('menu.index') }}" class="relative px-5 py-2.5 rounded-lg font-medium transition-all duration-300 group {{ request()->routeIs('menu.*') ? 'text-black bg-gray-100' : 'text-gray-500 hover:text-black hover:bg-gray-50' }}">
                        <span class="relative z-10 flex items-center">
                            <i class="fas fa-utensils mr-2 transition-transform group-hover:scale-110 duration-300"></i>
                            Menu
                        </span>
                        @if(request()->routeIs('menu.*'))
                        <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-1/2 h-0.5 bg-black rounded-full"></span>
                        @endif
                    </a>
                    
                    <a href="{{ route('laporan.index') }}" class="relative px-5 py-2.5 rounded-lg font-medium transition-all duration-300 group {{ request()->routeIs('laporan.*') ? 'text-black bg-gray-100' : 'text-gray-500 hover:text-black hover:bg-gray-50' }}">
                        <span class="relative z-10 flex items-center">
                            <i class="fas fa-chart-line mr-2 transition-transform group-hover:scale-110 duration-300"></i>
                            Laporan
                        </span>
                        @if(request()->routeIs('laporan.*'))
                        <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-1/2 h-0.5 bg-black rounded-full"></span>
                        @endif
                    </a>
                </div>
            </div>
            
            <!-- Right Section -->
            <div class="hidden md:flex items-center space-x-3">
                <!-- Notification Button -->
                <button class="relative p-3 rounded-lg hover:bg-gray-100 transition-all duration-300 group">
                    <i class="fas fa-bell text-gray-500 text-lg group-hover:text-black transition-colors duration-300"></i>
                    <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-black rounded-full shadow-sm border border-white"></span>
                </button>
                
                <!-- Profile Dropdown -->
                <div class="relative" @click.away="profileOpen = false">
                    <button @click="profileOpen = !profileOpen" class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-50 transition-all duration-300 group border border-transparent hover:border-gray-200">
                        <div class="w-9 h-9 bg-black text-white rounded-lg flex items-center justify-center shadow-sm">
                            <span class="font-bold text-sm">{{ substr(auth()->user()->nama_kasir ?? 'A', 0, 1) }}</span>
                        </div>
                        <div class="text-left hidden lg:block">
                            <p class="text-sm font-semibold text-gray-900 group-hover:text-black transition-colors duration-300">{{ auth()->user()->nama_kasir ?? 'Admin' }}</p>
                            <p class="text-xs text-gray-500">{{ auth()->user()->username ?? 'admin' }}</p>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400 text-xs transition-all duration-300 group-hover:text-black" :class="{ 'rotate-180': profileOpen }"></i>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div x-show="profileOpen" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95 -translate-y-2"
                         x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 transform scale-95 -translate-y-2"
                         class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-xl py-2 border border-gray-100 overflow-hidden z-50">
                        
                        <!-- Profile Header -->
                        <div class="px-4 py-3 bg-gray-50 border-b border-gray-100">
                            <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->nama_kasir ?? 'Admin' }}</p>
                            <p class="text-xs text-gray-500">{{ auth()->user()->username ?? 'admin' }}</p>
                        </div>
                        
                        <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-all duration-300 group">
                            <i class="fas fa-user mr-3 text-gray-400 group-hover:text-black w-5 transition-colors duration-300"></i>
                            <span class="group-hover:translate-x-1 transition-transform duration-300">Profil Saya</span>
                        </a>
                        
                        <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-all duration-300 group">
                            <i class="fas fa-cog mr-3 text-gray-400 group-hover:text-black w-5 transition-colors duration-300"></i>
                            <span class="group-hover:translate-x-1 transition-transform duration-300">Pengaturan</span>
                        </a>
                        
                        <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-all duration-300 group">
                            <i class="fas fa-question-circle mr-3 text-gray-400 group-hover:text-black w-5 transition-colors duration-300"></i>
                            <span class="group-hover:translate-x-1 transition-transform duration-300">Bantuan</span>
                        </a>
                        
                        <hr class="my-2 border-gray-100">
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-black transition-all duration-300 group">
                                <i class="fas fa-sign-out-alt mr-3 w-5 text-gray-400 group-hover:text-black transition-colors duration-300"></i>
                                <span class="group-hover:translate-x-1 transition-transform duration-300">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Mobile Menu Button -->
            <div class="md:hidden relative z-50">
                <button type="button" @click="open = !open" class="p-3 rounded-lg hover:bg-gray-100 transition-all duration-300 border border-transparent hover:border-gray-200 relative z-50 pointer-events-auto text-gray-900">
                    <i class="fas text-xl transition-all duration-300" :class="open ? 'fa-times rotate-90' : 'fa-bars'"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform -translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-4"
         class="md:hidden border-t border-gray-200 bg-white shadow-lg">
        <div class="px-4 py-4 space-y-2">
            <!-- User Info Mobile -->
            <div class="flex items-center space-x-3 px-4 py-3 bg-gray-50 rounded-lg mb-3 border border-gray-100">
                <div class="w-10 h-10 bg-black text-white rounded-lg flex items-center justify-center shadow-sm">
                    <span class="font-bold">{{ substr(auth()->user()->nama_kasir ?? 'A', 0, 1) }}</span>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->nama_kasir ?? 'Admin' }}</p>
                    <p class="text-xs text-gray-500">{{ auth()->user()->username ?? 'admin' }}</p>
                </div>
            </div>
            
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3.5 rounded-lg transition-all duration-300 group {{ request()->routeIs('dashboard') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-black' }}">
                <i class="fas fa-home mr-3 w-5"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('transaksi.index') }}" class="flex items-center px-4 py-3.5 rounded-lg transition-all duration-300 group {{ request()->routeIs('transaksi.*') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-black' }}">
                <i class="fas fa-shopping-cart mr-3 w-5"></i>
                <span>Transaksi</span>
            </a>
            
            <a href="{{ route('menu.index') }}" class="flex items-center px-4 py-3.5 rounded-lg transition-all duration-300 group {{ request()->routeIs('menu.*') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-black' }}">
                <i class="fas fa-utensils mr-3 w-5"></i>
                <span>Menu</span>
            </a>
            
            <a href="{{ route('laporan.index') }}" class="flex items-center px-4 py-3.5 rounded-lg transition-all duration-300 group {{ request()->routeIs('laporan.*') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-black' }}">
                <i class="fas fa-chart-line mr-3 w-5"></i>
                <span>Laporan</span>
            </a>
            
            <hr class="my-3 border-gray-100">
            
            <a href="#" class="flex items-center px-4 py-3.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-black transition-all duration-300 group">
                <i class="fas fa-cog mr-3 w-5"></i>
                <span>Pengaturan</span>
            </a>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center px-4 py-3.5 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-black transition-all duration-300 group">
                    <i class="fas fa-sign-out-alt mr-3 w-5"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</nav>

<style>
    /* Custom scrollbar untuk dropdown */
    .overflow-y-auto::-webkit-scrollbar {
        width: 6px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-track {
        background: #f9fafb;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 10px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }

    [x-cloak] { display: none !important;}
</style>