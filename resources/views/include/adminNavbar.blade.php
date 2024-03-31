{{--
<div id="TopNavbar">
    <a href="#home">Home</a>
    <a href="#news">News</a>
    <a href="#contact">Contact</a>
</div>
--}}

<nav id="TopNavbar" class="navbarAdmin navbar navbar-expand-md shadow-sm">
    <div class="container navAdminWidth">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img class="imgNavbar" src="{{ asset('/images/logo_old.svg') }}">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <i id="hamburgerMenu" class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

                <li class="nav-item">
                    <a class="nav-link" href="/admin">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/leden">Leden</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/groepen">Groepen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/activiteiten">Activiteiten</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/nieuws">Nieuws</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/newsletter">Nieuwsbrief</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/sponsors">Partners</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/socials">Socials</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/products">Producten</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/oud-bestuur">Oud bestuur</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/financien">Financiën</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/rules">Regels</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/bijbaanbank">Bijbanen bank</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/clubs">Clubs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/rechten">Rechten</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/coupons">Coupons</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/merch">Merch</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/calendar">Calendar</a>
                </li>
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav m-lg-auto">
                <!-- Authentication Links -->
                @guest
                    @if (session('userName') != null)
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
