@extends('layouts.appmin')
@section('content')
<script>
    function CopyMe(oFileInput, sTargetID) {
        document.getElementById(sTargetID).value = oFileInput.value;
    }
</script>
<div class="row widthFix adminOverlap center removeAutoMargin">
    @if(session()->has('information'))
    <div class="alert alert-primary">
        {{ session()->get('information') }}
    </div>
    @endif
    <div class="col-auto col-md-10 col-sm-8">
        <div class="table-responsive">
            <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
                data-show-columns="true">
                <thead>
                    <tr class="tr-class-1">
                        <th data-field="transactie ID" data-sortable="true">Transactie ID</th>
                        <th data-field="paymentStatus" data-sortable="true">PaymentStatus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                            <td data-value="{{ $transaction->transactionId }}">{{$transaction->transactionId}}</td>
                            <td data-value="{{ $transaction->paymentStatus }}">{{ App\Enums\paymentStatus::fromvalue($transaction->paymentStatus)->key }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
