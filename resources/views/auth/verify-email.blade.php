<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - The Secret</title>
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
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl p-8 border border-pink-100 text-center">
        <h1 class="font-heading text-3xl font-bold mb-4" style="color: var(--color-primary);">Verifikasikan Email Anda</h1>
        
        <p class="text-gray-600 leading-relaxed mb-6">
            Terima kasih telah mendaftar! Sebelum mulai, silakan verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan ke email Anda.
        </p>

        @if (session('message'))
            <div class="bg-green-50 text-green-700 p-4 rounded-2xl mb-6 text-sm">
                Tautan verifikasi baru telah dikirim ke alamat email Anda.
            </div>
        @endif

        <div class="flex flex-col gap-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full px-8 py-3 bg-[#7d2a2a] text-white font-bold rounded-2xl hover:bg-[#5d1f1f] transition-all shadow-lg active:scale-95">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-[#7d2a2a] font-bold hover:underline">
                    Keluar
                </button>
            </form>
        </div>
    </div>
</body>
</html>
捉
