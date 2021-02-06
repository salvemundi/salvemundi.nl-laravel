<nav id="TopNavbar" class="navbar navbar-expand-md ">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
        <img class="imgNavbar" src="{{ asset('/images/logo.svg') }}">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <i id="hamburgerMenu" class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <div class="dropdown">
                    <button onclick="myFunction()" class="dropbtn">Commissies &nbsp;<i class="fa fa-sort-down"></i></button>
                    <div id="dropdown" class="dropdown-content">
                        <a class="dropdownText" href="/commissies#Bestuur">Bestuur</a>
                        @foreach ($Commissies as $commissie)
                            @if (str_contains($commissie->DisplayName, 'commissie'))
                                <a class="dropdownText" href="/commissies#{{$commissie->DisplayName}}">{{$commissie->DisplayName}}</a>
                            @endif
                        @endforeach
                    </div>
                </div>
                </li>
                @if (session('id') == null)
                    <li class="nav-item">
                        <a class="nav-link" href="/inschrijven">Inschrijven</a>
                    </li>
                @endif
                @if($introSetting->settingValue  == 1)
                    <li class="nav-item">
                        <a class="nav-link" href="/intro">Intro</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="/activiteiten">Activiteiten</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/nieuws">Nieuws</a>
                </li>
                @if (session('id') != null)
                <li class="nav-item">
                    <a class="nav-link" href="/financien">Financiën</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="/merch">Merch</a>
                </li>
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                @if(session('userName') != null)
                    <li class="nav-item">
                        <a class="nav-link" href="/mijnAccount">Mijn account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/signout">{{ __('Uitloggen') }}</a>
                    </li>
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
