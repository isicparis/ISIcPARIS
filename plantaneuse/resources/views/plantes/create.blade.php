<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Plante Edit') }}
        </h2>
    </x-slot>

    
                    {{--<form action="{{ route('plantes.update', $plante->id) }}" method="post" enctype="multipart/form-data" class="box" id="result_para">
                    @csrf
                    @method('PUT')
                    
                    <img src="{{ asset('images/' . $plante->image) }}" alt="{{ $plante->nom_commun }}">
                    <input type="number" name="product_quantity" value="{{ $plante->quantite }}" class="quantity">
                    <input type="text" name="product_name" class="name" value="{{ $plante->nom_commun }}">
                    <input type="text" name="product_price" class="price" value="{{ $plante->prix_achat }}">
                    <input type="file" name="product_image">
                    <a href="{{ route('plantes.update', $plante->id) }}">Mettre a jour</a>
                    
                    </form>--}}


<style>
    /* Styles pour le conteneur principal */
.py-12 {
    padding: 3rem 0;
}

.max-w-7xl {
    max-width: 112rem;
    margin: 0 auto;
}

.sm\\:px-6 {
    padding-left: 1.5rem;
    padding-right: 1.5rem;
}

.lg\\:px-8 {
    padding-left: 2rem;
    padding-right: 2rem;
}

/* Styles pour la carte */
.bg-white {
    background-color: #ffffff;
}

