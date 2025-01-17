<x-app-layout> 
    @if(isset($message))
    <div class="message">
        <span> {{ $message }}</span>
        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
    </div>
   
    @endif  
    <x-slot name="head">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(isset($message))
            <div class="message">
                <span> {{ $message }}</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
            @endif
        </h2>
    </x-slot>
    <div class="heading">
        <h3>shop</h3>
        <p><a href="home.php">home</a> / shop</p>
    </div>
    
    <div class="search-bar">
        <button class="btn btn-outline-secondary">    
            <img src="{{ asset('img/settings.png') }}" alt="" class ="iconss">        
        </button>
        <form action="{{ route('shop.search') }}" method="GET">
        @csrf
            <input
        type="text"
        class="form-control"
        name="search_word"
        placeholder="Rechercher une plante"
        aria-label="Rechercher une plante">
            <button class="btn btn-primary" type="submit"> 
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
    
    @if(isset($results))
    <h3>Résultats de la recherche :</h3>
    <ul>
        @foreach($results as $result)
            <li>Résultat : {{ $result }}</li>
        @endforeach
    </ul>
    @else
    
        {{-- @if(isset($message))
        <div class="message">
            <span> {{ $message }}</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
       
        @endif --}}
        <h1 class="title">NOTRE PLANTES</h1>
        <div class="box-container">
            @foreach($plantes as $plante)
            
            <form action="{{ route('shop.addToCart') }}" method="post" class="box" id="result_para">
                @csrf
                <img src="{{ asset('images/' . $plante->image) }}" alt="{{ $plante->nom_commun }}">
                <div class="name">{{$plante->nom_commun}}</div>
                <div class="price">{{$plante->prix_achat}} $</div>
                <input type="number" name="product_quantity" min="1" value="1" class="quantity">
                <input type="hidden" name="product_name" value="{{$plante->nom_commun}}">
                <input type="hidden" name="product_price" value="<{{$plante->prix_achat}}">
                <input type="hidden" name="product_image" value="{{$plante->image}}">
                <input type="submit" value="add to cart" name="add_to_cart" class="btn">
            </form>
            @endforeach
        </div>


        @endif
    
</x-app-layout>