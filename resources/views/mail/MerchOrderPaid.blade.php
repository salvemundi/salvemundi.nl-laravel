@component('mail::message')
    Beste {{ $user->getDisplayName() }},
    <p>Ontzettend bedankt voor je merch aankoop!</p>
    <p>Je kan je merch ophalen in het Salve Mundi hok op R10.</p>
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
