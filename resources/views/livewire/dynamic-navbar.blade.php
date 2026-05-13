<div wire:key="navbar-root"
    x-data="{ mobileOpen: false }"
    @keydown.escape="mobileOpen = false"   
    class="sticky top-0 z-[1100] w-full shadow-lg bg-white">
    
    {{-- 1. BREAKING NEWS TICKER --}}
    @include('partials.breaking-news', ['showDemo' => false])
    
    {{-- 2. MAIN NAVIGATION --}}
    @include('partials.main-navbar', ['showDemo' => false])
    
    {{-- 3. MOBILE MENU --}}
    @include('partials.mobile-navbar', ['showDemo' => false])    
</div>