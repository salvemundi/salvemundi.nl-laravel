@extends('layouts.appmin')
@section('title', 'Admin | Commissies – ' . config('app.name'))
@section('content')
    <div class="row widthFix adminOverlap center removeAutoMargin">
        <div class="col-auto col-md-10 col-sm-8 mt-5">
            <h2>Commissies / groepen</h2>
            <div class="">
                <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
                    data-show-columns="true">
                    <thead>
                        <tr class="tr-class-1">
                            <th data-field="diplayName" data-sortable="true">Naam</th>
                            <th data-field="email" data-sortable="true">E-mail</th>
                            <th data-field="commissie" data-sortable="true">Rechten</th>
                            <th data-field="leden" data-sortable="true">Leden</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($committees as $committee)
                            <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                <td data-value="{{ $committee->DisplayName }}">{{ $committee->DisplayName }}</td>
                                <td data-value="{{ $committee->email }}">{{ $committee->email }}</td>
                                <td data-value="{{ $committee->id }}">
                                    <form method="get" action="/admin/groepen/{{ $committee->id }}/permissions">
                                        <button type="submit" class="btn btn-primary">Rechten</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="/admin/groepen/{{ $committee->id }}/members" class="btn btn-primary">Leden</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
