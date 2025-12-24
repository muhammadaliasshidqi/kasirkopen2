<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kasir Modern')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        [x-cloak] { display: none !important; }
        
        .gradient-text {
            background: linear-gradient(135deg, #111827 0%, #374151 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }
        
        .card:hover {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border-color: #000;
        }
        
        .hover-lift {
            transition: transform 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
        }
        
        .sidebar {
            background: #000000;
        }
        
        .sidebar-link {
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        
        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.15);
            padding-left: 1.5rem;
            border-left-color: #9ca3af;
        }
        
        .sidebar-link.active {
            background: white;
            color: black;
            border-left-color: #d1d5db; /* Light gray accent */
            font-weight: 700;
        }
        
        .sidebar-link.active i {
            color: black;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-100" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" 
             x-cloak
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black bg-opacity-70 z-40 md:hidden">
        </div>

        <!-- Mobile Sidebar -->
        <aside x-show="sidebarOpen"
               x-cloak
               x-transition:enter="transition ease-in-out duration-300 transform"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in-out duration-300 transform"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="-translate-x-full"
               class="fixed inset-y-0 left-0 sidebar w-64 text-white z-50 md:hidden border-r border-gray-800">
            <div class="p-6">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-lg">
                            <i class="fas fa-cash-register text-black text-xl"></i>
                        </div>
                        <h1 class="text-xl font-black tracking-tight">Kasir Kopen</h1>
                    </div>
                    <button @click="sidebarOpen = false" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home w-5"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('transaksi.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart w-5"></i>
                        <span>Transaksi</span>
                    </a>
                    
                    <a href="{{ route('menu.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('menu.*') ? 'active' : '' }}">
                        <i class="fas fa-utensils w-5"></i>
                        <span>Menu</span>
                    </a>
                    
                    <a href="{{ route('laporan.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar w-5"></i>
                        <span>Laporan</span>
                    </a>
                    
                    <a href="{{ route('profile.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <i class="fas fa-user w-5"></i>
                        <span>Profile</span>
                    </a>
                    
                    <hr class="border-gray-800 my-4">
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg w-full text-left hover:bg-white hover:text-black">
                            <i class="fas fa-sign-out-alt w-5"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </nav>
            </div>
        </aside>

        <!-- Desktop Sidebar -->
        <aside class="sidebar w-64 text-white flex-shrink-0 hidden md:block border-r border-gray-800 shadow-xl">
            <div class="p-6">
                <!-- Logo Layout -->
                <div class="flex items-center space-x-3 mb-10 p-2">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-[0_0_15px_rgba(255,255,255,0.3)] transform hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-cash-register text-black text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-black tracking-tighter leading-none">KASIR</h1>
                        <h1 class="text-xl font-black tracking-tighter leading-none text-gray-400">KOPEN</h1>
                    </div>
                </div>
                
                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3.5 rounded-lg {{ request()->routeIs('dashboard') ? 'active' : 'text-gray-400 hover:text-white' }}">
                        <i class="fas fa-home w-5 text-lg"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    
                    <a href="{{ route('transaksi.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3.5 rounded-lg {{ request()->routeIs('transaksi.*') ? 'active' : 'text-gray-400 hover:text-white' }}">
                        <i class="fas fa-shopping-cart w-5 text-lg"></i>
                        <span class="font-medium">Transaksi</span>
                    </a>
                    
                    <a href="{{ route('menu.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3.5 rounded-lg {{ request()->routeIs('menu.*') ? 'active' : 'text-gray-400 hover:text-white' }}">
                        <i class="fas fa-utensils w-5 text-lg"></i>
                        <span class="font-medium">Menu</span>
                    </a>
                    
                    <a href="{{ route('laporan.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3.5 rounded-lg {{ request()->routeIs('laporan.*') ? 'active' : 'text-gray-400 hover:text-white' }}">
                        <i class="fas fa-chart-bar w-5 text-lg"></i>
                        <span class="font-medium">Laporan</span>
                    </a>
                    
                    <a href="{{ route('profile.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3.5 rounded-lg {{ request()->routeIs('profile.*') ? 'active' : 'text-gray-400 hover:text-white' }}">
                        <i class="fas fa-user w-5 text-lg"></i>
                        <span class="font-medium">Profile</span>
                    </a>
                    
                    <hr class="border-gray-800 my-6">
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="sidebar-link flex items-center space-x-3 px-4 py-3.5 rounded-lg w-full text-left text-gray-400 hover:bg-white hover:text-black hover:shadow-lg transform active:scale-95">
                            <i class="fas fa-sign-out-alt w-5 text-lg"></i>
                            <span class="font-medium">Logout</span>
                        </button>
                    </form>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden bg-gray-100">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm z-10 border-b border-gray-200">
                <div class="px-6 py-4 flex items-center justify-between">
                    <button class="md:hidden text-gray-500 hover:text-black transition-colors p-2 rounded-lg hover:bg-gray-100" @click="sidebarOpen = true">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <!-- Breadcrumbs or Title could go here -->
                    <div class="hidden md:block">
                        <h2 class="text-lg font-bold text-gray-800">
                            @yield('header_title', '')
                        </h2>
                    </div>

                    <div class="flex items-center space-x-6">
                        <!-- Notification (Static for now) -->
                        <button class="relative p-2 text-gray-400 hover:text-gray-900 transition-colors">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-black rounded-full border-2 border-white"></span>
                        </button>

                        <div class="flex items-center space-x-4 pl-4 border-l border-gray-200">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-bold text-gray-900 uppercase tracking-wide">
                                    {{ Auth::guard('kasir')->user()->nama_kasir }}
                                </p>
                                <p class="text-xs text-gray-500 font-mono">
                                    {{ Auth::guard('kasir')->user()->username }}
                                </p>
                            </div>
                            <div class="w-10 h-10 bg-black rounded-lg flex items-center justify-center text-white font-bold shadow-md hover:bg-gray-800 transition-colors cursor-pointer ring-2 ring-gray-100">
                                {{ strtoupper(substr(Auth::guard('kasir')->user()->nama_kasir, 0, 1)) }}
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-4 md:p-6">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-white border-l-4 border-black text-gray-900 rounded-lg shadow-sm flex items-center animate-fade-in-down">
                        <div class="w-8 h-8 bg-black rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        <span class="font-bold">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-white border-l-4 border-gray-500 text-gray-900 rounded-lg shadow-sm flex items-center animate-fade-in-down">
                        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-exclamation text-gray-700 text-sm"></i>
                        </div>
                        <span class="font-bold">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>