@extends('layouts.appmin')
@section('content')

<div class="adminOverlap center">
    <div id="contact" class="col-md-6">
        @if(session()->has('message'))
            <div class="alert alert-primary">
                {{ session()->get('message') }}
            </div>
        @endif
        <form action="/admin/sponsors/add/store" method="post">
            @csrf
            <br>
            <h2 class="h2">Sponsor toevoegen</h2>

            <div class="test">
                <br>
                <label for="name">Naam</label>
                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" type="text" id="name" name="name" placeholder="Voornaam...">
            </div>

            <div class="test">
                <br>
                <label for="reference">Referentie / Website</label>
                <input class="form-control{{ $errors->has('reference') ? ' is-invalid' : '' }}" value="{{ old('reference') }}" type="text" id="reference" name="reference" placeholder="Tussenvoegsel...">
            </div>

            <div class="test">
                <br>
                <label for="photo">Foto</label>
                <div class="input-group mb-3 test">
                    <div class="input-group-prepend">
                        <span class="input-group-text form-control" id="inputGroupFileAddon01">Browse</span>
                    </div>
                    <div class="custom-file form-control">
                        <input type="file" class="custom-file-input form-control" id="photo" name="photo" aria-describedby="inputGroupFileAddon01">
                    </div>
                </div>
            </div>

            <div class="test">
                <br>
                <input class="btn btn-primary" type="submit" value="Toevoegen">
            </div>
        </form>
    </div>
</div>
@endsection
