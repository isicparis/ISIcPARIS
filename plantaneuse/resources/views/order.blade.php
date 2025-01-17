<x-app-layout>
  
    <section class="placed-orders">
        <h1 class="title">placed orders</h1>

        <div class="box-container">
           @if($order)
           @foreach($order as $item)

            <div class="box">
                <p>placed on : <span>{{$item->placed_on}}</span></p>
                <p>name : <span>{{$item->user->name}}</span></p>
                <p>email : <span>{{$item->user->email}}</span></p>
                <p>phone : <span>{{$item->user->phone}}</span></p>
                <p>address : <span>{{$item->user->address}}</span></p>
                <p>payment method : <span>{{$item->payment_method}}</span></p>
                <p>your orders : <span>{{$item->total_products}}</span></p>
                <p>total price : <span>{{$item->total_price}}€</span></p>
                <p>Payment status: 
                    <span style="color: @if ($item->status== 'pending') 
                                    {{ 'var(--orange)' }} 
                                @else 
                                    {{ 'green' }} 
                                @endif;">
                        {{ $item->status }}
                    </span>
                </p>
            </div>
            @endforeach

                
            @else
                <p class='empty'>You have no orders placed</p>
            @endif
        
        </div>
    </section>

</x-app-layout>