@component('mail::message')
@if($insertion != "")
    <h1> Beste {{ htmlspecialchars($firstName) }} {{ htmlspecialchars($insertion) }} {{ htmlspecialchars($lastName) }},</h1><hr>
@else
    <h1> Beste {{ htmlspecialchars($firstName) }} {{ htmlspecialchars($lastName) }},</h1><hr>
@endif

Vanuit de studievereniging hebben we met Microsoft geregeld dat iedereen een Office 365 account krijgt.
Deze gaan we ook gebruiken voor de ALV.
Zorg er vast voor dat je een nieuw wachtwoord hebt ingesteld.

Dit zijn je inlog gegevens voor je Salve Mundi Office 365 account:

Account: nou succes quint
Wachtwoord: hier ook succes

Je kunt inloggen op https://www.office.com/ of op de sharepoint https://salvemundi.sharepoint.com/

Let op, als je automatisch op je fontys email wordt ingelogd kun je het beste even een incognito venster aanmaken.

Groetjes,
het ICT-Commissie
@endcomponent
