<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - The Secret</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Nunito+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-primary: #7d2a2a;
        }
        body { font-family: 'Nunito Sans', sans-serif; background-color: #fff7f6; }
        .font-heading { font-family: 'Cormorant Garamond', serif; }
    </style>
</head>
<body class="h-screen flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl overflow-hidden border border-pink-100">
        <div class="p-8">
            <div class="text-center mb-8">
                <h1 class="font-heading text-4xl font-bold text-[#7d2a2a] mb-2">Welcome Back</h1>
                <p class="text-gray-400 text-sm">Sign in to your account</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1 ml-1">Email Address</label>
                    <input type="email" name="email" class="w-full px-4 py-3 rounded-xl border border-pink-100 bg-pink-50/10 focus:outline-none focus:border-[#7d2a2a] focus:ring-1 focus:ring-[#7d2a2a] transition-all" placeholder="you@example.com" value="{{ old('email') }}" required>
                </div>
                
                <div class="mb-6">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1 ml-1">Password</label>
                    <input type="password" name="password" class="w-full px-4 py-3 rounded-xl border border-pink-100 bg-pink-50/10 focus:outline-none focus:border-[#7d2a2a] focus:ring-1 focus:ring-[#7d2a2a] transition-all" placeholder="••••••••" required>
                </div>

                <button type="submit" class="w-full bg-[#7d2a2a] text-white font-bold py-4 px-4 rounded-2xl hover:bg-[#5d1f1f] transition-all shadow-lg shadow-red-900/20 active:scale-[0.98]">
                    Sign In
                </button>
            </form>
        </div>
        <div class="bg-pink-50/30 px-8 py-5 border-t border-pink-100 text-center text-sm">
            <p class="text-gray-500">Don't have an account? <a href="{{ route('register') }}" class="text-[#7d2a2a] font-bold hover:underline">Register</a></p>
        </div>
    </div>
</body>
</html>
