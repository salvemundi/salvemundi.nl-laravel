@extends('layouts.app')
@section('content')

    <div id="content">
        <div class="overlap" style="z-index: 16;">
            <div class="mijnSlider">
                @if (session()->has('message'))
                    <div class="alert alert-primary">
                        {{ session()->get('message') }}
                    </div>
                @endif

                @if ($message ?? '' != null)
                    <div class="alert alert-primary">
                        {{ $message ?? '' }}
                    </div>
                @endif
                @if (session('userName'))
                    @if ($bday == true)
                        <h4>Gefeliciteerd <b>{{ session('userName') }}!!</h4></b>
                    @else
                        <h4>Welkom <b>{{ session('userName') }}!</h4></b>
                    @endif
                @endif
                <br>
                <h2 class="h2">Over ons</h2> <br>
                <p>Salve Mundi is de studievereniging van Fontys Hogenscholen ICT, opgericht in 2017 door Mohammed Mighiss
                    en Luuk Hendriks. Het is Latijn voor "Hello World", een typische zin die menig programmeur maar al te
                    goed kent.</p>
                <p>De vereniging organiseert veel activiteiten, zowel studiebemiddelend als voor de lol, of een combinatie
                    van de twee. Denk hierbij aan: <br></p>
                <div class="row">
                    <div class="col-md-6">
                        <li>Lezingen</li>
                        <li> Excursies </li>
                        <li> Workshops </li>
                        <li> Bedrijfsbezoeken </li>
                        <li> Elke dinsdag bijlessen </li>
                        <br>
                        <p> Voor de uitgaande studenten:</p>

                        <li> Op stap bij onze stamkroeg Villa Fiësta op Stratumseind </li>
                        <li> Casinoavonden </li>
                        <li> Pubquiz-avonden </li>
                        <li> Willekeurige spontane activiteiten </li>
                        <br>
                        <p> En voor de wat minder uitgaande studenten:</p>
                        <li> Jaarlijks op kamp </li>
                        <li> Game Nights (bordspellen & eSports) </li>
                        <li> Uitjes naar bijvoorbeeld pretparken </li>
                        <br>
                        <p>Naast deze activiteiten verzorgt Salve Mundi ook de introductie van FICT van top tot teen.
                    </div>

                    <div class="col-md-6">
                        <div class="imgSlider" data-slick='{"slidesToShow": 1, "slidesToScroll": 1}'>
                            <div>
                                <img class="imgIndex"
                                    src={{ Thumbnailer::generate('images/SaMuFotos/Intro2023/intro22.jpg', '50%') }}>
                            </div>
                            <div>
                                <img class="imgIndex"
                                    src={{ Thumbnailer::generate('images/SaMuFotos/Intro2023/intro102.jpg', '50%') }}>
                            </div>
                            <div>
                                <img class="imgIndex"
                                    src={{ Thumbnailer::generate('images/SaMuFotos/Intro2023/intro156.jpg', '50%') }}>
                            </div>
                            <div>
                                <img class="imgIndex"
                                    src={{ Thumbnailer::generate('images/SaMuFotos/Intro2023/intro239.jpg', '50%') }}>
                            </div>
                            <div>
                                <img class="imgIndex"
                                    src={{ Thumbnailer::generate('images/SaMuFotos/Intro2023/intro259.jpg', '50%') }}>
                            </div>
                            <div>
                                <img class="imgIndex"
                                    src={{ Thumbnailer::generate('images/SaMuFotos/Intro2023/intro282.jpg', '50%') }}>
                            </div>
                            <div>
                                <img class="imgIndex"
                                    src={{ Thumbnailer::generate('images/SaMuFotos/Intro2023/intro288.jpg', '50%') }}>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($activitiesCount > 0)
                <div class="mijnSlider">
                    <a href="/activiteiten">
                        <h1 class="center groot"><b>Activiteiten</b></h1>
                    </a>
                    <div class="row my-3">
                        @foreach ($activitiesData as $activity)
                            <div class="col-md-4 mt-2">
                                <a class="" href="/activiteiten#{{ $activity->name }}">
                                    <div class="card indexCard" data-toggle="tooltip" data-placement="top"
                                        title="Klik om volledig te lezen!">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $activity->name }}</h5>
                                            <p class="card-text" style="white-space: pre-line">
                                                {{ Str::limit($activity->description, 300) }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @if ($newsCount > 0)
                <div class="mijnSlider">
                    <a href="/nieuws">
                        <h1 class="center groot"><b>Nieuws</b></h1>
                    </a>
                    <div class="row my-3">
                        @foreach ($newsData as $nieuws)
                            <div class="col-md-4 mt-2">
                                <a class="" href="/nieuws#{{ $nieuws->title }}">
                                    <div class="card indexCard" data-toggle="tooltip" data-placement="top"
                                        title="Klik om volledig te lezen!">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $nieuws->title }}</h5>
                                            <p class="card-text" style="white-space: pre-line">
                                                {{ Str::limit($nieuws->content, 300) }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @if ($sponsorsCount > 0)
                <h1 class="center groot"><b>Onze partners</b></h1>
                <div class="slider" data-slick='{"slidesToScroll": 1}'>
                    @foreach ($sponsorsData as $sponsor)
                        <div class="d-flex justify-content-center">
                            <h3><a target="_blank" href="{{ $sponsor->reference }}"><img
                                        class="sponsor img-fluid h-100 w-100 mx-auto"
                                        src="{{ asset('storage/' . $sponsor->imagePath) }}"></a></h3>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    @endsection
