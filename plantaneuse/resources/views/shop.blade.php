<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tab Icon -->
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    @vite(['resources/js/main.js'])
    {{-- @vite(['resources/js/main.js', 'resources/js/multimodal.js', 'resources/js/suggestions.js']) --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <!-- <script src="{{ asset('js/main.js') }}"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        a {
            text-decoration: none;
        }
    </style>
</head>

<body class="font-sans antialiased">

    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Content -->
        <main>


            @if (isset($message))
                <div class="message1">
                    <span> {{ $message }}</span>
                    <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                </div>
            @endif

            <div class="heading">
                <h3>Boutique</h3>
                <p><a href="{{ route('home') }}">Accueil</a> / Boutique</p>
            </div>

            <!-- Barre de recherche -->
            <div class="search-bar">
                <button class="btn1 btn-outline-secondary" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                    <img src="{{ asset('img/settings.png') }}" alt="" class ="iconss">
                </button>
                <form action="{{ route('shop.search') }}" method="GET">
                    @csrf
                    <input type="text" id="search_input" class="form-control" name="search_word"
                        placeholder="Rechercher une plante" aria-label="Rechercher une plante" autocomplete="off">
                    <button class="btn1" type="submit">
                        <img src="{{ asset('img/loop.png') }}" alt="rechercher" class ="iconss">
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


            <section class="home-products">

                @if(isset($erreur))
            <h3 class="querry" >{{ $erreur }}</h3>
                @else
                    <!-- Liste des plantes -->
                    <h1 class="title">NOS PLANTES</h1>
                    <div class="box-container" id="plant-list">
                        @foreach ($plantes as $plante)
                            <form action="{{ route('shop.addToCart') }}" method="post" class="box"
                                id="result_para">
                                @csrf
                                <img src="{{ asset($plante->image) }}" alt="{{ $plante->nom_commun }}">
                                <div class="name">{{ $plante->nom_commun }}</div>
                                <div class="price">{{ $plante->prix_achat }} $</div>
                                <input type="number" name="product_quantity" min="1" value="1"
                                    class="quantity">
                                <input type="hidden" name="product_name" value="{{ $plante->nom_commun }}">
                                <input type="hidden" name="product_price" value="<{{ $plante->prix_achat }}">
                                <input type="hidden" name="product_image" value="{{ $plante->image }}">
                                <input type="submit" value="Ajouter au panier" name="add_to_cart" class="btn1">
                            </form>
                        @endforeach
                    </div>
{{-- 
                    <style>
                        .pagination .page-item .page-link {
                            color: #000;
                            /* Couleur des liens */
                            border: 1px solid #ddd;
                            padding: 10px 15px;
                            margin: 0 5px;
                            border-radius: 5px;
                        }

                        .pagination .page-item.active .page-link {
                            background-color: #a7d477 !important;
                            color: white;
                            border-color: #a7d477 !important;
                        }

                        .pagination {
                            display: flex;
                            justify-content: center;
                            margin-top: 20px;
                        }
                    </style>
                    <div class="d-flex justify-content-center">
                        {{ $plantes->links('pagination::bootstrap-5') }}
                    </div>
 --}}

                @endif
                @include('layouts.filter')

        </main>
        @include('layouts.footer')
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    <script>
        window.shopAutocompleteUrl = "{{ route('shop.autocomplete') }}";
        window.shopAutoloadUrl = "{{ route('shop.autoload') }}";
        window.shopAddToCartUrl = "{{ route('shop.addToCart') }}";
        window.csrfToken = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('js/multimodal.js') }}"></script>
    <script src="{{ asset('js/suggestions.js') }}"></script>
</body>

</html>
