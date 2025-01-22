<x-app-layout>   

    <section class="display-order">
        <h3>Your Order</h3>
        @if($cart_items->isEmpty())
            <p class="empty">Your cart is empty</p>
        @else
             @php
                $total=0
             @endphp
            @foreach($cart_items as $item)
                @php
                    $total=$total+ $item->price
                @endphp
                <p>{{ $item->plante->nom_commun }} salut<span>( {{ $item->price }} $ )</span></p>
            @endforeach
            
            <div class="grand-total">Grand Total: <span>${{ $total}}</span></div>
        @endif
    </section>
    
    <section class="checkout">
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            @php
             if (auth()->check()) {
                        $userId = auth()->id();
                        $userEmail = \App\Models\User::find($userId)->email;
                        $name = \App\Models\User::find($userId)->name;}
            @endphp
            <h3>Place Your Order</h3>
            <div class="flex">
                <div class="input-box">
                    <label for="name">Your Name:</label>
                    <input type="text" name="name" id="name" disabeled value="{{$name}}">
                </div>
                <div class="input-box">
                    <label for="phone">Your Phone:</label>
                    <input type="text" name="phone" id="phone" required>
                </div>
                <div class="input-box">
                    <label for="email">Your Email:</label>
                    
                    
                    <input type="email" name="email" id="email" placeholder="{{$userEmail }}" value="{{$userEmail }}" disabled  >
                </div>
                <div class="input-box">
                    <label for="method">Payment Method:</label>
                    <select name="method" id="method" required>
                        <option value="cash on delivery">Cash on Delivery</option>
                        <option value="credit card">Credit Card</option>
                    </select>
                </div>
                <div class="input-box">
                    <label for="flat">Flat No.:</label>
                    <input type="text" name="flat" id="flat" >
                </div>
                <div class="input-box">
                    <label for="street">Street:</label>
                    <input type="text" name="street" id="street" required>
                </div>
                <div class="input-box">
                    <label for="city">City:</label>
                    <input type="text" name="city" id="city" required>
                </div>
                <div class="input-box">
                    <label for="state">State:</label>
                    <input type="text" name="state" id="state" required>
                </div>
                <div class="input-box">
                    <label for="country">Country:</label>
                    <input type="text" name="country" id="country" required>
                </div>
                <div class="input-box">
                    <label for="pin_code">Pin Code:</label>
                    <input type="text" name="pin_code" id="pin_code" required>
                </div>
            </div>
            <button type="submit" class="btn1">Order Now</button>
        </form>
    </section>
</x-app-layout>