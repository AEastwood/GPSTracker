<div class="app-header header-shadow">
    <div class="app-header__logo">
        @auth
        <a href="/home">
            <div class="logo-src"><img src="{{ asset('/imgs/architect/logo.png') }}"></div>
        </a>
        @else
        <a href="/">
            <div class="logo-src"><img src="{{ asset('/imgs/architect/logo.png') }}"></div>
        </a>
        @endauth
        <div class="pr-3"></div>
    </div>
    @auth
    <div class="app-header__content">
        
        <div class="app-header-right">
            {{-- Menu only for 'map' route --}}
            @if(Request::route()->getName() == 'map')
            
            @component('components.layout.map_tools')
            @endcomponent

            @endif

            @if(Request::route()->getName() != 'home')

                @component('components.layout.nav_menu')
                @endcomponent
            @endif
            
            @component('components.layout.user_menu')
            @endcomponent

        </div>
    </div>
    @endauth
</div>
