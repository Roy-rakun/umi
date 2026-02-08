1. OVERVIEW DAN STRUKTUR AFFILIATE DASHBOARD
Buat dashboard affiliate single-page responsive dengan 5 section utama:

Sidebar Navigation - Menu navigasi affiliate

Header Welcome - Sambutan personal untuk affiliate

Statistics Cards - 4 kartu statistik performa

Affiliate Link Section - Link affiliate & generator

Commission History - Tabel riwayat komisi

Tech Stack: HTML5, Tailwind CSS, Font Awesome Icons, Inter font family

Color Palette:

Primary: #2C3E50 (Dark Blue - Professional/Trust)

Secondary: #8B7355 (Muted Gold - Premium/Reward)

Accent: #27AE60 (Green - Success/Growth)

Warning: #F39C12 (Orange - Pending)

Light: #F8F9FA (Light Gray - Background)

Dark: #1A252F (Darker Blue - Sidebar)

Text: #333333 (Dark Gray)

Text Light: #6C757D (Gray)

Typography:

Primary Font: 'Inter', sans-serif (Clean, modern, professional)

Spiritual Font: 'Playfair Display', serif untuk quotes/welcome

Monospace: 'SF Mono', 'Monaco', monospace untuk kode/link

Layout: Dashboard dengan sidebar tetap (mobile: hidden) dan konten utama responsive

