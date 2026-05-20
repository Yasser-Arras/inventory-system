@extends('layouts.pos')

@section('page')
<div class="flex overflow-hidden bg-background text-on-surface">

    <main class="ml-[260px] flex-1 flex flex-col min-h-screen overflow-hidden">

        <div class="flex-1 overflow-y-auto p-8 max-w-[1200px] mx-auto w-full">

            {{-- BACK --}}
            <div class="mb-6">
                <button onclick="window.history.back()"
                    class="flex items-center gap-2 text-secondary font-bold hover:-translate-x-1 transition">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Retour
                </button>
            </div>

            {{-- HEADER --}}
            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant overflow-hidden">

                <div class="p-6 bg-primary-container/10 border-b border-outline-variant">

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                        <div>
                            <p class="text-xs uppercase text-on-surface-variant">Sale ID</p>
                            <h2 class="text-xl font-bold text-primary">
                                #{{ $sale->id }}
                            </h2>
                        </div>

                        <div>
                            <p class="text-xs uppercase text-on-surface-variant">Date</p>
                            <p class="font-bold">
                                {{ $sale->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs uppercase text-on-surface-variant">Processed by</p>
                            <p class="font-bold">
                                {{ $sale->user->name }}
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="text-xs uppercase text-on-surface-variant">Total</p>
                            <p class="text-2xl font-extrabold text-primary">
                                {{ number_format($sale->total_price, 2) }} MAD
                            </p>
                        </div>

                    </div>

                </div>

                {{-- ITEMS --}}
                <div class="p-0">

                    <table class="w-full text-left">

                        <thead class="bg-surface-container-low border-b border-outline-variant">
                            <tr>
                                <th class="px-6 py-4 text-xs uppercase">Product</th>
                                <th class="px-6 py-4 text-xs uppercase text-center">Price</th>
                                <th class="px-6 py-4 text-xs uppercase text-center">Qty</th>
                                <th class="px-6 py-4 text-xs uppercase text-right">Subtotal</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-outline-variant/20">

                            @foreach($sale->items as $item)

                                <tr class="hover:bg-surface-container-low transition">

                                    <td class="px-6 py-4 flex items-center gap-3">
                                        <span class="material-symbols-outlined text-secondary">
                                            {{ $item->product->category->icon ?? 'category' }}
                                        </span>

                                        <div>
                                            <p class="font-bold">
                                                {{ $item->product->name }}
                                            </p>
                                            <p class="text-xs text-on-surface-variant">
                                                Product ID: {{ $item->product->id }}
                                            </p>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        {{ number_format($item->product->price, 2) }} MAD
                                    </td>

                                    <td class="px-6 py-4 text-center font-bold">
                                        {{ $item->quantity_sold }}
                                    </td>

                                    <td class="px-6 py-4 text-right font-bold">
                                        {{ number_format($item->product->price * $item->quantity_sold, 2) }} MAD
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                {{-- SUMMARY --}}
                <div class="flex justify-end p-6 border-t border-outline-variant bg-surface-bright">

                    <div class="w-full max-w-xs space-y-2">

                       

                        <div class="flex justify-between font-extrabold text-primary text-lg pt-1 border-t">
                            <span>Total</span>
                            <span>{{ number_format($sale->total_price, 2) }} MAD</span>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>

</div>
@endsection