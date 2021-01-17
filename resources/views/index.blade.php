@extends('layouts.app')

@section('content')


<div class="overlap">
    @if(session('userName'))

    <h4>Welkom <b>{{ session('userName') }}!</h4></b>

@endif
    <h2 class="h2">Over ons</h2> <br>
    <p>Salve Mundi is de Studievereniging van Fontys Hogenscholen ICT, opgericht in 2017 door Mohammed Mighiss en Luuk Hendriks. Het is Latijn voor "Hello World", een typische zin die menig programmeur maar al te goed kent.</p>
    <p>De vereniging organiseert veel activiteiten, zowel studie bemiddelend als voor de lol, of een combinatie van de twee. Denk hierbij aan: <br></p>

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
    <li> Partnership met een grote hackathon </li>
    <li> Uitjes naar bijvoorbeeld pretparken </li>
    <br>
    <p>Naast deze activiteiten verzorgd Salve Mundi ook de introductie van FHICT van top tot teen.

    <div class="mijnSlider">
        <h1 class="center groot"><b>Onze sponsoren</b></h1>
        <div class="slider" data-slick='{"slidesToShow": 5, "slidesToScroll": 1}'>
            @foreach($sponsorsData as $sponsor)
            <div><h3><img class="sponsor" src="{{ asset("storage/".$sponsor->imagePath) }}"></h3></div>
            @endforeach
        </div>
    </div>
</div>

@endsection
