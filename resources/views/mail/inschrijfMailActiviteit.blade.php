@component('mail::message')
Beste,

Bedankt voor het inschrijven voor {{ $activity }}!

We hopen je te ontvangen op de aangegeven tijden.

@if($productObject->isGroupSignup)

Join de whatsapp community en join je groepje!
https://chat.whatsapp.com/E6OekecqaE6DHX1JbjuDFa

@endif
Met vriendelijke groet,

Salve Mundi <br>
Rachelsmolen 1 <br>
5612 MA Eindhoven
@endcomponent
