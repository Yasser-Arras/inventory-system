@extends('layouts.pos')

@section('page')
@php
    $colors = [
        '#10b981',
        '#2170e4',
        '#fc7c78',
        '#006c49',
        '#6c7a71',
        '#f59e0b',
        '#8b5cf6',
    ];

    $i = 0;
@endphp

    <main class="ml-[260px] p-margin-desktop max-w-[calc(1440px-260px)] min-h-screen" x-data="categoryUi()">

        @if(session('success'))
            <div class="mb-6 px-4 py-3 rounded-lg bg-primary/10 text-primary text-body-sm font-medium border border-primary/20">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
            <div>
                <h2 class="text-headline-lg font-headline-lg text-on-surface">Gestion des Catégories</h2>
                <p class="text-body-md text-on-surface-variant mt-1">
                    Organisez votre inventaire par segments logiques.
                </p>
            </div>

            <button type="button" @click="$store.crud.openCreate('{{ route('categories.store') }}', { name: '', description: '', icon: '' })"
                class="flex items-center gap-2 bg-primary text-on-primary px-6 py-2.5 rounded-lg font-bold hover:opacity-90 active:scale-95 transition-all">
                <span class="material-symbols-outlined">add</span>
                Ajouter une catégorie
            </button>
        </div>

        <form method="GET" action="{{ route('categories.index') }}" class="flex justify-end mb-6">
            <select name="order" onchange="this.form.submit()" class="bg-transparent border-none text-primary font-bold">
                <option value="name" @selected(request('order') == 'name')>Nom</option>
                <option value="products" @selected(request('order') == 'products')>Produits</option>
                <option value="created_at" @selected(request('order') == 'created_at')>Date</option>
            </select>
        </form>

        <div class="category-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

@foreach($categories as $category)

@php
    $iconName = str_replace(' ', '_', strtolower($category->name));
    $iconPath = "storage/category_icons/{$iconName}.png";
    $fallback = "storage/category_icons/default.png";
    $icon = file_exists(public_path($iconPath)) ? $iconPath : $fallback;

    $color = $colors[$i % count($colors)];
    $i++;
@endphp

<div class="glass-card shadow rounded-xl overflow-hidden hover:shadow-xl transition-all duration-300 group relative">

    <div class="h-2 w-full " style="background: {{ $color }}"></div>

    <div class="p-5">

        <div class="flex items-center justify-between mb-4">

            <div class="w-10 h-10 bg-surface-container rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-3xl">
                    {{ $category->icon ?? 'category' }}
                </span>
            </div>

            <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">

                <button
                    type="button"
                    @click="$store.crud.openEdit('{{ route('categories.update', $category) }}', @js([
                        'id' => $category->id,
                        'name' => $category->name,
                        'description' => $category->description,
                    ]))"
                    class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-surface-container text-secondary"
                >
                    <span class="material-symbols-outlined text-[18px]">edit</span>
                </button>

                <button
                    type="button"
                    @click="$store.crud.openConfirm(
                        'Supprimer catégorie',
                        'Cette action est irreversible',
                        () => document.getElementById('delete-cat-{{ $category->id }}').submit()
                    )"
                    class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-surface-container text-error"
                >
                    <span class="material-symbols-outlined text-[18px]">delete</span>
                </button>

                <form id="delete-cat-{{ $category->id }}" method="POST" action="{{ route('categories.destroy', $category) }}">
                    @csrf
                    @method('DELETE')
                </form>

            </div>

        </div>

        <h3 class="text-headline-md font-headline-md text-on-surface mb-1">
            {{ $category->name }}
        </h3>

        <p class="text-body-sm text-on-surface-variant mb-5">
            {{ $category->description ?? 'Aucune description.' }}
        </p>

        <div class="flex items-center gap-2 pt-4 border-t border-outline-variant">

            <span class="material-symbols-outlined text-primary text-sm"
                  style="font-variation-settings: 'FILL' 1;">
                inventory_2
            </span>

            <span class="text-label-md font-bold text-on-surface">
                {{ $category->products_count ?? 0 }}
            </span>

            <span class="text-body-sm text-on-surface-variant">
                 {{ Str::plural('produit', $category->products_count) }}
            </span>

        </div>

    </div>
</div>

@endforeach

<div
    @click="$store.crud.openCreate('{{ route('categories.store') }}', { name: '', description: '', icon: '' })"
    class="border-2 border-dashed border-outline-variant rounded-xl flex flex-col items-center justify-center p-6 hover:bg-surface-container-low hover:border-primary transition-all duration-300 cursor-pointer group min-h-[220px]"
>
    <div class="w-12 h-12 bg-surface-container rounded-full flex items-center justify-center mb-3">
        <span class="material-symbols-outlined text-primary">add</span>
    </div>

    <p class="text-headline-md font-headline-md text-on-surface-variant group-hover:text-primary">
        Nouvelle Catégorie
    </p>
</div>

</div>

        <x-pos.form-modal>

            <div>
                <label class="block mb-1">Nom</label>
                <input type="text" name="name" placeholder="Nom du categorie..." :value="$store.crud.formData.name" @input="$store.crud.formData.name = $event.target.value" class="w-full border rounded-lg p-2">
            </div>

            <div>
                <label class="block mb-1">Description</label>
                <textarea name="description" placeholder="Description de la categorie..." :value="$store.crud.formData.description" @input="$store.crud.formData.description = $event.target.value"
                    class="w-full border rounded-lg p-2"></textarea>
            </div>
            <div>
    <label class="block mb-2">Icone</label>

    <div class="grid grid-cols-6 gap-2">
        @foreach($icons as $icon)
            <label class="cursor-pointer">

                <input
                    type="radio"
                    name="icon"
                    value="{{ $icon }}"
                    class="hidden peer"
                    :checked="$store.crud.formData.icon === '{{ $icon }}'"
                    @change="$store.crud.formData.icon = '{{ $icon }}'"
                >

                <div class="w-10 h-10 flex items-center justify-center rounded-lg border
                            hover:bg-surface-container transition
                            peer-checked:bg-primary peer-checked:text-white">

                    <span class="material-symbols-outlined text-lg">
                        {{ $icon }}
                    </span>

                </div>
            </label>
        @endforeach
    </div>
</div>
        </x-pos.form-modal>

        <x-pos.confirm-modal />

    </main>

@endsection