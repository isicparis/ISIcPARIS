document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search_input');
    const suggestionsContainer = document.getElementById('suggestions');

    searchInput.addEventListener('input', function () {
        const query = searchInput.value;

        // Ne pas continuer si l'utilisateur n'a pas saisi au moins 2 caractères
        if (query.length < 2) {
            suggestionsContainer.innerHTML = '';
            return;
        }

        // Appeler l'API Laravel pour récupérer les suggestions
        fetch(`/shop/suggestions?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                // Vider le conteneur des suggestions
                suggestionsContainer.innerHTML = '';

                // Ajouter les nouvelles suggestions
                if (data.length > 0) {
                    data.forEach(suggestion => {
                        const suggestionItem = document.createElement('div');
                        suggestionItem.classList.add('suggestion-item');
                        suggestionItem.textContent = suggestion;
                        suggestionItem.addEventListener('click', function () {
                            searchInput.value = suggestion;
                            suggestionsContainer.innerHTML = '';
                        });
                        suggestionsContainer.appendChild(suggestionItem);
                    });
                } else {
                    suggestionsContainer.innerHTML = '<div class="no-suggestions">Aucune suggestion disponible</div>';
                }
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des suggestions:', error);
            });
    });
});
