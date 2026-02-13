<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - The Secret</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Iconify -->
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    <!-- Alpine component for icon picker -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('iconPicker', (initialValue = '') => ({
                open: false,
                search: '',
                value: initialValue,
                icons: [],
                filteredResults: [],
                loading: false,
                error: null,

                async init() {
                    this.$watch('search', (v) => this.filterIcons(v));
                    this.loading = true;
                    try {
                        const response = await fetch('https://cdn.jsdelivr.net/npm/lucide-static@latest/icon-nodes.json');
                        if (!response.ok) throw new Error('Fetch failed');
                        const data = await response.json();
                        this.icons = Object.keys(data).map(name => `lucide:${name}`);
                        this.filterIcons('');
                    } catch (e) {
                        this.error = 'Failed to load icons';
                        console.error(e);
                    } finally {
                        this.loading = false;
                    }
                },

                filterIcons(searchTerm) {
                    if (!searchTerm) {
                        this.filteredResults = this.icons.slice(0, 100);
                        return;
                    }
                    const lower = searchTerm.toLowerCase();
                    this.filteredResults = this.icons.filter(icon => icon.toLowerCase().includes(lower)).slice(0, 100);
                },

                selectIcon(icon) {
                    this.value = icon;
                    this.open = false;
                },

                filteredIcons() {
                    return this.filteredResults;
                },

                toggle() {
                    this.open = !this.open;
                    if (this.open) {
                        this.$nextTick(() => {
                            this.$refs.searchInput?.focus();
                        });
                    }
                },

                close() {
                    this.open = false;
                }
            }));
        });
    </script>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #FFF9F9;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        ::-webkit-scrollbar-thumb {
            background: #ccc; 
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #999; 
        }

        .icon-grid {
            display: grid !important;
            grid-template-columns: repeat(5, minmax(0, 1fr)) !important;
            gap: 0.5rem !important;
            max-height: 250px !important;
            overflow-y: auto !important;
            padding-right: 4px !important;
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
<body class="flex h-screen bg-bg text-text">

    <!-- Sidebar -->
    <aside class="sidebar w-64 flex-shrink-0 hidden lg:flex lg:flex-col bg-surface border-r border-gray-100 shadow-sm z-20">
        <!-- Logo Section -->
        <div class="p-8 flex flex-col items-center justify-center border-b border-gray-50">
            <div class="w-16 mb-4">
                <img src="{{ asset('Logo.png') }}" alt="The Secret" class="w-full h-auto drop-shadow-sm">
            </div>
            <div class="text-center">
                <h1 class="font-serif text-xl font-bold text-primary tracking-wide">The Secret</h1>
                <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">by Umy Fadillaa</p>
            </div>
        </div>
        
        <!-- Navigation Menu -->
        <nav class="flex-1 p-4 overflow-y-auto">
            <p class="px-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 mt-2">Menu Utama</p>
            <ul class="space-y-1 mb-6">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center p-3 rounded-lg transition-all {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-gray-500' }}">
                        <i class="fas fa-th-large w-6 text-center mr-3 text-sm"></i>
                        <span class="font-medium text-sm">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.index') }}" class="sidebar-link flex items-center p-3 rounded-lg transition-all {{ request()->routeIs('admin.products.*') ? 'active' : 'text-gray-500' }}">
                        <i class="fas fa-box-open w-6 text-center mr-3 text-sm"></i>
                        <span class="font-medium text-sm">Produk</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders') }}" class="sidebar-link flex items-center p-3 rounded-lg transition-all {{ request()->routeIs('admin.orders') ? 'active' : 'text-gray-500' }}">
                        <i class="fas fa-shopping-bag w-6 text-center mr-3 text-sm"></i>
                        <span class="font-medium text-sm">Pesanan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.affiliates') }}" class="sidebar-link flex items-center p-3 rounded-lg transition-all {{ request()->routeIs('admin.affiliates') ? 'active' : 'text-gray-500' }}">
                        <i class="fas fa-users w-6 text-center mr-3 text-sm"></i>
                        <span class="font-medium text-sm">Afiliasi</span>
                    </a>
                </li>
            </ul>

            <p class="px-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Keuangan</p>
            <ul class="space-y-1 mb-6">
                <li>
                    <a href="{{ route('admin.commissions') }}" class="sidebar-link flex items-center p-3 rounded-lg transition-all {{ request()->routeIs('admin.commissions') ? 'active' : 'text-gray-500' }}">
                        <i class="fas fa-coins w-6 text-center mr-3 text-sm"></i>
                        <span class="font-medium text-sm">Komisi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.payouts') }}" class="sidebar-link flex items-center p-3 rounded-lg transition-all {{ request()->routeIs('admin.payouts') ? 'active' : 'text-gray-500' }}">
                        <i class="fas fa-money-check-alt w-6 text-center mr-3 text-sm"></i>
                        <span class="font-medium text-sm">Pencairan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reports') }}" class="sidebar-link flex items-center p-3 rounded-lg transition-all {{ request()->routeIs('admin.reports') ? 'active' : 'text-gray-500' }}">
                        <i class="fas fa-chart-pie w-6 text-center mr-3 text-sm"></i>
                        <span class="font-medium text-sm">Laporan</span>
                    </a>
                </li>
            </ul>

            <p class="px-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Sistem</p>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.landing.sections.index') }}" class="sidebar-link flex items-center p-3 rounded-lg transition-all {{ request()->routeIs('admin.landing.sections.*') ? 'active' : 'text-gray-500' }}">
                        <i class="fas fa-layer-group w-6 text-center mr-3 text-sm"></i>
                        <span class="font-medium text-sm">Bagian Landing</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.pages.index') }}" class="sidebar-link flex items-center p-3 rounded-lg transition-all {{ request()->routeIs('admin.pages.*') ? 'active' : 'text-gray-500' }}">
                        <i class="fas fa-file-alt w-6 text-center mr-3 text-sm"></i>
                        <span class="font-medium text-sm">Halaman</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.settings') }}" class="sidebar-link flex items-center p-3 rounded-lg transition-all {{ request()->routeIs('admin.settings') ? 'active' : 'text-gray-500' }}">
                        <i class="fas fa-cog w-6 text-center mr-3 text-sm"></i>
                        <span class="font-medium text-sm">Pengaturan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.fraud_logs') }}" class="sidebar-link flex items-center p-3 rounded-lg transition-all {{ request()->routeIs('admin.fraud_logs') ? 'active' : 'text-gray-500' }}">
                        <i class="fas fa-shield-alt w-6 text-center mr-3 text-sm"></i>
                        <span class="font-medium text-sm">Log Mencurigakan</span>
                    </a>
                </li>
            </ul>
        </nav>
        
        <!-- User Profile Minimal -->
        <div class="p-4 border-t border-gray-50">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-serif font-bold text-xs mr-3">
                        A
                    </div>
                    <div>
                        <p class="text-sm font-bold text-heading">Admin User</p>
                        <p class="text-[10px] text-gray-400">Administrator</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
            <div class="mt-2 text-[10px] text-center text-gray-300">
                v1.0.0 | UMI System
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="bg-surface border-b border-gray-100 py-4 px-6 flex justify-between items-center z-10">
            <div class="flex items-center">
                <button class="mr-4 lg:hidden text-gray-500 hover:text-primary transition-colors">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div class="flex flex-col">
                    <h2 class="text-xl font-serif font-bold text-heading">@yield('title', 'Dashboard')</h2>
                    <p class="text-xs text-gray-400">@yield('subtitle', 'Pantau performa sistem affiliate Anda')</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-6">
                <!-- Notifications -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="text-gray-400 hover:text-primary transition-colors relative">
                        <i class="far fa-bell text-lg"></i>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[9px] w-3 h-3 flex items-center justify-center rounded-full">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>
                    
                    <!-- Notification Dropdown -->
                    <div x-show="open" @click.away="open = false" 
                         class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-100 z-50 overflow-hidden"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100">
                        <div class="p-4 border-b border-gray-50 flex justify-between items-center">
                            <h3 class="text-sm font-bold text-heading">Notifikasi</h3>
                            <form action="{{ route('admin.notifications.read') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-[10px] text-primary font-bold uppercase hover:underline">Tandai semua dibaca</button>
                            </form>
                        </div>
                        <div class="max-h-96 overflow-y-auto">
                            @forelse(auth()->user()->unreadNotifications as $notification)
                                <div class="p-4 border-b border-gray-50 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mt-1">
                                            @if($notification->data['type'] == 'order')
                                                <div class="w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xs">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </div>
                                            @elseif($notification->data['type'] == 'payout')
                                                <div class="w-8 h-8 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-xs">
                                                    <i class="fas fa-money-bill-wave"></i>
                                                </div>
                                            @else
                                                <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs">
                                                    <i class="fas fa-user-plus"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-xs font-bold text-heading">{{ $notification->data['title'] }}</p>
                                            <p class="text-[10px] text-gray-500 mt-0.5">{{ $notification->data['message'] }}</p>
                                            <p class="text-[9px] text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-8 text-center text-gray-400 text-xs italic">
                                    Tidak ada notifikasi baru.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-3 py-1 rounded-full text-xs text-gray-500 border border-gray-100">
                    Today: <span class="font-medium text-heading">{{ date('M j, Y') }}</span>
                </div>
            </div>
        </header>

        <!-- Main Content Scroll Area -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-bg p-6 lg:p-10">
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center shadow-sm" role="alert" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                    <i class="fas fa-check-circle mr-2"></i>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                    <button @click="show = false" class="ml-auto opacity-50 hover:opacity-100">&times;</button>
                </div>
            @endif
            
            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 7000)" class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center shadow-sm" role="alert" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                    <button @click="show = false" class="ml-auto opacity-50 hover:opacity-100">&times;</button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Overlay for mobile -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/20 backdrop-blur-sm z-20 hidden lg:hidden"></div>

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
    <!-- CKEditor 5 -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    @stack('scripts')
</body>
