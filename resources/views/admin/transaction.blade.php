@extends('layouts.appmin')
@section('content')

<div class="adminOverlap">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table
                       id="table"
                       data-toggle="table"
                       data-search="true"
                       data-sortable="true"
                       data-pagination="true"
                       data-show-columns="true">
                    <thead>
                        <tr class="tr-class-1">
                            <th data-field="transactie ID" data-sortable="true">transactie ID</th>
                            <th data-field="paymentStatus" data-sortable="true">paymentStatus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                                <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                    <td data-value="{{ $transaction->transactionId }}">{{$transaction->transactionId}}</td>
                                    <td data-value="{{ $transaction->paymentStatus }}">{{$transaction->paymentStatus}}</td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
