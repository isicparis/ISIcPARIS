<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Plante Edit') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{--<form action="{{ route('plantes.update', $plante->id) }}" method="post" enctype="multipart/form-data" class="box" id="result_para">
                    @csrf
                    @method('PUT')

                    <img src="{{ asset('images/' . $plante->image) }}" alt="{{ $plante->nom_commun }}">
                    <input type="number" name="product_quantity" value="{{ $plante->quantite }}" class="quantity">
                    <input type="text" name="product_name" value="{{ $plante->nom_commun }}">
                    <input type="text" name="product_price" value="{{ $plante->prix_achat }}">
                    <input type="file" name="product_image">
                    <a href="{{ route('plantes.update', $plante->id) }}">Mettre a jour</a>
                    </form>--}}
                    <form action="{{ route('plantes.update', $plante->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="nom_scientifique">Nom scientifique</label>
                            <input type="text" name="nom_scientifique" id="nom_scientifique" value="{{ old('nom_scientifique', $plante->nom_scientifique) }}" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="nom_commun">Nom commun</label>
                            <input type="text" name="nom_commun" id="nom_commun" value="{{ old('nom_commun', $plante->nom_commun) }}" class="form-control">
                        </div>

                        <!-- Répétez les champs pour tous les autres attributs -->

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                            @if($plante->image)
                            <img src="{{ asset('images/' . $plante->image) }}" alt="Image de la plante" class="img-thumbnail mt-2" width="150">
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="quantite">Quantité</label>
                            <input type="number" name="quantite" id="quantite" value="{{ old('quantite', $plante->quantite) }}" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="prix_achat">Prix d'achat</label>
                            <input type="number" name="prix_achat" id="prix_achat" value="{{ old('prix_achat', $plante->prix_achat) }}" step="0.01" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="prix_vente">Prix de vente</label>
                            <input type="number" name="prix_vente" id="prix_vente" value="{{ old('prix_vente', $plante->prix_vente) }}" step="0.01" class="form-control" required>
                        </div>

                        <!-- Ajoutez les champs restants de la table -->

                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </form>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>