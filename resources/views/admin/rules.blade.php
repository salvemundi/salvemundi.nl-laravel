@extends('layouts.appmin')
@section('content')
<div class="row widthFix adminOverlap center">
    @if(session()->has('information'))
    <div class="alert alert-primary">
        {{ session()->get('information') }}
    </div>
    @endif
    <div class="col-md-12 center">

        <div class="table-responsive center centerTable">

            <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
                data-show-columns="true">
                <thead>
                    <tr class="tr-class-1">
                        <th data-field="name" data-sortable="true" data-width="250">naam</th>
                        <th data-field="link" data-sortable="true">Link</th>
                        <th data-field="delete" data-sortable="false">Verwijderen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rules as $rule)
                    <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                        <td data-value="{{ $rule->name }}">{{ $rule->name }}</td>
                        <td data-value="{{ $rule->link }}">{{ $rule->link }}</td>
                        <td data-value="{{ $rule->id }}">
                            <form method="post" action="/admin/rules/delete">@csrf<input type="hidden" name="id"
                                    value="{{ $rule->id }}"><button type="submit"
                                    class="btn btn-danger">Verwijderen</button></form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<div class="row widthFix center adminOverlap mijnSlider">
    <div id="contact" class="col-md-6">
        @if(session()->has('message'))
        <div class="alert alert-primary">
            {{ session()->get('message') }}
        </div>
        @endif
        <form action="/admin/rules/store" method="post">
            @csrf
            <br>
            <h2 class="h2">Regels link toevoegen</h2>

            <div class="form-group">
                <label for="Achternaam">Naam</label>
                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}"
                    id="name" name="name" placeholder="Naam...">
            </div>

            <div class="form-group">
                <label for="voornaam">Link</label>
                <input class="form-control{{ $errors->has('link') ? ' is-invalid' : '' }}" value="{{ old('link') }}"
                    id="link" name="link" placeholder="Link...">
            </div>

            <div class="form-group">
                <br>
                <input class="btn btn-primary" type="submit" value="Toevoegen">
            </div>
        </form>
    </div>
</div>
@endsection
