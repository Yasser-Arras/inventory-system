<div
  x-show="$store.crud.confirmOpen"
  x-cloak
  class="fixed inset-0 z-[110] flex items-center justify-center p-4"
  @keydown.escape.window="$store.crud.closeConfirm()"
>
  <div
    class="absolute inset-0 bg-inverse-surface/60 backdrop-blur-sm"
    @click="$store.crud.closeConfirm()"
  ></div>

  <div
    class="relative w-full max-w-md bg-surface-container-lowest rounded-xl custom-shadow border border-white/20 overflow-hidden"
    @click.stop
  >
    <div class="p-6">
      <div class="w-12 h-12 rounded-full bg-error-container/40 flex items-center justify-center mb-4">
        <span class="material-symbols-outlined text-error">warning</span>
      </div>

      <h3 class="text-headline-md font-headline-md text-on-surface mb-2"
          x-text="$store.crud.confirmTitle"></h3>

      <p class="text-body-sm text-on-surface-variant"
         x-text="$store.crud.confirmMessage"></p>
    </div>

    <div class="px-6 py-4 border-t border-outline-variant bg-surface-container-low/20 flex justify-end gap-3">
      <button
        type="button"
        @click="$store.crud.closeConfirm()"
        class="px-4 py-2 rounded-lg border border-outline-variant text-body-sm font-medium hover:bg-surface-container-low transition-colors"
      >
        Annuler
      </button>

      <button
        type="button"
        @click="$store.crud.submitConfirm()"
        class="px-6 py-2 rounded-lg bg-error text-on-error text-body-sm font-bold hover:opacity-90 transition-all"
      >
        Supprimer
      </button>
    </div>
  </div>
</div>