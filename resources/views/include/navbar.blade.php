{{--
<div id="TopNavbar">
    <a href="#home">Home</a>
    <a href="#news">News</a>
    <a href="#contact">Contact</a>
</div>
--}}

<nav id="TopNavbar" class="navbar navbar-expand-md shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
        {{ config('app.name', 'Laravel') }}
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
                    <button href="/users" class="dropbtn">Commissies &nbsp;<i class="fa fa-sort-down"></i></button>
                    <div class="dropdown-content">
                      <a href="#">ICT-commissie</a>
                      <a href="#">Studie-commissie</a>
                      <a href="#">Activiteiten-commissie</a>
                      <a href="#">Media-commissie</a>
                      <a href="#">Feest-commissie</a>
                      <a href="#">Kamp-commissie</a>
                      <a href="#">Kas-commissie</a>
                    </div>
                </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/intro">Intro</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/inschrijven">Inschrijven</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href>Merch</a>
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
<img class="navImg" src="/images/headerLogoSamu.jpg">
