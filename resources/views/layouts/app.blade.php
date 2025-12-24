<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Kasir Modern')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        [x-cloak] { display: none !important; }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f9fafb;
            min-height: 100vh;
        }
        
        .smooth-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in;
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
        
        .slide-in {
            animation: slideIn 0.4s ease-out;
        }
        
        @keyframes slideIn {
            from {
                transform: translateX(-100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        .gradient-text {
            color: #000;
            /* No gradient for monochrome */
        }
        
        .btn-primary {
            background: #000; /* Black */
            color: #fff;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: #1f2937; /* Gray 800 */
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
            border-color: #d1d5db;
        }
        
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f3f4f6;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #9ca3af;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }
    </style>
    
    @stack('styles')
</head>
<body class="antialiased text-gray-900">
    <div class="min-h-screen flex flex-col">
        @include('components.nav')
        
        <main class="flex-grow fade-in">
            @yield('content')
        </main>
        
        @include('components.footer')
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('fade-in');
                }, index * 100);
            });
        });
        
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            // Monochrome notification styles
            const bgClass = type === 'success' ? 'bg-black' : (type === 'error' ? 'bg-white border-2 border-black text-black' : 'bg-gray-800');
            const textClass = type === 'error' ? 'text-black' : 'text-white';
            
            notification.className = `fixed top-4 right-4 px-6 py-4 rounded-lg shadow-xl z-50 smooth-transition ${bgClass} ${textClass} font-medium flex items-center border border-transparent`;
            
            // Add icon
            const icon = document.createElement('i');
            icon.className = `fas fa-${type === 'success' ? 'check' : (type === 'error' ? 'exclamation' : 'info')}-circle mr-2`;
            notification.prepend(icon);

            notification.appendChild(document.createTextNode(message));
            
            notification.style.opacity = '0';
            notification.style.transform = 'translateY(-20px)';
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.opacity = '1';
                notification.style.transform = 'translateY(0)';
            }, 10);
            
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateY(-20px)';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
    </script>
    
    @stack('scripts')
</body>
</html>