2. DETAIL SETIAP SECTION DENGAN KODE LENGKAP
STRUKTUR UTAMA AFFILIATE DASHBOARD
html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affiliate Dashboard - The Secret by Umy Fadillaa</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        :root {
            --primary: #2C3E50;
            --secondary: #8B7355;
            --accent: #27AE60;
            --warning: #F39C12;
            --light: #F8F9FA;
            --dark: #1A252F;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F5F7FA;
        }
        
        .affiliate-sidebar {
            background: linear-gradient(180deg, #1A252F 0%, #2C3E50 100%);
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .link-card {
            background: linear-gradient(135deg, #2C3E50 0%, #4A6583 100%);
            border-radius: 12px;
            overflow: hidden;
        }
        
        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .status-paid {
            background-color: rgba(39, 174, 96, 0.1);
            color: #27AE60;
            border: 1px solid rgba(39, 174, 96, 0.3);
        }
        
        .status-approved {
            background-color: rgba(52, 152, 219, 0.1);
            color: #3498DB;
            border: 1px solid rgba(52, 152, 219, 0.3);
        }
        
        .status-pending {
            background-color: rgba(243, 156, 18, 0.1);
            color: #F39C12;
            border: 1px solid rgba(243, 156, 18, 0.3);
        }
        
        .badge-gold {
            background: linear-gradient(135deg, #FFD700 0%, #DAA520 100%);
            color: #333;
            font-weight: 700;
        }
        
        .badge-silver {
            background: linear-gradient(135deg, #C0C0C0 0%, #A9A9A9 100%);
            color: #333;
            font-weight: 700;
        }
        
        .badge-bronze {
            background: linear-gradient(135deg, #CD7F32 0%, #8B4513 100%);
            color: white;
            font-weight: 700;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #F1F1F1;
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #CBD5E0;
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #A0AEC0;
        }
        
        /* Animation for balance */
        @keyframes balance-pulse {
            0%, 100% { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
            50% { box-shadow: 0 4px 6px -1px rgba(39, 174, 96, 0.3); }
        }
        
        .balance-card {
            animation: balance-pulse 3s infinite;
        }
        
        /* Link copy animation */
        @keyframes copy-success {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .copy-success {
            animation: copy-success 0.3s ease;
        }
        
        /* Product button hover */
        .product-btn {
            transition: all 0.3s ease;
        }
        
        .product-btn:hover {
            background-color: #2C3E50;
            color: white;
            transform: translateY(-2px);
        }
        
        /* Welcome message styling */
        .welcome-message {
            background: linear-gradient(135deg, rgba(139, 115, 85, 0.1) 0%, rgba(44, 62, 80, 0.1) 100%);
            border-left: 4px solid #8B7355;
        }
        
        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .affiliate-sidebar {
                transform: translateX(-100%);
            }
            .affiliate-sidebar.active {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="text-gray-800">
    <div class="flex h-screen overflow-hidden">
        
        <!-- ==================== SIDEBAR ==================== -->
        <aside class="affiliate-sidebar w-64 flex-shrink-0 hidden lg:flex lg:flex-col text-white">
            <!-- Logo Section -->
            <div class="p-6 border-b border-gray-700">
                <div class="flex items-center space-x-3">
                    <!-- Logo SVG -->
                    <div class="relative">
                        <svg class="w-10 h-10" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="45" fill="#8B7355" opacity="0.2"/>
                            <path d="M50,20 L60,40 L80,45 L65,60 L70,80 L50,70 L30,80 L35,60 L20,45 L40,40 Z" 
                                  fill="#FFFFFF" opacity="0.9"/>
                            <circle cx="50" cy="50" r="15" fill="#FFFFFF" opacity="0.7"/>
                        </svg>
                        <div class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-[#27AE60] border-2 border-[#1A252F]"></div>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">The Secret</h1>
                        <p class="text-xs text-gray-400">by Umy Fadillaa</p>
                    </div>
                </div>
            </div>
            
            <!-- Affiliate Profile -->
            <div class="p-6 border-b border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-[#FFD700] to-[#DAA520] flex items-center justify-center">
                            <span class="font-bold text-gray-800">SA</span>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-[#27AE60] border-2 border-[#1A252F] flex items-center justify-center">
                            <i class="fas fa-crown text-white text-xs"></i>
                        </div>
                    </div>
                    <div>
                        <p class="font-medium">Sarah Amalia</p>
                        <div class="flex items-center mt-1">
                            <span class="badge-gold text-xs px-2 py-1 rounded-full">Gold Affiliate</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Navigation Menu -->
            <nav class="flex-1 p-4">
                <div class="mb-6">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">OVERVIEW</p>
                    <ul class="space-y-1">
                        <li>
                            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg bg-gray-800 text-white">
                                <i class="fas fa-tachometer-alt w-5 text-center"></i>
                                <span>My Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                                <i class="fas fa-link w-5 text-center"></i>
                                <span>My Links</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="mb-6">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">EARNINGS</p>
                    <ul class="space-y-1">
                        <li>
                            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                                <i class="fas fa-history w-5 text-center"></i>
                                <span>Commission History</span>
                                <span class="ml-auto bg-[#27AE60] text-white text-xs px-2 py-1 rounded-full">127</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                                <i class="fas fa-wallet w-5 text-center"></i>
                                <span>Withdrawals</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">RESOURCES</p>
                    <ul class="space-y-1">
                        <li>
                            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                                <i class="fas fa-box-open w-5 text-center"></i>
                                <span>Products</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                                <i class="fas fa-question-circle w-5 text-center"></i>
                                <span>Help Center</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            
            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-gray-700">
                <div class="text-center">
                    <div class="text-xs text-gray-400 mb-2">Affiliate Since</div>
                    <div class="text-sm text-gray-300">Jan 2023</div>
                    <div class="mt-3">
                        <a href="#" class="text-xs text-gray-400 hover:text-white flex items-center justify-center">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </aside>
        
        <!-- ==================== MAIN CONTENT ==================== -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Top Header -->
            <header class="bg-white border-b border-gray-200 py-4 px-6">
                <div class="flex items-center justify-between">
                    <!-- Left: Page Title & Mobile Menu -->
                    <div class="flex items-center space-x-4">
                        <!-- Mobile Menu Button -->
                        <button class="lg:hidden text-gray-600" id="mobile-menu-button">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        
                        <div>
                            <div class="flex items-center space-x-2">
                                <h1 class="text-xl font-bold text-gray-800">My Dashboard</h1>
                                <span class="hidden md:inline text-sm text-gray-600">• Track your affiliate performance</span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1 lg:hidden">Welcome, Sarah Amalia</p>
                        </div>
                    </div>
                    
                    <!-- Right: Quick Actions -->
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="relative p-2 text-gray-600 hover:text-gray-800">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">2</span>
                        </button>
                        
                        <!-- Quick Withdraw -->
                        <button class="hidden md:flex items-center space-x-2 bg-gradient-to-r from-[#27AE60] to-[#2ECC71] hover:opacity-90 text-white px-4 py-2 rounded-lg font-medium transition-all">
                            <i class="fas fa-donate"></i>
                            <span>Withdraw</span>
                        </button>
                        
                        <!-- Profile Dropdown -->
                        <div class="relative">
                            <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#FFD700] to-[#DAA520] flex items-center justify-center">
                                    <span class="font-bold text-gray-800 text-sm">SA</span>
                                </div>
                                <div class="hidden md:block text-left">
                                    <p class="text-sm font-medium">Sarah Amalia</p>
                                    <p class="text-xs text-gray-500">Gold Affiliate</p>
                                </div>
                                <i class="fas fa-chevron-down text-gray-500 hidden md:block"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-4 md:p-6">
                
                <!-- Welcome Banner -->
                <div class="mb-6 md:mb-8">
                    <div class="welcome-message rounded-xl p-6">
                        <div class="flex items-start">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-[#8B7355] to-[#2C3E50] flex items-center justify-center mr-4">
                                <i class="fas fa-hands-praying text-white text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-xl font-bold text-gray-800 mb-2">Welcome back, Sarah</h2>
                                <p class="text-gray-700 leading-relaxed">
                                    <span class="font-playfair italic">"May your efforts be meaningful and blessed."</span>
                                    <br>
                                    Your dashboard is ready. Track your progress and continue building with integrity.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
                    
                    <!-- Total Earnings -->
                    <div class="stat-card p-4 md:p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Total Earnings</p>
                                <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mt-1">Rp 8.5M</h3>
                            </div>
                            <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-[#27AE60]/20 to-[#27AE60]/10 flex items-center justify-center">
                                <i class="fas fa-money-bill-wave text-[#27AE60] text-xl"></i>
                            </div>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            <span>All time earnings</span>
                        </div>
                    </div>
                    
                    <!-- Total Clicks -->
                    <div class="stat-card p-4 md:p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Total Clicks</p>
                                <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mt-1">3,842</h3>
                            </div>
                            <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-[#3498DB]/20 to-[#3498DB]/10 flex items-center justify-center">
                                <i class="fas fa-mouse-pointer text-[#3498DB] text-xl"></i>
                            </div>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-chart-line mr-2"></i>
                            <span>+12% from last month</span>
                        </div>
                    </div>
                    
                    <!-- Successful Orders -->
                    <div class="stat-card p-4 md:p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Successful Orders</p>
                                <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mt-1">127</h3>
                            </div>
                            <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-[#8B7355]/20 to-[#8B7355]/10 flex items-center justify-center">
                                <i class="fas fa-shopping-cart text-[#8B7355] text-xl"></i>
                            </div>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check-circle mr-2 text-green-500"></i>
                            <span>Conversion: 3.3%</span>
                        </div>
                    </div>
                    
                    <!-- Available Balance -->
                    <div class="stat-card p-4 md:p-6 balance-card">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Available Balance</p>
                                <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mt-1">Rp 2.1M</h3>
                            </div>
                            <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-[#2ECC71]/20 to-[#2ECC71]/10 flex items-center justify-center">
                                <i class="fas fa-wallet text-[#2ECC71] text-xl"></i>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-600">
                                <i class="fas fa-coins mr-2"></i>
                                <span>Ready to withdraw</span>
                            </div>
                            <button class="text-sm bg-[#27AE60] hover:bg-[#219653] text-white px-3 py-1 rounded-md transition-colors">
                                Withdraw
                            </button>
                        </div>
                    </div>
                    
                </div>
                
                <!-- Main Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    
                    <!-- Left Column: Affiliate Link Section -->
                    <div>
                        <!-- Affiliate Link Card -->
                        <div class="link-card p-6 mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-white mb-1">Your Affiliate Link</h3>
                                    <p class="text-gray-200 text-sm">Share this link to earn commissions</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center">
                                    <i class="fas fa-link text-white"></i>
                                </div>
                            </div>
                            
                            <!-- Link Display -->
                            <div class="bg-white/10 rounded-lg p-4 mb-4">
                                <div class="flex items-center">
                                    <div class="flex-1 overflow-x-auto">
                                        <code class="text-white font-mono text-sm md:text-base whitespace-nowrap">
                                            https://thesecret.id/ref/sarah-amalia-2024?product=workshop
                                        </code>
                                    </div>
                                    <button id="copy-link-btn" class="ml-4 bg-white text-[#2C3E50] hover:bg-gray-100 px-4 py-2 rounded-lg font-medium transition-colors whitespace-nowrap">
                                        <i class="far fa-copy mr-2"></i>Copy Link
                                    </button>
                                </div>
                                <div class="mt-2 text-xs text-gray-300">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    This link tracks all clicks and sales automatically
                                </div>
                            </div>
                            
                            <!-- Social Share Buttons -->
                            <div class="flex flex-wrap gap-2">
                                <button class="flex-1 bg-white/10 hover:bg-white/20 text-white px-3 py-2 rounded-lg text-sm transition-colors flex items-center justify-center">
                                    <i class="fab fa-whatsapp mr-2"></i> WhatsApp
                                </button>
                                <button class="flex-1 bg-white/10 hover:bg-white/20 text-white px-3 py-2 rounded-lg text-sm transition-colors flex items-center justify-center">
                                    <i class="fab fa-telegram mr-2"></i> Telegram
                                </button>
                                <button class="flex-1 bg-white/10 hover:bg-white/20 text-white px-3 py-2 rounded-lg text-sm transition-colors flex items-center justify-center">
                                    <i class="fas fa-envelope mr-2"></i> Email
                                </button>
                            </div>
                        </div>
                        
                        <!-- Product Link Generator -->
                        <div class="bg-white rounded-xl p-6 shadow-lg">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Generate link for specific product:</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <button class="product-btn p-4 rounded-lg border border-gray-200 hover:border-[#2C3E50] text-center transition-all">
                                    <div class="w-10 h-10 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center mx-auto mb-2">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Premium Course</span>
                                </button>
                                
                                <button class="product-btn p-4 rounded-lg border border-gray-200 hover:border-[#2C3E50] text-center transition-all">
                                    <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mx-auto mb-2">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">E-Book Collection</span>
                                </button>
                                
                                <button class="product-btn p-4 rounded-lg border border-gray-200 hover:border-[#2C3E50] text-center transition-all">
                                    <div class="w-10 h-10 rounded-lg bg-green-100 text-green-600 flex items-center justify-center mx-auto mb-2">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Masterclass</span>
                                </button>
                                
                                <button class="product-btn p-4 rounded-lg border border-gray-200 hover:border-[#2C3E50] text-center transition-all active">
                                    <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center mx-auto mb-2">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Workshop</span>
                                </button>
                            </div>
                            <div class="mt-4 text-sm text-gray-600">
                                <i class="fas fa-lightbulb mr-2 text-amber-500"></i>
                                <span>Tip: Specific product links have higher conversion rates</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column: Quick Stats & Tips -->
                    <div class="space-y-6">
                        <!-- Performance Chart Placeholder -->
                        <div class="bg-white rounded-xl p-6 shadow-lg">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold text-gray-800">This Month's Performance</h3>
                                <select class="text-sm border border-gray-300 rounded-lg px-3 py-1">
                                    <option>January 2024</option>
                                    <option>December 2023</option>
                                </select>
                            </div>
                            <div class="h-48 bg-gray-50 rounded-lg flex items-center justify-center mb-4">
                                <div class="text-center">
                                    <i class="fas fa-chart-bar text-4xl text-gray-300 mb-2"></i>
                                    <p class="text-gray-500">Performance chart will appear here</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4 text-center">
                                <div>
                                    <p class="text-sm text-gray-600">Clicks</p>
                                    <p class="font-bold text-gray-800">428</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Conversions</p>
                                    <p class="font-bold text-gray-800">14</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Earnings</p>
                                    <p class="font-bold text-green-600">Rp 1.2M</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Quick Tips -->
                        <div class="bg-gradient-to-br from-[#8B7355] to-[#2C3E50] rounded-xl p-6 text-white">
                            <h3 class="text-lg font-bold mb-4 flex items-center">
                                <i class="fas fa-lightbulb mr-3"></i>
                                Pro Tips for Success
                            </h3>
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-300 mr-3 mt-1"></i>
                                    <span>Share your personal experience with the products</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-300 mr-3 mt-1"></i>
                                    <span>Use specific product links for higher conversions</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-300 mr-3 mt-1"></i>
                                    <span>Post during peak engagement hours (7-9 PM)</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-300 mr-3 mt-1"></i>
                                    <span>Build trust by being authentic and transparent</span>
                                </li>
                            </ul>
                            <div class="mt-4 pt-4 border-t border-white/20">
                                <a href="#" class="text-sm hover:underline inline-flex items-center">
                                    View complete affiliate guide
                                    <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <!-- Commission History Table -->
                <div class="table-container">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Commission History</h3>
                                <p class="text-gray-600 text-sm">Track your earnings transparently</p>
                            </div>
                            <div class="flex space-x-2">
                                <button class="text-sm text-[#2C3E50] hover:text-[#8B7355] font-medium flex items-center">
                                    <i class="fas fa-download mr-2"></i>
                                    Export CSV
                                </button>
                                <select class="text-sm border border-gray-300 rounded-lg px-3 py-1">
                                    <option>All Status</option>
                                    <option>Paid</option>
                                    <option>Approved</option>
                                    <option>Pending</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <th class="px-6 py-3">DATE</th>
                                    <th class="px-6 py-3">PRODUCT</th>
                                    <th class="px-6 py-3">ORDER VALUE</th>
                                    <th class="px-6 py-3">COMMISSION</th>
                                    <th class="px-6 py-3">STATUS</th>
                                    <th class="px-6 py-3">ACTION</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                
                                <!-- Row 1 -->
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="font-medium text-gray-900">Jan 15, 2024</p>
                                            <p class="text-xs text-gray-500">10:32 AM</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center mr-3">
                                                <i class="fas fa-graduation-cap text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">Premium Course Bundle</p>
                                                <p class="text-xs text-gray-500">#ORD-2024-0015</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-gray-900">Rp 2,500,000</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-green-600">Rp 375,000</p>
                                        <p class="text-xs text-gray-500">15% commission</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="status-paid px-3 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-check mr-1"></i>Paid
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button class="text-[#2C3E50] hover:text-[#8B7355]">
                                            <i class="fas fa-receipt"></i>
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Row 2 -->
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="font-medium text-gray-900">Jan 14, 2024</p>
                                            <p class="text-xs text-gray-500">3:45 PM</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                                                <i class="fas fa-book text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">E-Book Collection</p>
                                                <p class="text-xs text-gray-500">#ORD-2024-0014</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-gray-900">Rp 450,000</p>
                                        <p class="text-xs text-green-600">-10% promo</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-green-600">Rp 67,500</p>
                                        <p class="text-xs text-gray-500">15% commission</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="status-paid px-3 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-check mr-1"></i>Paid
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button class="text-[#2C3E50] hover:text-[#8B7355]">
                                            <i class="fas fa-receipt"></i>
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Row 3 -->
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="font-medium text-gray-900">Jan 13, 2024</p>
                                            <p class="text-xs text-gray-500">9:15 AM</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-lg bg-green-100 text-green-600 flex items-center justify-center mr-3">
                                                <i class="fas fa-chalkboard-teacher text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">Masterclass Access</p>
                                                <p class="text-xs text-gray-500">#ORD-2024-0013</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-gray-900">Rp 1,800,000</p>
                                        <p class="text-xs text-gray-500">Installment payment</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-blue-600">Rp 270,000</p>
                                        <p class="text-xs text-gray-500">15% commission</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="status-approved px-3 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-check-double mr-1"></i>Approved
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button class="text-[#2C3E50] hover:text-[#8B7355]">
                                            <i class="fas fa-receipt"></i>
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Row 4 -->
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="font-medium text-gray-900">Jan 12, 2024</p>
                                            <p class="text-xs text-gray-500">2:20 PM</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center mr-3">
                                                <i class="fas fa-users text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">Workshop Recording</p>
                                                <p class="text-xs text-gray-500">#ORD-2024-0012</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-gray-900">Rp 350,000</p>
                                        <p class="text-xs text-amber-600">Early bird price</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-amber-600">Rp 52,500</p>
                                        <p class="text-xs text-gray-500">15% commission</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="status-pending px-3 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-clock mr-1"></i>Pending
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button class="text-[#2C3E50] hover:text-[#8B7355]">
                                            <i class="fas fa-question-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Row 5 -->
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="font-medium text-gray-900">Jan 10, 2024</p>
                                            <p class="text-xs text-gray-500">11:05 AM</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center mr-3">
                                                <i class="fas fa-graduation-cap text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">Premium Course Bundle</p>
                                                <p class="text-xs text-gray-500">#ORD-2024-0010</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-gray-900">Rp 2,500,000</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-green-600">Rp 375,000</p>
                                        <p class="text-xs text-gray-500">15% commission</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="status-paid px-3 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-check mr-1"></i>Paid
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button class="text-[#2C3E50] hover:text-[#8B7355]">
                                            <i class="fas fa-receipt"></i>
                                        </button>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Table Footer -->
                    <div class="p-4 border-t border-gray-200 bg-gray-50">
                        <div class="flex flex-col md:flex-row justify-between items-center">
                            <div class="text-sm text-gray-600 mb-2 md:mb-0">
                                Showing <span class="font-semibold">1–5</span> of <span class="font-semibold">127</span> results
                            </div>
                            <div class="flex items-center space-x-2">
                                <button class="w-8 h-8 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="w-8 h-8 rounded-lg bg-[#2C3E50] text-white flex items-center justify-center">1</button>
                                <button class="w-8 h-8 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 flex items-center justify-center">2</button>
                                <button class="w-8 h-8 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 flex items-center justify-center">3</button>
                                <span class="text-gray-500">...</span>
                                <button class="w-8 h-8 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 flex items-center justify-center">13</button>
                                <button class="w-8 h-8 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Bottom Quick Links -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="#" class="bg-white rounded-xl p-4 border border-gray-200 hover:border-[#8B7355] hover:shadow-md transition-all flex items-center">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Performance Analytics</p>
                            <p class="text-sm text-gray-600">Detailed reports & insights</p>
                        </div>
                    </a>
                    
                    <a href="#" class="bg-white rounded-xl p-4 border border-gray-200 hover:border-[#8B7355] hover:shadow-md transition-all flex items-center">
                        <div class="w-10 h-10 rounded-lg bg-green-100 text-green-600 flex items-center justify-center mr-3">
                            <i class="fas fa-gift"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Referral Bonuses</p>
                            <p class="text-sm text-gray-600">Earn extra for referrals</p>
                        </div>
                    </a>
                    
                    <a href="#" class="bg-white rounded-xl p-4 border border-gray-200 hover:border-[#8B7355] hover:shadow-md transition-all flex items-center">
                        <div class="w-10 h-10 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center mr-3">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Achievements</p>
                            <p class="text-sm text-gray-600">Unlock rewards & levels</p>
                        </div>
                    </a>
                </div>
                
            </main>
            
            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 py-4 px-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-sm text-gray-600 mb-2 md:mb-0">
                        <span class="font-medium">Affiliate Dashboard</span> • 
                        <span class="text-green-600">Gold Tier</span> • 
                        <span>Next payout: Jan 31, 2024</span>
                    </div>
                    <div class="text-sm text-gray-600">
                        <span>© 2024 The Secret by Umy Fadillaa</span>
                        <span class="mx-2 hidden md:inline">•</span>
                        <span class="hidden md:inline">Need help? <a href="#" class="text-[#2C3E50] hover:underline">Contact Support</a></span>
                    </div>
                </div>
            </footer>
            
        </div>
    </div>
    
    <!-- Mobile Sidebar Overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden" id="mobile-overlay"></div>
    
    <!-- JavaScript -->
    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileOverlay = document.getElementById('mobile-overlay');
        const sidebar = document.querySelector('.affiliate-sidebar');
        
        if (mobileMenuButton && mobileOverlay && sidebar) {
            mobileMenuButton.addEventListener('click', () => {
                sidebar.classList.toggle('hidden');
                sidebar.classList.toggle('flex');
                sidebar.classList.toggle('fixed');
                sidebar.classList.toggle('inset-y-0');
                sidebar.classList.toggle('left-0');
                sidebar.classList.toggle('z-50');
                mobileOverlay.classList.toggle('hidden');
            });
            
            mobileOverlay.addEventListener('click', () => {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('flex', 'fixed', 'inset-y-0', 'left-0', 'z-50');
                mobileOverlay.classList.add('hidden');
            });
        }
        
        // Copy link functionality
        const copyLinkBtn = document.getElementById('copy-link-btn');
        if (copyLinkBtn) {
            copyLinkBtn.addEventListener('click', () => {
                const link = 'https://thesecret.id/ref/sarah-amalia-2024?product=workshop';
                navigator.clipboard.writeText(link).then(() => {
                    // Change button appearance temporarily
                    const originalHTML = copyLinkBtn.innerHTML;
                    copyLinkBtn.innerHTML = '<i class="fas fa-check mr-2"></i>Copied!';
                    copyLinkBtn.classList.add('copy-success');
                    copyLinkBtn.style.backgroundColor = '#27AE60';
                    copyLinkBtn.style.color = 'white';
                    
                    setTimeout(() => {
                        copyLinkBtn.innerHTML = originalHTML;
                        copyLinkBtn.classList.remove('copy-success');
                        copyLinkBtn.style.backgroundColor = '';
                        copyLinkBtn.style.color = '';
                    }, 2000);
                    
                    // Show notification
                    showNotification('Link copied to clipboard!');
                });
            });
        }
        
        // Product button selection
        document.querySelectorAll('.product-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons
                document.querySelectorAll('.product-btn').forEach(b => {
                    b.classList.remove('active', 'bg-[#2C3E50]', 'text-white');
                    b.classList.add('border-gray-200', 'text-gray-700');
                });
                
                // Add active class to clicked button
                this.classList.remove('border-gray-200', 'text-gray-700');
                this.classList.add('active', 'bg-[#2C3E50]', 'text-white');
                
                // Update affiliate link based on product
                const product = this.querySelector('span').textContent.trim();
                updateAffiliateLink(product);
            });
        });
        
        function updateAffiliateLink(product) {
            const productMap = {
                'Premium Course': 'premium-course',
                'E-Book Collection': 'ebook-collection', 
                'Masterclass': 'masterclass',
                'Workshop': 'workshop'
            };
            
            const productSlug = productMap[product] || 'workshop';
            const newLink = `https://thesecret.id/ref/sarah-amalia-2024?product=${productSlug}`;
            
            // Update link display
            const linkDisplay = document.querySelector('code');
            if (linkDisplay) {
                linkDisplay.textContent = newLink;
            }
            
            showNotification(`Link updated for ${product}`);
        }
        
        function showNotification(message) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-gray-800 text-white px-4 py-3 rounded-lg shadow-lg z-50 transform translate-x-full opacity-0 transition-all duration-300';
            notification.textContent = message;
            notification.id = 'temp-notification';
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full', 'opacity-0');
                notification.classList.add('translate-x-0', 'opacity-100');
            }, 10);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.classList.remove('translate-x-0', 'opacity-100');
                notification.classList.add('translate-x-full', 'opacity-0');
                
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }
        
        // Table row click for details
        document.querySelectorAll('tbody tr').forEach(row => {
            row.addEventListener('click', (e) => {
                // Don't trigger if clicking on a button
                if (!e.target.closest('button') && !e.target.tagName === 'BUTTON') {
                    const orderId = row.querySelector('.text-gray-500')?.textContent || '#ORD-XXXX';
                    alert(`Viewing details for ${orderId}`);
                    // In real implementation, would open a modal or navigate
                }
            });
        });
        
        // Initialize tooltips
        document.querySelectorAll('[data-tooltip]').forEach(el => {
            el.addEventListener('mouseenter', (e) => {
                const tooltip = document.createElement('div');
                tooltip.className = 'absolute bg-gray-900 text-white text-xs px-2 py-1 rounded z-50';
                tooltip.textContent = el.getAttribute('data-tooltip');
                
                const rect = el.getBoundingClientRect();
                tooltip.style.top = `${rect.top - 30}px`;
                tooltip.style.left = `${rect.left + rect.width/2 - 50}px`;
                tooltip.style.width = '100px';
                tooltip.style.textAlign = 'center';
                
                document.body.appendChild(tooltip);
                el._tooltip = tooltip;
            });
            
            el.addEventListener('mouseleave', () => {
                if (el._tooltip) {
                    el._tooltip.remove();
                }
            });
        });
        
        // Simulate real-time updates
        function simulateRealTimeUpdates() {
            // Simulate new commission notification
            setInterval(() => {
                const shouldNotify = Math.random() > 0.7; // 30% chance
                if (shouldNotify) {
                    showNotification('New commission earned! Check your history.');
                }
            }, 30000); // Every 30 seconds
        }
        
        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            simulateRealTimeUpdates();
            
            // Set current date in footer
            const now = new Date();
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            const dateString = now.toLocaleDateString('en-US', options);
            
            const dateElements = document.querySelectorAll('.current-date');
            dateElements.forEach(el => {
                el.textContent = dateString;
            });
        });
    </script>
    
</body>
</html>
3. DETAIL TEKNIS DAN SPESIFIKASI
A. Responsive Breakpoints:
Mobile: < 640px - Single column, hamburger menu, stacked stats

Tablet: 641px - 1024px - 2-column stats, scrollable tables

Desktop: > 1025px - Full dashboard dengan sidebar fixed

B. Icon Specifications:
Navigation: fa-tachometer-alt, fa-link, fa-history, fa-wallet, fa-box-open, fa-question-circle

Stats: fa-money-bill-wave, fa-mouse-pointer, fa-shopping-cart, fa-wallet

Status: fa-check (Paid), fa-check-double (Approved), fa-clock (Pending)

Products: fa-graduation-cap, fa-book, fa-chalkboard-teacher, fa-users

Actions: fa-copy, fa-download, fa-receipt, fa-question-circle

C. Color Coding System:
Gold Affiliate: Gradient #FFD700 to #DAA520

Silver Affiliate: Gradient #C0C0C0 to #A9A9A9

Bronze Affiliate: Gradient #CD7F32 to #8B4513

Paid Status: Green (#27AE60) dengan opacity background

Approved Status: Blue (#3498DB) dengan opacity background

Pending Status: Orange (#F39C12) dengan opacity background

Product Colors: Purple (Course), Blue (E-book), Green (Masterclass), Amber (Workshop)

D. Typography Hierarchy:
H1: text-xl font-bold text-gray-800 - Page titles

H2: text-lg font-bold text-gray-800 - Section headers

H3: text-lg font-bold - Card titles

Body: text-gray-700 - Regular text

Quote: font-playfair italic - Spiritual quotes

Monospace: font-mono untuk links dan codes

E. Border Radius System:
Small: rounded (4px) - buttons kecil, badges

Medium: rounded-lg (8px) - icons, product buttons

Large: rounded-xl (12px) - cards utama, containers

Full: rounded-full - avatars, circular elements

F. Animation System:
Hover Effects: translateY(-2px) dengan shadow increase

Copy Success: Scale animation dengan color change

Balance Pulse: Subtle shadow pulse untuk highlight

Notifications: Slide-in dari kanan dengan fade

G. Component States:
Buttons: Hover state dengan background/color changes

Product Buttons: Active state dengan full background fill

Table Rows: Hover dengan bg-gray-50

Cards: Hover dengan elevation increase

Links: Underline on hover untuk text links

4. INTERAKSI DAN FUNGSIONALITAS
Copy Link Feature:
Button berubah menjadi "Copied!" dengan check icon

Animasi feedback saat berhasil copy

Notifikasi muncul di pojok kanan atas

Link bisa dibagikan ke WhatsApp, Telegram, Email

Product Link Generator:
4 produk dengan icons dan colors berbeda

Active state menunjukkan produk yang dipilih

Link affiliate diperbarui otomatis berdasarkan produk

Tooltip dengan conversion tips

Table Features:
Sortable columns (bisa di-expand)

Filter berdasarkan status (Paid/Approved/Pending)

Export ke CSV functionality

Pagination dengan page numbers

Row click untuk detail view

Real-time Updates:
Simulasi notifikasi komisi baru

Balance updates otomatis

Performance stats refresh

Notification badges update

Mobile Optimizations:
Hamburger menu untuk sidebar

Touch-friendly buttons dan controls

Scrollable tables dengan horizontal scroll

Stacked layout untuk small screens

5. DATA DISPLAY FORMATS
Currency Formatting:
Large: Rp 8.5M (jutaan)

Medium: Rp 375,000 (ribuan)

Small: Rp 52,500 (ratusan)

Format: new Intl.NumberFormat('id-ID').format(amount)

Date Formatting:
Table: Jan 15, 2024 dengan time 10:32 AM

Compact: Jan 15 untuk mobile

Relative: 2 days ago untuk recent items

Future: Next payout: Jan 31, 2024

Percentage Formatting:
Positive: +12% dengan warna hijau

Negative: -5% dengan warna merah (jika ada)

Conversion: 3.3% dengan 1 decimal place

Commission: 15% tanpa decimal untuk rates

Number Formatting:
Large: 3,842 dengan thousands separator

Compact: 1.2K untuk display di small spaces

Precise: 3.3% dengan 1 decimal untuk rates

ID Formatting: Menggunakan locale Indonesia

6. AFFILIATE-SPECIFIC FEATURES
Level System:
Gold: Highest commission rates, priority support

Silver: Medium commission rates, standard support

Bronze: Basic commission rates, community support

Visual: Badge dengan gradient sesuai level

Performance Tracking:
Click tracking dengan trend indicators

Conversion rate calculations

Earnings breakdown per product

Monthly performance comparisons

Educational Content:
Pro tips untuk meningkatkan conversions

Best practices untuk affiliate marketing

Product knowledge resources

Success stories dan case studies

Support System:
Help center access

Direct support contact

FAQ section

Community forum link

7. SECURITY FEATURES
Session Management:
Auto-logout setelah inactivity

Secure session tokens

Device recognition

Login history tracking

Data Protection:
Masked affiliate links

Secure API endpoints

Encrypted personal data

GDPR compliance ready

Fraud Prevention:
Click tracking validation

Order verification systems

Suspicious activity alerts

Manual review flags

Privacy Controls:
Data export functionality

Account deletion option

Privacy settings

Communication preferences

8. INTEGRATION POINTS
API Endpoints:
javascript
const AFFILIATE_API = {
  dashboard: '/api/affiliate/dashboard',
  stats: '/api/affiliate/stats',
  links: '/api/affiliate/links',
  commissions: '/api/affiliate/commissions',
  withdraw: '/api/affiliate/withdraw',
  profile: '/api/affiliate/profile'
};

// Example: Load dashboard data
async function loadAffiliateData() {
  try {
    const response = await fetch(AFFILIATE_API.dashboard);
    const data = await response.json();
    updateDashboard(data);
  } catch (error) {
    showError('Failed to load data');
  }
}
WebSocket for Real-time:
javascript
// Real-time commission updates
const affiliateSocket = new WebSocket('wss://thesecret.com/affiliate-updates');

affiliateSocket.onmessage = (event) => {
  const data = JSON.parse(event.data);
  switch(data.type) {
    case 'new_commission':
      addCommissionToTable(data.commission);
      updateBalance(data.balance);
      break;
    case 'status_update':
      updateCommissionStatus(data.commission_id, data.status);
      break;
  }
};
Social Sharing:
javascript
function shareToWhatsApp(link) {
  const text = `Check out this amazing spiritual product: ${link}`;
  const url = `https://wa.me/?text=${encodeURIComponent(text)}`;
  window.open(url, '_blank');
}

function shareToTelegram(link) {
  const text = `Amazing spiritual resource: ${link}`;
  const url = `https://t.me/share/url?url=${encodeURIComponent(link)}&text=${encodeURIComponent(text)}`;
  window.open(url, '_blank');
}
Export Functionality:
javascript
function exportCommissionsToCSV() {
  const rows = [
    ['Date', 'Product', 'Order Value', 'Commission', 'Status'],
    // ... data rows
  ];
  
  const csvContent = rows.map(row => row.join(',')).join('\n');
  const blob = new Blob([csvContent], { type: 'text/csv' });
  const url = URL.createObjectURL(blob);
  
  const a = document.createElement('a');
  a.href = url;
  a.download = `commissions-${new Date().toISOString().split('T')[0]}.csv`;
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
}
CATATAN PENTING UNTUK DEVELOPER:

Personalization: Dashboard menampilkan nama affiliate dan level

Motivational Elements: Quote spiritual dan encouragement messages

Transparency: Semua calculations jelas dan transparan

Ease of Use: Copy link dan share buttons mudah diakses

Mobile First: Optimized untuk affiliate yang pakai mobile

Performance: Fast loading untuk real-time updates

Security: Affiliate links protected dari abuse

Scalability: Siap untuk ratusan/thousands of affiliates

Untuk Laravel Integration:

Gunakan Laravel Sanctum untuk affiliate authentication

Implementasi role-based access (affiliate vs admin)

Gunakan Laravel Cashier untuk payout management

Setup Laravel Notifications untuk commission alerts

Implementasi Laravel Horizon untuk background jobs

Dashboard affiliate ini dirancang untuk memberikan pengalaman yang empowering, transparan, dan mudah digunakan bagi affiliate untuk melacak performa dan earnings mereka.