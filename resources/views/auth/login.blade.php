<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Sistem Kasir Kopen</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f3f4f6;
            min-height: 100vh;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 1);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="antialiased flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md fade-in">
        <div class="glass-effect rounded-xl shadow-lg p-8 border border-gray-200">
            <!-- Logo & Title -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-black rounded-xl mb-4 shadow-sm">
                    <i class="fas fa-cash-register text-white text-4xl"></i>
                </div>
                <h1 class="text-3xl text-gray-900 font-black mb-2 tracking-tight">Kasir Kopen</h1>
                <p class="text-gray-500 font-medium">Sistem Point of Sale Terintegrasi</p>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-gray-50 border-l-4 border-black text-gray-900 rounded-lg flex items-center shadow-sm">
                    <i class="fas fa-check-circle mr-3 text-lg"></i>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 bg-gray-50 border-l-4 border-gray-900 text-gray-900 rounded-lg shadow-sm">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-circle mr-2 text-lg"></i>
                        <span class="font-bold">Login Gagal</span>
                    </div>
                    <ul class="list-disc list-inside text-sm text-gray-600 pl-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2 uppercase tracking-wide">
                        <i class="fas fa-user mr-2"></i>Username
                    </label>
                    <input 
                        type="text" 
                        name="username" 
                        value="{{ old('username') }}"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-black focus:border-black transition duration-200 font-medium bg-gray-50 focus:bg-white"
                        placeholder="Masukkan username"
                        required
                        autofocus
                    >
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2 uppercase tracking-wide">
                        <i class="fas fa-lock mr-2"></i>Password
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            name="password" 
                            id="password"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-black focus:border-black transition duration-200 font-medium bg-gray-50 focus:bg-white"
                            placeholder="Masukkan password"
                            required
                        >
                        <button 
                            type="button"
                            onclick="togglePassword()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-900 transition-colors bg-transparent border-0 p-2 cursor-pointer"
                        >
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <button 
                    type="submit"
                    class="w-full bg-black text-white py-3.5 rounded-lg font-bold hover:bg-gray-800 transform active:scale-95 transition duration-200 uppercase tracking-wide text-sm shadow-md"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                </button>
            </form>

            <!-- Footer -->
            <div class="text-center mt-8 text-gray-400">
                <p class="text-xs font-mono">
                    &copy; {{ date('Y') }} Kasir Kopen. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>