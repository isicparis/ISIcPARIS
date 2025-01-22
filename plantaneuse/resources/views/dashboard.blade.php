<x-app-layout>
    
    <section class="home">
        <div class="content">
            <h3>Plantes qui respirent <br>la vie.</h3>
            <p>PLANTANEUSE : des plantes, du style, et un brin de nature chez vous. Découvrez nos trésors verts et
                faites de votre espace un véritable havre de sérénité.</p>
            <a href="{{route('shop')}}" class="white-btn">Discover more</a>
        </div>
    </section>
    <section class="home-products">
        <h1 class="title">Nos Plantes Populaires</h1>
        <div class="box-container">
            @foreach ($plantes as $plante)
                <form action="" method="post" class="box" id="result_para">
                    <!-- Affichage de l'image -->
                    <img src="{{ asset('images/' . $plante->image) }}" alt="{{ $plante->nom_commun }}">

                    <!--<img src="../images/{{ $plante->image }}" alt="{{ $plante->image }}">-->
                    <div class="name">{{ $plante->nom_commun }}</div>
                    <!-- Prix -->
                    <div class="price">Euro {{ $plante->prix_achat }}</div>
                    <!-- Quantité -->
                    <input type="number" name="product_quantity" min="1" value="1" class="quantity">
                    <input type="hidden" name="product_name" value="{{ $plante->nom_commun }}">
                    <input type="hidden" name="product_price" value="{{ $plante->prix_achat }}">
                    <input type="hidden" name="product_image" value="{{ $plante->image }}">
                    <input type="submit" value="Add to Cart" name="add_to_cart" class="btn1">
                </form>
            @endforeach
        </div>
        <input type="hidden" id="result_no" value="3">
        <input type="button" id="load" value="Load More Results" class="option-btn">
    </section>
    <section class="home-about">
        <h1 class="title">About PLANTANEUSE</h1>
        <div class="flex">
            <div class="imgBx">

                <img src="{{ asset('img/about-img.jpeg') }}" alt="about">
            </div>
            <div class="content">
                <p><span>PLANTA<span>NEUSE</span></span> PLANTANEUSE : des plantes, du style, et un brin de nature chez
                    vous. Découvrez nos trésors verts et faites de votre espace un véritable havre de sérénité.</p>
                <a href="{{route('about')}}" class="white-btn">discover more</a>
            </div>
        </div>
    </section>

    <section class="home-contact">
        <div class="content">
            <h3>have any questions</h3>
            <p>Keep in touch with us and ask about anything you want and we'll be for you as fast as possible !</p>
            <a href="{{route('contact')}}" class="white-btn">contact us</a>
        </div>
    </section>
</x-app-layout>