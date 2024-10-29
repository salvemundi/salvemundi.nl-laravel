<nav id="TopNavbar" class="navbar navbar-expand-md">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img class="imgNavbar" src="{{ asset('/images/logo_old.svg') }}" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <i id="hamburgerMenu" class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse showCom" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav justify-content-lg-start">
                <li class="nav-item">
                    <a class="nav-link" href="/commissies">Commissies</a>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="/inschrijven">Inschrijven</a>
                    </li>
                @endguest
                @if ($introSetting->settingValue === 1)
                    <li class="nav-item">
                        <a class="nav-link" href="https://intro.salvemundi.nl/">Intro</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="/activiteiten">Activiteiten</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/nieuws">Nieuws</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/nieuwsbrief">Nieuwsbrief</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="/financien">Financiën</a>
                    </li>
                @endauth
                <li class="nav-item">
                    <a class="nav-link" href="/bijbaanbank">Bijbanen bank</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/clubs">Clubs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/stickers">Stickers</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="/merch">Merch</a>
                    </li>
                @endauth
                <li class="nav-item">
                    <a class="nav-link" href="/kroegentocht">Kroegentocht</a>
                </li>
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav w-50 d-flex justify-content-end">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="/signin">{{ __('Inloggen') }}</a>
                    </li>
                @endguest
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="/mijnAccount">Mijn account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/signout">{{ __('Uitloggen') }}</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
{{-- <img class="navImg" src="/images/headerLogoSamu.jpg"> --}}
<div class="overlayVideo">
    <video class="navImg" autoplay muted playsinline loop disablePictureInPicture id="vid">
        <source src="{{ asset('/images/intro2024.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>
