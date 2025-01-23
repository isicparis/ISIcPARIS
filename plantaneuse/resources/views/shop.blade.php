<x-app-layout>
    <div class="heading">
        <h3>Boutique</h3>
        <p><a href="{{ url('/') }}">Accueil</a> / Boutique</p>
    </div>

    <!-- Barre de recherche -->
    <div class="search-bar position-relative">
        <button class="btn btn-outline-secondary">
            <img src="{{ asset('img/settings.png') }}" alt="" class="iconss">
        </button>
        <form action="#" method="GET">
            <input
                type="text"
                id="search_input"
                class="form-control"
                name="search_word"
                placeholder="Rechercher une plante"
                aria-label="Rechercher une plante"
                autocomplete="off">
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
    <script>
        window.shopAutocompleteUrl = "{{ route('shop.autocomplete') }}";
  
        window.csrfToken = "{{ csrf_token() }}";
    </script>

    <!-- Scripts -->
   <!-- <script src="{{ asset('js/suggestions.js') }}"></script>-->
    

    <!-- Script JavaScript -->
    <script>
      $(document).ready(function () {
    // Quand l'utilisateur tape dans la barre de recherche
    $('#search_input').on('keyup', function () {
        let search_word = $(this).val(); // Texte saisi

        // Requête Ajax
        $.ajax({
            url: "{{ route('shop.autoload') }}", // URL de la route
            type: 'GET',
            data: { search_word: search_word }, // Paramètres
            success: function (response) {
                console.log(response); // Afficher la réponse JSON dans la console
                let plantList = $('#plant-list');
                plantList.empty(); // Vider la liste des plantes existantes

                // Ajouter les résultats
                if (response.length > 0) {
                    response.forEach(function (plant) {
                        plantList.append(`
                            <form action="{{ route('shop.addToCart') }}" method="post" class="box">
                                @csrf
                                <img src="${plant.image}" alt="${plant.nom_commun}">
                                <div class="name">${plant.nom_commun}</div>
                                <div class="price">${plant.prix_achat} $</div>
                                <input type="number" name="product_quantity" min="1" value="1" class="quantity">
                                <input type="hidden" name="product_name" value="${plant.nom_commun}">
                                <input type="hidden" name="product_price" value="${plant.prix_achat}">
                                <input type="hidden" name="product_image" value="${plant.image}">
                                <input type="submit" value="Ajouter au panier" name="add_to_cart" class="btn">
                            </form>
                        `);
                    });
                } else {
                    plantList.append('<p>Aucune plante trouvée.</p>');
                }
            },
            error: function () {
                alert('Erreur lors du chargement des données.');
            }
        });
    });
});    


    </script>
   
</x-app-layout>
