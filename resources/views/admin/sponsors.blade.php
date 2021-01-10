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
                            <th data-field="name" data-sortable="true">Naam</th>
                            <th data-field="reference" data-sortable="true">Referentie</th>
                            <th data-field="imgPath" data-sortable="true">Foto pad</th>
                            <th data-field="delete" data-sortable="false">Verwijderen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sponsors as $sponsor)
                                <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                    <td data-value="{{ $sponsor->name }}">{{$sponsor->name}}</td>
                                    <td data-value="{{ $sponsor->reference }}">{{$sponsor->reference}}</td>
                                    <td data-value="{{ $sponsor->imagePath }}">{{$sponsor->imagePath}}</td>
                                    <td data-value="{{ $sponsor->id }}"><form method="post" action="/admin/sponsors/delete">@csrf<input type="hidden" name="id" id="id" value="{{ $sponsor->id }}"><button type="submit" class="btn btn-danger">Verwijderen</button></form></td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="center">
        <a href="/admin/sponsors/add">
    <input class="btn btn-primary" type="submit" value="Toevoegen">
        </a>
    </div>
</div>
@endsection
