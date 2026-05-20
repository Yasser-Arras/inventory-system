@extends('layouts.pos')

@section('page')

    <main class="ml-[260px] p-margin-desktop max-w-[1440px] min-h-screen" x-data>

        {{-- HEADER --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-headline-lg font-headline-lg">Gestion du Stock</h2>
                <p class="text-body-md text-on-surface-variant">
                    Surveillez vos inventaires et mouvements en temps réel.
                </p>
            </div>

            <button @click="$store.crud.openCreate(
              '{{ route('stock-movements.store') }}',
              { product_id: '', type: 'IN', quantity: '', reason: 'manual' }
            )"
                class="px-6 py-2 bg-primary text-on-primary rounded-lg">
                Nouveau mouvement
            </button>
        </div>

        {{-- STATS --}}
         <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-primary">
               <p>Total Produits</p>
            <h2 class="text-2xl font-bold">{{ $totalProducts  }}</h2>
        </div>

        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-green-500">
           <p>Total Stock</p>
            <h2 class="text-2xl font-bold">{{ $totalUnits }}</h2>
        </div>

        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-blue-500">
            <p>Stock critique</p>
            <h2 class="text-2xl font-bold">{{ $lowStockProducts->count() }}</h2>
        </div>

        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-orange-500">
            <p>Valeur totale</p>
            <h2 class="text-2xl font-bold">{{ number_format($totalValue, 2) }} DH</h2>
        </div>

    </div>
      

        {{-- CONTENT GRID --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- MOVEMENTS --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow overflow-hidden">

                <div class="p-4 border-b">
                    <h3 class="font-bold">Mouvements de Stock</h3>
                </div>

                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="p-3">Produit</th>
                            <th class="p-3">Type</th>
                            <th class="p-3">Quantité</th>
                            <th class="p-3">Date</th>
                            <th class="p-3">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($movements as $move)
                                    <tr class="border-t">
                                        <td class="p-3">
                                            {{ $move->product->name ?? 'N/A' }}
                                        </td>

                                        <td class="p-3">
                                            @if($move->type === 'IN')
                                                <span class="text-green-600 font-bold">IN</span>
                                            @else
                                                <span class="text-red-600 font-bold">OUT</span>
                                            @endif
                                        </td>

                                        <td class="p-3">
                                            {{ $move->quantity }}
                                        </td>

                                        <td class="p-3 text-gray-500">
                                            {{ $move->created_at->format('d/m H:i') }}
                                        </td>

                                        {{-- REVERT --}}
                                        <td class="p-3">

                                            <div class="flex items-center gap-2">

                                                {{-- REVERT (undo stock + delete) --}}
                                                <button type="button" @click="$store.crud.openConfirm(
                                'Annuler mouvement',
                                'Le stock sera restauré et le mouvement supprimé',
                                () => document.getElementById('revert-{{ $move->id }}').submit()
                            )" class="w-8 h-8 flex items-center justify-center rounded-md hover:bg-gray-100 text-orange-600"
                                                    title="Revert">
                                                    <span class="material-symbols-outlined text-[18px]">undo</span>
                                                </button>

                                                <form id="revert-{{ $move->id }}" method="POST"
                                                    action="{{ route('stock-movements.revert', $move->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                                {{-- DELETE  --}}
                                                <button type="button" @click="$store.crud.openConfirm(
                                'Supprimer mouvement',
                                'Cette action est irréversible, cela n\'affectera pas le stock mais supprimera l\'historique',
                                () => document.getElementById('delete-{{ $move->id }}').submit()
                            )" class="w-8 h-8 flex items-center justify-center rounded-md hover:bg-gray-100 text-red-600"
                                                    title="Delete">
                                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                                </button>

                                                <form id="delete-{{ $move->id }}" method="POST"
                                                    action="{{ route('stock-movements.destroy', $move->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                            </div>

                                        </td>
                                    </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            {{-- LOW STOCK --}}
            <div class="bg-white rounded-xl shadow p-4">

    <h3 class="font-bold mb-4 text-red-500">
        Produits à réapprovisionner
    </h3>

    <div class="space-y-3">

        @forelse($lowStockProducts as $product)
            <div class="p-3 border rounded-lg flex justify-between">
                <div>
                    <p class="font-bold">{{ $product->name }}</p>
                    <p class="text-sm text-red-500">
                        {{ $product->quantity_stock }} unités
                    </p>
                </div>
                <span class="text-xs text-gray-500">seuil: 10</span>
            </div>
        @empty
            <div class="p-6 text-center text-gray-400">
                Aucun produit pour le moment!
            </div>
        @endforelse

    </div>

</div>

        </div>


        <x-pos.form-modal>

            <input type="hidden" name="reason" value="manual">

            <div class="space-y-3">

                <select name="product_id" class="w-full border p-2 select">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>

                <select name="type" class="w-full border p-2">
                    <option value="IN">IN</option>
                    <option value="OUT">OUT</option>
                </select>

                <input type="number" name="quantity" placeholder="Quantité" class="w-full border p-2">

            </div>

        </x-pos.form-modal>
         <x-pos.confirm-modal />
        <script>

        </script>
    </main>

@endsection