<header @php
  $showSearch = request()->routeIs('products.*')
    || request()->routeIs('users.*')
    || request()->routeIs('categories.*')

@endphp
  class="h-16 ml-[260px] w-[calc(100%-260px)] flex items-center justify-between px-margin-desktop sticky top-0 z-40 bg-surface border-b border-outline-variant">
  @if($showSearch ?? false)
    <div class="flex items-center gap-4 w-1/2 max-w-md">
      <form method="GET" action="{{  url()->current() }}" class="relative w-full">
        <input type="text" name="name" class="w-full pl-10 pr-4 py-2"
          placeholder="Rechercher..." />
      </form>
    </div>
  @else
    <div class="flex-1"></div>
  @endif

  <div class="flex items-center gap-4 md:gap-6">
    <button type="button"
      class="material-symbols-outlined text-on-surface-variant hover:bg-surface-container-low p-2 rounded-full transition-colors">notifications</button>
   
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                    class="material-symbols-outlined text-on-surface-variant hover:bg-surface-container-low p-2 rounded-full transition-colors">
                    logout
                </button>
            </form>
    <div class="h-8 w-px bg-outline-variant mx-2"></div>
    <div class="flex items-center gap-3">
      <div class="text-right hidden sm:block">
        <p class="text-body-sm font-bold text-on-surface leading-none">{{ auth()->user()->role ? ucfirst(auth()->user()->role) : 'User' }}</p>
        <p class="text-[11px] text-on-surface-variant"> {{  auth()->user()->role ?? 'User'  }}</p>
      </div>
      <img class="w-9 h-9 md:w-10 md:h-10 rounded-full border-2 border-primary/20 object-cover"
        src="https://lh3.googleusercontent.com/aida-public/AB6AXuBfDxaVKT0cV7aXinfXVoomdj3zM4OlH8LW4hUUUa0tCOxE4r7d-rJaV3AhFa7GQ2xKH8HRmeUli5wrkgGFG9k3h3zGffb5cMvpepAIivVHg-ktwTMmFGeeba0xaGHZkI70GhiksChaNRxmZa7BS5qP7KnQabPLCti8jOWjelm7d2iPH1uUFcbSe4826KYkz7Vw7I_lmKfUplngVBJ0Tak6ySi1GlfnNq-1yfH_DK5Dv19gXQkFrT9mf6M2kcnHFvHrh6brlDyecYA"
        alt="Profil" />
    </div>
  </div>
</header>