@extends('components.app')

@section('title', 'Point of Sale - Kasir Modern')

@push('styles')
<style>
    .gradient-bg {
        background: #f3f4f6;
    }
    
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    .menu-card {
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid transparent;
    }
    
    .menu-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        border-color: #000;
    }
    
    .menu-card:active {
        transform: translateY(-2px) scale(0.99);
    }
    
    .menu-card.selected {
        border: 2px solid #000;
        background: #f3f4f6;
    }
    
    .cart-item {
        animation: slideIn 0.3s ease-out;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>
@endpush

@section('content')
<div class="min-h-screen gradient-bg py-6">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Menu List -->
            <div class="lg:col-span-2">
                <div class="glass-card rounded-xl p-6 shadow-sm">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <div class="w-10 h-10 bg-black rounded-lg flex items-center justify-center mr-3 shadow-sm">
                            <i class="fas fa-store text-white"></i>
                        </div>
                        Pilih Menu
                    </h2>
                    
                    <!-- Search & Filter -->
                    <div class="flex flex-col md:flex-row gap-4 mb-6">
                        <div class="flex-1 relative">
                            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input 
                                type="text" 
                                id="searchMenu"
                                placeholder="Cari menu..."
                                class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-black focus:border-black transition"
                            >
                        </div>
                        <select 
                            id="filterKategori"
                            class="px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-black focus:border-black transition"
                        >
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori }}">{{ $kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Menu Grid -->
                    <div id="menuGrid" class="grid grid-cols-2 md:grid-cols-3 gap-4 max-h-[600px] overflow-y-auto pr-2">
                        @foreach($menus as $menu)
                            <div class="menu-card glass-card rounded-xl overflow-hidden shadow-sm" 
                                 data-id="{{ $menu->id_menu }}"
                                 data-nama="{{ $menu->nama_menu }}"
                                 data-harga="{{ $menu->harga }}"
                                 data-stok="{{ $menu->stok }}"
                                 data-kategori="{{ $menu->kategori }}"
                                 onclick="addToCart(this)">
                                
                                <!-- Gambar Menu -->
                                <div class="relative h-40 overflow-hidden bg-gray-100">
                                    @if($menu->gambar)
                                        <img src="{{ asset('storage/' . $menu->gambar) }}" 
                                             alt="{{ $menu->nama_menu }}"
                                             class="w-full h-full object-cover transition-all duration-300 hover:scale-105">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                            <i class="fas fa-utensils text-gray-400 text-3xl"></i>
                                        </div>
                                    @endif
                                    
                                    <!-- Stock Badge -->
                                    <div class="absolute top-2 right-2">
                                        <span class="px-2 py-1 rounded text-xs font-bold border border-gray-200 bg-white text-black shadow-sm">
                                            <i class="fas fa-box mr-1"></i>{{ $menu->stok }}
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Info Menu -->
                                <div class="p-3">
                                    <h3 class="font-bold text-gray-900 mb-1 text-sm line-clamp-1">{{ $menu->nama_menu }}</h3>
                                    <p class="text-xs text-gray-500 font-medium mb-2 uppercase tracking-wide">{{ $menu->kategori }}</p>
                                    <div class="flex justify-between items-center">
                                        <p class="text-black font-black text-lg">{{ $menu->harga_format }}</p>
                                        @if($menu->stok > 0)
                                            <span class="text-gray-900 text-xs font-bold">Tersedia</span>
                                        @else
                                            <span class="text-gray-400 text-xs font-bold decoration-line-through">Habis</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Cart & Checkout -->
            <div class="lg:col-span-1">
                <div class="glass-card rounded-xl p-6 sticky top-20 shadow-sm border border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <div class="w-10 h-10 bg-black rounded-lg flex items-center justify-center mr-3 shadow-sm">
                            <i class="fas fa-shopping-cart text-white"></i>
                        </div>
                        Keranjang
                    </h2>
                    
                    <!-- Cart Items -->
                    <div id="cartItems" class="space-y-3 max-h-[400px] overflow-y-auto mb-4 pr-2">
                        <div class="text-center py-12">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-shopping-basket text-gray-400 text-3xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Belum ada item</p>
                            <p class="text-gray-400 text-sm mt-1">Pilih menu untuk memulai</p>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="border-t-2 border-gray-100 pt-4 mb-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700 font-bold uppercase tracking-wide">Subtotal:</span>
                            <span id="subtotal" class="font-black text-3xl text-black">Rp 0</span>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">
                            <i class="fas fa-credit-card mr-2"></i>
                            Metode Pembayaran
                        </label>
                        <select id="metodePembayaran" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-black focus:border-black transition font-semibold">
                            <option value="tunai">Tunai</option>
                            <option value="qris">QRIS</option>
                        </select>
                    </div>

                    <!-- Payment Input -->
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">
                            <i class="fas fa-money-bill-wave mr-2"></i>
                            Jumlah Bayar
                        </label>
                        <input 
                            type="number" 
                            id="jumlahBayar"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-black focus:border-black transition text-lg font-bold"
                            placeholder="0"
                            min="0"
                        >
                        <p id="kembalian" class="text-sm font-bold mt-2"></p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button 
                            id="btnCheckout"
                            onclick="prosesCheckout()"
                            class="w-full bg-black text-white py-4 rounded-lg font-bold hover:bg-gray-800 transition-all disabled:opacity-50 disabled:cursor-not-allowed uppercase tracking-wider"
                            disabled
                        >
                            <i class="fas fa-cash-register mr-2"></i>Proses Pembayaran
                        </button>
                        <button 
                            onclick="clearCart()"
                            class="w-full bg-white border-2 border-gray-200 text-gray-700 py-3 rounded-lg font-bold hover:bg-gray-50 transition-all uppercase tracking-wide"
                        >
                            <i class="fas fa-trash mr-2"></i>Bersihkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Success -->
