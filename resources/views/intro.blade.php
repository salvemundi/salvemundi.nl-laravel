@extends('layouts.app')

@section('content')

<script src="js/scrollonload.js"></script>
<div class="overlap">
    <div class="row center">
        @if($introSetting->settingValue == 0)
            <script>window.location = "/";</script>
        @else
            <div id="contact" class="col-md-9">
                @if(session()->has('message'))
                <div class="alert alert-primary">
                    {{ session()->get('message') }}
                </div>
                @endif

                @if($message ?? '' != null)
                    <div class="alert alert-primary">
                        {{ $message ?? '' }}
                    </div>
                @endif
                <form action="/introData/store" method="post">
                    @csrf
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <h2 class="h2">Salve Mundi Introductie</h2>

                            <p>
                                Salvemundi organiseert jaarlijks een introductieweek: De FHICT-introductie. Het is een week vol avontuur en teambuilding in Eindhoven. Zo leer je ook de stad beter kennen. Salve Mundi is druk bezig geweest om dit allemaal mogelijk te maken voor de nieuwe studenten. Er wordt rekening gehouden met verschillende scenario's en daarom is de kans dat de introductie dit jaar door gaat extra groot! De introductie vindt plaats van maandag 23 augustus tot en met vrijdag 27 augustus. Houd na het inschrijven je mail in de gaten voor updates, je zult later namelijk een mail ontvangen met daarin de betalings details en aanvullende informatie!
                            </p>
                            <p>
                                De introductie duurt 5 dagen. Vanuit de slaaplocatie worden tijdens de introductie touringcars ingezet om alle studenten bij de evenementen te krijgen. Slapen zal gebeuren in slaapzalen en legertenten. Naast het slapen, is er een grote evenementenzaal met bar waar zowel alcohol (18+) als frisdrank verkocht zal worden door middel van consumptiebonnen. De locatie bevindt zich bij een bosrand en een mooi open veld. Genoeg ruimte voor activiteiten dus!
                            </p>
                            <p>
                                Voor overige vragen neem per mail contact op met de intro commissie: <a  href="mailto:intro@salvemundi.nl">intro@salvemundi.nl</a>
                            </p>
                        </div>
                        <div class="col-md-6 mt-5">
                            <div class="imgSlider introSlider"  data-slick='{"slidesToShow": 1, "slidesToScroll": 1}'>
                                <div>
                                    <img class="imgIndex" src="images/intro/Picture1.jpg">
                                </div>
                                <div>
                                    <img class="imgIndex" src="images/intro/Picture2.jpg">
                                </div>
                                <div>
                                    <img class="imgIndex" src="images/intro/Picture3.jpg">
                                </div>
                                <div>
                                    <img class="imgIndex" src="images/intro/Picture4.jpg">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>

                    <div class="col-md-10">
                        <h2 class="h2">Aanmelden voor de intro</h2>
                        <br>
                        <label for="voornaam">Voornaam*</label>
                        <input class="form-control{{ $errors->has('firstName') ? ' is-invalid' : '' }}" value="{{ old('firstName') }}" type="text" id="firstName" name="firstName" placeholder="Voornaam...">

                        <br>
                        <label for="Tussenvoegsel">Tussenvoegsel</label>
                        <input class="form-control{{ $errors->has('insertion') ? ' is-invalid' : '' }}" value="{{ old('insertion') }}" type="text" id="insertion" name="insertion" placeholder="Tussenvoegsel...">

                        <br>
                        <label for="Achternaam">Achternaam*</label>
                        <input class="form-control{{ $errors->has('lastName') ? ' is-invalid' : '' }}" value="{{ old('lastName') }}" type="text" id="lastName" name="lastName" placeholder="Achternaam...">

                        <br>
                        <label for="Email">E-mail*</label>
                        <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" type="email" id="email" name="email" placeholder="E-mail...">

                        <br>
                        <input class="btn btn-primary" type="submit" value="Versturen">
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
