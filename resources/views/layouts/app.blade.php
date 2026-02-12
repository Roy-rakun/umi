<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'The Secret by Umy Fadillaa')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#7D2E35', // Maroon
                        secondary: '#E8D5B5', // Gold/Beige (kept for subtle accents if needed)
                        bg: '#FFF9F9', // Very Pale Pink
                        pink: '#FFF0F0', // Slightly darker pink for cards
                        text: '#4A4A4A', // Dark Grey
                        heading: '#2C3E50', // Darker Grey/Blueish
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #FFF9F9;
            color: #4A4A4A;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
        }
        .btn-maroon {
            background-color: #7D2E35;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-maroon:hover {
            background-color: #5D2228;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(125, 46, 53, 0.2);
        }
    </style>
</head>
<body class="bg-bg text-text antialiased">

    <!-- Navbar / Header (Minimalist) -->
    <nav class="absolute top-0 w-full z-50 p-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <!-- Back to Home Link (Visible on inner pages) -->
            <div>
                @if(!request()->routeIs('home'))
                <a href="{{ route('home') }}" class="flex items-center text-primary hover:text-primary/80 transition-colors font-medium text-sm md:text-base">
                    <i class="fas fa-arrow-left mr-2"></i> <span class="hidden md:inline">Back to Home</span><span class="md:hidden">Home</span>
                </a>
                @endif
            </div>
            
            <div class="space-x-4">
               @auth
                    <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium hover:text-primary transition-colors">Dashboard</a>
               @endauth
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed top-24 left-1/2 transform -translate-x-1/2 z-50 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg max-w-xl w-full flex justify-between items-start" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div>
                <p class="font-bold">Success!</p>
                <p>{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="opacity-50 hover:opacity-100">&times;</button>
        </div>
    @endif

    @yield('content')

    <!-- Footer Refined -->
    <footer class="bg-[#FFF9F9] py-16 mt-auto border-t border-red-50">
        <div class="max-w-4xl mx-auto px-4 text-center">
             <!-- Logo -->
             <div class="mb-6 flex justify-center">
                 <div class="w-20 md:w-24">
                     <img src="{{ asset('Logo.png') }}" alt="The Secret Logo" class="w-full h-auto drop-shadow-md">
                 </div>
             </div>
             
             <!-- Brand Name -->
             <h3 class="font-serif text-3xl text-heading mb-2">The Secret by Umy Fadillaa</h3>
             <p class="text-gray-500 mb-10">Guiding souls towards inner peace and spiritual growth</p>
             
             <!-- Navigation Links -->
             <div class="flex flex-wrap justify-center gap-6 md:gap-12 text-gray-500 text-sm mb-12 font-medium">
                 <a href="{{ route('page.show', 'privacy-policy') }}" class="hover:text-primary transition-colors">Privacy Policy</a>
                 <span class="text-gray-300">•</span>
                 <a href="{{ route('page.show', 'terms-of-service') }}" class="hover:text-primary transition-colors">Terms of Service</a>
                 <span class="text-gray-300">•</span>
                 <a href="{{ route('page.show', 'affiliate-terms') }}" class="hover:text-primary transition-colors">Affiliate Terms</a>
                 <span class="text-gray-300">•</span>
                 <a href="{{ route('page.show', 'contact') }}" class="hover:text-primary transition-colors">Contact</a>
             </div>
             
             <!-- Copyright -->
             <div class="text-xs text-gray-400 mb-8">
                 &copy; {{ date('Y') }} The Secret by Umy Fadillaa. All rights reserved.
             </div>

             <!-- Quote -->
             <p class="font-serif italic text-primary/60 text-sm">"May your journey be blessed with light and guidance"</p>
        </div>
    </footer>

</body>
</html>
