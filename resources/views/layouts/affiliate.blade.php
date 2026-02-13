<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affiliate Dashboard - The Secret</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        :root {
            --primary: #7D2E35;
            --secondary: #E8D5B5;
            --bg: #FFF9F9;
            --surface: #FFFFFF;
            --text: #4A4A4A;
            --heading: #2C3E50;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #FFF9F9;
        }
        
        .font-serif {
            font-family: 'Playfair Display', serif;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        ::-webkit-scrollbar-thumb {
            background: #7D2E35; 
            border-radius: 3px;
        }
        
        .sidebar-link.active {
            background-color: #FFF0F0;
            color: #7D2E35;
            border-right: 3px solid #7D2E35;
        }
        
        .sidebar-link:hover {
            background-color: #FFF9F9;
            color: #7D2E35;
        }
    </style>
</head>
<body class="flex h-screen bg-[#FFF9F9] text-[#4A4A4A]">

    <!-- Sidebar -->
    <aside class="sidebar w-64 flex-shrink-0 hidden lg:flex lg:flex-col bg-white border-r border-gray-100 shadow-sm z-20">
        <!-- Logo Section -->
        <div class="p-8 flex flex-col items-start justify-center">
            <h1 class="font-serif text-xl font-bold text-[#7D2E35] tracking-wide">The Secret</h1>
            <p class="text-[10px] text-gray-400 uppercase tracking-widest">by Umy Fadillaa</p>
        </div>

        <!-- Role Toggle Removed -->
        
        <!-- Navigation Menu -->
        <nav class="flex-1 px-4 overflow-y-auto">
            <p class="px-4 text-[10px] font-bold text-gray-300 uppercase tracking-widest mb-2 mt-2">Ikhtisar</p>
            <ul class="space-y-1 mb-6">
                <li>
                    <a href="{{ route('affiliate.dashboard') }}" class="sidebar-link flex items-center p-3 rounded-lg transition-all {{ request()->routeIs('affiliate.dashboard') ? 'active' : 'text-gray-500' }}">
                        <i class="fas fa-th-large w-6 text-center mr-3 text-sm"></i>
                        <span class="font-medium text-sm">Dashboard Saya</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('affiliate.my_links') }}" class="sidebar-link flex items-center p-3 rounded-lg transition-all {{ request()->routeIs('affiliate.my_links') ? 'active' : 'text-gray-500' }}">
                        <i class="fas fa-link w-6 text-center mr-3 text-sm"></i>
                        <span class="font-medium text-sm">Link Saya</span>
                    </a>
                </li>
            </ul>
            
            <p class="px-4 text-[10px] font-bold text-gray-300 uppercase tracking-widest mb-2">Penghasilan</p>
            <ul class="space-y-1 mb-6">
                <li>
                    <a href="{{ route('affiliate.commissions') }}" class="sidebar-link flex items-center p-3 rounded-lg transition-all {{ request()->routeIs('affiliate.commissions') ? 'active' : 'text-gray-500' }}">
                        <i class="fas fa-wallet w-6 text-center mr-3 text-sm"></i>
                        <span class="font-medium text-sm">Riwayat Komisi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('affiliate.payouts') }}" class="sidebar-link flex items-center p-3 rounded-lg transition-all {{ request()->routeIs('affiliate.payouts') ? 'active' : 'text-gray-500' }}">
                        <i class="fas fa-university w-6 text-center mr-3 text-sm"></i>
                        <span class="font-medium text-sm">Pencairan Dana</span>
                    </a>
                </li>
            </ul>
            
            <p class="px-4 text-[10px] font-bold text-gray-300 uppercase tracking-widest mb-2">Sumber Daya</p>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('affiliate.marketing_assets') }}" class="sidebar-link flex items-center p-3 rounded-lg transition-all {{ request()->routeIs('affiliate.marketing_assets') ? 'active' : 'text-gray-500' }}">
                        <i class="fas fa-shapes w-6 text-center mr-3 text-sm"></i>
                        <span class="font-medium text-sm">Produk</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('affiliate.academy') }}" class="sidebar-link flex items-center p-3 rounded-lg transition-all {{ request()->routeIs('affiliate.academy') ? 'active' : 'text-gray-500' }}">
                        <i class="fas fa-graduation-cap w-6 text-center mr-3 text-sm"></i>
                        <span class="font-medium text-sm">Pusat Bantuan</span>
                    </a>
                </li>
            </ul>
        </nav>
        
        <!-- Sidebar Footer -->
        <div class="p-6 border-t border-gray-50">
            <div class="flex items-center justify-between">
                <a href="{{ route('affiliate.profile') }}" class="flex items-center group">
                    <div class="w-8 h-8 rounded-full bg-[#7D2E35] text-white flex items-center justify-center font-serif font-bold text-xs mr-3 group-hover:bg-[#632429] transition-colors">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-[#2C3E50] group-hover:text-[#7D2E35] transition-colors">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-gray-400 capitalize">{{ auth()->user()->affiliate?->level ?? 'Free' }} Affiliate</p>
                    </div>
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-[#7D2E35] transition-colors">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="bg-white border-b border-[#E8E1D5] py-4 px-6 flex justify-between items-center shadow-sm z-10">
            <div class="flex items-center">
                <button class="mr-4 lg:hidden text-gray-500 hover:text-[#8B7355]">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div class="hidden md:block">
                    <h2 class="text-xl font-bold text-[#2C3E50]">@yield('title', 'Dashboard')</h2>
                    <p class="text-xs text-gray-500">Kelola bisnis affiliate Anda</p>
                </div>
            </div>
            
            
            <div class="flex items-center space-x-4" x-data="{ notificationOpen: false }">
                <!-- Notification Dropdown -->
                <div class="relative">
                    <button @click="notificationOpen = !notificationOpen" 
                            class="bg-[#F8F5F0] p-2 rounded-full text-[#8B7355] hover:bg-[#E8E1D5] transition-colors relative">
                        <i class="far fa-bell"></i>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="absolute top-0 right-0 w-2 h-2 bg-[#E74C3C] rounded-full"></span>
                        @endif
                    </button>

                    <!-- Dropdown -->
                    <div x-show="notificationOpen" 
                         @click.away="notificationOpen = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-gray-100 z-50"
                         style="display: none;">
                        
                        <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="font-bold text-[#2C3E50] text-sm">Notifikasi</h3>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                            <a href="{{ route('affiliate.notifications.mark-all-read') }}" 
                               class="text-xs text-[#7D2E35] hover:underline font-bold">
                                Tandai Semua Dibaca
                            </a>
                            @endif
                        </div>

                        <div class="max-h-96 overflow-y-auto">
                            @forelse(auth()->user()->notifications->take(10) as $notification)
                            <a href="{{ $notification->data['url'] ?? '#' }}" 
                               class="block p-4 hover:bg-[#FFF9F9] transition-colors border-b border-gray-50 {{ is_null($notification->read_at) ? 'bg-[#FFF9F9]' : '' }}">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-[#7D2E35] flex items-center justify-center text-white mr-3">
                                        <i class="{{ $notification->data['icon'] ?? 'fas fa-bell' }} text-xs"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-[#2C3E50] truncate">
                                            {{ $notification->data['title'] ?? 'Notifikasi Baru' }}
                                        </p>
                                        <p class="text-xs text-gray-500 line-clamp-2">
                                            {{ $notification->data['message'] ?? 'Anda memiliki notifikasi baru' }}
                                        </p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    @if(is_null($notification->read_at))
                                    <div class="flex-shrink-0 w-2 h-2 bg-[#7D2E35] rounded-full ml-2"></div>
                                    @endif
                                </div>
                            </a>
                            @empty
                            <div class="p-8 text-center text-gray-400">
                                <i class="far fa-bell text-4xl mb-3 opacity-20"></i>
                                <p class="text-sm">Belum ada notifikasi</p>
                            </div>
                            @endforelse
                        </div>

                        @if(auth()->user()->notifications->count() > 10)
                        <div class="p-3 border-t border-gray-100 text-center">
                            <a href="{{ route('affiliate.notifications.index') }}" 
                               class="text-xs text-[#7D2E35] hover:underline font-bold">
                                Lihat Semua Notifikasi
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="h-8 w-px bg-gray-200 mx-1"></div>
                <div class="flex items-center cursor-pointer">
                    <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                </div>
            </div>
        </header>

        <!-- Main Content Scroll Area -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#F8F5F0] p-4 md:p-8">
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow-sm flex justify-between items-center" role="alert" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                    <p>{{ session('success') }}</p>
                    <button @click="show = false" class="opacity-50 hover:opacity-100">&times;</button>
                </div>
            @endif
            
            @yield('content')
        </main>
    </div>

    <!-- Overlay for mobile -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden lg:hidden"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('aside');
            const toggleBtn = document.querySelector('.fa-bars').parentElement;
            const overlay = document.getElementById('sidebarOverlay');
            
            function toggleSidebar() {
                sidebar.classList.toggle('hidden');
                sidebar.classList.toggle('fixed');
                sidebar.classList.toggle('z-30');
                sidebar.classList.toggle('h-full');
                overlay.classList.toggle('hidden');
            }

            toggleBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                toggleSidebar();
            });

            overlay.addEventListener('click', function() {
                toggleSidebar();
            });
        });
    </script>
</body>
</html>
