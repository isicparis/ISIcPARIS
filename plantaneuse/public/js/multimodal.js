
$(document).ready(function () {
    // Quand l'utilisateur tape dans la barre de recherche
    $('#search_input').on('keyup', function () {
        let search_word = $(this).val(); // Texte saisi

        // Requête Ajax
        $.ajax({
            url: window.shopAutoloadUrl, // URL de la route
            type: 'GET',
            data: { search_word: search_word, _token: window.csrfToken }, // Paramètres
            success: function (response) {
                console.log(response); // Afficher la réponse JSON dans la console
                let plantList = $('#plant-list');
                plantList.empty(); // Vider la liste des plantes existantes

                // Ajouter les résultats
                if (response.length > 0) {
                    response.forEach(function (plant) {
                        plantList.append(`
                            <form action="${window.shopAddToCartUrl}" method="post" class="box">
                             
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
                    plantList.append('<p> </p>');
                }
            },
            error: function () {
                alert('Erreur lors du chargement des données.');
            }
        });
    });
});    
