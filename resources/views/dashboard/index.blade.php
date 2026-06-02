@extends('layouts.pos')

@section('page')

<main class="ml-[260px] min-h-screen">

  @if(session('success'))
    <div class="mx-margin-desktop mt-4 px-4 py-3 rounded-lg bg-primary/10 text-primary text-body-sm font-medium border border-primary/20">
      {{ session('success') }}
    </div>
  @endif

  <div class="p-margin-desktop max-w-[calc(1440px-260px)] mx-auto space-y-gutter">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-headline-lg font-headline-lg text-on-surface">Tableau de Bord</h2>
        <p class="text-body-md text-on-surface-variant">
          Aperçu global de votre activité
        </p>
      </div>

      <a href="{{ route('products.index', ['open' => 'create']) }}"
         class="bg-primary text-on-primary px-6 py-2.5 rounded-lg flex items-center gap-2 font-label-md hover:opacity-90 transition-all shadow-sm active:scale-95">
        <span class="material-symbols-outlined">add</span>
        Nouveau Produit
      </a>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter">

      <div class="ambient-card p-6 rounded-xl border-t-4 border-quandale shadow p-5">
        <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
          <span class="material-symbols-outlined text-primary">inventory_2</span>
        </div>
        <p class="text-outline text-label-caps uppercase">Total Produits</p>
        <h3 class="text-headline-lg font-headline-lg text-on-surface">
          {{ number_format($totalProducts) }}
        </h3>
      </div>

      <div class="ambient-card p-6 rounded-xl shadow p-5  border-t-4 border-secondary">
        <div class="w-12 h-12 bg-secondary/10 rounded-lg flex items-center justify-center mb-4">
          <span class="material-symbols-outlined text-secondary">point_of_sale</span>
        </div>
        <p class="text-outline text-label-caps uppercase">Ventes Totales</p>
        <h3 class="text-headline-lg font-headline-lg text-on-surface">
          {{ number_format($totalSales, 0, ',', ' ') }} MAD
        </h3>
      </div>

       <div class="ambient-card p-6 rounded-xl shadow p-5  border-t-4 border-primary">
        <div class="w-12 h-12 bg-surface-tint/10 rounded-lg flex items-center justify-center mb-4">
          <span class="material-symbols-outlined text-surface-tint">account_balance_wallet</span>
        </div>
        <p class="text-outline text-label-caps uppercase">Valeur du Stock</p>
        <h3 class="text-headline-lg font-headline-lg text-on-surface">
          {{ number_format($stockValue, 0, ',', ' ') }} MAD
        </h3>
      </div>

      <div class="ambient-card p-6 rounded-xl border-t-4 border-error shadow p-5 ">
        <div class="flex items-center justify-between mb-4">
          <div class="w-12 h-12 bg-error/10 rounded-lg flex items-center justify-center">
            <span class="material-symbols-outlined text-error" style="font-variation-settings: 'FILL' 1;">
              warning
            </span>
          </div>

          @if($lowStockCount > 0)
            <span class="text-error text-label-md bg-error/5 px-2 py-1 rounded-full">
              {{ $lowStockCount }} Alertes
            </span>
          @endif
        </div>

        <p class="text-outline text-label-caps uppercase">Stock Faible</p>
        <h3 class="text-headline-lg font-headline-lg text-on-surface">
          {{ number_format($lowStockCount) }} Items
        </h3>
      </div>

    </div>

    {{-- GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-gutter">

      {{-- NEW PRODUCTS --}}
      <div class="ambient-card rounded-xl overflow-hidden flex flex-col shadow ">
        <div class="p-4 border-b  border-outline-variant bg-surface-container-low flex items-center justify-between">
          <h4 class="text-label-md font-bold text-on-surface">Nouveaux Produits</h4>
          <a href="{{ route('products.index') }}" class="text-outline hover:text-primary">
            <span class="material-symbols-outlined">open_in_new</span>
          </a>
        </div>

        <table class="w-full text-left text-body-sm">
          <thead class="bg-surface-bright text-outline text-label-caps">
            <tr>
              <th class="px-4 py-3 font-bold">Nom</th>
              <th class="px-4 py-3 font-bold text-right">Prix</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-outline-variant">
            @foreach($latestProducts as $product)
              <tr class="hover:bg-surface-container-low">
                <td class="px-4 py-3">
                  {{ $product->name }}
                </td>
                <td class="px-4 py-3 text-right font-medium">
                  {{ number_format((float) ($product->price ?? 0), 0, ',', ' ') }} MAD
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{-- LOW STOCK --}}
      <div class="ambient-card rounded-xl overflow-hidden flex flex-col shadow ">
        <div class="p-4 border-b border-outline-variant bg-error-container/20 flex items-center justify-between">
          <h4 class="text-label-md font-bold text-error flex items-center gap-2">
            <span class="material-symbols-outlined text-error text-[18px]">warning</span>
            Stock Faible
          </h4>

          <span class="text-error text-label-caps font-bold">
            {{ $lowStockCount }} Alertes
          </span>
        </div>

        <div class="p-4 space-y-3">
          @foreach($lowStockProducts as $product)
            @php $qty = (int) ($product->quantity_stock ?? 0); @endphp

            <div class="flex items-center justify-between p-3 rounded-lg bg-surface-container-low border-l-4
              {{ $qty <= 5 ? 'border-error' : 'border-tertiary' }}">

              <div>
                <p class="text-label-md font-bold text-on-surface">
                  {{ $product->name }}
                </p>
                <p class="text-[11px] text-outline uppercase">
                  SKU-{{ str_pad((string) ($product->id ?? 0), 3, '0', STR_PAD_LEFT) }}
                </p>
              </div>

              <p class="{{ $qty <= 5 ? 'text-error' : 'text-tertiary' }} font-bold">
                {{ $qty }} restants
              </p>

            </div>
          @endforeach
        </div>
      </div>

      {{-- RECENT ACTIVITY --}}
      <div class="ambient-card rounded-xl overflow-hidden flex flex-col shadow ">
         <div class="p-4 border
        <div class="p-4 border-b border-outline-variant bg-surface-container-low flex items-center justify-between">
          <h4 class="text-label-md font-bold text-on-surface">Activité Récente</h4>
          <span class="material-symbols-outlined text-outline">history</span>
        </div>

        <div class="p-4 space-y-6">
          @foreach($recentActivity as $activity)

            @php
              $dotBg = match ($activity['color'] ?? 'primary') {
                'secondary' => 'bg-secondary',
                'tertiary' => 'bg-tertiary',
                default => 'bg-primary',
              };
            @endphp

            <div class="flex gap-4 items-start">
              <div class="w-5 h-5 rounded-full {{ $dotBg }} flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[12px] text-white">
                  {{ $activity['icon'] }}
                </span>
              </div>

              <div>
                <p class="text-body-sm">
                  <span class="font-bold">{{ $activity['title'] }}</span>
                  — {{ $activity['label'] }}
                </p>

                <p class="text-[11px] text-outline">
                  {{ $activity['detail'] }}
                  @if(!empty($activity['extra']))
                    • <span class="{{ $activity['extra_class'] }}">{{ $activity['extra'] }}</span>
                  @endif
                </p>
              </div>
            </div>

          @endforeach
        </div>
      </div>

      {{-- BEST SELLERS --}}
      <div class="ambient-card rounded-xl overflow-hidden flex flex-col shadow ">
        <div class="p-4 border-b border-outline-variant bg-surface-container-low flex items-center justify-between">
          <h4 class="text-label-md font-bold text-on-surface flex items-center gap-2">
            <span class="material-symbols-outlined text-primary text-[18px]">trending_up</span>
            Meilleures Ventes
          </h4>

          <span class="text-primary text-label-caps font-bold">Cette semaine</span>
        </div>

        <div class="p-4 space-y-3">
          @foreach($bestProducts as $row)
            <div class="p-3 rounded-lg bg-surface-container-low border-l-4 border-primary">

              <p class="text-label-md font-bold text-on-surface">
                {{ $row->product?->name ?? 'Produit' }}
              </p>

              <p class="text-[11px] text-outline">
                {{ number_format((int) ($row->total_qty ?? 0)) }} vendus
              </p>

            </div>
          @endforeach
        </div>
      </div>

    </div>

  </div>

  <footer class="mt-gutter px-margin-desktop py-6 text-center text-body-sm text-outline border-t border-outline-variant">
    © {{ date('Y') }} Inventory Manager
  </footer>

</main>

@endsection