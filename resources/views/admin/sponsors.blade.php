@extends('layouts.appmin')
@section('title', 'Admin | Partners – ' . config('app.name'))
@section('content')
    <script>
        function CopyMe(oFileInput, sTargetID) {
            document.getElementById(sTargetID).value = oFileInput.value;
        }
    </script>
    <div class="row widthFix adminOverlap center removeAutoMargin">
        @if (session()->has('information'))
            <div class="alert alert-primary">
                {{ session()->get('information') }}
            </div>
        @endif
        <div class="col-auto col-md-6 col-sm-8">
            <div class="table-responsive">
                <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
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
                                <td data-value="{{ $sponsor->name }}">{{ $sponsor->name }}</td>
                                <td data-value="{{ $sponsor->reference }}">{{ $sponsor->reference }}</td>
                                <td data-value="{{ $sponsor->imagePath }}">{{ $sponsor->imagePath }}</td>
                                <td data-value="{{ $sponsor->id }}">
                                    <form method="post" action="/admin/sponsors/delete">@csrf<input type="hidden"
                                            name="id" id="id" value="{{ $sponsor->id }}"><button type="submit"
                                            class="btn btn-danger">Verwijderen</button></form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row widthFix adminOverlap center removeAutoMargin">
        <div id="contact" class="col-auto col-md-4 col-sm-8">
            @if (session()->has('message'))
                <div class="alert alert-primary">
                    {{ session()->get('message') }}
                </div>
            @endif
            <form action="/admin/sponsors/add/store" method="post" enctype="multipart/form-data">
                @csrf
                <br>
                <h2 class="h2">Partner toevoegen</h2>

                <div class="form-group">
                    <label for="name">Naam*</label>
                    <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}"
                        type="text" id="name" name="name" placeholder="Naam...">
                </div>

                <div class="form-group">
                    <label for="reference">Referentie / Website*</label>
                    <input class="form-control{{ $errors->has('reference') ? ' is-invalid' : '' }}"
                        value="{{ old('reference') }}" type="text" id="reference" name="reference"
                        placeholder="Referentie / Website...">
                </div>

                <label for="photo">Foto*</label>
                <div class="input-group mb-3 test">
                    <div class="input-group-prepend">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Upload sponsor foto</label>
                            <input class="form-control" type="file" id="photo" name="photo">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <input class="btn btn-primary py-3" type="submit" value="Toevoegen">
                </div>
            </form>
        </div>
    </div>
@endsection
