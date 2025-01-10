<x-app-layout>   

    <section class="home-about">
        <div class="flex">
            <div class="imgBx">
                <img src="{{ asset('img/about-img.jpeg') }}" alt="À propos de nous">
            </div>
            <div class="content">
                <h3>Pourquoi nous choisir ?</h3>
                <p>
                    <span>PLANT<span>ANEUSE</span></span> -Révélez la beauté de la nature et donnez vie à votre espace avec élégance.
                </p>
                <a href="{{ route('contact') }}" class="white-btn">Contactez-nous</a> <!-- Utilisation de route() -->
            </div>
        </div>
    </section>

    <!-- Section Équipe -->
    <section class="authors">
        <h1 class="title">Notre équipe</h1>
        <div class="box-container">
            @foreach($teamMembers as $member)
            <div class="box">
                <img src="{{ asset('img/' . $member['image']) }}" alt="{{ $member['name'] }}">
                <div class="share">
                    @if(!empty($member['facebook']))
                        <a href="{{ $member['facebook'] }}" class="fab fa-facebook-f"></a>
                    @endif
                    @if(!empty($member['linkedin']))
                        <a href="{{ $member['linkedin'] }}" class="fab fa-linkedin"></a>
                    @endif
                    @if(!empty($member['github']))
                        <a href="{{ $member['github'] }}" class="fab fa-github"></a>
                    @endif
                    @if(!empty($member['instagram']))
                        <a href="{{ $member['instagram'] }}" class="fab fa-instagram"></a>
                    @endif
                </div>
                <h3>{{ $member['name'] }}</h3>
            </div>
            @endforeach
        </div>
    </section>
</x-app-layout>
