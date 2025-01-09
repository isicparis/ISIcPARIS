<section class="footer">
    <div class="box-container">

        <div class="box">
            <h3>Liens</h3>
            <a href="{{ route('home') }}">Acceuil</a>
            <a href="{{ route('about') }}">A propos</a>
            <a href="{{ route('shop') }}">Shop</a>
            <a href="{{ route('order') }}">Commandes</a>
            <a href="#">recherche</a>
        </div>

        <div class="box">
            <h3>contact info</h3>
            <p><i class="fas fa-phone"></i> +33 720092003 </p>
            <p><i class="fas fa-envelope"></i> ISIcPARIS@gmail.com </p>
            <p><i class="fas fa-map-marker-alt"></i> Paris, France </p>
        </div>

        <div class="box">
            <h3>follow us</h3>
            <a href="" target="_blank"><i class="fab fa-facebook-f"></i>
                Facebook</a>
            <a href="https://github.com/isicparis/ISIcPARIS" target="_blank"><i class="fab fa-github"></i> Github</a>
            <a href="" target="_blank"><i class="fab fa-instagram"></i>
                Instagram</a>
        </div>
    </div>

    <p class="credit">created by <a href="https://github.com/isicparis/ISIcPARIS" target="_blank">ISIcPARIS</a> @
        <?php echo date('Y'); ?>
        | all rights reserved! &copy;</p>
</section>
