@extends('layouts.pos')

@section('page')

<main class="ml-[260px] p-margin-desktop max-w-[1440px] min-h-screen">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-8">

        <div>
            <h2 class="text-headline-lg font-headline-lg">
                Gestion des Fournisseurs
            </h2>

            <p class="text-body-md text-on-surface-variant">
                Visualisez et gérez vos fournisseurs.
            </p>
        </div>

        <button
            @click="$store.crud.openCreate(
                '{{ route('suppliers.store') }}',
                {
                    name: '',
                    contact_person: '',
                    phone: '',
                    city: '',
                    address: '',
                    status: 'active'
                }
            )"
            class="bg-primary text-white px-6 py-2 rounded-lg flex items-center gap-2"
        >
            <span class="material-symbols-outlined">add</span>
            Ajouter
        </button>

    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-primary">
            <p>Total Fournisseurs</p>
            <h2 class="text-2xl font-bold">{{ $totalSuppliers }}</h2>
        </div>

        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-green-500">
            <p>Commandes en cours</p>
            <h2 class="text-2xl font-bold">{{ $activeSuppliers }}</h2>
        </div>

        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-blue-500">
            <p>Villes desservies</p>
            <h2 class="text-2xl font-bold">{{ $citiesCount }}</h2>
        </div>

        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-orange-500">
            <p>Valeur achats</p>
            <h2 class="text-2xl font-bold">{{ number_format($totalPurchases, 2) }} DH</h2>
        </div>

    </div>
<div class="bg-white rounded-xl shadow p-4 mb-4">

    <form method="GET" class="w-full">

        <div class="flex items-stretch gap-3 w-full max-w-5xl mx-auto">

            {{-- SEARCH --}}
            <div class="relative flex-1">

                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[20px] pointer-events-none">
                    search
                </span>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Rechercher..."
                    class="h-11 w-full border border-gray-300 rounded-lg pl-10 pr-3
                           focus:outline-none focus:ring-2 focus:ring-primary"
                >

            </div>

            {{-- FILTER (FIXED ALIGNMENT) --}}
            <div class="flex-[1.2]">

                <select
                    name="filter"
                    class="h-11 w-full border border-gray-300 rounded-lg px-3
                           bg-white block appearance-none
                           focus:outline-none focus:ring-2 focus:ring-primary"
                >
                    <option value="name" @selected(request('filter') == 'name')>Nom</option>
                    <option value="contact_person" @selected(request('filter') == 'contact_person')>Contact</option>
                    <option value="phone" @selected(request('filter') == 'phone')>Téléphone</option>
                    <option value="city" @selected(request('filter') == 'city')>Ville</option>
                </select>

            </div>

            {{-- BUTTON --}}
            <button
                type="submit"
                class="h-11 px-6 bg-primary text-white rounded-lg whitespace-nowrap"
            >
                Rechercher
            </button>

        </div>

    </form>

</div>
    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="p-4 border-b">
            <h3 class="font-bold">Fournisseurs</h3>
        </div>

        <table class="w-full text-sm">

            <thead>
                <tr class="bg-gray-50 text-left">
                    <th class="p-4">Nom</th>
                    <th class="p-4">Contact</th>
                    <th class="p-4">Téléphone</th>
                    <th class="p-4">Ville</th>
                    <th class="p-4">Adresse</th>
                    <th class="p-4">Statut</th>
                    <th class="p-4">Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($suppliers as $supplier)

                <tr class="border-t">

                    <td class="p-4 font-bold">{{ $supplier->name }}</td>
                    <td class="p-4">{{ $supplier->contact_person }}</td>

                    <td class="p-4 phone-format">
                        {{ $supplier->phone }}
                    </td>

                    <td class="p-4">{{ $supplier->city }}</td>
                    <td class="p-4 text-gray-500">{{ $supplier->address ?: '-' }}</td>

                    <td class="p-4">
                        @if($supplier->status === 'active')
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                                Actif
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                Inactif
                            </span>
                        @endif
                    </td>

                    <td class="p-4">

                        <div class="flex items-center gap-2">

                            {{-- EDIT --}}
                            <button type="button"
                                @click="$store.crud.openEdit(
                                    '{{ route('suppliers.update', $supplier->id) }}',
                                    @js($supplier)
                                )"
                                class="w-8 h-8 rounded-md hover:bg-gray-100 flex items-center justify-center text-blue-600"
                            >
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </button>

                            {{-- DELETE --}}
                            <button type="button"
                                @click="$store.crud.openConfirm(
                                    'Supprimer fournisseur',
                                    'Cette action est irréversible',
                                    () => document.getElementById('delete-{{ $supplier->id }}').submit()
                                )"
                                class="w-8 h-8 rounded-md hover:bg-gray-100 flex items-center justify-center text-red-600"
                            >
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>

                            <form id="delete-{{ $supplier->id }}"
                                  method="POST"
                                  action="{{ route('suppliers.destroy', $supplier->id) }}">
                                @csrf
                                @method('DELETE')
                            </form>

                        </div>

                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-gray-500">
                        Aucun fournisseur pour le moment.
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>

    </div>

    {{-- MODAL --}}