<div id="successModal" class="hidden fixed inset-0 bg-black bg-opacity-70 z-50 flex items-center justify-center backdrop-blur-sm">
    <div class="bg-white rounded-2xl p-8 max-w-md mx-4 shadow-2xl border border-gray-200">
        <div class="text-center">
            <div class="w-24 h-24 bg-black rounded-full flex items-center justify-center mx-auto mb-4 shadow-xl">
                <i class="fas fa-check text-white text-5xl"></i>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-3">Transaksi Berhasil!</h3>
            <div class="bg-gray-50 rounded-lg p-4 mb-4 border border-gray-100">
                <p class="text-gray-500 mb-1 text-xs font-bold uppercase tracking-wide">No. Transaksi</p>
                <p class="text-2xl font-bold text-black" id="modalNoTransaksi"></p>
            </div>
            <div class="bg-gray-100 rounded-lg p-4 mb-6 border border-gray-200">
                <p class="text-gray-500 mb-1 text-xs font-bold uppercase tracking-wide">Kembalian</p>
                <p class="text-3xl font-bold text-black" id="modalKembalian"></p>
            </div>
            <div class="space-y-3">
                <button onclick="printStruk()" class="w-full bg-black text-white py-3 rounded-lg hover:bg-gray-800 transition-all font-bold uppercase tracking-wide">
                    <i class="fas fa-print mr-2"></i>Print Struk
                </button>
                <button onclick="closeModal()" class="w-full bg-white border-2 border-gray-200 text-gray-700 py-3 rounded-lg hover:bg-gray-50 transition-all font-bold uppercase tracking-wide">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let cart = [];
let currentTransaksiId = null;

