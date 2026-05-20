<!DOCTYPE html>
<html lang="fr" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Inventory Manager</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <style>
        .no-scrollbar::-webkit-scrollbar {
            height: 6px;
        }


        .no-scrollbar::-webkit-scrollbar-track {
            background-color: rgba(0, 0, 0, 0);
        }

        .no-scrollbar::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.12);
            border-radius: 999px;

            opacity: 0.6;
            transition: opacity 0.25s ease;
        }
    </style>
    <header
        class="h-16 w-full flex items-center justify-between px-margin-desktop sticky top-0 z-40 bg-surface border-b border-outline-variant">

        <div class="flex items-center gap-4 w-1/2 max-w-md">
            <form method="GET" action="{{  route('catalogue.index') }}" class="relative w-full">
                <input type="text" name="name" class="w-full pl-10 pr-4 py-2" placeholder="Rechercher..."
                    value="{{ request('name') }}" />
            </form>

        </div>


        <div class="flex items-center gap-4 md:gap-6">

            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-6 py-2 rounded-lg bg-green-700 text-white hover:bg-green-700 transition shadow-sm">

                <span class="material-symbols-outlined text-[20px]">
                    dashboard
                </span>

                <span class="hidden sm:inline font-medium">
                    Dashboard
                </span>

            </a>

            <button type="button"
                class="material-symbols-outlined text-on-surface-variant hover:bg-surface-container-low p-2 rounded-full transition-colors">notifications</button>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                    class="material-symbols-outlined text-on-surface-variant hover:bg-surface-container-low p-2 rounded-full transition-colors">
                    logout
                </button>
            </form>
            <div class="h-8 w-px bg-outline-variant mx-2"></div>
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 hover:opacity-80 transition">
                <div class="text-right hidden sm:block">
                    <p class="text-body-sm font-bold text-on-surface leading-none">
                        {{ auth()->user()->name ?? 'User' }}
                    </p>

                    <p class="text-[11px] text-on-surface-variant">
                        {{ auth()->user()->role ? ucfirst(auth()->user()->role) : 'User' }}
                    </p>
                </div>

                <img class="w-9 h-9 md:w-10 md:h-10 rounded-full border-2 border-primary/20 object-cover"
            src="https://www.gravatar.com/avatar/?d=mp"                    alt="Profil" />
            </a>
        </div>
    </header>
</head>

<body class="bg-surface text-on-surface font-body-md antialiased">

    <main class="max-w-[1440px] mx-auto px-6 md:px-10 py-10 mb-8">
        <header class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-on-surface">
                Product Showcase
            </h1>

            <p class="text-on-surface-variant mt-2 max-w-2xl">
                Explorez le catalogue des produits disponibles et gérez votre inventaire facilement.
            </p>
        </header>

        {{-- CATEGORY FILTERS --}}
        <section class="mb-10 overflow-x-auto no-scrollbar  py-2">
            <div class="flex gap-3 min-w-max" id="categoryScroll">

                {{-- ALL --}}
                <a href="{{ url()->current() }}" class="flex items-center gap-2 px-5 py-2 rounded-full border
           {{ !request('category') ? 'bg-primary text-white' : 'bg-surface-container' }}">
                    <span class="material-symbols-outlined">grid_view</span>
                    <span>Tous</span>
                </a>

                @foreach($categories as $cat)
                    <a href="?category={{ $cat->id }}&search={{ request('search') }}"
                        class="flex items-center gap-2 px-5 py-2 rounded-full border
                                   {{ request('category') == $cat->id ? 'bg-primary text-white' : 'bg-surface-container' }}">

                        <span class="material-symbols-outlined">
                            {{ $cat->icon ?? 'category' }}
                        </span>

                        <span>{{ $cat->name }}</span>
                    </a>
                @endforeach

            </div>
        </section>

        {{-- PRODUCT TABLE --}}
        <section class="bg-white rounded-xl border overflow-hidden">

            {{-- HEADER --}}
            <div
                class="hidden md:grid grid-cols-12 px-6 py-3 text-xs font-bold border-b bg-surface-container-lowest items-center">
                <div class="col-span-5">Produit</div>
                <div class="col-span-2">Catégorie</div>
                <div class="col-span-2 text-right">Prix</div>
                <div class="col-span-3 text-center">Stock</div>
            </div>

            {{-- ROWS --}}
            <div class="divide-y">

                @forelse($products as $p)
                            <div class="grid grid-cols-12 px-6 py-5 items-center hover:bg-surface-container-low transition">

                                {{-- PRODUCT --}}
                                <div class="col-span-5 flex items-center gap-4">

                                    <div
                                        class="w-14 h-14 rounded-lg overflow-hidden border bg-surface-container flex items-center justify-center flex-shrink-0">

                                        @if($p->image)
                                            <img src="{{ asset('storage/' . $p->image) }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="material-symbols-outlined text-outline">
                                                {{ $p->category->icon ?? 'inventory_2' }}
                                            </span>
                                        @endif

                                    </div>

                                    <div class="flex flex-col">
                                        <span class="font-semibold text-on-surface">
                                            {{ $p->name }}
                                        </span>

                                        {{-- DESCRIPTION --}}
                                        <span class="text-sm text-on-surface-variant leading-snug">
                                            {{ $p->description ?? 'Aucune description disponible' }}
                                        </span>
                                    </div>

                                </div>

                                {{-- CATEGORY --}}
                                <div class="col-span-2 flex items-center gap-2 text-on-surface-variant">
                                    <span class="material-symbols-outlined text-sm">
                                        {{ $p->category->icon ?? 'category' }}
                                    </span>
                                    <span class="text-sm">
                                        {{ $p->category->name }}
                                    </span>
                                </div>

                                {{-- PRICE --}}
                                <div class="col-span-2 text-right font-semibold">
                                    {{ number_format($p->price, 2) }} MAD
                                </div>

                                {{-- STOCK --}}
                                <div class="col-span-3 flex justify-center">
                                    <span class="text-sm px-3 py-1 rounded-full
                                                            {{ $p->quantity_stock > 0
                    ? 'bg-green-100 text-green-700'
                    : 'bg-red-100 text-red-600' }}">
                                        {{ $p->quantity_stock > 0 ? 'Disponible' : 'Indisponible' }}
                                    </span>
                                </div>

                            </div>
                @empty
                    <div class="p-10 text-center text-on-surface-variant">
                        Aucun produit trouvé
                    </div>
                @endforelse

            </div>
        </section>

        {{ $products->withQueryString()->links() }}

    </main>

    {{-- FOOTER --}}
    <footer class="bg-inverse-surface text-inverse-on-surface mt-20 py-12">
        <div class="max-w-[1440px] mx-auto px-6 md:px-10 grid md:grid-cols-3 gap-10">

            <div>
                <h2 class="text-lg font-bold">Inventory Manager</h2>
                <p class="text-sm opacity-70 mt-2">
                    Gestion simple et moderne des produits.
                </p>
            </div>

            <div>
                <h3 class="font-semibold mb-3">Ressources</h3>
                <ul class="space-y-2 text-sm opacity-80">
                    <li>Catalogue</li>
                    <li>Support</li>
                    <li>Documentation</li>
                </ul>
            </div>

            <div>
                <h3 class="font-semibold mb-3">Contact</h3>
                <p class="text-sm opacity-80">contact@Inventorymanager.dz</p>
            </div>

        </div>
    </footer>

</body>