<x-pos.form-modal>
  <div class="flex flex-col gap-4">

    {{-- NAME --}}
    <div>
      <label class="block mb-1 text-sm text-on-surface-variant">Nom entreprise</label>
      <input
        type="text"
        name="name"
        :value="$store.crud.formData.name"
        @input="$store.crud.formData.name = $event.target.value"
        placeholder="Ex: Atlas Trading SARL"
        class="w-full border p-2 rounded-lg"
      >
    </div>

    {{-- CONTACT PERSON --}}
    <div>
      <label class="block mb-1 text-sm text-on-surface-variant">Nom du contact</label>
      <input
        type="text"
        name="contact_person"
        :value="$store.crud.formData.contact_person"
        @input="$store.crud.formData.contact_person = $event.target.value"
        placeholder="Ex: Ahmed Benali"
        class="w-full border p-2 rounded-lg"
      >
    </div>

    {{-- PHONE --}}
    <div>
      <label class="block mb-1 text-sm text-on-surface-variant">Téléphone</label>
      <input
        type="text"
        name="phone"
        :value="$store.crud.formData.phone"
        @input="$store.crud.formData.phone = $event.target.value"
        placeholder="Ex: 0612345678"
        inputmode="numeric"
        class="w-full border p-2 rounded-lg"
      >
    </div>

    {{-- CITY --}}
    <div>
      <label class="block mb-1 text-sm text-on-surface-variant">Ville</label>

      <select
        name="city"
        :value="$store.crud.formData.city"
        @change="$store.crud.formData.city = $event.target.value"
        class="w-full border p-2 rounded-lg"
      >
        <option value="" disabled>Choisir une ville</option>

        @foreach($cities as $city)
          <option value="{{ $city }}">{{ $city }}</option>
        @endforeach

      </select>
    </div>

    {{-- ADDRESS --}}
    <div>
      <label class="block mb-1 text-sm text-on-surface-variant">Adresse</label>
      <textarea
        name="address"
        :value="$store.crud.formData.address"
        @input="$store.crud.formData.address = $event.target.value"
        placeholder="Ex: Rue 12, Quartier Maarif, Casablanca"
        class="w-full border p-2 rounded-lg"
      ></textarea>
    </div>

    {{-- STATUS --}}
    <div>
      <label class="block mb-1 text-sm text-on-surface-variant">Statut</label>

      <select
        name="status"
        :value="$store.crud.formData.status"
        @change="$store.crud.formData.status = $event.target.value"
        class="w-full border p-2 rounded-lg"
      >
        <option value="active">Actif</option>
        <option value="inactive">Inactif</option>
      </select>
    </div>

  </div>
</x-pos.form-modal>

    <x-pos.confirm-modal />

</main>

{{-- PHONE FORMAT --}}
<script>
document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll(".phone-format").forEach(el => {

        let raw = el.textContent.replace(/\D/g, '');

        el.textContent =
            raw.slice(0,2) + ' ' +
            raw.slice(2,4) + ' ' +
            raw.slice(4,7) + ' ' +
            raw.slice(7,10);

    });

});
</script>

@endsection