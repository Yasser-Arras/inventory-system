@if ($paginator->hasPages())
    <div class="flex items-center justify-center gap-3 mt-10">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <button disabled
                class="w-10 h-10 rounded-xl border border-outline-variant text-on-surface-variant opacity-50 flex items-center justify-center">
                <span class="material-symbols-outlined">chevron_left</span>
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="w-10 h-10 rounded-xl border border-outline-variant flex items-center justify-center hover:bg-surface-container transition">
                <span class="material-symbols-outlined">chevron_left</span>
            </a>
        @endif

        {{-- Pages --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-2 text-outline">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span
                            class="w-10 h-10 rounded-xl bg-primary text-on-primary flex items-center justify-center font-bold shadow-md">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                           class="w-10 h-10 rounded-xl border border-outline-variant flex items-center justify-center hover:bg-surface-container transition">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="w-10 h-10 rounded-xl border border-outline-variant flex items-center justify-center hover:bg-surface-container transition">
                <span class="material-symbols-outlined">chevron_right</span>
            </a>
        @else
            <button disabled
                class="w-10 h-10 rounded-xl border border-outline-variant text-on-surface-variant opacity-50 flex items-center justify-center">
                <span class="material-symbols-outlined">chevron_right</span>
            </button>
        @endif

    </div>
@endif