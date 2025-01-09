<x-app-layout>   

    <section class="home-about">
        <div class="flex">
            <div class="imgBx">
                <img src="{{ asset('img/about-img.jpeg') }}" alt="About Us">
            </div>
            <div class="content">
                <h3>Why choose us?</h3>
                <p>
                    <span>PLANT<span>ANEUSE</span></span> - Where nature meets style. 
                    Uncover our lush collection and let your space bloom with life and charm.
                </p>
                <a href="{{ route('contact') }}" class="white-btn">Contact us</a> <!-- Utilisation de route() -->
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="authors">
    <h1 class="title">Our Team</h1>
    <div class="box-container">
        <?php 
        ?>
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