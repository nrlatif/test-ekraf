<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - EKRAF KUNINGAN</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>
<body class="bg-gradient-to-br from-yellow-300 via-orange-400 to-orange-500 min-h-screen">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Logo & Header -->
            <div class="text-center mb-8">
                <div class="bg-white rounded-full w-24 h-24 mx-auto mb-6 flex items-center justify-center shadow-lg border-4 border-white/50">
                    <img src="{{ asset('assets/img/LogoEkraf.png') }}" alt="EKRAF Logo" class="w-16 h-16 object-contain">
                </div>
                <h1 class="text-3xl font-bold text-white mb-2 drop-shadow-lg">EKRAF KUNINGAN</h1>
            </div>

            <!-- Login Card -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                <!-- Header Card -->
                <div class="bg-gradient-to-r from-green-600 to-green-700 p-6 text-center">
                    <div class="w-16 h-16 bg-white/20 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-lock text-white text-2xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Selamat Datang</h2>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <p class="text-green-600 text-sm font-medium">{{ session('status') }}</p>
                        </div>
                    @endif

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                            @foreach ($errors->all() as $error)
                                <p class="text-red-600 text-sm font-medium">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-envelope mr-2 text-orange-500"></i>
                                Alamat Email
                            </label>
                            <input id="email" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus 
                                   autocomplete="email"
                                   placeholder="Masukkan alamat email Anda"
                                   class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-lg text-gray-800 placeholder-gray-500 focus:outline-none focus:border-orange-400 focus:bg-white transition-all duration-200 font-medium">
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-lock mr-2 text-orange-500"></i>
                                Kata Sandi
                            </label>
                            <input id="password" 
                                   type="password" 
                                   name="password" 
                                   required 
                                   autocomplete="current-password"
                                   placeholder="Masukkan kata sandi Anda"
                                   class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-lg text-gray-800 placeholder-gray-500 focus:outline-none focus:border-orange-400 focus:bg-white transition-all duration-200 font-medium">
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <input id="remember" type="checkbox" name="remember" class="w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 focus:ring-2">
                            <label for="remember" class="ml-3 text-sm font-medium text-gray-600">
                                Ingat saya di perangkat ini
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5" id="loginButton">
                                <span id="loginText">
                                    <i class="fas fa-sign-in-alt mr-2"></i>
                                    Masuk
                                </span>
                                <span id="loadingText" class="hidden">
                                    <i class="fas fa-spinner fa-spin mr-2"></i>
                                    Memproses...
                                </span>
                            </button>
                        </div>
                    </form>

                    <!-- Back to Home -->
                    <div class="mt-4 text-center">
                        <a href="{{ route('landing') }}" class="inline-flex items-center text-orange-600 hover:text-orange-700 font-medium text-sm transition-colors duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-6">
                <p class="text-white/80 text-sm font-medium drop-shadow-sm">
                    © {{ date('Y') }} EKRAF KUNINGAN
                </p>
                <div class="flex items-center justify-center mt-2 space-x-2 text-white/60 text-xs">
                    <span>Ekonomi Kreatif</span>
                    <span>•</span>
                    <span>Kabupaten Kuningan</span>
                    <span>•</span>
                    <span>Jawa Barat</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Simple JavaScript for form interactions -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const loginButton = document.getElementById('loginButton');
            const loginText = document.getElementById('loginText');
            const loadingText = document.getElementById('loadingText');

            // Loading state for form submission
            if (form && loginButton) {
                form.addEventListener('submit', function() {
                    loginButton.disabled = true;
                    loginText.classList.add('hidden');
                    loadingText.classList.remove('hidden');
                    loginButton.classList.add('opacity-75', 'cursor-not-allowed');
                });
            }

            // Auto-focus on email input
            const emailInput = document.getElementById('email');
            if (emailInput) {
                setTimeout(() => emailInput.focus(), 100);
            }
        });
    </script>
</body>
</html>
