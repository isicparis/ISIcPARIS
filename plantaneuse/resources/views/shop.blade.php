<x-app-layout>   
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            
        </h2>
    </x-slot>
    <div class="heading">
        <h3>Boutique</h3>
        <p><a href="{{ url('/') }}">Accueil</a> / Boutique</p>
    </div>
    

    <div class="search-bar">
        <button class="btn btn-outline-secondary">
        <i class="iconss bi bi-sliders"></i>
        <!-- Search Icon -->
        <i class="iconss bi bi-search"></i>

        <!-- Heart Icon -->
        <i class="icons bi bi-heart"></i>

        <!-- Trash (Delete) Icon -->
        <i class="icons bi bi-trash"></i>

        </button>
        <input
        type="text"
        class="form-control"
        placeholder="Rechercher une plante"
        aria-label="Rechercher une plante">
        <button class="btn btn-primary">
        <i class="bi bi-search"></i>
        </button>
    </div>

    <style>
        
.iconss{
    width: 300px;
    height : 300px ;
    background-color: red;
    color : black ;
}
    </style>

    <section class="home-products">
        <h1 class="title">NOTRE PLANTES</h1>
        <div class="box-container">
            @foreach($plantes as $plante)

            <form action="" method="post" class="box" id="result_para">
                <img src="{{ asset('images/' . $plante->image) }}" alt="{{ $plante->nom_commun }}">
                <div class="name">{{$plante->nom_commun}}</div>
                <div class="price">{{$plante->prix_achat}}</div>
                <input type="number" name="product_quantity" min="1" value="1" class="quantity">
                <input type="hidden" name="product_name" value="{{$plante->nom_commun}}">
                <input type="hidden" name="product_price" value="<{{$plante->prix_achat}}">
                <input type="hidden" name="product_image" value="{{$plante->image}}">
                <input type="submit" value="Ajouter au panier" name="add_to_cart" class="btn">
            </form>
            @endforeach
        </div>


        
    
</x-app-layout>