@extends('layouts.app')
@section('content')
    <script src="js/scrollonload.js"></script>
    <div class="overlap">
        <h1 class="center">Voeg de Salve Mundi agenda toe!</h1> <br>
        <h3 class="center">Je kunt dit integreren met bijna elke kalender client, o.a. dus ook google calendar.</h3><br>
        <h3 class="center">Doe dit door in je agenda client een agenda toe te voegen via URL, en voer dan
            https://salvemundi.nl/ical in.</h3>
        <h4 class="center">Waarschuwing: google calendar en enkele andere kalender apps doen er lang over om te
            synchroniseren, hier kunnen wij niks aan
            doen ;-;</h4>
        @include('include.calendar', ['activities' => $activities])
    </div>
@endsection
