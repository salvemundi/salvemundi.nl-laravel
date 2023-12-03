@component('mail::message')
    @if ($insertion != '')
        <h1> Hallo {{ $firstName }} {{ $insertion }} {{ $lastName }},</h1>
        <hr>
    @else
        <h1> Hallo {{ $firstName }} {{ $lastName }},</h1>
        <hr>
    @endif

    @if ($paymentStatus == 0)
        Uw inschijving is niet gelukt.<br>
        U hebt niet betaald.<br>
    @elseif ($paymentStatus == 1)
        Bedankt voor het inschrijven bij de intro van Salve Mundi!<br>
        De betaling is gelukt.<br>
        Het wordt super gezellig!<br>
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
    De Intro-commissie van Salve Mundi<br>
@endcomponent
