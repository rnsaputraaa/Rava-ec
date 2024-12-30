<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rava Store</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 text-gray-900">
    <header class="absolute top-0 left-0 right-0 z-50">
        <nav class="bg-transparent">
            <div class="w-full px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <img src="{{ asset('img/logo.png') }}" alt="logo" class="inline-block mr-1" style="width: 50px; height: 50px;">
                        <a class="text-3xl font-bold text-white">Rava</a>
                    </div>

                    <div class="flex items-center space-x-6">
                        @auth
                        <a href="{{ route('dashboard') }}" class="text-white hover:text-red-600 font-medium">Dashboard</a>
                        @else
                        <a href="{{ route('login') }}" class="text-white hover:text-red-600 font-medium">Login</a>
                        <a href="{{ route('register') }}" class="text-white hover:text-red-600 font-medium">Register</a>
                        @endauth

                        <div class="border-l border-white pl-4">
                            <a href="{{ route('cart') }}" class="text-white hover:text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l1.38-6H6.62M7 13l-1 5m14-5l1 5m-3 0a2 2 0 11-4 0m4 0a2 2 0 10-4 0M7 13h10" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="relative h-96 flex items-center justify-center">
        <img src="img/bg.jpg" alt="Razz Store Background" class="absolute inset-0 w-full h-full object-cover">
        <div class="relative z-10 text-center text-white">
            <h1 class="text-4xl md:text-6xl font-bold">Rava Store</h1>
            <p class="mt-4 text-lg">Temukan produk terbaik dengan harga terbaik.</p>
        </div>
    </div>

    <main>
        @yield('content')
    </main>

    <footer class="bg-white py-12 mt-16 border-t border-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">About Us</h3>
                    <p class="mt-4 text-gray-600 leading-relaxed">
                        Razz Store adalah toko e-commerce yang menyediakan berbagai produk berkualitas dengan harga terbaik. Kami berkomitmen memberikan pengalaman belanja terbaik untuk Anda.
                    </p>
                </div>
    
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Contact</h3>
                    <ul class="mt-4 space-y-2">
                        <li class="text-gray-600">Telepon: 0812-4756-4179</li>
                        <li class="text-gray-600">Email: khafifatulmufidah762@gmail.com</li>
                        <li class="text-gray-600">Alamat: Jl.Kh Wachid Hasyim No.13B</li>
                    </ul>
                </div>
    
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Subscribe</h3>
                    <p class="mt-4 text-gray-600 leading-relaxed">
                        Dapatkan informasi terbaru tentang produk dan penawaran khusus kami dengan berlangganan newsletter.
                    </p>
                </div>
            </div>
    
            <div class="mt-12 border-t border-gray-300 pt-6 text-center">
                <p class="text-sm text-gray-500">&copy; 2024 Razz Store.</p>
            </div>
        </div>
    </footer>

</body>
</html>