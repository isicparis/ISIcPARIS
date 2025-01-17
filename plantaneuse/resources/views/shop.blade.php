<x-app-layout>


    <div class="heading">
        <h3>Boutique</h3>
        <p><a href="{{ url('/') }}">Accueil</a> / Boutique</p>
    </div>

    <!-- Search Bar Container -->
    <div class="search-bar position-relative">
        <button class="btn btn-outline-secondary">
            <img src="{{ asset('img/settings.png') }}" alt="" class="iconss">
        </button>
        <form action="{{ route('shop.search') }}" method="GET">
            @csrf
            <input
                type="text"
                id="search_input"
                class="form-control"
                name="search_word"
                placeholder="Rechercher une plante"
                aria-label="Rechercher une plante"
                autocomplete="off">
            <button class="btn btn-primary" type="submit">
                <img src="{{ asset('img/loop.png') }}" alt="" class="iconss">
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
    }

    .suggestion-item {
        padding: 10px 10px 10px 30px; /* Ajoute un padding à gauche */
        cursor: pointer;
        font-size: 25px;
        color: #333333;
        border-bottom: 1px solid #f0f0f0;
        transition: background-color 0.2s ease;
    }

    .suggestion-item:hover {
        background-color: #f8f9fa; /* Effet de survol */
    }

    .suggestion-item:last-child {
        border-bottom: none; /* Pas de bordure pour le dernier élément */
    }
</style>


    <section class="home-products">
        @if(isset($message))
            <p>Message : {{ $message }}</p>
        @elseif(isset($results))
            <h3>Résultats de la recherche :</h3>
            <ul>
                @foreach($results as $result)
                    <li>Résultat : {{ $result }}</li>
                @endforeach
            </ul>
        @else
            <h1 class="title">NOS PLANTES</h1>
            <div class="box-container">
                @foreach($plantes as $plante)
                    <form action="" method="post" class="box" id="result_para">
                        <img src="{{ asset('images/' . $plante->image) }}" alt="{{ $plante->nom_commun }}">
                        <div class="name">{{ $plante->nom_commun }}</div>
                        <div class="price">{{ $plante->prix_achat }} $</div>
                        <input type="number" name="product_quantity" min="1" value="1" class="quantity">
                        <input type="hidden" name="product_name" value="{{ $plante->nom_commun }}">
                        <input type="hidden" name="product_price" value="{{ $plante->prix_achat }}">
                        <input type="hidden" name="product_image" value="{{ $plante->image }}">
                        <input type="submit" value="Ajouter au panier" name="add_to_cart" class="btn">
                    </form>
                @endforeach
            </div>
        @endif
    </section>


<script>
    // Pass the route URL and CSRF token to JavaScript
    window.shopAutocompleteUrl = "{{ route('shop.autocomplete') }}";
    window.csrfToken = "{{ csrf_token() }}";
</script>
</x-app-layout>