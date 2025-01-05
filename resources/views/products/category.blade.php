<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 text-gray-900">
    <div id="produk" class="py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-4 sm:p-6 mb-4 sm:mb-5 border-b-4 border-red-600 flex justify-between items-center">
                <h2 class="text-xl sm:text-2xl font-bold text-center text-gray-800">
                    {{ $selectedCategory->name ?? 'PRODUK' }}
                </h2>

                <div>
                    <label for="sortPrice" class="text-sm font-medium text-gray-800 mr-2">Urutkan:</label>
                    <select id="sortPrice" onchange="sortProducts()"
                        class="py-2 px-4 rounded-md bg-red-600 text-white font-medium border-none shadow-md focus:outline-none focus:ring-2 focus:ring-red-500 hover:bg-red-700 transition duration-300">
                        <option value="asc" class="bg-white text-black">Harga Terendah ke Tertinggi</option>
                        <option value="desc" class="bg-white text-black">Harga Tertinggi ke Terendah</option>
                    </select>
                </div>
            </div>

            @if(isset($products) && $products->isNotEmpty())
            <div id="productGrid" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-8">
                @foreach($products as $product)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden product-card hover:scale-105 transition-transform duration-300"
                    data-price="{{ $product->price }}">
                    @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                        class="w-full h-40 sm:h-56 object-cover">
                    @else
                    <div class="w-full h-40 sm:h-56 bg-gray-200 flex items-center justify-center">
                        <span class="text-sm sm:text-base text-gray-400">No Image</span>
                    </div>
                    @endif

                    <div class="p-3 sm:p-5">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800 truncate">{{ $product->name }}</h3>
                        <p class="mt-1 sm:mt-2 text-sm sm:text-base text-gray-500">Rp
                            {{ number_format($product->price, 0, ',', '.') }}</p>
                        <button onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, '{{ $product->image }}')"
                            class="mt-2 sm:mt-4 w-full bg-red-600 text-white py-1.5 sm:py-2 px-3 sm:px-4 rounded-md text-sm sm:text-base font-medium hover:bg-red-700 transition duration-300">
                            Tambah ke Keranjang
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-center text-gray-500 text-sm sm:text-base italic">Tidak ada produk tersedia.</p>
            @endif

        </div>
    </div>

    <footer class="bg-white py-12 mt-16 border-t border-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">About Us</h3>
                    <p class="mt-4 text-gray-600 leading-relaxed">
                        Razz Store adalah toko e-commerce yang menyediakan berbagai produk berkualitas dengan harga
                        terbaik. Kami berkomitmen memberikan pengalaman belanja terbaik untuk Anda.
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Contact</h3>
                    <ul class="mt-4 space-y-2">
                        <li class="text-gray-600">Telepon: 0812-4756-4179</li>
                        <li class="text-gray-600">Email: ramanurj@gmail.com</li>
                        <li class="text-gray-600">Alamat: Jl.Kh Wachid Hasyim No.13B</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Subscribe</h3>
                    <p class="mt-4 text-gray-600 leading-relaxed">
                        Dapatkan informasi terbaru tentang produk dan penawaran khusus kami dengan berlangganan
                        newsletter.
                    </p>
                </div>
            </div>

            <div class="mt-12 border-t border-gray-300 pt-6 text-center">
                <p class="text-sm text-gray-500">&copy; 2024 Razz Store.</p>
            </div>
        </div>
    </footer>

    <script>
        function sortProducts() {
            const sortValue = document.getElementById('sortPrice').value;
            const productGrid = document.getElementById('productGrid');
            const productCards = Array.from(productGrid.getElementsByClassName('product-card'));

            productCards.sort((a, b) => {
                const priceA = parseInt(a.getAttribute('data-price'));
                const priceB = parseInt(b.getAttribute('data-price'));

                return sortValue === 'asc' ? priceA - priceB : priceB - priceA;
            });

            productGrid.innerHTML = '';
            productCards.forEach(card => productGrid.appendChild(card));
        }

        function addToCart(productId, productName, productPrice, productImage) {
            if (!{{ auth()->check() ? 'true' : 'false' }}) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Login Dulu Yaa :)',
                    text: 'Login dulu untuk melakukan pembelian',
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#dc2626',
                });
                return;
            }

            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            let productIndex = cart.findIndex(item => item.id === productId);

            if (productIndex > -1) {
                cart[productIndex].quantity += 1;
            } else {
                cart.push({
                    id: productId,
                    name: productName,
                    price: productPrice,
                    image: productImage,
                    quantity: 1
                });
            }

            localStorage.setItem('cart', JSON.stringify(cart));

            Swal.fire({
                icon: 'success',
                title: 'Produk Ditambahkan',
                text: `${productName} ditambah ke keranjang.`,
                showConfirmButton: false,
                timer: 1500
            });
        }
    </script>

</body>
</html>