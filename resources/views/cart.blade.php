<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
        <div class="bg-white p-6 mb-5 border-b-4 border-red-600">
            <h2 class="text-2xl font-bold text-center text-gray-800">KERANJANG</h2>
        </div>
        <div class="mt-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="divide-y divide-gray-200">
                    <div id="cartItems" class="divide-y divide-gray-200">
                        <!-- Produk dimuat di sini -->
                    </div>
                </div>
            </div>

            <div class="mt-8 mb-5 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <input type="checkbox" id="selectAll" class="w-4 h-4 text-red-600 rounded border-gray-300" onchange="toggleSelectAll()">
                    <label for="selectAll" class="text-sm font-medium">Pilih Semua</label>
                </div>
                <div class="flex items-center space-x-8">
                    <p class="text-xl font-semibold">Total: Rp <span id="totalPrice">0</span></p>
                    <button class="px-6 py-2 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 transition duration-300" onclick="checkout()">
                        Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function loadCart() {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            let cartItems = document.getElementById('cartItems');
            let totalPrice = 0;
            cartItems.innerHTML = '';

            cart.forEach((item, index) => {
                let totalItemPrice = item.price * item.quantity;
                if (item.selected) {
                    totalPrice += totalItemPrice;
                }

                cartItems.innerHTML += `
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center space-x-4">
                            <input type="checkbox" 
                                class="cart-checkbox w-4 h-4 text-red-600 rounded border-gray-300"
                                ${item.selected ? 'checked' : ''} 
                                onchange="toggleItemSelection(${index}, this.checked)">
                            <div class="flex-shrink-0 w-20 h-20 sm:w-24 sm:h-24">
                                <img src="${item.image}" alt="${item.name}" 
                                    class="w-full h-full object-cover rounded-md"
                                    onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full bg-gray-200 flex items-center justify-center rounded-md\'><span class=\'text-gray-400\'>No Image</span></div>'">
                            </div>
                            <div class="flex-1">
                                <h3 class="text-base sm:text-lg font-medium text-gray-900">${item.name}</h3>
                                <p class="mt-1 text-sm sm:text-base text-gray-500">Rp ${item.price.toLocaleString('id-ID')}</p>
                                <div class="mt-2 flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                                    <div class="flex items-center border rounded-md">
                                        <button class="px-3 py-1 border-r hover:bg-gray-100" onclick="updateQuantity(${index}, ${item.quantity - 1})">-</button>
                                        <input type="number" value="${item.quantity}" min="1" 
                                            class="qty-input w-16 px-2 py-1 text-center border-none focus:ring-0" 
                                            onchange="updateQuantity(${index}, this.value)">
                                        <button class="px-3 py-1 border-l hover:bg-gray-100" onclick="updateQuantity(${index}, ${item.quantity + 1})">+</button>
                                    </div>
                                    <p class="font-medium">Rp ${totalItemPrice.toLocaleString('id-ID')}</p>
                                    <button class="text-red-500 hover:text-red-700" onclick="removeItem(${index})">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            document.getElementById('totalPrice').textContent = totalPrice.toLocaleString('id-ID');
            updateSelectAllCheckbox();
        }

        function toggleSelectAll() {
            const selectAllCheckbox = document.getElementById('selectAll');
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart = cart.map(item => ({...item, selected: selectAllCheckbox.checked}));
            localStorage.setItem('cart', JSON.stringify(cart));
            loadCart();
        }

        function updateSelectAllCheckbox() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const selectAllCheckbox = document.getElementById('selectAll');
            selectAllCheckbox.checked = cart.length > 0 && cart.every(item => item.selected);
        }

        function toggleItemSelection(index, checked) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart[index].selected = checked;
            localStorage.setItem('cart', JSON.stringify(cart));
            loadCart();
        }

        function removeItem(index) {
            Swal.fire({
                title: 'Hapus Produk',
                text: 'Ingin menghapus produk ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let cart = JSON.parse(localStorage.getItem('cart')) || [];
                    cart.splice(index, 1);
                    localStorage.setItem('cart', JSON.stringify(cart));
                    loadCart();
                }
            });
        }

        function updateQuantity(index, newQuantity) {
            if (newQuantity < 1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Quantity',
                    text: 'Kuantitas minimal adalah 1',
                    confirmButtonColor: '#dc2626',
                });
                return;
            }
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart[index].quantity = parseInt(newQuantity);
            localStorage.setItem('cart', JSON.stringify(cart));
            loadCart();
        }

        function checkout() {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const selectedItems = cart.filter(item => item.selected);
            
            if (cart.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Keranjang Kosong',
                    text: 'Tambahkan produk terlebih dahulu',
                    confirmButtonColor: '#dc2626',
                });
                return;
            }

            if (selectedItems.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Produk Dulu',
                    text: 'Pilih produk yang ingin di checkout',
                    confirmButtonColor: '#dc2626',
                });
                return;
            }

            Swal.fire({
                icon: 'success',
                title: 'Checkout Berhasil',
                text: 'Pesanan Anda telah diproses.',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                cart = cart.filter(item => !item.selected);
                localStorage.setItem('cart', JSON.stringify(cart));
                loadCart();
            });
        }

        window.onload = loadCart;
    </script>

</body>
</html>