@extends('layouts.home')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white p-6 mt-5">
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">KATEGORI</h2>

            @if(isset($categories) && $categories->isNotEmpty())
            <div class="flex flex-wrap justify-center items-center gap-6">
                @foreach($categories as $category)
                <a href="{{ route('category.products', $category->id) }}" data-category-url="{{ route('category.products', $category->id) }}" class="group hover:scale-105 transition-transform duration-300">
                    <div class="bg-white w-24 h-24 rounded-full shadow-lg group-hover:bg-red-600 group-hover:shadow-2xl flex flex-col justify-center items-center mx-auto mb-4 border-2 border-red-600 group-hover:border-white">

                        @if($category->name == 'Elektronik')
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-red-600 group-hover:text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                        </svg>

                        @elseif($category->name == 'Fashion')
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-red-600 group-hover:text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>

                        @elseif($category->name == 'Figure')
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-red-600 group-hover:text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a3 3 0 110-6 3 3 0 010 6zM8.25 21v-3.75a3.75 3.75 0 017.5 0V21M9 11.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm7.5 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM9.75 14.25h4.5m-4.5 2.25h4.5" />
                        </svg>                                                                            

                        @elseif($category->name == 'Otomotif')
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-red-600 group-hover:text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 15l1.5-6h13.5l1.5 6M5.25 15.75a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm13.5 0a1.5 1.5 0 100 3 1.5 1.5 0 000-3zM2.25 15H21.75M4.5 9V5.25A2.25 2.25 0 016.75 3h10.5a2.25 2.25 0 012.25 2.25V9" />
                        </svg>                                        
                        @endif

                    </div>
                    <p class="text-lg font-semibold text-gray-800 group-hover:text-red-600 text-center">{{ $category->name }}</p>
                </a>
                @endforeach
            </div>

            @else
            <p class="text-gray-500 italic text-center">Tidak ada kategori tersedia.</p>
            @endif

        </div>
    </div>
</div>    

<div id="produk" class="py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white p-4 sm:p-6 mb-4 sm:mb-5 border-b-4 border-red-600">
            <h2 class="text-xl sm:text-2xl font-bold text-center text-gray-800">
                {{ $selectedCategory->name ?? 'PRODUK' }}
            </h2>
        </div>

        @if(isset($products) && $products->isNotEmpty())
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-8">
            @foreach($products as $product)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:scale-105 transition-transform duration-300">
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-40 sm:h-56 object-cover product-image">
                @else
                    <div class="w-full h-40 sm:h-56 bg-gray-200 flex items-center justify-center">
                        <span class="text-sm sm:text-base text-gray-400">No Image</span>
                    </div>
                @endif
                
                <div class="p-3 sm:p-5">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800 truncate">{{ $product->name }}</h3>
                    <p class="mt-1 sm:mt-2 text-sm sm:text-base text-gray-500">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <button 
                        type="button"
                        onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, '{{ $product->image ? Storage::url($product->image) : '' }}')"
                        class="mt-2 sm:mt-4 w-full bg-red-600 text-white py-1.5 sm:py-2 px-3 sm:px-4 rounded-md text-sm sm:text-base font-medium hover:bg-red-700 transition duration-300">
                        Tambah Keranjang
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

<script>
    let isLoggedIn = @json(auth()->check());

    document.addEventListener('DOMContentLoaded', function() {
        @if(session('refresh'))
            localStorage.setItem('justLoggedIn', 'true');
        @endif

        if (localStorage.getItem('justLoggedIn') === 'true') {
            localStorage.removeItem('justLoggedIn');
            location.reload();
        }
    });

    function addToCart(productId, productName, productPrice, imageUrl) {
        if (!isLoggedIn) {
            Swal.fire({
                icon: 'warning',
                title: 'Login Dulu Yaa :)',
                text: 'login dulu untuk melakukan pembelian',
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
                image: imageUrl,
                quantity: 1,
                selected: false
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
@endsection