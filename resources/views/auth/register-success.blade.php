<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Bergabung - The Secret</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@700&family=Nunito+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-bg: #fff7f6;
            --color-primary: #7d2a2a;
        }
        body {
            background-color: var(--color-bg);
            font-family: 'Nunito Sans', sans-serif;
        }
        .font-heading {
            font-family: 'Cormorant Garamond', serif;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full text-center">
        <!-- Image with Pastel Background -->
        <div class="mb-8 p-4 bg-white/50 rounded-3xl shadow-sm inline-block">
            <img src="{{ asset('assets/img/regis-greetings.png') }}" alt="Greeting" class="max-w-full h-auto rounded-2xl">
        </div>

        <h1 class="font-heading text-3xl font-bold mb-4" style="color: var(--color-primary);">Hi {{ $name }}</h1>
        
        <p class="text-gray-600 leading-relaxed mb-6">
            Selamat bergabung menjadi keluarga besar kami, silahkan membuka email anda dan verifikasikan email via link dari kami ya.
        </p>

        <div class="space-y-2 text-sm text-gray-500">
            <p>Silakan masuk terlebih dahulu.</p>
            <p>Anda akan dialihkan kembali ke halaman login dalam <span id="timer" class="font-bold">8</span> detik...</p>
        </div>

        <div class="mt-8">
            <a href="{{ route('login') }}" class="inline-block px-8 py-3 bg-[#7d2a2a] text-white font-bold rounded-2xl hover:bg-[#5d1f1f] transition-all shadow-lg active:scale-95">
                Masuk Sekarang
            </a>
        </div>
    </div>

    <script>
        let seconds = 8;
        const timerElement = document.getElementById('timer');
        
        const countdown = setInterval(() => {
            seconds--;
            timerElement.innerText = seconds;
            if (seconds <= 0) {
                clearInterval(countdown);
                window.location.href = "{{ route('login') }}";
            }
        }, 1000);
    </script>
</body>
</html>
