@component('mail::message')
@if($insertion != "")
    <h1> Hallo {{ $firstName }} {{ $insertion }} {{ $lastName }},</h1><hr>
@else
    <h1> Hallo {{ $firstName }} {{ $lastName }},</h1><hr>
@endif

@if($paymentStatus == 0)
Uw inschijving is niet gelukt.<br>
U hebt niet betaald.<br>
@elseif ($paymentStatus == 1)

Leuk dat je hebt gekozen om deel te zijn van onze studie vereniging Salve Mundi.
<br>
De betaling is gelukt.<br>
    Je gebruikersnaam voor office is: {{ $firstName.".".$lastName."@lid.salvemundi.nl" }}<br>
    Je wachtwoord is: {{ $pass }}
    hieronder staan de linkjes voor de whatsapp groepen. Die kan je joinen als je wilt. <br>
    @foreach ($whatsappLink as $whatsapp)
        {{$whatsapp->name}}: {{$whatsapp->link}} <br>
    @endforeach <br>
    Als de linkjes niet werken kun je inloggen op de website en onder mijn account de actuele linkjes vinden.
@elseif ($paymentStatus == 3)
Uw inschrijving is niet gelukt.
De betaling is niet gelukt.
@elseif ($paymentStatus == 4)
Uw inschrijving is niet gelukt.
De betaling is geannuleerd.
@elseif ($paymentStatus == 5)
Uw inschrijving is niet gelukt.
De betaling is verlopen.
@endif
<br>

Veel liefs,<br>
Het bestuur van Salve Mundi<br>
@endcomponent
