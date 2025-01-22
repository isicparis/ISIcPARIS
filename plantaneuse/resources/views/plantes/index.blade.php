<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('plantes') }} 
        </h2>
    </x-slot>
 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table> 
                        
                        <tbody>
                        <section class="home-products">
                        <div class="box-container">
                            @foreach($plantes as $plante)
                            <div class="box" id="result_para">
                                <img src="{{ asset('images/' . $plante->image) }}" alt="{{ $plante->nom_commun }}">
                                <div class="name">{{$plante->nom_commun}}</div>
                                <div class="price">{{$plante->prix_achat}}</div>
                                <input type="number" name="product_quantity" value="{{ $plante->quantite }}" class="quantity">
                                <input type="hidden" name="product_name" value="{{$plante->nom_commun}}">
                                <input type="hidden" name="product_price" value="<{{$plante->prix_achat}}">
                                <input type="hidden" name="product_image" value="{{$plante->image}}">
                                <a href="{{ route('plantes.edit', $plante->id) }}" class="btn1">Edit</a>
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