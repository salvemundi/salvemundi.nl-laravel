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
                            <th data-field="firstName" data-sortable="true">Naam</th>
                            <th data-field="lastName" data-sortable="true">Referentie</th>
                            <th data-field="email" data-sortable="true">Foto pad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sponsors as $sponsor)
                                <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                    <td data-value="{{ $sponsor->name }}">{{$sponsor->name}}</td>
                                    <td data-value="{{ $sponsor->reference }}">{{$sponsor->reference}}</td>
                                    <td data-value="{{ $sponsor->imagePath }}">{{$sponsor->imagePath}}</td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
