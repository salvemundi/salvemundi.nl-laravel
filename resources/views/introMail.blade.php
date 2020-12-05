@component('mail::message')
@if($insertion != "")
    <h1> Hallo {{ $firstName }} {{ $insertion }} {{ $lastName }},</h1><hr>
@else
    <h1> Hallo {{ $firstName }} {{ $lastName }},</h1><hr>
@endif

Bedankt voor het inschrijven bij de intro van Salve Mundi!<br>
Het wordt super gezellig!<br>
<br>
Veel liefs,<br>
De Intro-commissie van Salve Mundi<br>
@endcomponent