.shadow-sm {
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.sm\\:rounded-lg {
    border-radius: 0.5rem;
}

.p-6 {
    padding: 1.5rem;
}

.text-gray-900 {
    color: #1a202c;
}

/* Section produits */
.home-products {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

/* Formulaire */
.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #4a5568;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 0.375rem;
    background-color: #f7fafc;
    color: #4a5568;
    font-size: 1rem;
}

.form-control:focus {
    outline: none;
    border-color: #3182ce;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);
}



/* Image */
.img-thumbnail {
    display: block; /* Nécessaire pour que le centrage fonctionne */
    margin: 1rem auto; /* Centre horizontalement avec auto sur les marges */
    border: 1px solid #e2e8f0;
    border-radius: 0.375rem;
    max-width: 100%; /* Empêche l'image de déborder de son conteneur */
    width: 200px; /* Taille de l'image en pixels (modifiable selon besoin) */
    height: auto; /* Garde les proportions de l'image */
    transition: transform 0.3s ease; /* Ajoute une animation pour l'agrandissement */
}

.img-thumbnail:hover {
    transform: scale(1.1); /* Agrandit légèrement l'image au survol */
}
.zidfaza input {
            height : 60px ;
            padding-left : 30px ;
            font-size: medium;
            
        }
        .zidfaza  label{
            font  : bold
        }
        .zidfaza textarea {
            height : 60px ;
            padding-left : 30px ;
            padding-top : 18px ;
            font-size: medium;
        }


</style>

            <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <section class="home-products text-3xl  zidfaza">
                    <!-- <div class="box-container"> -->
                        <form action="{{ route('plantes.create') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            
                            {{-- @method('POST') --}}
                                <!-- Nom scientifique -->
                                <div class="form-group">
                                    <label for="nom_scientifique">Nom scientifique</label>
                                    <input type="text" name="nom_scientifique" id="nom_scientifique" class="form-control" required>
                                </div>
                        
                                <!-- Nom commun -->
                                <div class="form-group">
                                    <label for="nom_commun">Nom commun</label>
                                    <input type="text" name="nom_commun" id="nom_commun" class="form-control">
                                </div>
                        
                                <!-- Famille -->
                                <div class="form-group">
                                    <label for="famille">Famille</label>
                                    <input type="text" name="famille" id="famille" class="form-control">
                                </div>
                        
                                <!-- Genre -->
                                <div class="form-group">
                                    <label for="genre">Genre</label>
                                    <input type="text" name="genre" id="genre" class="form-control">
                                </div>
                        
                                <!-- Espèce -->
                                <div class="form-group">
                                    <label for="espece">Espèce</label>
                                    <input type="text" name="espece" id="espece" class="form-control">
                                </div>
                        
                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control"></textarea>
                                </div>
                        
                                <!-- Image -->
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" name="image" id="image" class="form-control">
                                </div>
                        
                                <!-- Quantité -->
                                <div class="form-group">
                                    <label for="quantite">Quantité</label>
                                    <input type="number" name="quantite" id="quantite" class="form-control" required>
                                </div>
                        
                                <!-- Prix d'achat -->
                                <div class="form-group">
                                    <label for="prix_achat">Prix d'achat</label>
                                    <input type="number" name="prix_achat" id="prix_achat" step="0.01" class="form-control" required>
                                </div>
                        
                                <!-- Prix de vente -->
                                <div class="form-group">
                                    <label for="prix_vente">Prix de vente</label>
                                    <input type="number" name="prix_vente" id="prix_vente" step="0.01" class="form-control" required>
                                </div>
                        
                                <!-- Tags -->
                                <div class="form-group">
                                    <label for="tags">Tags</label>
                                    <input type="text" name="tags" id="tags" class="form-control">
                                </div>
                        
                                <!-- Type de plante -->
                                <div class="form-group">
                                    <label for="type_de_plante">Type de plante</label>
                                    <input type="text" name="type_de_plante" id="type_de_plante" class="form-control">
                                </div>
                        
                                <!-- Niveau d'entretien -->
                                <div class="form-group">
                                    <label for="niveau_entretien">Niveau d'entretien</label>
                                    <input type="text" name="niveau_entretien" id="niveau_entretien" class="form-control">
                                </div>
                        
                                <!-- Besoins en lumière -->
                                <div class="form-group">
                                    <label for="besoins_lumiere">Besoins en lumière</label>
                                    <input type="text" name="besoins_lumiere" id="besoins_lumiere" class="form-control">
                                </div>
                        
                                <!-- Fréquence d'arrosage -->
                                <div class="form-group">
                                    <label for="frequence_arrosage">Fréquence d'arrosage</label>
                                    <input type="text" name="frequence_arrosage" id="frequence_arrosage" class="form-control">
                                </div>
                        
                                <!-- Port de la plante -->
                                <div class="form-group">
                                    <label for="port_plante">Port de la plante</label>
                                    <input type="text" name="port_plante" id="port_plante" class="form-control">
                                </div>
                        
                                <!-- Floraison -->
                                <div class="form-group">
                                    <label for="floraison">Floraison</label>
                                    <input type="text" name="floraison" id="floraison" class="form-control">
                                </div>
                        
                                <!-- Toxicité -->
                                <div class="form-group">
                                    <label for="toxicite">Toxicité</label>
                                    <select name="toxicite" id="toxicite" class="form-control">
                                        <option value="1" selected>Oui</option>
                                        <option value="0">Non</option>
                                    </select>
                                </div>
                        
                                <!-- Couleur -->
                                <div class="form-group">
                                    <label for="couleur">Couleur</label>
                                    <input type="text" name="couleur" id="couleur" class="form-control">
                                </div>
                        
                                <!-- Taille -->
                                <div class="form-group">
                                    <label for="taille">Taille</label>
                                    <input type="text" name="taille" id="taille" class="form-control">
                                </div>
                        
                                <!-- Saisonnalité -->
                                <div class="form-group">
                                    <label for="saisonnalite">Saisonnalité</label>
                                    <input type="text" name="saisonnalite" id="saisonnalite" class="form-control">
                                </div>
                        
                                <!-- Origine -->
                                <div class="form-group">
                                    <label for="origine">Origine</label>
                                    <input type="text" name="origine" id="origine" class="form-control">
                                </div>
                        
                                <!-- Bouton de soumission -->
                                <button type="submit" class="btn btn-primary">Ajouter cette plante</button>
                            
                        </form>
                    <!-- </div> -->
                    </section>
                </div>
            </div>
        </div>

    </div>
    

</x-app-layout>