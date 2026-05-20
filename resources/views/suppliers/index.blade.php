@extends('layouts.app')

@section('content')

<main class="min-h-screen bg-surface px-6 py-8 max-w-6xl mx-auto">

  {{-- HEADER --}}
  <div class="mb-6">
    <h1 class="text-3xl font-bold text-on-surface">Catalogue Produits</h1>
    <p class="text-sm text-on-surface-variant">Consultation simple des produits</p>
  </div>

  {{-- SEARCH --}}
  <form method="GET" class="mb-6">
    <input
      type="text"
      name="search"
      value="{{ request('search') }}"
      placeholder="Rechercher un produit..."
      class="w-full border border-outline-variant rounded-lg px-4 py-2"
    />
  </form>

  {{-- ================= CATEGORY SCROLLER ================= --}}
  <div id="catSlider"
       class="flex gap-3 overflow-x-auto whitespace-nowrap scroll-smooth pb-3 cursor-grab">

    <a href="{{ route('catalogue.index') }}"
       class="flex items-center gap-2 px-4 py-2 rounded-full border
       {{ !request('category') ? 'bg-primary text-white' : '' }}">
      <span class="material-symbols-outlined text-[18px]">grid_view</span>
      Tous
    </a>

    @foreach($categories as $cat)

      <a href="{{ route('catalogue.index', ['category' => $cat->id, 'search' => request('search')]) }}"
         class="flex items-center gap-2 px-4 py-2 rounded-full border whitespace-nowrap
         {{ request('category') == $cat->id ? 'bg-primary text-white' : '' }}">

        <span class="material-symbols-outlined text-[18px]">
          {{ $iconMap[strtolower($cat->name)] ?? 'category' }}
        </span>

        {{ $cat->name }}

      </a>

    @endforeach

  </div>

  {{-- ================= TABLE ================= --}}
  <div class="mt-6 bg-white border border-outline-variant rounded-xl overflow-hidden">

    <table class="w-full">

      <thead class="text-xs uppercase bg-surface-container-low text-on-surface-variant">
        <tr>
          <th class="p-4 text-left">Produit</th>
          <th class="p-4 text-left">Catégorie</th>
          <th class="p-4 text-right">Prix</th>
          <th class="p-4 text-center">Stock</th>
        </tr>
      </thead>

      <tbody class="divide-y">

        @forelse($products as $product)

        @php $qty = (int) $product->quantity_stock; @endphp

        <tr class="hover:bg-surface-container-low/40 transition">

          <td class="p-4 font-medium text-on-surface">
            {{ $product->name }}
          </td>

          <td class="p-4 text-on-surface-variant">
            {{ $product->category?->name ?? '—' }}
          </td>

          <td class="p-4 text-right font-bold text-primary">
            {{ number_format($product->price, 0, ',', ' ') }} MAD
          </td>

          <td class="p-4 text-center">
            @if($qty > 0)
              <span class="text-primary">{{ $qty }}</span>
            @else
              <span class="text-error">Rupture</span>
            @endif
          </td>

        </tr>

        @empty
        <tr>
          <td colspan="4" class="p-6 text-center text-on-surface-variant">
            Aucun produit trouvé
          </td>
        </tr>
        @endforelse

      </tbody>

    </table>

  </div>

</main>

@endsection