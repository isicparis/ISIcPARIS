
<x-app-layout>
    
    <section class="home">
        <div class="content">
            <h3>Plantes qui respirent <br>la vie.</h3>
            <p>PLANTANEUSE : des plantes, du style, et un brin de nature chez vous. Découvrez nos trésors verts et
                faites de votre espace un véritable havre de sérénité.</p>
            <a href="{{route('shop')}}" class="white-btn">Découvrir plus</a>
        </div>
    </section>
    <section class="home-products">
        <h1 class="title">Nos Plantes Populaires</h1>
        <div class="box-container">
            @foreach ($plantes as $plante)
                <form action="" method="post" class="box" id="result_para">
                    <!-- Affichage de l'image -->
                    <img src="{{ asset($plante->image) }}" alt="{{ $plante->nom_commun }}">

                    <!--<img src="../images/{{ $plante->image }}" alt="{{ $plante->image }}">-->
                    <div class="name">{{ $plante->nom_commun }}</div>
                    <!-- Prix -->
                    <div class="price">Euro {{ $plante->prix_achat }}</div>
                    <!-- Quantité -->
                    <input type="number" name="product_quantity" min="1" value="1" class="quantity">
                    <input type="hidden" name="product_name" value="{{ $plante->nom_commun }}">
                    <input type="hidden" name="product_price" value="{{ $plante->prix_achat }}">
                    <input type="hidden" name="product_image" value="{{ $plante->image }}">
                    <input type="submit" value="Ajouter au panier" name="add_to_cart" class="btn1">
                </form>
            @endforeach
        </div>
        <input type="hidden" id="result_no" value="3">
        <form action="{{ route('shop') }}" method="get">
    <input type="submit" id="load" value="Charger plus de résultats" class="option-btn">
</form>
    </section>
    <section class="home-about">
        <h1 class="title">À propos de PLANTANEUSE</h1>
        <div class="flex">
            <div class="imgBx">

                <img src="{{ asset('img/about-img.jpeg') }}" alt="about">
            </div>
            <div class="content">
                <p><span>PLANTA<span>NEUSE</span></span> PLANTANEUSE : des plantes, du style, et un brin de nature chez
                    vous. Découvrez nos trésors verts et faites de votre espace un véritable havre de sérénité.</p>
                <a href="{{route('about')}}" class="white-btn">Découvrir plus</a>
            </div>
        </div>
    </section>

    <section class="home-contact">
        <div class="content">
            <h3>Avez-vous des questions</h3>
            <p>Restez en contact avec nous et posez-nous toutes vos questions. Nous vous répondrons le plus rapidement possible !</p>
            <a href="contact.php" class="white-btn">Contactez-nous</a>
        </div>
    </section>
</x-app-layout>
