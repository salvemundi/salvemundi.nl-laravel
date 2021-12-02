@extends('layouts.app')
@section('title', 'Introductie – ' . config('app.name'))
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
                                Salve Mundi organiseert jaarlijks een introductieweek: De FHICT-introductie. Het is een week vol avontuur en teambuilding in Eindhoven. Zo leer je ook de stad beter kennen. Salve Mundi is druk bezig geweest om dit allemaal mogelijk te maken voor de nieuwe studenten dit jaar. Omdat er rekening gehouden is met verschillende scenario’s kunnen wij ook nu een leuke introductie voor jullie neerzetten. De introductie vindt plaats van dinsdag 24 augustus tot en met donderdag 26 augustus. De introductie kost 40 euro. Houd na het inschrijven je mail in de gaten voor updates, je zult later namelijk een mail ontvangen met daarin de betalingsdetails en aanvullende informatie!
                            </p>
                            <p>
                                De introductie duurt 3 dagen. Op de locatie is een grote evenementenzaal met bar waar zowel alcohol (18+) als frisdrank verkocht zal worden door middel van consumptiebonnen. De locatie bevindt zich bij een bosrand en een mooi open veld. Genoeg ruimte voor activiteiten dus!
                            </p>
                            <h4>
                                Wat hebben wij nu voor jullie georganiseerd?
                            </h4>
                            <p>
                                Op dinsdag hebben wij een dag voor jullie gepland met spellen, een pub quiz en levend stratego. ’s Avonds zal er nog een afterparty gegeven worden.
                            </p>
                            <p>
                                Op woensdag is de Fontys dag. Je wordt om 10:00 verwacht op de Fontys Rachelsmolen. ’s Middags hebben wij weer een middagprogramma voor jullie met daarin bijvoorbeeld de crazy88. ’s Avonds is er weer een vet feest voor jullie.
                            </p>
                            <p>
                                Op donderdag hebben we weer een middagprogramma voor jullie met daarin bijvoorbeeld zeepvoetbal en het moordspel. In de namiddag is er een waterpongtoernooi voor jullie. ’s Avonds hebben we weer een vet feest voor jullie gepland.
                            </p>
                            <p>
                                Lunch en avondeten wordt door ons geregeld op alle drie de dagen.
                            </p>
                            <p>
                                Wij hopen jullie allemaal eind augustus te zien! Tot dan!
                            </p>
                            <p>
                                Voor overige vragen neem per mail contact op met de intro commissie: <a  href="mailto:intro@salvemundi.nl">intro@salvemundi.nl</a>
                            </p>
                            <p>
                                Voor overige vragen neem per mail of whatsapp contact op met de intro commissie: <a  href="mailto:intro@salvemundi.nl">intro@salvemundi.nl</a> of <a href="tel:+31 6 24827777">+31 6 24827777</a>
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

                        <div class="">
                            <input type="radio" id="customRadio1" value="{{App\Enums\IntroStudentYear::FirstYear()}}" name="introYear" checked class="form-check-input">
                            <label class="custom-control-label" for="customRadio1">Ik ben aankomend student</label>
                        </div>
                        <div class="">
                            <input type="radio" id="customRadio2" value="{{App\Enums\IntroStudentYear::SecondYear()}}" name="introYear" class="form-check-input">
                            <label class="custom-control-label" for="customRadio2">Ik ben al student</label>
                        </div>

                        <br>
                        <input class="btn btn-primary" type="submit" value="Versturen">
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
