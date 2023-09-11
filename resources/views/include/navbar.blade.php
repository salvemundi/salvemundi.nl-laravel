<nav id="TopNavbar" class="navbar navbar-expand-md">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img class="imgNavbar" src="{{ asset('/images/logo.svg') }}" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <i id="hamburgerMenu" class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse showCom" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav justify-content-lg-start">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                @if (session('id') === null)
                    <li class="nav-item">
                        <a class="nav-link" href="/commissies">Commissies</a>
                    </li>
                @endif
                @if($introSetting->settingValue === 1)
                    <li class="nav-item">
                        <a class="nav-link" href="/activiteiten">Activiteiten</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="/clubs">Clubs</a>
                </li>
                @if (session('id') !== null)
                    <li class="nav-item">
                        <a class="nav-link" href="/financien">Financiën</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="/bijbaanbank">Bijbanen bank</a>
                </li>
                </li>
                    <a class="nav-link" href="/inschrijven"><b>Word lid</b></a>
                </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav w-50 d-flex justify-content-end">
                <!-- Authentication Links -->
                @guest
                    @if(session('userName') !== null)
                        <li class="nav-item">
                            <a class="nav-link" href="/mijnAccount">Mijn account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/signout">{{ __('Uitloggen') }}</a>
                        </li>
                        <div class="btn-group">
                            <button type="button" href="/mijnAccount" class="btn btn-primary">Mijn account</button>
                            <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu">
                                <a class="nav-link" href="/signout">{{ __('Uitloggen') }}</a>
                            </div>
                        </div>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="/signin">{{ __('Inloggen') }}</a>
                        </li>
                    @endif
                    
                @endguest
            </ul>
        </div>
    </div>
</nav>
{{-- <img class="navImg" src="/images/headerLogoSamu.jpg"> --}}
<div class="overlayVideo">
    <video class="navImg" autoplay muted loop disablePictureInPicture id="vid">
        <source src="{{asset('/images/Intro2019.mp4')}}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>
