<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 text-gray-900">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
        <h2 class="text-2xl font-bold text-center">SHOPPING CART</h2>
        <div class="mt-8">
            <table class="min-w-full bg-white shadow-md">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">Produk</th>
                        <th class="px-4 py-2 text-left">Harga</th>
                        <th class="px-4 py-2 text-left">Jumlah</th>
                        <th class="px-4 py-2 text-left">Total</th>
                        <th class="px-4 py-2 text-left">Delete</th>
                    </tr>
                </thead>

                <tbody id="cartItems">
                    <!-- Produk akan dimuat di sini -->
                </tbody>
                
            </table>

            <div class="mt-8 mb-5 flex justify-between items-center">
                <p class="text-xl font-semibold">Total: Rp <span id="totalPrice">0</span></p>
                <div class="flex space-x-4">
                    <button class="px-6 py-2 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700" onclick="checkout()">
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
                totalPrice += totalItemPrice;

                cartItems.innerHTML += `
                    <tr class="border-b">
                        <td class="px-4 py-2">${item.name}</td>
                        <td class="px-4 py-2">Rp ${item.price}</td>
                        <td class="px-4 py-2">
                            <input type="number" value="${item.quantity}" min="1" class="qty-input px-2 py-1 border rounded-md w-16" onchange="updateQuantity(${index}, this.value)">
                        </td>
                        <td class="px-4 py-2">Rp ${totalItemPrice}</td>
                        <td class="px-4 py-2">
                            <button class="text-red-500 hover:text-red-700 font-semibold" onclick="removeItem(${index})">Hapus</button>
                        </td>
                    </tr>
                `;
            });

            document.getElementById('totalPrice').textContent = totalPrice.toLocaleString('id-ID');
        }

        function removeItem(index) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            loadCart();
        }

        function updateQuantity(index, newQuantity) {
            if (newQuantity < 1) {
                alert('Kuantitas minimal adalah 1');
                return;
            }
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart[index].quantity = parseInt(newQuantity);
            localStorage.setItem('cart', JSON.stringify(cart));
            loadCart();
        }

        function checkout() {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            if (cart.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Keranjang Masih Kosong',
                    text: 'tambahkan produk terlebih dahulu',
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
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
                localStorage.removeItem('cart');
                window.location.reload();
            });
        }

        window.onload = loadCart;
    </script>

</body>
</html>