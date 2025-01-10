
<x-app-layout>   

    <div class="heading">
        <h3>Contactez-nous</h3>
        <p><a href="{{ url('/') }}">Accueil</a> / Contact</p>
    </div>

    <section class="contact">
        @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <form action="{{ route('contact') }}" method="POST">
            @csrf
            <h3>Entrons en contact !</h3>
            <input type="text" name="name" placeholder="Nom complet" class="box" value="{{ old('name') }}" required>
            @error('name')<span class="error">{{ $message }}</span>@enderror

            <input type="text" name="number" placeholder="Numéro de téléphone" class="box" value="{{ old('number') }}" required>
            @error('number')<span class="error">{{ $message }}</span>@enderror

            <input type="email" name="email" placeholder="Adresse e-mail" class="box" value="{{ old('email') }}" required>
            @error('email')<span class="error">{{ $message }}</span>@enderror

            <textarea name="message" placeholder="Votre message" cols="30" rows="10" class="box" required>{{ old('message') }}</textarea>
            @error('message')<span class="error">{{ $message }}</span>@enderror

            <input type="submit" value="Envoyer le message" class="btn">
        </form>
    </section>
</x-app-layout>