function addToCart(element) {
    const id = element.dataset.id;
    const nama = element.dataset.nama;
    const harga = parseFloat(element.dataset.harga);
    const stok = parseInt(element.dataset.stok);

    if (stok <= 0) {
        showNotification('Stok habis!', 'error');
        return;
    }

    const existing = cart.find(item => item.id === id);
    if (existing) {
        if (existing.jumlah < stok) {
            existing.jumlah++;
            element.classList.add('selected');
            setTimeout(() => element.classList.remove('selected'), 300);
        } else {
            showNotification('Stok tidak mencukupi!', 'warning');
            return;
        }
    } else {
        cart.push({ id, nama, harga, jumlah: 1, stok });
        element.classList.add('selected');
        setTimeout(() => element.classList.remove('selected'), 300);
    }

    updateCart();
    showNotification('Item ditambahkan', 'success');
}

function updateCart() {
    const cartItems = document.getElementById('cartItems');
    const subtotalEl = document.getElementById('subtotal');
    const btnCheckout = document.getElementById('btnCheckout');

    if (cart.length === 0) {
        cartItems.innerHTML = `
            <div class="text-center py-12">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-shopping-basket text-gray-400 text-3xl"></i>
                </div>
                <p class="text-gray-500 font-medium">Belum ada item</p>
                <p class="text-gray-400 text-sm mt-1">Pilih menu untuk memulai</p>
            </div>
        `;
        subtotalEl.textContent = 'Rp 0';
        btnCheckout.disabled = true;
        return;
    }

    let html = '';
    let total = 0;

    cart.forEach((item, index) => {
        const subtotal = item.harga * item.jumlah;
        total += subtotal;

        html += `
            <div class="cart-item flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-100">
                <div class="flex-1 mr-3">
                    <p class="font-bold text-gray-900 mb-1">${item.nama}</p>
                    <p class="text-sm text-gray-600 font-bold">Rp ${item.harga.toLocaleString('id-ID')}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <button onclick="updateQuantity(${index}, -1)" class="w-8 h-8 bg-white border border-gray-300 text-gray-700 rounded hover:bg-gray-50 transition-all flex items-center justify-center">
                        <i class="fas fa-minus text-xs"></i>
                    </button>
                    <span class="w-8 text-center font-bold text-lg text-black">${item.jumlah}</span>
                    <button onclick="updateQuantity(${index}, 1)" class="w-8 h-8 bg-black border border-black text-white rounded hover:bg-gray-800 transition-all flex items-center justify-center">
                        <i class="fas fa-plus text-xs"></i>
                    </button>
                </div>
            </div>
        `;
    });

    cartItems.innerHTML = html;
    subtotalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
    btnCheckout.disabled = false;
}

function updateQuantity(index, change) {
    cart[index].jumlah += change;

    if (cart[index].jumlah <= 0) {
        cart.splice(index, 1);
    } else if (cart[index].jumlah > cart[index].stok) {
        showNotification('Stok tidak mencukupi!', 'warning');
        cart[index].jumlah = cart[index].stok;
    }

    updateCart();
}

function clearCart() {
    if (cart.length === 0) return;
    
    if (confirm('Yakin ingin menghapus semua item?')) {
        cart = [];
        updateCart();
        document.getElementById('jumlahBayar').value = '';
        document.getElementById('kembalian').textContent = '';
        showNotification('Keranjang dikosongkan', 'info');
    }
}

document.getElementById('jumlahBayar').addEventListener('input', function() {
    const total = cart.reduce((sum, item) => sum + (item.harga * item.jumlah), 0);
    const bayar = parseFloat(this.value) || 0;
    const kembalian = bayar - total;

    const kembalianEl = document.getElementById('kembalian');
    if (kembalian >= 0) {
        kembalianEl.innerHTML = '<i class="fas fa-check-circle mr-1"></i>Kembalian: <span class="text-black">Rp ' + kembalian.toLocaleString('id-ID') + '</span>';
        kembalianEl.className = 'text-sm font-bold mt-2 text-black';
    } else {
        kembalianEl.innerHTML = '<i class="fas fa-exclamation-circle mr-1"></i>Kurang: <span class="text-gray-500">Rp ' + Math.abs(kembalian).toLocaleString('id-ID') + '</span>';
        kembalianEl.className = 'text-sm font-bold mt-2 text-gray-500';
    }
});

