<x-app-layout>   
   
    <div class="heading">
        <h3>shop</h3>
        <p><a href="home.php">home</a> / shop</p>
    </div>
    
    <div class="search-bar">
        <button class="btn btn-outline-secondary">    
            <img src="{{ asset('img/settings.png') }}" alt="" class ="iconss">        
        </button>
        <form action="" method="post" class="">
            <input
        type="text"
        class="form-control"
        placeholder="Rechercher une plante"
        aria-label="Rechercher une plante">
            <button class="btn btn-primary">
                <img src="{{ asset('img/loop.png') }}" alt="" class ="iconss">        
            </button>
        </form>
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
                <input type="submit" value="add to cart" name="add_to_cart" class="btn">
            </form>
            @endforeach
        </div>


        
    
</x-app-layout>