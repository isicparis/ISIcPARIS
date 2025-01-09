
<x-app-layout>   

    <div class="heading">
    <h3>Contact Us</h3>
    <p><a href="{{ url('/') }}">Home</a> / Contact</p>
</div>

<section class="contact">
    @if(session('message'))
    <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <form action="{{ route('contact') }}" method="POST">
        @csrf
        <h3>Get in touch!</h3>
        <input type="text" name="name" placeholder="Full Name" class="box" value="{{ old('name') }}" required>
        @error('name')<span class="error">{{ $message }}</span>@enderror

        <input type="text" name="number" placeholder="Phone Number" class="box" value="{{ old('number') }}" required>
        @error('number')<span class="error">{{ $message }}</span>@enderror

        <input type="email" name="email" placeholder="Email Address" class="box" value="{{ old('email') }}" required>
        @error('email')<span class="error">{{ $message }}</span>@enderror

        <textarea name="message" placeholder="Your Message" cols="30" rows="10" class="box" required>{{ old('message') }}</textarea>
        @error('message')<span class="error">{{ $message }}</span>@enderror

        <input type="submit" value="Send Message" class="btn">
    </form>
</section>
</x-app-layout>