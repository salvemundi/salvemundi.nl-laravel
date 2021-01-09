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
                            <th data-field="firstName" data-sortable="true">Voornaam</th>
                            <th data-field="lastName" data-sortable="true">Achternaam</th>
                            <th data-field="email" data-sortable="true">E-mail</th>
                            <th data-field="paymentStatus" data-sortable="true">Betalings Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($introObjects as $user)
                            <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                <td data-value="{{ $user->firstName }}">{{$user->firstName}}</td>
                                <td data-value="{{ $user->lastName }}">{{$user->lastName}}</td>
                                <td data-value="{{ $user->email }}">{{$user->email}}</td>
                                <td data-value="{{ $user->payment->paymentStatus }}">{{ \App\Enums\paymentStatus::fromValue($user->payment->paymentStatus)->key }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
