@extends('layouts.pos')

@section('page')

  @php
    $editProduct = request('edit') ? \App\Models\Product::find(request('edit')) : null;
  @endphp

  <main class="ml-[260px] p-margin-desktop max-w-[calc(1440px-260px)] min-h-screen">

    {{-- SUCCESS --}}
    @if(session('success'))
      <div class="mb-6 px-4 py-3 rounded-lg bg-primary/10 text-primary text-body-sm font-medium border border-primary/20">
        {{ session('success') }}
      </div>
    @endif

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
      <div>
        <h2 class="text-headline-lg font-headline-lg text-on-surface">Gestion des Produits</h2>
        <p class="text-body-md text-on-surface-variant mt-1">
          Consultez et gérez l'ensemble de votre inventaire en temps réel.
        </p>
      </div>

      <button type="button" @click="$store.crud.openCreate(
            '{{ route('products.store') }}',
            {
              name: '',
              price: '',
              quantity_stock: '',
              description: '',
              category_id: '',
              supplier_id: ''
            }
          )"
        class="flex items-center gap-2 bg-primary text-on-primary px-6 py-2.5 rounded-lg font-bold hover:opacity-90 active:scale-95 transition-all">
        <span class="material-symbols-outlined">add</span>
        Ajouter un produit
      </button>
    </div>

    {{-- FILTERS + STATS --}}
    <form method="GET" action="{{ route('products.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-gutter mb-8">
      <div class="md:col-span-1 flex flex-col gap-4">

        <div class="bg-surface-container-lowest p-5 rounded-xl border border-slate-200">
          <label class="text-label-caps text-on-surface-variant mb-2 block">Catégorie</label>
          <select name="category_id" onchange="this.form.submit()"
            class="w-full border border-outline-variant rounded-lg p-2 text-body-sm">
            <option value="">Toutes les catégories</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                {{ $category->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="bg-surface-container-lowest p-5 rounded-xl border border-slate-200">
          <label class="text-label-caps text-on-surface-variant mb-2 block">Fournisseur</label>
          <select name="supplier_id" onchange="this.form.submit()"
            class="w-full border border-outline-variant rounded-lg p-2 text-body-sm">
            <option value="">Tous les fournisseurs</option>
            @foreach($suppliers as $supplier)
              <option value="{{ $supplier->id }}" @selected(request('supplier_id') == $supplier->id)>
                {{ $supplier->name }}
              </option>
            @endforeach
          </select>
        </div>

      </div>

      <div class="md:col-span-2 bg-surface-container-lowest p-5 rounded-xl border border-slate-200">

        <!-- Total -->
        <div class="mb-4">
          <p class="text-label-caps text-on-surface-variant">Total Produits</p>
          <p class="text-headline-md font-headline-md text-on-surface">
            {{ number_format($totalProducts) }}
          </p>
        </div>

        <div class="grid grid-cols-3 gap-3">

          <div class="p-3 rounded-lg border border-slate-200 bg-white">
            <p class="text-[11px] text-slate-500 uppercase">Plus stocké</p>
            <p class="text-body-sm font-semibold text-on-surface truncate">
              {{ $mostStocked->name ?? '—' }}
            </p>
            <p class="text-[11px] text-slate-500">
              {{ $mostStocked->quantity_stock ?? 0 }} unités
            </p>
          </div>

          <div class="p-3 rounded-lg border border-slate-200 bg-white">
            <p class="text-[11px] text-slate-500 uppercase">Moins stocké</p>
            <p class="text-body-sm font-semibold text-on-surface truncate">
              {{ $leastStocked->name ?? '—' }}
            </p>
            <p class="text-[11px] text-slate-500">
              {{ $leastStocked->quantity_stock ?? 0 }} unités
            </p>
          </div>

          <div class="grid grid-rows-2 gap-3">

            <div class="p-3 rounded-lg border border-slate-200 bg-white">
              <p class="text-[11px] text-slate-500 uppercase">7 jours</p>
              <p class="text-body-sm font-semibold text-primary">
                {{ $lastWeekCount ?? 0 }}
              </p>
            </div>

            <div class="p-3 rounded-lg border border-slate-200 bg-white">
              <p class="text-[11px] text-slate-500 uppercase">Croissance</p>
              <p class="font-semibold text-primary">
                {{ $lastWeekPercent ?? 0 }}%
              </p>
            </div>

          </div>

        </div>

      </div>
    </form>

    {{-- TABLE --}}
    <div class="bg-surface-container-lowest rounded-xl overflow-hidden border border-white/20">

      <div class="px-6 py-4 border-b border-outline-variant bg-surface-container-low/30">
        <h3 class="text-label-md font-bold text-on-surface-variant uppercase tracking-wider">
          Inventaire Actuel
        </h3>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">

          <thead>
            <tr class="bg-surface-container-low/10">
              <th class="px-6 py-4 text-label-caps">Produit</th>
              <th class="px-6 py-4 text-label-caps">Catégorie</th>
              <th class="px-6 py-4 text-label-caps">Prix</th>
              <th class="px-6 py-4 text-label-caps">Stock</th>
              <th class="px-6 py-4 text-label-caps">Fournisseur</th>
              <th class="px-6 py-4 text-label-caps text-right">Actions</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-outline-variant/30">

            @forelse($products as $product)

              @php $qty = (int) ($product->quantity_stock ?? 0); @endphp

              <tr class="hover:bg-surface-container-low/50 transition-colors group">

                <td class="px-6 py-4">
                  <p class="text-body-sm font-bold text-on-surface">
                    {{ $product->name }}
                  </p>
                  <p class="text-[11px] text-on-surface-variant">
                    ID: PROD-{{ str_pad((string) $product->id, 4, '0', STR_PAD_LEFT) }}
                  </p>
                </td>

                <td class="px-6 py-4">
                  <span class="bg-surface-variant px-3 py-1 rounded-full text-[11px] font-bold">
                    {{ $product->category?->name ?? '—' }}
                  </span>
                </td>

                <td class="px-6 py-4 text-body-sm font-medium">
                  {{ number_format((float) $product->price, 0, ',', ' ') }} MAD
                </td>

                <td class="px-6 py-4">
                  <span class="text-body-sm {{ $qty <= 5 ? 'text-tertiary font-bold' : '' }}">
                    {{ $qty }} units
                  </span>
                </td>

                <td class="px-6 py-4 text-body-sm text-on-surface-variant">
                  {{ $product->supplier?->name ?? '—' }}
                </td>

                {{-- ACTIONS --}}
                <td class="px-6 py-4 text-right">

                  <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">

                    {{-- EDIT --}}
                    <button type="button" @click="$store.crud.openEdit(
                              '{{ route('products.update', $product) }}',
                              @js([
                                'id' => $product->id,
                                'name' => $product->name,
                                'price' => $product->price,
                                'quantity_stock' => $product->quantity_stock,
                                'description' => $product->description,
                                'category_id' => $product->category_id,
                                'supplier_id' => $product->supplier_id,
                              ])
                            )" class="material-symbols-outlined text-secondary">
                      edit
                    </button>

                    {{-- DELETE --}}
                    <button type="button" @click="$store.crud.openConfirm(
                              'Supprimer produit',
                              'Cette action est irreversible',
                              () => fetch('{{ route('products.destroy', $product) }}', {
                                method: 'POST',
                                headers: {
                                  'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                  'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: new URLSearchParams({ _method: 'DELETE' })
                              }).then(() => window.location.reload())
                            )" class="material-symbols-outlined text-error">
                      delete
                    </button>

                  </div>

                </td>

              </tr>

            @empty
              <tr>
                <td colspan="6" class="px-6 py-10 text-center text-on-surface-variant">
                  Aucun produit trouvé.
                </td>
              </tr>
            @endforelse

          </tbody>
        </table>
      </div>

      {{-- PAGINATION --}}
      @if($totalProducts > 0)
        {{ $products->links('partials.pagination') }}
      @endif

    </div>

  </main>

  {{-- MODALS --}}
  <x-pos.form-modal>
    <div class="space-y-4">

      <div>
        <label>Nom</label>
        <input type="text" name="name" placeholder="Nom du produit..." :value="$store.crud.formData.name"
          @input="$store.crud.formData.name = $event.target.value" class="w-full border rounded-lg p-2">
      </div>

      <div>
        <label>Prix</label>
        <input type="number" name="price" placeholder="Prix d'unité..." :value="$store.crud.formData.price"
          @input="$store.crud.formData.price = $event.target.value" class="w-full border rounded-lg p-2">
      </div>

      <div>
        <label>Stock</label>
        <input type="number" name="quantity_stock" placeholder="Quantité en stock..."
          :value="$store.crud.formData.quantity_stock" @input="$store.crud.formData.quantity_stock = $event.target.value"
          class="w-full border rounded-lg p-2">
      </div>

      <div>
        <label>Catégorie</label>
        <select name="category_id" :value="$store.crud.formData.category_id"
          @change="$store.crud.formData.category_id = $event.target.value" class="w-full border rounded-lg p-2">

          <option value="">Choisir</option>
          @foreach($categories as $c)
            <option value="{{ $c->id }}">{{ $c->name }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label>Fournisseur</label>
        <select name="supplier_id" :value="$store.crud.formData.supplier_id"
          @change="$store.crud.formData.supplier_id = $event.target.value" class="w-full border rounded-lg p-2">

          <option value="">Choisir</option>
          @foreach($suppliers as $s)
            <option value="{{ $s->id }}">{{ $s->name }}</option>
          @endforeach
        </select>
      </div>

    </div>
  </x-pos.form-modal>

  <x-pos.confirm-modal />

@endsection