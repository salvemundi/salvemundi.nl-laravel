{{--
<div id="TopNavbar">
    <a href="#home">Home</a>
    <a href="#news">News</a>
    <a href="#contact">Contact</a>
</div>
--}}

<nav id="TopNavbar" class="navbarAdmin navbar-expand-md shadow-sm">
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
                    <a class="nav-link" href="/admin/leden">Leden</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/intro">intro inschrijvingen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/transactie">Transactie lijst</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/activiteiten">Activiteiten</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/nieuws">Nieuws</a>
                </li>
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                @if(session('userName') != null)
                    <li class="nav-item">
                        <a class="nav-link" href="/signout">{{ __('Uitloggen') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/mijnAccount">Mijn account</a>
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
