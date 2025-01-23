<x-app-layout>

    <section class="placed-orders">
        <div class="heading">
            <h3>commandes passées</h3>
            <p><a href="{{ route('home') }}">Accueil</a> / Commandes</p>
        </div>


        <div class="box-container">
            @if ($order)
                @foreach ($order as $item)
                    <div class="box">
                        <p>Placé le : <span>{{ $item->placed_on }}</span></p>
                        <p>Nom : <span>{{ $item->user->name }}</span></p>
                        <p>Email : <span>{{ $item->user->email }}</span></p>
                        <p>Téléphone : <span>{{ $item->user->phone }}</span></p>
                        <p>Adresse : <span>{{ $item->user->address }}</span></p>
                        <p>Mode de paiement : <span>{{ $item->payment_method }}</span></p>
                        <p>Nombre de produits : <span>{{ $item->total_products }}</span></p>
                        <p>Prix total : <span>{{ $item->total_price }}€</span></p>
                        <p>Statut de paiement :
                            <span
                                style="color: @if ($item->status == 'pending') {{ 'var(--orange)' }} 
                                            @else 
                                                {{ 'green' }} @endif;">
                                {{ $item->status }}
                            </span>
                        </p>
                    </div>
                @endforeach
            @else
                <p>Vous n'avez pas passé de commande</p>
            @endif

        </div>
    </section>

</x-app-layout>
