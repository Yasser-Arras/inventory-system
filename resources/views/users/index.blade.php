@extends('layouts.pos')

@section('page')

    @php
        $editUser = request('edit') ? \App\Models\User::find(request('edit')) : null;
    @endphp

    <main class="ml-[260px] min-h-screen">

        <div class="p-margin-desktop max-w-[1440px] mx-auto space-y-gutter">

            {{-- HEADER --}}
            <div>
                <h2 class="text-headline-lg text-on-surface">Gestion des utilisateurs</h2>
                <p class="text-body-md text-on-surface-variant">
                    Modifier ou supprimer les comptes utilisateurs
                </p>
            </div>

            {{-- SUCCESS --}}
            @if(session('success'))
                <div class="p-3 bg-primary/10 text-primary rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- TABLE --}}
            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant overflow-hidden">

                <table class="w-full text-left">

                    <thead class="bg-surface-container-low text-label-caps text-outline">
                        <tr>
                            <th class="p-4">Utilisateur</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">Rôle</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-outline-variant">

                        @forelse($users as $user)
                            <tr class="hover:bg-surface-container-low transition">

                                <td class="p-4 font-medium text-on-surface">
                                    {{ $user->name }}
                                </td>

                                <td class="p-4 text-on-surface-variant">
                                    {{ $user->email }}
                                </td>

                                <td class="p-4">
                                    <span class="px-3 py-1 rounded-full text-xs bg-primary/10 text-primary">
                                        {{ $user->role ?? 'user' }}
                                    </span>
                                </td>

                                {{-- ACTIONS --}}
                                <td class="p-4 text-right">

                                    <div class="flex items-center justify-end gap-3">

                                        {{-- EDIT --}}
                                        <button type="button" @click="$store.crud.openEdit(
                              '{{ route('users.update', $user) }}',
                              @js([
                                'id' => $user->id,
                                'name' => $user->name,
                                'email' => $user->email,
                                'role' => $user->role,
                            ])
                            )" class="material-symbols-outlined text-secondary hover:opacity-70">
                                            edit
                                        </button>

                                        {{-- DELETE --}}
                                        <button type="button" @click="$store.crud.openConfirm(
                              'Supprimer utilisateur',
                              'Cette action est irréversible',
                              () => fetch('{{ route('users.destroy', $user) }}', {
                                method: 'POST',
                                headers: {
                                  'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                  'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: new URLSearchParams({ _method: 'DELETE' })
                              }).then(() => window.location.reload())
                            )" class="material-symbols-outlined text-error hover:opacity-70">
                                            delete
                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="4" class="p-6 text-center text-on-surface-variant">
                                    Aucun utilisateur trouvé.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="mt-4">
                {{ $users->links() }}
            </div>

        </div>

    </main>

    {{-- ================= EDIT MODAL ================= --}}
    <x-pos.form-modal>

        <div class="space-y-4">

            {{-- NAME --}}
            <div>
                <label>Nom</label>
                <input type="text" name="name" :value="$store.crud.formData.name"  placeholder="Nom"
                    @input="$store.crud.formData.name = $event.target.value" class="w-full border rounded-lg p-2">
            </div>

            {{-- EMAIL --}}
            <div>
                <label>Email</label>
                <input type="email" name="email" :value="$store.crud.formData.email" placeholder="Email"
                    @input="$store.crud.formData.email = $event.target.value" class="w-full border rounded-lg p-2">
            </div>

            {{-- ROLE --}}
            <div>
                <label>Rôle</label>

                <select name="role" :value="$store.crud.formData.role"
                    @change="$store.crud.formData.role = $event.target.value" class="w-full border rounded-lg p-2">
                    <option value="" disabled selected>Choisir un rôle</option>

                    <option value="admin">Admin</option>
                    <option value="cashier">Caissier</option>
                    <option value="user">Utilisateur</option>

                </select>
            </div>

        </div>

    </x-pos.form-modal>

    {{-- ================= CONFIRM MODAL ================= --}}
    <x-pos.confirm-modal />

@endsection