@component('mail::message')
    Beste {{ $user->getDisplayName() }},
    <p>Ontzettend bedankt voor je merch pre order!</p>
    @if(!$merch->preOrderNeedsPayment)
    <p>Je ontvangt later een betaalverzoek! Een reminder dat het even kan duren voordat jou bestelling wordt besteld gezien er met quota's word gewerkt. Dit houd in dat er eem minimaal aantal bestellingen moet worden behaald voordat de producten besteld worden.</p>
    @endif
    <p>
        Merch: {{ $merch->name }}<br>
        Maat: {{ $size->size }}<br>
        Pasvorm: {{ $gender->description }}<br>
        Prijs: € {{ $transaction->amount }}<br>
        Notities: {{ $note ?? 'niet opgegeven' }}
    </p>
    <br>
    Met vriendelijke groet,<br><br>
    Salve Mundi<br>
    Rachelsmolen 1<br>
    5612MA, Eindhoven<br>
    info@salvemundi.nl<br>
    +31 6 24827777
@endcomponent
