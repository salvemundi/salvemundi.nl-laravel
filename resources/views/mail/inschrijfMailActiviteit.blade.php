@component('mail::message')

Beste,

Bedankt voor het inschrijven voor {{ $activity }}!

We hopen je te ontvangen op de aangegeven tijden.

@if($productObject->formsLink ! null)
Verder is er meer informatie nodig voor de activiteit.
Graag verzoeken wij jou dit formulier in te vullen.
{{ $productObject->formslink }}

Alvast bedankt!
@endif

Met vriendelijke groet,

Salve Mundi
RachelsMolen 1
5612 MA Eindhoven
@endcomponent
