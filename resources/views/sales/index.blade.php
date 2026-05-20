@extends('layouts.pos')

@section('page')
    <div class="flex overflow-hidden bg-background text-on-surface">



        {{-- MAIN --}}
        <main class="ml-[260px] flex-1 flex flex-col min-h-screen overflow-hidden">



            {{-- CONTENT --}}
            <div class="flex-1 overflow-hidden p-6 flex flex-col gap-5">
                @if(session('success'))
                    <div class="px-4 py-3 rounded-xl bg-primary/10 text-primary border border-primary/20">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="px-4 py-3 rounded-xl bg-error-container text-on-error-container border border-error/20">
                        {{ session('error') }}
                    </div>
                @endif
                {{-- SWITCHER --}}
                <div class="grid grid-cols-2 gap-3">

                    <button id="productsTabBtn" class="h-14 rounded-xl bg-secondary text-white font-bold shadow">
                        Produits
                    </button>

                    <button id="salesTabBtn" class="h-14 rounded-xl bg-surface-container text-on-surface">
                        Historique des ventes
                    </button>

                </div>

                {{-- PRODUCTS TAB --}}
                <div id="productsTab" class="flex-1 overflow-hidden flex flex-col gap-4">

                    {{-- SEARCH --}}
                    <div class="relative">

                        <span
                            class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">
                            search
                        </span>

                        <input id="searchInput" type="text" placeholder="Rechercher un produit..."
                            class="w-full bg-surface-container-low border border-outline-variant rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-secondary/20">

                    </div>

                    {{-- TABLE --}}
                    <div
                        class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm flex-1 overflow-hidden flex flex-col">

                        {{-- TABLE HEADER --}}
                        <div
                            class="grid grid-cols-[1fr_120px_120px_90px] bg-surface-container-low border-b border-outline-variant px-6 py-4 shrink-0">

                            <span class="text-label-caps uppercase text-on-surface-variant">
                                Produit
                            </span>

                            <span class="text-label-caps uppercase text-center text-on-surface-variant">
                                Prix
                            </span>

                            <span class="text-label-caps uppercase text-center text-on-surface-variant">
                                Stock
                            </span>

                            <span class="text-label-caps uppercase text-center text-on-surface-variant">
                                ActionF
                            </span>

                        </div>

                        {{-- TABLE BODY --}}
                        <div id="productsList" class="flex-1 overflow-y-auto custom-scrollbar">

                            @foreach($products as $product)

                                                <div class="product-slot grid grid-cols-[1fr_120px_120px_90px] items-center px-6 py-4 border-b border-outline-variant hover:bg-surface-container-low transition"
                                                    data-name="{{ strtolower($product->name) }}">


                                                    {{-- PRODUCT --}}
                                                    <div class="flex items-center gap-3 min-w-0">

                                                        <div
                                                            class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center shrink-0">

                                                            <div
                                                                class="w-10 h-10 bg-surface-container rounded-lg flex items-center justify-center">
                                                                <span class="material-symbols-outlined text-3xl">
                                                                    {{ $product->category->icon ?? 'restaurant' }}
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="min-w-0">

                                                            <p class="font-bold truncate">
                                                                {{ $product->name }}
                                                            </p>

                                                            <p class="text-[11px] text-on-surface-variant">
                                                                CODE : {{ $product->id }}
                                                            </p>

                                                        </div>

                                                    </div>

                                                    {{-- PRICE --}}
                                                    <div class="text-center font-bold text-on-surface">
                                                        {{ number_format($product->price, 2) }} DA
                                                    </div>

                                                    {{-- STOCK --}}
                                                    <div class="flex justify-center">

                                                        <span
                                                            class="px-2 py-1 rounded-full text-[11px] font-bold
                                                                                                                                                {{ $product->quantity_stock <= 5
                                ? 'bg-error-container text-on-error-container'
                                : 'bg-primary-container/20 text-on-primary-container'
                                                                                                                                                }}">
                                                            {{ $product->quantity_stock }} pces
                                                        </span>

                                                    </div>

                                                    {{-- ACTION --}}
                                                    <div class="flex justify-center">

                                                        <button type="button"
                                                            class="add-product-btn w-9 h-9 rounded-full bg-secondary text-white flex items-center justify-center active:scale-95 transition"
                                                            data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                                            data-price="{{ $product->price }}">

                                                            <span class="material-symbols-outlined text-[18px]">
                                                                add
                                                            </span>

                                                        </button>

                                                    </div>

                                                </div>

                            @endforeach

                        </div>

                    </div>

                </div>
                {{-- SALES TAB --}}
                <div id="salesTab" class="hidden flex-1 overflow-hidden">

                    <div
                        class="bg-surface-container-lowest rounded-xl border border-outline-variant h-full flex flex-col shadow-sm overflow-hidden">

                        {{-- HEADER --}}
                        <div
                            class="grid grid-cols-[100px_1fr_180px_220px] bg-surface-container-low border-b border-outline-variant px-6 py-4">

                            <span>ID</span>
                            <span>Utilisateur</span>
                            <span>Total</span>
                            <span class="text-center">Actions</span>

                        </div>

                        {{-- SALES --}}
                        <div class="flex-1 overflow-y-auto custom-scrollbar">

                            @foreach($sales as $sale)

                                                    <div
                                                        class="group grid grid-cols-[100px_1fr_180px_220px] px-6 py-4 border-b border-outline-variant items-center hover:bg-surface-container-low transition">

                                                        <div>#{{ $sale->id }}</div>

                                                        <div>
                                                            {{ $sale->user->name }}
                                                        </div>

                                                        <div class="font-bold">
                                                            {{ number_format($sale->total_price, 2) }} DA
                                                        </div>
                                                        {{-- Actions --}}
                                                        <div
                                                            class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition">

                                                            {{-- VIEW --}}
                                                            <a href="{{ route('sales.show', $sale) }}"
                                                                class="w-9 h-9 rounded-lg  text-secondary flex items-center justify-center hover:scale-105 transition"
                                                                title="Voir">
                                                                <span class="material-symbols-outlined text-[18px]">visibility</span>
                                                            </a>

                                                            {{-- REVERT --}}
                                                            <button type="button" @click="$store.crud.openConfirm(
                                    'Annuler la vente',
                                    'Le stock sera restauré et la vente sera annulée',
                                    () => document.getElementById('revert-sale-{{ $sale->id }}').submit()
                                )" class="w-9 h-9 rounded-lg text-primary flex items-center justify-center hover:scale-105 transition"
                                                                title="Revert">

                                                                <span class="material-symbols-outlined text-[18px]">undo</span>
                                                            </button>

                                                            <form id="revert-sale-{{ $sale->id }}" method="POST"
                                                                action="{{ route('sales.revert', $sale) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                            <button type="button"
                                                                @click="$store.crud.openConfirm(
                                                                    'Supprimer vente',
                                                                    'Cette action supprimera l’historique définitivement',
                                                                    () => document.getElementById('delete-sale-{{ $sale->id }}').submit()
                                                                )"
                                                                class="w-9 h-9 rounded-lg text-error flex items-center justify-center hover:scale-105 transition"
                                                                title="Delete">

                                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                                            </button>

                                                            <form id="delete-sale-{{ $sale->id }}"
                                                                method="POST"
                                                                action="{{ route('sales.destroy', $sale) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </div>

                                                    </div>

                            @endforeach

                        </div>

                    </div>

                </div>

            </div>

        </main>

        {{-- DRAWER --}}
        <div id="drawer"
            class="fixed top-0 right-[-420px] w-[420px] h-screen bg-white border-l border-outline-variant shadow-2xl z-50 transition-all duration-300 flex flex-col">

            {{-- TOGGLE --}}
            <button id="drawerToggle"
                class="absolute left-[-42px] top-1/2 -translate-y-1/2 w-10 h-20 rounded-l-xl bg-secondary text-white flex items-center justify-center shadow-lg">
                <span id="drawerArrow" class="material-symbols-outlined">
                    chevron_left
                </span>
            </button>

            {{-- HEADER --}}
            <div class="p-6 border-b border-outline-variant bg-surface-container-low flex justify-between items-center">

                <div>
                    <h2 class="text-headline-md font-bold">
                        Vente en cours
                    </h2>

                    <p class="text-body-sm text-on-surface-variant">
                        Produits sélectionnés
                    </p>
                </div>

                <button id="cancelSaleBtn"
                    class="w-10 h-10 rounded-full border border-error/30 text-error hover:bg-error-container flex items-center justify-center">
                    <span class="material-symbols-outlined">
                        delete_sweep
                    </span>
                </button>

            </div>

            {{-- ITEMS --}}
            <div id="cartItems" class="flex-1 overflow-y-auto p-4 space-y-4 custom-scrollbar"></div>

            {{-- FOOTER --}}
            <div class="p-6 border-t border-outline-variant bg-surface-container-low">

                <div class="flex justify-between items-end mb-6">

                    <span class="uppercase text-on-surface-variant text-sm">
                        Total
                    </span>

                    <span id="totalPrice" class="text-headline-lg font-bold text-secondary">
                        0.00 DA
                    </span>

                </div>

                <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
                    @csrf

                    <input type="hidden" name="cart" id="cartInput">

                    <button type="submit"
                        class="w-full bg-secondary-container text-on-secondary-container h-14 rounded-xl font-bold flex items-center justify-center gap-3 shadow-lg">
                        <span class="material-symbols-outlined">
                            payments
                        </span>

                        VALIDER LA VENTE
                    </button>

                </form>

            </div>

        </div>

    </div>
    <x-pos.confirm-modal />
    <script>

        const drawer = document.getElementById('drawer');
        const drawerArrow = document.getElementById('drawerArrow');

        const cartItems = document.getElementById('cartItems');
        const totalPrice = document.getElementById('totalPrice');

        const cartInput = document.getElementById('cartInput');

        const searchInput = document.getElementById('searchInput');

        const productsTab = document.getElementById('productsTab');
        const salesTab = document.getElementById('salesTab');

        const productsBtn = document.getElementById('productsTabBtn');
        const salesBtn = document.getElementById('salesTabBtn');

        let drawerOpen = false;

        let cart = [];

        /*
        |--------------------------------------------------------------------------
        | Drawer
        |--------------------------------------------------------------------------
        */

        function toggleDrawer() {
            drawerOpen = !drawerOpen;

            drawer.style.right = drawerOpen
                ? '0px'
                : '-420px';

            drawerArrow.innerText = drawerOpen
                ? 'chevron_right'
                : 'chevron_left';
        }

        document
            .getElementById('drawerToggle')
            .addEventListener('click', toggleDrawer);

        /*
        |--------------------------------------------------------------------------
        | Cart
        |--------------------------------------------------------------------------
        */

        function getCartTotal() {
            return cart.reduce((total, item) => {
                return total + (item.price * item.quantity);
            }, 0);
        }

        function updateCart() {
            cartItems.innerHTML = '';

            cart.forEach((item, index) => {

                const itemTotal = item.price * item.quantity;

                cartItems.innerHTML += `
                                    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4 shadow-sm">

                                        <div class="flex justify-between items-start">

                                            <div>

                                                <p class="font-bold">
                                                    ${item.name}
                                                </p>

                                                <p class="text-sm text-on-surface-variant">
                                                    ${item.price.toFixed(2)} DA x ${item.quantity}
                                                </p>

                                            </div>

                                            <button
                                                onclick="removeItem(${index})"
                                                class="text-error"
                                            >
                                                <span class="material-symbols-outlined">
                                                    close
                                                </span>
                                            </button>

                                        </div>

                                        <div class="flex items-center justify-between mt-4">

                                            <div class="flex items-center border border-outline-variant rounded-lg overflow-hidden">

                                                <button
                                                    onclick="changeQty(${index},-1)"
                                                    class="w-10 h-10"
                                                >
                                                    -
                                                </button>

                                                <span class="w-10 text-center font-bold">
                                                    ${item.quantity}
                                                </span>

                                                <button
                                                    onclick="changeQty(${index},1)"
                                                    class="w-10 h-10"
                                                >
                                                    +
                                                </button>

                                            </div>

                                            <p class="font-bold text-secondary">
                                                ${itemTotal.toFixed(2)} DA
                                            </p>

                                        </div>

                                    </div>
                                `;
            });

            totalPrice.innerText =
                getCartTotal().toFixed(2) + ' DA';

            cartInput.value = JSON.stringify(cart);
        }

        function addToCart(data) {
            const existing =
                cart.find(item => item.id == data.id);

            if (existing) {
                existing.quantity++;
            }
            else {
                cart.push({
                    id: data.id,
                    name: data.name,
                    price: parseFloat(data.price),
                    quantity: 1
                });
            }

            updateCart();
        }

        function changeQty(index, amount) {
            if (cart[index].quantity <= 1 && amount == -1) {
                return
            }
            cart[index].quantity += amount;



            updateCart();
        }

        function removeItem(index) {
            cart.splice(index, 1);

            updateCart();
        }

        function clearCart() {
            cart = [];

            updateCart();
        }

        /*
        |--------------------------------------------------------------------------
        | Product Buttons
        |--------------------------------------------------------------------------
        */
        document
            .getElementById('saleForm')
            .addEventListener('submit', e => {

                console.log('SUBMITTING');
                console.log(cartInput.value);

            });
        document
            .querySelectorAll('.add-product-btn')
            .forEach(btn => {

                btn.addEventListener('click', () => {

                    addToCart({
                        id: btn.dataset.id,
                        name: btn.dataset.name,
                        price: btn.dataset.price
                    });

                });

            });

        /*
        |--------------------------------------------------------------------------
        | Cancel
        |--------------------------------------------------------------------------
        */

        document
            .getElementById('cancelSaleBtn')
            .addEventListener('click', clearCart);

        /*
        |--------------------------------------------------------------------------
        | Search Filter
        |--------------------------------------------------------------------------
        */

        searchInput.addEventListener('input', () => {

            const value =
                searchInput.value.toLowerCase();

            document
                .querySelectorAll('.product-slot')
                .forEach(slot => {

                    const name =
                        slot.dataset.name;

                    slot.style.display =
                        name.includes(value)
                            ? ''
                            : 'none';

                });

        });

        /*
        |--------------------------------------------------------------------------
        | Tabs
        |--------------------------------------------------------------------------
        */

        productsBtn.addEventListener('click', () => {

            productsTab.classList.remove('hidden');
            salesTab.classList.add('hidden');

            productsBtn.className =
                'h-14 rounded-xl bg-secondary text-white font-bold shadow';

            salesBtn.className =
                'h-14 rounded-xl bg-surface-container text-on-surface';

        });

        salesBtn.addEventListener('click', () => {

            salesTab.classList.remove('hidden');
            productsTab.classList.add('hidden');

            salesBtn.className =
                'h-14 rounded-xl bg-secondary text-white font-bold shadow';

            productsBtn.className =
                'h-14 rounded-xl bg-surface-container text-on-surface';

        });

    </script>
@endsection