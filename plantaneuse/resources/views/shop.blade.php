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

            <div class="search-bar">
                <button class="btn1 btn-outline-secondary" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                    <img src="{{ asset('img/settings.png') }}" alt="" class ="iconss">
                </button>
                <form action="{{ route('shop.search') }}" method="GET">
                    @csrf
                    <input type="text" class="form-control" name="search_word" placeholder="Rechercher une plante"
                        aria-label="Rechercher une plante">
                    <button class="btn1" type="submit">
                        <img src="{{ asset('img/loop.png') }}" alt="rechercher" class ="iconss">
                    </button>
                </form>
            </div>

            <style>
                .iconss {
                    width: 300px;
                    height: 300px;
                    background-color: red;
                    color: black;
                }
            </style>


            <section class="home-products">

                @if (isset($results))
                    <h3>Résultats de la recherche :</h3>
                    <ul>
                        @foreach ($results as $result)
                            <li>Résultat : {{ $result }}</li>
                        @endforeach
                    </ul>
                @else
                    <h1 class="title">NOS PLANTES</h1>
                    <div class="box-container">
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



                @endif
                @include('layouts.filter')

        </main>
        @include('layouts.footer')
    </div>
</body>

</html>
