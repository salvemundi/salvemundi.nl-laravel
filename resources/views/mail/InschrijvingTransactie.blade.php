@component('mail::message')
    @if ($insertion != '')
        <h1> Hallo {{ $firstName }} {{ $insertion }} {{ $lastName }},</h1>
        <hr>
    @else
        <h1> Hallo {{ $firstName }} {{ $lastName }},</h1>
        <hr>
    @endif

    Bedankt voor het inschrijven!
    Voltooi je inschrijving door te betalen via deze link:
    {{ $paymentLink }}
    <br>

    Veel liefs,<br>
    De Intro-commissie van Salve Mundi<br>
@endcomponent
