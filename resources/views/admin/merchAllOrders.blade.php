@extends('layouts.appmin')
@section('title', 'Admin | Merch orders – ' . config('app.name'))

@section('content')

    <script>
        function CopyMe(oFileInput, sTargetID) {
            document.getElementById(sTargetID).value = oFileInput.value;
        }
    </script>
    <div class="row widthFix adminOverlap center removeAutoMargin">
        <div class="col-auto col-md-6 col-sm-8">
            @include('include.messageStatus')
            <a class="btn-primary btn mt-2" href="/admin/merch"><i class="fas fa-arrow-left"></i> Terug</a>
            <div class="table-responsive">
                <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
                    data-show-columns="true">
                    <thead>
                        <tr class="tr-class-1">
                            <th data-field="name" data-sortable="true">Naam</th>
                            <th data-field="merch" data-sortable="true">Merch</th>
                            <th data-field="size" data-sortable="true">Maat</th>
                            <th data-field="gender" data-sortable="true">Pasvorm</th>
                            <th data-field="pickedUp" data-sortable="false">Opgehaald</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allMerch as $merch)
                            @foreach ($merch->userOrders as $order)
                                @if(App\Models\Transaction::find($order->pivot->transaction_id)->paymentStatus == App\Enums\paymentStatus::paid || !$merch->preOrderNeedsPayment)
                                    <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                        <td data-value="{{ $order->getDisplayName() }}">{{ $order->getDisplayName() }}</td>
                                        <td data-value="{{ $merch->name }}">{{ $merch->name }}</td>
                                        <td data-value="{{ $order->merch_size_id }}">
                                            {{ \App\Models\MerchSize::find($order->pivot->merch_size_id)->size }}</td>
                                        <td data-value="{{ $order->pivot->merch_gender }}">
                                            {{ \App\Enums\MerchGender::coerce($order->pivot->merch_gender)->description }}</td>
                                        <td data-value="{{ $order->id }}">
                                            <form method="post" action="/admin/merch/orders/pickedUp/{{ $order->pivot->id }}">
                                                @csrf
                                                @if (!$order->pivot->isPickedUp)
                                                    <button type="submit" class="btn btn-danger"><i
                                                            class="fas fa-times"></i></button>
                                                @else
                                                    <button type="submit" class="btn btn-success"><i
                                                            class="fas fa-check"></i></button>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
