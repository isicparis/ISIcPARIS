// Affiche un message dans la console pour confirmer que le fichier est chargé
console.log("suggestions.js is loaded!");

// Attend que le document soit prêt avant d'exécuter le code
$(document).ready(function() {
    // Récupère l'élément de la boîte de suggestions
    const suggestionsBox = $('#suggestions-box');
    let searchTimeout; // Pour gérer le délai avant la requête AJAX
    let currentFocus; // Pour suivre la suggestion actuellement sélectionnée

    // Fonction pour ajuster la position de la boîte de suggestions
    function adjustSuggestions() {
        const inputWidth = $('#search_input').outerWidth(); // Largeur de l'input
        const inputOffset = $('#search_input').offset(); // Position de l'input
        const inputHeight = $('#search_input').outerHeight(); // Hauteur de l'input
        const gap = 2; // Espace entre l'input et la boîte de suggestions

        // Ajuste le style de la boîte de suggestions
        suggestionsBox.css({
            width: inputWidth,
            //position: 'absolute',
            top: inputOffset.top + inputHeight + gap,
            left: inputOffset.left,
            display: 'block' // Rend la boîte visible
        });
    }

    // Écoute l'événement 'input' sur le champ de recherche
    $('#search_input').on('input', function() {
        clearTimeout(searchTimeout); // Annule le délai précédent

        const query = $(this).val(); // Récupère la valeur de l'input

        // Masque la boîte de suggestions si l'input est vide
        if (query.length < 1) {
            suggestionsBox.hide();
            return;
        }

        // Déclenche la requête AJAX après un délai de 300ms
        searchTimeout = setTimeout(function() {
            $.ajax({
                url: window.shopAutocompleteUrl, // URL de la route pour l'autocomplétion
                type: 'POST', // Méthode HTTP
                data: { search_word: query, _token: window.csrfToken }, // Données envoyées
                dataType: 'json', // Type de réponse attendu
                success: function(data) {
                    suggestionsBox.empty(); // Vide la boîte de suggestions

                    // Si des résultats sont trouvés
                    if (data && data.length > 0) {
                        data.forEach(function(suggestion) {
                            // Met en évidence le terme recherché dans la suggestion
                            const highlightedSuggestion = suggestion.replace(new RegExp(query, 'gi'), `<strong>${query}</strong>`);
                            suggestionsBox.append(`<div class="suggestion-item">${highlightedSuggestion}</div>`);
                        });

                        // Masque la boîte de suggestions si on clique en dehors
                        $(document).click(function(event) {
                            if (!$(event.target).closest('.search-bar').length) {
                                suggestionsBox.hide();
                            }
                        });

                        // Sélectionne une suggestion au clic
                        $('.suggestion-item').click(function() {
                            $('#search_input').val($(this).text());
                            suggestionsBox.hide();
                        });

                        suggestionsBox.show(); // Affiche la boîte de suggestions
                        currentFocus = -1; // Réinitialise la suggestion sélectionnée
                    } else {
                        // Si aucun résultat n'est trouvé, on ne fait rien (pas de message)
                        suggestionsBox.hide(); // Masque la boîte de suggestions
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Affiche une erreur en cas de problème avec la requête AJAX
                    console.error("AJAX Error:", textStatus, errorThrown, jqXHR.responseText, jqXHR);
                }
            });
        }, 300); // Délai de 300ms avant la requête
    });

    // Gère la navigation au clavier dans les suggestions
    $('#search_input').on('keydown', function(event) {
        const items = $('.suggestion-item');
        if (!items.length) return;

        switch (event.key) {
            case 'ArrowDown': // Flèche vers le bas
                event.preventDefault();
                currentFocus++;
                if (currentFocus >= items.length) currentFocus = items.length - 1;
                updateFocus(items);
                break;
            case 'ArrowUp': // Flèche vers le haut
                event.preventDefault();
                currentFocus--;
                if (currentFocus < 0) currentFocus = 0;
                updateFocus(items);
                break;
            case 'Enter': // Touche Entrée
                if (currentFocus >= 0 && currentFocus < items.length) {
                    $('#search_input').val(items.eq(currentFocus).text());
                    suggestionsBox.hide();
                    // Soumet le formulaire
                    $('#search_input').closest('form').submit();
                }
                break;
        }
    });

    // Met à jour le style de la suggestion sélectionnée
    function updateFocus(items) {
        items.removeClass('focus');
        items.eq(currentFocus).addClass('focus');
    }

    // Ajuste la boîte de suggestions lors du redimensionnement de la fenêtre
    $(window).on('resize', adjustSuggestions);

    // Ajuste la boîte de suggestions au chargement de la page
    adjustSuggestions();
});