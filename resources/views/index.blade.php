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


    <div class="slick-bar autoplay">
        <div>Sponsor 1</div>
        <div>sponsor 2</div>
        <div>sponsor 3</div>
        <div>sponsor 4</div>
        <div>sponsor 5</div>
        <div>sponsor 6</div>
        <div>sponsor 7</div>
        <div>sponsor 8</div>
    </div>

      <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
      <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
      <script type="text/javascript" src="slick/slick.min.js"></script>

      <script type="text/javascript">
        $(document).ready(function(){
          $('.slick-bar').slick({
            setting-name: setting-value
          });
        });

        $('.autoplay').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
        });
      </script>
</div>

@endsection
