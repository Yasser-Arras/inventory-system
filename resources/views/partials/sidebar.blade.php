@php
$navClass = fn (bool $active) =>
    $active
        ? 'text-primary-fixed bg-primary-container/20 border-l-4 border-primary-fixed font-bold px-6 py-3 flex items-center gap-4 text-body-md transition-colors duration-200'
        : 'text-inverse-on-surface/70 hover:text-inverse-on-surface hover:bg-white/5 px-6 py-3 flex items-center gap-4 text-body-md transition-colors duration-200';
@endphp

<aside class="w-[260px] h-screen fixed left-0 top-0 bg-inverse-surface shadow-md flex flex-col py-8 z-50">
  <div class="px-6 mb-10 flex items-center gap-3">
    <div class="w-10 h-10 bg-primary-container rounded-lg flex items-center justify-center">
      <span class="material-symbols-outlined text-on-primary-container">inventory_2</span>
    </div>
    <div>
      <h1 class="text-headline-md font-headline-md text-primary-fixed leading-none">Inventory Manager</h1>
    </div>
  </div>

  <nav class="flex-1 flex flex-col overflow-y-auto">
    <a href="{{ route('dashboard') }}" class="{{ $navClass(request()->routeIs('dashboard')) }}">
      <span class="material-symbols-outlined">dashboard</span>
      Dashboard
    </a>
    <a href="{{ route('products.index') }}" class="{{ $navClass(request()->routeIs('products.*')) }}">
      <span class="material-symbols-outlined">inventory_2</span>
      Produits
    </a>
    <a href="{{ route('categories.index') }}" class="{{ $navClass(request()->routeIs('categories.*')) }}">
      <span class="material-symbols-outlined">category</span>
      Catégories
    </a>
    <a href="{{ route('suppliers.index') }}" class="{{ $navClass(request()->routeIs('suppliers.*')) }}">
      <span class="material-symbols-outlined">local_shipping</span>
      Fournisseurs
    </a>
     <a href="{{ route('stock-movements.index') }}" class="{{ $navClass(request()->routeIs('stock-movements.*')) }}">
      <span class="material-symbols-outlined">inventory</span>
      Mouvements de Stock
    </a>
    
    <a href="{{ route('sales.index') }}" class="{{ $navClass(request()->routeIs('sales.*')) }}">
      <span class="material-symbols-outlined">point_of_sale</span>
      Ventes
    </a>
    <a href="{{ route('users.index') }}" class="{{ $navClass(request()->routeIs('users.*')) }}">
      <span class="material-symbols-outlined">group</span>
      Utilisateurs
    </a>
    <!-- <a href="#" class="{{ $navClass(false) }}">
      <span class="material-symbols-outlined">analytics</span>
      Statistiques
    </a> -->

    <div class="mt-auto">
      <!-- <a href="#" class="{{ $navClass(false) }}">
        <span class="material-symbols-outlined">settings</span>
        Paramètres
      </a> -->
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full text-left {{ $navClass(false) }}">
          <span class="material-symbols-outlined">logout</span>
          Déconnexion
        </button>
      </form>
    </div>
  </nav>
</aside>
