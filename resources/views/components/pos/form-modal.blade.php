<div x-show="$store.crud.formOpen"
     x-cloak
     class="fixed inset-0 z-[100] flex items-center justify-center p-4">

  <div class="absolute inset-0 bg-inverse-surface/60 backdrop-blur-sm"
       @click="$store.crud.closeForm()"></div>

  <div class="relative w-full max-w-lg bg-surface-container-lowest rounded-xl custom-shadow border border-white/20 overflow-hidden">

    <form method="POST"
          :action="$store.crud.action"
          @submit.prevent="$el.submit()"
          class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">

      @csrf

      <template x-if="$store.crud.mode === 'edit'">
        <input type="hidden" name="_method" value="PUT">
      </template>

      {{ $slot }}

      <div class="pt-4 flex justify-end gap-3 border-t border-outline-variant bg-surface-container-low/20">

        <button type="button"
                @click="$store.crud.closeForm()"
                class="px-4 py-2 rounded-lg border border-outline-variant text-body-sm font-medium hover:bg-surface-container-low">
          Annuler
        </button>

        <button type="submit"
          class="px-6 py-2 rounded-lg bg-primary text-on-primary text-body-sm font-bold hover:opacity-90">

          <span x-text="$store.crud.mode === 'edit' ? 'Mettre à jour' : 'Créer'"></span>

        </button>

      </div>

    </form>

  </div>
</div>