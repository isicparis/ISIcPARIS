<x-app-layout>
 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- bouton ajouter une plante -->
            <div style="margin-top:2rem; text-align:center;" class ="w-full h-full mb-24">
                <a href="{{ route('plantes.ajout')}}" class="w-[400px] h-[100px] p-[30px] rounded-xl text-5xl bg-red-700 hover:bg-red-800  delete-all text-white m-auto p-auto justify-center items-center  text-center "
                   onclick="">
                    Ajouter une plante
                </a>
            </div>

            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table> 
                        
                        <tbody>
                        <section class="home-products">
                        <div class="box-container">
                            @foreach($plantes as $plante)
                            <div class="box" id="result_para">
                                <img src="{{ asset( $plante->image) }}" alt="{{ $plante->nom_commun }}">
                                <div class="name">{{$plante->nom_commun}}</div>
                                <div class="price">{{$plante->prix_achat}}</div>
                                <input type="number" name="product_quantity" value="{{ $plante->quantite }}" class="quantity">
                                <input type="hidden" name="product_name" value="{{$plante->nom_commun}}">
                                <input type="hidden" name="product_price" value="<{{$plante->prix_achat}}">
                                <input type="hidden" name="product_image" value="{{$plante->image}}">
                            
                                <div class="flex justify-center items-center">
                                    <form method="GET" action="{{ route('plantes.edit', $plante->id) }}">
                                        @csrf
                                        @method('GET')
                                        <button class="option-btn">Modifier</button>
                                    </form>
                                    <form method="GET" action="{{ route('plantes.delete', $plante->id) }}">
                                        @csrf
                                        {{-- @method('POST') --}}
                                        <button class="delete-btn " onclick="return confirm('Êtes vous sûr de supprimer cette plante ?');">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        </section>
                        </tbody>
                    </table> 
                </div>
            </div>
        </div>
    </div>

</x-app-layout>