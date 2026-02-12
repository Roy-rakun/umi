<!doctype html>
<html lang="id" class="h-full">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $sections['hero']->content['headline'] ?? 'The Secret by Umy Fadilla' }}</title>
  <!-- Vite Assets -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  
  <!-- Alpine.js -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&amp;family=Nunito+Sans:wght@300;400;500;600&amp;display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  
  <!-- Iconify -->
  <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

  <!-- Swiper CSS -->
  <style>
    body {
      box-sizing: border-box;
    }
    
    :root {
      --color-bg: #fff7f6;
      --color-surface: #ffffff;
      --color-text: #4a3f3f;
      --color-primary: #7d2a2a;
      --color-secondary: #d4a574;
    }
    
    * {
      scroll-behavior: smooth;
    }
    
    .font-heading {
      font-family: 'Cormorant Garamond', serif;
    }
    
    .font-body {
      font-family: 'Nunito Sans', sans-serif;
    }
    
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }
    
    .animate-fade-in-up {
      animation: fadeInUp 0.8s ease-out forwards;
    }
    
    .animate-fade-in {
      animation: fadeIn 1s ease-out forwards;
    }
    
    .animate-float {
      animation: float 6s ease-in-out infinite;
    }
    
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
    .delay-400 { animation-delay: 0.4s; }
    .delay-500 { animation-delay: 0.5s; }
    
    .btn-primary {
      background: var(--color-primary);
      color: white;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(125, 42, 42, 0.2);
    }
    
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(125, 42, 42, 0.3);
    }
    
    .btn-secondary {
      background: transparent;
      color: var(--color-primary);
      border: 2px solid var(--color-primary);
      transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
      background: var(--color-primary);
      color: white;
      transform: translateY(-2px);
    }
    
    .card-soft {
      background: var(--color-surface);
      box-shadow: 0 8px 30px rgba(74, 63, 63, 0.08);
      transition: all 0.3s ease;
    }
    
    .card-soft:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 40px rgba(74, 63, 63, 0.12);
    }
    
    .wax-seal {
      width: 120px;
      height: 120px;
      background: linear-gradient(145deg, #8b3a3a, #6b2020);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 
        0 8px 30px rgba(125, 42, 42, 0.4),
        inset 0 2px 10px rgba(255, 255, 255, 0.2),
        inset 0 -2px 10px rgba(0, 0, 0, 0.2);
      position: relative;
    }
    
    .wax-seal::before {
      content: '';
      position: absolute;
      width: 100px;
      height: 100px;
      border: 2px solid rgba(255, 255, 255, 0.2);
      border-radius: 50%;
    }
    
    .section-padding {
      padding: 80px 24px;
    }
    
    @media (min-width: 768px) {
      .section-padding {
        padding: 120px 48px;
      }
    }
    
    .product-image {
      background: linear-gradient(135deg, #f5e6e0 0%, #e8d5cf 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 3rem;
    }
    
    .gallery-item {
      background: linear-gradient(135deg, #f8ece8 0%, #f0ddd7 100%);
      display: flex;
      align-items: center;
      justify-content: center;
    }
  </style>
 </head>
 <body class="h-full font-body" style="background-color: var(--color-bg); color: var(--color-text);">
  <div id="app-wrapper" class="w-full h-full overflow-auto">
   @if(session('success'))
   <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed top-24 left-1/2 transform -translate-x-1/2 z-[60] bg-green-500 text-white px-6 py-3 rounded-2xl shadow-2xl flex items-center gap-3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4">
       <i class="fas fa-check-circle"></i>
       <span class="font-bold">{{ session('success') }}</span>
       <button @click="show = false" class="ml-4 hover:opacity-70">&times;</button>
   </div>
   @endif
   
   <!-- Navigation -->
   <nav class="fixed top-0 left-0 right-0 z-50 bg-opacity-95 backdrop-blur-sm" style="background-color: var(--color-bg);">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
     <div class="flex items-center gap-3">
      @if(isset($sections['hero']->content['logo_url']))
       <img src="{{ $sections['hero']->content['logo_url'] }}" alt="Logo" class="w-10 h-10 object-contain">
      @else
      <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-xs font-heading font-bold" style="background: linear-gradient(145deg, #8b3a3a, #6b2020);">
       TS
      </div>
      @endif
      <span class="font-heading text-xl font-semibold" style="color: var(--color-primary);">{{ $sections['hero']->content['site_name'] ?? 'The Secret' }}</span>
     </div>
     <div class="hidden md:flex items-center gap-8 text-sm">
        <a href="#about" class="hover:opacity-70 transition-opacity">{{ $settings['nav_label_about'] ?? 'Tentang' }}</a> 
        <a href="#products" class="hover:opacity-70 transition-opacity">{{ $settings['nav_label_products'] ?? 'Produk' }}</a> 
        <a href="#affiliate" class="hover:opacity-70 transition-opacity">{{ $settings['nav_label_affiliate'] ?? 'Affiliate' }}</a> 
        <a href="#contact" class="hover:opacity-70 transition-opacity">{{ $settings['nav_label_contact'] ?? 'Kontak' }}</a>
     </div>
    </div>
   </nav>   <!-- Dynamic Sections Loop -->
   @foreach($sections as $section)
       @if($section->key == 'hero')
           <!-- Hero Section -->
           <section id="hero" class="min-h-screen flex items-center section-padding pt-24 md:pt-32">
            <div class="max-w-7xl mx-auto w-full">
             <div class="grid md:grid-cols-2 gap-12 md:gap-16 items-center"><!-- Left: Image -->
              <div class="animate-fade-in-up order-2 md:order-1">
               <div class="relative">
                <div class="aspect-[3/4] rounded-3xl overflow-hidden card-soft max-w-md mx-auto">
                 <div class="w-full h-full bg-gradient-to-br from-rose-100 to-amber-50 flex items-center justify-center p-8">
                  @if(isset($section->content['image_url']) && $section->content['image_url'])
                   <img src="{{ $section->content['image_url'] }}" alt="Hero Image" class="w-full h-full object-cover">
                  @else
                  <svg viewbox="0 0 200 280" class="w-full h-full"><defs>
                    <lineargradient id="skinGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                     <stop offset="0%" style="stop-color:#f5d5c8" />
                     <stop offset="100%" style="stop-color:#e8c4b8" />
                    </lineargradient>
                    <lineargradient id="hijabGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                     <stop offset="0%" style="stop-color:#8b3a3a" />
                     <stop offset="100%" style="stop-color:#6b2020" />
                    </lineargradient>
                    <lineargradient id="dressGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                     <stop offset="0%" style="stop-color:#f8f4f2" />
                     <stop offset="100%" style="stop-color:#e8e0dc" />
                    </lineargradient>
                   </defs> <ellipse cx="100" cy="240" rx="60" ry="50" fill="url(#dressGrad)" /> <rect x="50" y="140" width="100" height="110" rx="20" fill="url(#dressGrad)" /> <!-- Neck --> <rect x="85" y="95" width="30" height="25" fill="url(#skinGrad)" /> <!-- Hijab --> <ellipse cx="100" cy="65" rx="55" ry="50" fill="url(#hijabGrad)" /> <path d="M45 65 Q45 140 70 180 L130 180 Q155 140 155 65" fill="url(#hijabGrad)" /> <!-- Face --> <ellipse cx="100" cy="75" rx="35" ry="40" fill="url(#skinGrad)" /> <!-- Eyes --> <ellipse cx="85" cy="70" rx="5" ry="3" fill="#3d2d2d" /> <ellipse cx="115" cy="70" rx="5" ry="3" fill="#3d2d2d" /> <!-- Eyebrows --> <path d="M78 62 Q85 59 92 62" stroke="#5d4040" stroke-width="1.5" fill="none" /> <path d="M108 62 Q115 59 122 62" stroke="#5d4040" stroke-width="1.5" fill="none" /> <!-- Nose --> <path d="M100 72 L100 82 Q98 85 100 85 Q102 85 100 82" stroke="#d4b0a0" stroke-width="1" fill="none" /> <!-- Smile --> <path d="M90 92 Q100 100 110 92" stroke="#c49080" stroke-width="2" fill="none" stroke-linecap="round" /> <!-- Blush --> <ellipse cx="78" cy="85" rx="8" ry="4" fill="#f0c0b0" opacity="0.5" /> <ellipse cx="122" cy="85" rx="8" ry="4" fill="#f0c0b0" opacity="0.5" /> <!-- Hands --> <ellipse cx="55" cy="200" rx="15" ry="12" fill="url(#skinGrad)" /> <ellipse cx="145" cy="200" rx="15" ry="12" fill="url(#skinGrad)" /> <!-- Decorative elements --> <circle cx="100" cy="140" r="8" fill="url(#hijabGrad)" opacity="0.3" />
                  </svg>
                  @endif
                 </div>
                </div>
                <div class="absolute -bottom-4 -right-4 w-20 h-20 rounded-full animate-float" style="background: linear-gradient(135deg, #d4a574 0%, #c49060 100%); opacity: 0.6;"></div>
               </div>
              </div><!-- Right: Content -->
              <div class="order-1 md:order-2 text-center md:text-left">
               <div class="wax-seal mx-auto md:mx-0 mb-8 animate-fade-in overflow-hidden">
                @if(isset($section->content['logo_url']))
                 <img src="{{ $section->content['logo_url'] }}" alt="Logo" class="w-full h-full object-contain p-4">
                @else
                <div class="text-center text-white"><span class="font-heading text-2xl font-bold block">TS</span> <span class="text-[10px] tracking-widest opacity-80 uppercase">{{ $section->content['site_name'] ?? 'THE SECRET' }}</span>
                </div>
                @endif
               </div>
               <h1 class="font-heading text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6 animate-fade-in-up delay-100" style="color: var(--color-primary);">{{ $section->content['headline'] }}</h1>
               <div class="text-lg md:text-xl leading-relaxed mb-10 opacity-80 animate-fade-in-up delay-200">
                   {!! $section->content['tagline'] !!}
               </div>
                <div class="flex flex-wrap gap-4 justify-center md:justify-start animate-fade-in-up delay-400">
                    @if(!empty($section->content['primary_button']) && !empty($section->content['primary_url']))
                    <a href="{{ $section->content['primary_url'] }}" target="_blank" class="btn-primary px-8 py-4 rounded-2xl font-bold"> {{ $section->content['primary_button'] }} </a>
                    @endif
                    
                    @if(!empty($section->content['buttons']))
                        @foreach($section->content['buttons'] as $btn)
                        <a href="{{ $btn['url'] }}" target="_blank" class="btn-secondary px-8 py-4 rounded-2xl font-bold text-center"> {{ $btn['text'] }} </a>
                        @endforeach
                    @endif
                </div>
              </div>
             </div>
            </div>
           </section>

       @elseif($section->key == 'problem')
           <!-- Problem & Empathy Section -->
           <section id="problem" class="section-padding" style="background: linear-gradient(180deg, #fef5f3 0%, #fff7f6 100%);">
            <div class="max-w-6xl mx-auto">
             <h2 class="font-heading text-3xl md:text-4xl font-bold text-center mb-16" style="color: var(--color-primary);">{{ $section->content['title'] }}</h2>
             <div class="grid md:grid-cols-3 gap-8">
              @foreach(['card_1', 'card_2', 'card_3'] as $idx => $cardKey)
              @php $item = $section->content[$cardKey] ?? null; @endphp
              @if($item)
              <div class="card-soft rounded-3xl p-8 text-center">
               <div class="w-20 h-20 mx-auto mb-6 rounded-full flex items-center justify-center text-3xl" style="background: linear-gradient(135deg, #fef5f3 0%, #f8ece8 100%);">
                @if(isset($item['icon']))
                    <iconify-icon icon="{{ $item['icon'] }}" class="w-10 h-10" style="color: var(--color-primary);"></iconify-icon>
                @else
                    @if($idx == 0)
                    <svg class="w-10 h-10" fill="none" viewbox="0 0 24 24" stroke="currentColor" style="color: var(--color-primary);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg>
                    @elseif($idx == 1)
                    <svg class="w-10 h-10" fill="none" viewbox="0 0 24 24" stroke="currentColor" style="color: var(--color-primary);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                    @else
                    <svg class="w-10 h-10" fill="none" viewbox="0 0 24 24" stroke="currentColor" style="color: var(--color-primary);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707" /></svg>
                    @endif
                @endif
               </div>
               <h3 class="font-heading text-xl font-semibold mb-4" style="color: var(--color-primary);">{{ $item['title'] ?? '' }}</h3>
               <p class="opacity-70 leading-relaxed">{{ $item['description'] ?? '' }}</p>
              </div>
              @endif
              @endforeach
             </div>
             @if(!empty($section->content['buttons']))
             <div class="flex flex-wrap justify-center gap-4 mt-12">
               @foreach($section->content['buttons'] as $btn)
               <a href="{{ $btn['url'] }}" target="_blank" class="btn-primary px-8 py-3 rounded-xl font-bold"> {{ $btn['text'] }} </a>
               @endforeach
             </div>
             @endif
            </div>
           </section>

       @elseif($section->key == 'sosmed')
           <!-- Sosmed Section -->
           <section id="sosmed" class="section-padding" style="background: linear-gradient(180deg, #fff7f6 0%, #fef5f3 100%);">
            <div class="max-w-6xl mx-auto">
             <h2 class="font-heading text-2xl md:text-3xl font-bold text-center mb-12" style="color: var(--color-primary);">{{ $section->content['title'] }}</h2>
             <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
              @foreach($section->content['items'] ?? [] as $item)
              <div class="text-center group">
               <div class="aspect-[3/4] rounded-2xl overflow-hidden shadow-2xl mb-6 transform group-hover:-translate-y-2 transition-transform duration-300 bg-white">
                @if(isset($item['image_url']) && $item['image_url'])
                 <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                @else
                 <div class="w-full h-full flex items-center justify-center bg-gray-50 text-6xl text-gray-200">
                  <iconify-icon icon="{{ $item['icon'] ?? 'lucide:link' }}"></iconify-icon>
                 </div>
                @endif
               </div>
               <h3 class="font-body text-sm font-medium mb-4 opacity-80">{{ $item['name'] }}</h3>
               <a href="{{ $item['button_url'] ?? '#' }}" target="_blank" class="btn-primary inline-block px-10 py-3 rounded-xl font-bold text-sm tracking-wide">
                {{ $item['button_text'] ?? 'Ikuti' }}
               </a>
              </div>
              @endforeach
             </div>
             @if(!empty($section->content['buttons']))
             <div class="flex flex-wrap justify-center gap-4 mt-12">
               @foreach($section->content['buttons'] as $btn)
               <a href="{{ $btn['url'] }}" target="_blank" class="btn-primary px-8 py-3 rounded-xl font-bold"> {{ $btn['text'] }} </a>
               @endforeach
             </div>
             @endif
            </div>
           </section>

       @elseif($section->key == 'about')
           <!-- About Section -->
           <section id="about" class="section-padding">
            <div class="max-w-7xl mx-auto">
             <div class="grid md:grid-cols-2 gap-12 md:gap-16 items-center"><!-- Left: Content -->
              <div><span class="inline-block px-4 py-2 rounded-full text-sm font-medium mb-6" style="background-color: #fef5f3; color: var(--color-primary);">{{ $section->content['badge'] }}</span>
               <h2 class="font-heading text-3xl md:text-4xl font-bold mb-6" style="color: var(--color-primary);">{{ $section->content['title'] }}</h2>
               <div class="space-y-4 leading-relaxed opacity-80">
                {!! $section->content['description'] !!}
               </div>
               <div class="flex items-center gap-6 mt-8">
                  @foreach($section->content['stats'] as $stat)
                  <div class="text-center"><span class="font-heading text-3xl font-bold block" style="color: var(--color-primary);">{{ $stat['value'] }}</span> <span class="text-sm opacity-60">{{ $stat['label'] }}</span>
                  </div>
                  @if(!$loop->last)
                  <div class="w-px h-12 bg-current opacity-20"></div>
                  @endif
                  @endforeach
               </div>
               @if(!empty($section->content['buttons']))
               <div class="flex flex-wrap gap-4 mt-10">
                   @foreach($section->content['buttons'] as $btn)
                   <a href="{{ $btn['url'] }}" target="_blank" class="btn-primary px-8 py-3 rounded-xl font-bold"> {{ $btn['text'] }} </a>
                   @endforeach
               </div>
               @endif
              </div><!-- Right: Gallery -->
              <div class="grid grid-cols-3 gap-3 grid-flow-dense">
               @php
                $gallery = $section->content['gallery'] ?? [];
               @endphp
               @foreach($gallery as $gItem)
                @php
                    $isLarge = isset($gItem['is_large']) && $gItem['is_large'];
                    $hasImage = isset($gItem['image_url']) && $gItem['image_url'];
                    $hasIcon = isset($gItem['icon']) && $gItem['icon'];
                @endphp
                <div class="gallery-item rounded-2xl overflow-hidden {{ $isLarge ? 'col-span-2 row-span-2 text-4xl aspect-square' : 'aspect-square' }}">
                    @if($hasImage)
                        <img src="{{ $gItem['image_url'] }}" class="w-full h-full object-cover">
                    @elseif($hasIcon)
                        <div class="w-full h-full flex items-center justify-center">
                            <iconify-icon icon="{{ $gItem['icon'] }}" class="{{ $isLarge ? 'text-5xl' : 'text-xl' }}" style="color: var(--color-primary);"></iconify-icon>
                        </div>
                    @endif
                </div>
               @endforeach
              </div>
             </div>
            </div>
           </section>

       @elseif($section->key == 'explanation')
           <!-- Program Explanation Section -->
           <section id="explanation" class="section-padding" style="background: linear-gradient(180deg, #fef5f3 0%, #fff7f6 100%);">
            <div class="max-w-4xl mx-auto text-center">
             <div class="wax-seal mx-auto mb-10 animate-float overflow-hidden">
              @if(isset($sections['hero']->content['logo_url']))
               <img src="{{ $sections['hero']->content['logo_url'] }}" alt="Logo" class="w-full h-full object-contain p-4">
              @else
              <div class="text-center text-white"><span class="font-heading text-2xl font-bold block">TS</span> <span class="text-[10px] tracking-widest opacity-80 uppercase">{{ $sections['hero']->content['site_name'] ?? 'THE SECRET' }}</span>
              </div>
              @endif
             </div>
             <h2 class="font-heading text-3xl md:text-4xl font-bold mb-8" style="color: var(--color-primary);">{{ $section->content['title'] }}</h2>
             <div class="space-y-6 leading-relaxed opacity-80 mb-10">
              {!! $section->content['description'] !!}
             </div>
             @if(!empty($section->content['buttons']))
             <div class="flex flex-wrap justify-center gap-4 mt-8">
               @foreach($section->content['buttons'] as $btn)
               <a href="{{ $btn['url'] }}" target="_blank" class="btn-primary px-8 py-3 rounded-xl font-bold"> {{ $btn['text'] }} </a>
               @endforeach
             </div>
             @endif
            </div>
           </section>

       @elseif($section->key == 'products')
           <!-- Products Section -->
           <section id="products" class="section-padding">
            <div class="max-w-7xl mx-auto">
             <div class="text-center mb-16"><span class="inline-block px-4 py-2 rounded-full text-sm font-medium mb-4" style="background-color: #fef5f3; color: var(--color-primary);">Koleksi Eksklusif</span>
              <h2 class="font-heading text-3xl md:text-4xl font-bold" style="color: var(--color-primary);">Produk &amp; Program The Secret</h2>
             </div>
             <div x-data="{ open: false, product: {} }">
              <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
               @foreach($products as $product)
               <div class="card-soft rounded-3xl overflow-hidden flex flex-col">
                <div class="product-image aspect-square text-4xl cursor-pointer hover:opacity-90 transition-opacity" 
                     @click="open = true; product = {{ json_encode($product) }}">
                  @if($product->type == 'physical') 📿 @else 🎓 @endif
                </div>
                <div class="p-6 flex-1 flex flex-col">
                 <h3 class="font-heading text-lg font-semibold mb-2 cursor-pointer hover:opacity-70 transition-opacity" 
                     style="color: var(--color-primary);"
                     @click="open = true; product = {{ json_encode($product) }}">{{ $product->name }}</h3>
                 <p class="text-xs opacity-70 mb-4 line-clamp-2 flex-1">{!! strip_tags($product->description) !!}</p>
                 <div class="flex flex-col gap-3 mt-auto">
                    <span class="font-heading text-lg font-bold" style="color: var(--color-primary);">Rp {{ number_format($product->price, 0, ',', '.') }}</span> 
                    <a href="{{ route('checkout', $product->product_id) }}" target="_blank" class="btn-primary px-5 py-2.5 rounded-xl text-sm text-center font-bold">
                        {{ $product->type == 'physical' ? 'Beli Sekarang' : 'Daftar Sekarang' }}
                    </a>
                 </div>
                </div>
               </div>
               @endforeach
              </div>

              <div class="text-center mt-12">
                  <a href="{{ route('products.index') }}" target="_blank" class="btn-secondary px-8 py-3 rounded-xl font-bold inline-block">Lihat Semua Produk</a>
              </div>
              @if(!empty($section->content['buttons']))
              <div class="flex flex-wrap justify-center gap-4 mt-8">
                @foreach($section->content['buttons'] as $btn)
                <a href="{{ $btn['url'] }}" target="_blank" class="btn-primary px-8 py-3 rounded-xl font-bold"> {{ $btn['text'] }} </a>
                @endforeach
              </div>
              @endif

              <!-- Detail Modal -->
              <template x-teleport="body">
                <div x-show="open" 
                     class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">
                  
                  <div @click.away="open = false" 
                       class="bg-white rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl relative"
                       x-transition:enter="transition ease-out duration-300"
                       x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                       x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                    
                    <button @click="open = false" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200 transition-colors z-10">
                        <i class="fas fa-times"></i>
                    </button>

                    <div class="grid md:grid-cols-2">
                        <div class="aspect-square bg-gradient-to-br from-rose-50 to-amber-50 flex items-center justify-center text-7xl">
                            <span x-text="product.type == 'physical' ? '📿' : '🎓'"></span>
                        </div>
                        <div class="p-8 flex flex-col">
                            <span class="text-xs font-bold uppercase tracking-widest text-amber-600 mb-2" x-text="product.type == 'physical' ? 'Produk Fisik' : 'Kelas Digital'"></span>
                            <h2 class="font-heading text-2xl md:text-3xl font-bold mb-4" style="color: var(--color-primary);" x-text="product.name"></h2>
                            <div class="flex-1 overflow-y-auto max-h-60 mb-6 text-sm leading-relaxed opacity-80 prose prose-sm max-w-none" x-html="product.description"></div>
                            
                            <div class="mt-auto border-t pt-6 flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="text-xs opacity-50 uppercase">Harga</span>
                                    <span class="font-heading text-2xl font-bold" style="color: var(--color-primary);" x-text="'Rp ' + (product.price ? product.price.toLocaleString('id-ID') : '0')"></span>
                                </div>
                                 <a :href="'/checkout/' + product.product_id" target="_blank" class="btn-primary px-8 py-3 rounded-xl font-bold">
                                    <span x-text="product.type == 'physical' ? 'Beli Sekarang' : 'Daftar Sekarang'"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
              </template>
             </div>
            </div>
           </section>

       @elseif($section->key == 'affiliate')
           <!-- Affiliate Section -->
           <section id="affiliate" class="section-padding" style="background: linear-gradient(180deg, #f5ebe8 0%, #f8f0ed 100%);">
            <div class="max-w-5xl mx-auto">
             <div class="text-center mb-12"><span class="inline-block px-4 py-2 rounded-full text-sm font-medium mb-4" style="background-color: #fff7f6; color: var(--color-primary);">{{ $section->content['badge'] }}</span>
              <h2 class="font-heading text-3xl md:text-4xl font-bold mb-4" style="color: var(--color-primary);">{{ $section->content['title'] }}</h2>
              <p class="max-w-2xl mx-auto opacity-80">{{ $section->content['description'] }}</p>
             </div>
             <div class="grid md:grid-cols-3 gap-6 mb-10">
              @foreach(['card_1', 'card_2', 'card_3'] as $idx => $cardKey)
              @php $feature = $section->content[$cardKey] ?? null; @endphp
              @if($feature)
              <div class="card-soft rounded-3xl p-6 text-center">
               <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center text-2xl" style="background: linear-gradient(135deg, #fef5f3 0%, #f8ece8 100%);">
                <iconify-icon icon="{{ $feature['icon'] ?? 'lucide:sparkles' }}" style="color: var(--color-primary);"></iconify-icon>
               </div>
               <h3 class="font-heading text-lg font-semibold mb-2" style="color: var(--color-primary);">{{ $feature['title'] ?? '' }}</h3>
               <p class="text-sm opacity-70">{{ $feature['description'] ?? '' }}</p>
              </div>
              @endif
              @endforeach
             </div>
             <div class="flex flex-col sm:flex-row gap-4 justify-center">
              @if(!empty($section->content['register_button']) && !empty($section->content['register_url']))
              <a href="{{ $section->content['register_url'] }}" target="_blank" class="btn-primary px-8 py-4 rounded-2xl font-semibold text-center"> {{ $section->content['register_button'] }} </a> 
              @endif
              
              @if(!empty($section->content['login_button']) && !empty($section->content['login_url']))
              <a href="{{ $section->content['login_url'] }}" target="_blank" class="btn-secondary px-8 py-4 rounded-2xl font-semibold text-center"> {{ $section->content['login_button'] }} </a>
              @endif
             </div>
             @if(!empty($section->content['buttons']))
             <div class="flex flex-wrap justify-center gap-4 mt-10">
               @foreach($section->content['buttons'] as $btn)
               <a href="{{ $btn['url'] }}" target="_blank" class="btn-primary px-8 py-3 rounded-xl font-bold"> {{ $btn['text'] }} </a>
               @endforeach
             </div>
             @endif
            </div>
           </section>

       @elseif($section->key == 'testimonials')
           <!-- Testimonial Section -->
           <section id="testimonials" class="section-padding">
            <div class="max-w-6xl mx-auto">
             <div class="text-center mb-16"><span class="inline-block px-4 py-2 rounded-full text-sm font-medium mb-4" style="background-color: #fef5f3; color: var(--color-primary);">{{ $section->content['badge'] }}</span>
              <h2 class="font-heading text-3xl md:text-4xl font-bold" style="color: var(--color-primary);">{{ $section->content['title'] }}</h2>
             </div>
             <div class="grid md:grid-cols-3 gap-8">
              @foreach($section->content['items'] as $testimonial)
              <div class="card-soft rounded-3xl p-8 relative">
               <div class="absolute -top-4 left-8 text-6xl font-heading text-primary/20">"</div>
               <p class="italic opacity-80 mb-6 relative z-10">{{ $testimonial['content'] }}</p>
               <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full flex items-center justify-center text-xl" style="background: linear-gradient(135deg, #f8ece8 0%, #f0ddd7 100%);">
                 <iconify-icon icon="{{ $testimonial['avatar'] ?? 'lucide:user' }}" class="text-primary"></iconify-icon>
                </div>
                <div>
                 <div class="font-semibold" style="color: var(--color-primary);">{{ $testimonial['name'] }}</div>
                 <div class="text-sm opacity-60">{{ $testimonial['role'] }}</div>
                </div>
               </div>
              </div>
              @endforeach
             </div>
            </div>
           </section>

       @elseif($section->key == 'contact')
           <!-- Contact Section -->
           <section id="contact" class="section-padding" style="background: linear-gradient(180deg, #fef5f3 0%, #fff7f6 100%);">
            <div class="max-w-4xl mx-auto text-center">
             <h2 class="font-heading text-3xl md:text-4xl font-bold mb-4" style="color: var(--color-primary);">{{ $section->content['title'] }}</h2>
             <p class="opacity-80 mb-10">{{ $section->content['description'] }}</p>
             <div class="flex flex-wrap justify-center gap-4 mb-8">
                @foreach($section->content['channels'] ?? [] as $channel)
                <a href="{{ $channel['url'] }}" target="_blank" rel="noopener noreferrer" class="card-soft rounded-2xl px-6 py-4 flex items-center gap-3 hover:scale-105 transition-transform">
                    <span class="text-2xl flex items-center">
                        <iconify-icon icon="{{ $channel['icon'] ?? 'lucide:link' }}" class="text-primary"></iconify-icon>
                    </span>
                    <span class="font-medium">{{ $channel['name'] }}</span>
                </a>
                @endforeach
             </div>
             <p class="text-sm opacity-60 card-soft inline-block px-4 py-2 rounded-xl">⚠️ {{ $section->content['warning_text'] }}</p>
              @if(!empty($section->content['buttons']))
              <div class="flex flex-wrap justify-center gap-4 mt-10">
                @foreach($section->content['buttons'] as $btn)
                <a href="{{ $btn['url'] }}" target="_blank" class="btn-primary px-8 py-3 rounded-xl font-bold"> {{ $btn['text'] }} </a>
                @endforeach
              </div>
              @endif
            </div>
           </section>
       @elseif($section->key == 'footer')
           <!-- Footer -->
           <footer id="footer" class="py-8 px-6" style="background-color: #f0e6e3;">
            <div class="max-w-6xl mx-auto">
             <div class="flex flex-col md:flex-row items-center justify-between gap-6">
              <div class="flex items-center gap-3">
               @if(isset($sections['hero']->content['logo_url']))
                <img src="{{ $sections['hero']->content['logo_url'] }}" alt="Logo" class="w-8 h-8 object-contain">
               @else
               <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-heading font-bold" style="background: linear-gradient(145deg, #8b3a3a, #6b2020);">
                TS
               </div>
               @endif
               <span class="font-heading font-semibold" style="color: var(--color-primary);">{{ $sections['hero']->content['site_name'] ?? 'The Secret by Umy Fadilla' }}</span>
              </div>
              <div class="flex flex-wrap justify-center gap-6 text-sm opacity-70">
                  @foreach($section->content['links'] as $link)
                  <a href="{{ $link['url'] }}" target="_blank" class="hover:opacity-100 transition-opacity">{{ $link['name'] }}</a>
                  @endforeach
              </div>
               <div class="flex flex-col items-end gap-2">
                   @if(!empty($section->content['buttons']))
                   <div class="flex flex-wrap gap-3 mb-2">
                       @foreach($section->content['buttons'] as $btn)
                       <a href="{{ $btn['url'] }}" target="_blank" class="text-xs font-bold px-4 py-1.5 rounded-lg border border-primary/20 hover:bg-primary/10 transition-colors" style="color: var(--color-primary);"> {{ $btn['text'] }} </a>
                       @endforeach
                   </div>
                   @endif
                   <p class="text-sm opacity-60">{{ $section->content['copyright'] }}</p>
               </div>
             </div>
            </div>
           </footer>
       @endif
   @endforeach
  </div>
  <script>
    // Intersection Observer for fade-in animations
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = '1';
          entry.target.style.transform = 'translateY(0)';
        }
      });
    }, observerOptions);

    document.querySelectorAll('section').forEach(section => {
      section.style.opacity = '0';
      section.style.transform = 'translateY(20px)';
      section.style.transition = 'all 0.6s ease-out';
      observer.observe(section);
    });

    // Make first section visible immediately
    const firstSection = document.querySelector('section');
    if (firstSection) {
      firstSection.style.opacity = '1';
      firstSection.style.transform = 'translateY(0)';
    }

    // Smooth scroll for navigation
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        if (href.startsWith('#')) {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
              target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
      });
    });
  </script>
</body>
</html>
