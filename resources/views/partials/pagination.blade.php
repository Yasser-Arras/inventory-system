@if ($paginator->hasPages())
  <div class="px-6 py-4 bg-surface-container-low/20 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-outline-variant">
    <p class="text-body-sm text-on-surface-variant">
      Affichage de
      <span class="font-bold text-on-surface">{{ $paginator->firstItem() ?? 0 }}-{{ $paginator->lastItem() ?? 0 }}</span>
      sur
      <span class="font-bold text-on-surface">{{ $paginator->total() }}</span>
      produits
    </p>
    <div class="flex gap-2 flex-wrap">
      @if ($paginator->onFirstPage())
        <span class="p-2 border border-outline-variant rounded-lg opacity-30 cursor-not-allowed">
          <span class="material-symbols-outlined text-[20px]">chevron_left</span>
        </span>
      @else
        <a href="{{ $paginator->previousPageUrl() }}" class="p-2 border border-outline-variant rounded-lg hover:bg-surface-container-low transition-colors">
          <span class="material-symbols-outlined text-[20px]">chevron_left</span>
        </a>
      @endif

      @foreach ($paginator->getUrlRange(max(1, $paginator->currentPage() - 2), min($paginator->lastPage(), $paginator->currentPage() + 2)) as $page => $url)
        @if ($page == $paginator->currentPage())
          <span class="px-4 py-2 bg-secondary text-on-secondary rounded-lg text-body-sm font-bold">{{ $page }}</span>
        @else
          <a href="{{ $url }}" class="px-4 py-2 hover:bg-surface-container rounded-lg text-body-sm transition-colors">{{ $page }}</a>
        @endif
      @endforeach

      @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="p-2 border border-outline-variant rounded-lg hover:bg-surface-container-low transition-colors">
          <span class="material-symbols-outlined text-[20px]">chevron_right</span>
        </a>
      @else
        <span class="p-2 border border-outline-variant rounded-lg opacity-30 cursor-not-allowed">
          <span class="material-symbols-outlined text-[20px]">chevron_right</span>
        </span>
      @endif
    </div>
  </div>
@endif
