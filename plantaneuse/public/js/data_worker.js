self.onmessage = function(e) {
    const html = e.data.map(plant => `
        <form action="${self.window.shopAddToCartUrl}" method="post" class="box">
            <img src="${plant.image}" alt="${plant.nom_commun}" decoding="async">
            <div class="name">${plant.nom_commun}</div>
            <div class="price">${plant.prix_achat} $</div>
            <input type="number" name="product_quantity" min="1" value="1" class="quantity">
            <input type="hidden" name="product_name" value="${plant.nom_commun}">
            <input type="hidden" name="product_price" value="${plant.prix_achat}">
            <input type="hidden" name="product_image" value="${plant.image}">
            <input type="submit" value="Ajouter au panier" name="add_to_cart" class="btn">
        </form>
    `).join('');

    postMessage(html);
};