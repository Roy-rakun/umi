<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - The Secret</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-arabic { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-[#F8F5F0] h-screen flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-[#E8E1D5]">
        <div class="p-8">
            <div class="text-center mb-8">
                <h1 class="font-arabic text-3xl font-bold text-[#2C3E50] mb-2">Welcome Back</h1>
                <p class="text-gray-500">Sign in to your account</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-lg mb-6 text-sm">
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
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                    <input type="email" name="email" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-[#8B7355] transition-colors" placeholder="you@example.com" value="{{ old('email') }}" required>
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" name="password" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-[#8B7355] transition-colors" placeholder="••••••••" required>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-[#8B7355] to-[#9B87B8] text-white font-bold py-3 px-4 rounded-lg hover:opacity-90 transition-opacity shadow-md">
                    Sign In
                </button>
            </form>
        </div>
        <div class="bg-gray-50 px-8 py-4 border-t border-gray-100 text-center text-sm">
            <p class="text-gray-600">Don't have an account? <a href="#" class="text-[#8B7355] font-semibold hover:underline">Register (Coming Soon)</a></p>
        </div>
    </div>
</body>
</html>