async function prosesCheckout() {
    const total = cart.reduce((sum, item) => sum + (item.harga * item.jumlah), 0);
    const bayar = parseFloat(document.getElementById('jumlahBayar').value) || 0;
    const metode = document.getElementById('metodePembayaran').value;

    if (cart.length === 0) {
        showNotification('Keranjang masih kosong!', 'warning');
        return;
    }

    if (bayar < total) {
        showNotification('Jumlah pembayaran kurang!', 'error');
        return;
    }

    const btnCheckout = document.getElementById('btnCheckout');
    btnCheckout.disabled = true;
    btnCheckout.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';

    const data = {
        items: cart.map(item => ({
            id_menu: item.id,
            jumlah: item.jumlah
        })),
        metode_pembayaran: metode,
        bayar: bayar
    };

    try {
        const response = await fetch('{{ route("transaksi.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        });

        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

        const result = await response.json();

        if (result.success) {
            currentTransaksiId = result.data.id_transaksi;
            document.getElementById('modalNoTransaksi').textContent = '#' + result.data.id_transaksi;
            document.getElementById('modalKembalian').textContent = 'Rp ' + result.data.kembalian.toLocaleString('id-ID');
            document.getElementById('successModal').classList.remove('hidden');
            
            cart = [];
            updateCart();
            document.getElementById('jumlahBayar').value = '';
            document.getElementById('kembalian').textContent = '';
            
            showNotification('Transaksi berhasil!', 'success');
        } else {
            showNotification('Gagal: ' + (result.message || 'Terjadi kesalahan'), 'error');
        }
    } catch (error) {
        showNotification('Terjadi kesalahan: ' + error.message, 'error');
    } finally {
        btnCheckout.disabled = false;
        btnCheckout.innerHTML = '<i class="fas fa-cash-register mr-2"></i>Proses Pembayaran';
    }
}

function closeModal() {
    document.getElementById('successModal').classList.add('hidden');
    currentTransaksiId = null;
}

function printStruk() {
    if (currentTransaksiId) {
        window.open(`/transaksi/${currentTransaksiId}/print`, '_blank');
        closeModal();
    }
}

document.getElementById('searchMenu').addEventListener('input', filterMenu);
document.getElementById('filterKategori').addEventListener('change', filterMenu);

function filterMenu() {
    const search = document.getElementById('searchMenu').value.toLowerCase();
    const kategori = document.getElementById('filterKategori').value;
    const menuCards = document.querySelectorAll('.menu-card');

    menuCards.forEach(card => {
        const nama = card.dataset.nama.toLowerCase();
        const kat = card.dataset.kategori;
        
        const matchSearch = nama.includes(search);
        const matchKategori = !kategori || kat === kategori;

        card.style.display = (matchSearch && matchKategori) ? 'block' : 'none';
    });
}

function showNotification(message, type) {
    const colors = {
        success: 'bg-black border-2 border-white',
        error: 'bg-white border-2 border-black text-black',
        warning: 'bg-gray-800 border-2 border-white',
        info: 'bg-gray-500'
    };
    
    // Adjust text color for error state if needed
    const textColor = type === 'error' ? 'text-black' : 'text-white';
    
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 ${colors[type]} ${textColor} px-6 py-3 rounded-lg shadow-xl z-50 font-bold flex items-center`;
    notification.innerHTML = `<i class="fas fa-${type === 'success' ? 'check' : (type === 'error' ? 'exclamation' : 'info')}-circle mr-2"></i>${message}`;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transition = 'opacity 0.3s';
        setTimeout(() => notification.remove(), 300);
    }, 2000);
}
</script>

<style>
    .line-clamp-1 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
    }
</style>
@endpush