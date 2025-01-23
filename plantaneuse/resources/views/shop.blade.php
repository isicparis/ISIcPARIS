<x-app-layout>
    <div class="heading">
        <h3>Boutique</h3>
        <p><a href="{{ url('/') }}">Accueil</a> / Boutique</p>
    </div>

    <!-- Barre de recherche -->
    <div class="search-bar position-relative d-flex align-items-center">
        <button class="btn btn-outline-secondary">
            <img src="{{ asset('img/settings.png') }}" alt="settings icon" class="iconss">
        </button>
        <form action="{{ route('shop.search') }}" method="GET" class="d-flex flex-grow-1">
            @csrf
            <input
                type="text"
                id="search_input"
                class="form-control"
                name="search_word"
                placeholder="Rechercher une plante"
                aria-label="Rechercher une plante"
                autocomplete="off">
            <button type="submit" class="btn btn-primary ms-2">
                <img src="{{ asset('img/loop.png') }}" alt="search icon" class="iconss">
            </button>
        </form>
        <!-- Suggestions Box -->
        <div id="suggestions-box" class="suggestions-box"></div>
    </div>

    <style>
        * {
            box-sizing: border-box;
        }

        .iconss {
            width: 30px;
            height: 30px;
        }

        .suggestions-box {
            display: none;
            z-index: 1000;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-height: 200px;
            overflow-y: auto;
            position: absolute;
            top: 100%;
            width: 100%;
        }

        .suggestion-item {
            padding: 10px 10px 10px 30px;
            cursor: pointer;
            font-size: 25px;
            color: #333333;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s ease;
        }

        .suggestion-item:hover {
            background-color: #f8f9fa;
        }

        .suggestion-item:last-child {
            border-bottom: none;
        }
    </style>

    <!-- Liste des plantes -->
    <section class="home-products">
        <h1 class="title">NOS PLANTES</h1>
        <div class="box-container" id="plant-list">
            <!-- Les plantes initiales -->
            @foreach($plantes as $plante)
            <form action="{{ route('shop.addToCart') }}" method="post" class="box">
                @csrf
                <img src="{{ asset($plante->image) }}" alt="{{ $plante->nom_commun }}">
                <div class="name">{{$plante->nom_commun}}</div>
                <div class="price">{{$plante->prix_achat}} $</div>
                <input type="number" name="product_quantity" min="1" value="1" class="quantity">
                <input type="hidden" name="product_name" value="{{$plante->nom_commun}}">
                <input type="hidden" name="product_price" value="{{$plante->prix_achat}}">
                <input type="hidden" name="product_image" value="{{$plante->image}}">
                <input type="submit" value="Ajouter au panier" name="add_to_cart" class="btn">
            </form>
            @endforeach
        </div>
    </section>
  
    <!-- Scripts -->
    <script>
        window.shopAutocompleteUrl = "{{ route('shop.autocomplete') }}";
        window.shopAutoloadUrl = "{{ route('shop.autoload') }}";
        window.shopAddToCartUrl = "{{ route('shop.addToCart') }}";
        window.csrfToken = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('js/multimodal.js') }}"></script>
    <script src="{{ asset('js/suggestions.js') }}"></script>
</x-app-layout>
