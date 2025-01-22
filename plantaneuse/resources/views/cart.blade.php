<x-app-layout>
   
    <div class="heading">
        <h3>Shopping Cart</h3>
        <p><a href="{{ route('home') }}">Home</a> / Cart</p>
    </div>

    <section class="shopping-cart">
        <h1 class="title">Plantes ajoutées</h1>

        <div class="box-container">
            @php
                $grand_total = 0;
            @endphp

            @foreach ($cart as $item)
                @php
                    $plante = $plantes->firstWhere('id', $item->plant_id);
                    // $sub_total = $item->quantity * $plante->price; 
                    $grand_total += $item->price;
                @endphp

                <div class="box">
                    {{-- <a href="{{ route('cart.delete', $item->id) }}" class="fas fa-times"
                       onclick="return confirm('Are You Sure Delete This Item From Cart?!');"></a> --}}
                       <a href="#" class="fas fa-times" 
    onclick="event.preventDefault(); 
    if(confirm('Are You Sure Delete This Item From Cart?!')) {
        document.getElementById('delete-cart-{{ $item->id }}').submit();
    }">
</a>

<form id="delete-cart-{{ $item->id }}" action="{{ route('cart.delete', $item) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
              
                    <img src="{{ asset('images/' . $plante->image) }}" alt="{{ $plante->nom_commun }}">
                    <div class="name">{{ $plante->nom_commun }}</div>
                    <div class="price">${{ $plante->prix_achat }} /-</div>
                    <form action="{{ route('cart.update', $item) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="cart_id" value="{{ $item->id }}">
                        <input type="number" min="1" name="quantity" value="{{ $item->quantity }}">
                        <input type="hidden"  name="price" value="{{ $plante->prix_achat }}">
                        <input type="submit" name="update_cart" value="Update" class="option-btn">
                    </form>
                    <div class="sub-total">
                        {{-- <!-- Sub-total: <span>${{ $sub_total}} /-</span> --> --}}
                        Sub-total: <span>${{ $item->price}} /-</span>
                    </div>
                </div>
            {{-- <!-- @empty
                <p class="empty">No items added to cart</p> --> --}}
            @endforeach
        </div>

        <div style="margin-top:2rem; text-align:center;">
            <a href="#" class="delete-btn delete-all {{ $grand_total > 1 ? '' : 'disabled' }}"
               onclick="event.preventDefault();
               if(confirm('Are You Sure Delete All From Cart?!')) {
                   document.getElementById('delete-all-form').submit();
               }">
                Delete All
            </a>
        </div>
        
        <form id="delete-all-form" action="{{ route('cart.delete_all') }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>

        <div class="cart-total">
            <p>Grand Total: <span>${{ $grand_total }} /-</span></p>
            <div class="flex">
                <a href="{{ route('shop') }}" class="option-btn">Continue Shopping</a>
                <a href="{{route('checkout.index')}}" class="btn1 {{ $grand_total > 1 ? '' : 'disabled' }}">Proceed to Checkout</a>
            </div>
        </div>
    </section>

</x-app-layout>
