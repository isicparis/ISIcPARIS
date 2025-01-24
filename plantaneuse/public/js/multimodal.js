

// Attend que le document soit prêt avant d'exécuter le code
$(document).ready(function () {
    // Crée un cache pour stocker les résultats des recherches
    const cache = new Map();

    // Variable pour stocker la requête AJAX en cours
    let currentRequest = null;

    // Référence jQuery à la liste des plantes
    const $plantList = $('#plant-list');

    // Référence jQuery à la barre de recherche
    const $searchInput = $('#search_input');

    // Variable pour stocker le temps du dernier rendu
    let lastRender = 0;

    // Fonction pour générer le HTML d'une plante
    const template = (plant) => `
        <form action="${window.shopAddToCartUrl}" method="post" class="box">
            <img src="${plant.image}" alt="${plant.nom_commun}" loading="lazy" decoding="async">
            <div class="name">${plant.nom_commun}</div>
            <div class="price">${plant.prix_achat} $</div>
            <input type="number" name="product_quantity" min="1" value="1" class="quantity">
            ${Object.entries({
                product_name: plant.nom_commun,
                product_price: plant.prix_achat,
                product_image: plant.image
            }).map(([name, value]) => `<input type="hidden" name="${name}" value="${value}">`).join('')}
            <input type="submit" value="Ajouter au panier" name="add_to_cart" class="btn1">
        </form>
    `;

    // Fonction pour afficher les résultats de la recherche
    const processResponse = (response) => {
        // Obtient le temps actuel en millisecondes
        const now = performance.now();

        // Limite le rendu à 60 images par seconde
        if (now - lastRender < 16) return;

        // Met à jour le temps du dernier rendu
        lastRender = now;

        // Met à jour le contenu de la liste des plantes
        $plantList[0].innerHTML = response.length 
            ? response.map(template).join('') 
            : '<p class="no-results">Aucun résultat</p>';
    };

    // Fonction pour gérer la recherche
    const searchHandler = (searchTerm) => {
        // Annule la requête précédente si elle existe
        if (currentRequest) currentRequest.abort();

        // Si la recherche est vide, affiche toutes les plantes
        if (searchTerm === '') {
            // Si le cache ne contient pas les résultats pour une recherche vide
            if (!cache.has('')) {
                // Lance une nouvelle requête AJAX
                currentRequest = $.ajax({
                    url: window.shopAutoloadUrl,
                    type: 'GET',
                    data: { 
                        search_word: '', 
                        _token: window.csrfToken 
                    },
                    success: (response) => {
                        // Stocke les résultats dans le cache
                        cache.set('', response);
                        // Affiche les résultats
                        processResponse(response);
                    }
                });
            } else {
                // Utilise les résultats du cache
                processResponse(cache.get(''));
            }
            return;
        }

        // Si les résultats sont déjà dans le cache, les utilise
        if (cache.has(searchTerm)) {
            processResponse(cache.get(searchTerm));
            return;
        }

        // Lance une nouvelle requête AJAX pour la recherche
        currentRequest = $.ajax({
            url: window.shopAutoloadUrl,
            type: 'GET',
            data: { 
                search_word: searchTerm, 
                _token: window.csrfToken 
            },
            success: (response) => {
                // Stocke les résultats dans le cache
                cache.set(searchTerm, response);
                // Affiche les résultats
                processResponse(response);
            },
            error: (xhr) => {
                // Gère les erreurs, sauf si la requête a été annulée
                if (xhr.statusText !== 'abort') {
                    console.error('Erreur silencieuse');
                }
            }
        });
    };

    // Gestion de l'événement 'input' sur la barre de recherche
    let timeout;
    $searchInput.on('input', function() {
        // Récupère la valeur de la recherche
        const searchTerm = this.value.trim();

        // Annule le délai précédent
        clearTimeout(timeout);

        // Démarre un nouveau délai avant de lancer la recherche
        timeout = setTimeout(() => {
            // Utilise requestAnimationFrame pour optimiser le rendu
            requestAnimationFrame(() => {
                // Appelle la fonction de recherche
                searchHandler(searchTerm);
            });
        }, searchTerm ? 100 : 50); // Délai dynamique : 100ms si recherche, 50ms si effacement
    });
});

