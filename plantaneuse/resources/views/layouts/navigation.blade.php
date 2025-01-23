<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <header class="header">
        <div class="main-header">
            <div class="flex">
                <a href="{{ route('home') }}" class="logo">PLANT<span>ANEUSE</span></a>
                @auth
                    @if (auth()->user()->is_admin)
                        <!-- Navigation pour les administrateurs -->
                        <nav class="navbar">
                            <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                                {{ __('Accueil') }}
                            </x-nav-link>
                            <x-nav-link :href="route('shop')" :active="request()->routeIs('shop')">
                                {{ __('Boutique') }}
                            </x-nav-link>
                            <x-nav-link :href="route('plantes.index')" :active="request()->routeIs('plante.index')">
                                {{ __('Plante') }}
                            </x-nav-link>
                        </nav>
                    @else
                        <!-- Navigation pour les utilisateurs non administrateurs -->
                        <nav class="navbar">
                            <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                                {{ __('Accueil') }}
                            </x-nav-link>
                            <x-nav-link :href="route('about')" :active="request()->routeIs('about')">
                                {{ __('À propos') }}
                            </x-nav-link>
                            <x-nav-link :href="route('shop')" :active="request()->routeIs('shop')">
                                {{ __('Boutique') }}
                            </x-nav-link>
                            <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                                {{ __('Contact') }}
                            </x-nav-link>
                            <x-nav-link :href="route('order')" :active="request()->routeIs('order')">
                                {{ __('Commandes') }}
                            </x-nav-link>
                        </nav>
                    @endif

                    
                    <!-- Options utilisateur -->
                    <div class="icons">
                        <div id="menu-btn" class="fas fa-bars"></div>
                        @if (!auth()->user()->is_admin)
                            <a href="{{ route('shop') }}" class="fas fa-search"></a>
                            <a href="{{ route('cart.index') }}">
                                <i class="fas fa-shopping-cart"></i>
                                @php
                                    $user_id = auth()->id();
                                    $count = \App\Models\Cart::where('user_id', $user_id)->count();
                                @endphp
                                <span>({{ $count }})</span>
                            </a>
                        @endif
                        <div id="user-btn" class="fas fa-user"></div>
                    </div>

                    <!-- Dropdown utilisateur -->
                    <div class="user-box">
                        <p>{{ Auth::user()->name }}</p>
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                this.closest('form').submit();">
                                {{ __('Déconnexion') }}
                            </x-dropdown-link>
                        </form>
                    </div>
                @endauth

                @guest
                    <!-- Navigation pour les visiteurs non connectés -->
                    <nav class="navbar">
                        <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                            {{ __('Accueil') }}
                        </x-nav-link>
                        <x-nav-link :href="route('about')" :active="request()->routeIs('about')">
                            {{ __('À propos') }}
                        </x-nav-link>
                        <x-nav-link :href="route('shop')" :active="request()->routeIs('shop')">
                            {{ __('Boutique') }}
                        </x-nav-link>
                        <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                            {{ __('Contact') }}
                        </x-nav-link>
                        
                        <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                            {{ __('Connexion') }}
                        </x-nav-link>
                        <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                            {{ __('register') }}
                        </x-nav-link>
                    </nav>
                    
                   
                @endguest
            </div>
        </div>
    </header>
</nav>