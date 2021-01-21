@extends('layouts.appmin')
@section('content')

<div class="row center adminOverlap">
    <div id="contact" class="col-md-6">
        @if(session()->has('message'))
        <div class="alert alert-primary">
            {{ session()->get('message') }}
        </div>
        @endif
        <form action="/admin/activities/store" method="post">
            @csrf
            <br>
            <h2 class="h2">Activiteit aanmaken</h2>

            <div class="form-group">
                <label for="voornaam">Activiteit naam</label>
                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" id="name" name="name" placeholder="Naam...">
            </div>

            <div class="form-group">
                <label for="Achternaam">Prijs</label>
                <input type="number" min="0" step=".01" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{ old('price') }}" id="price" name="price" placeholder="Prijs...">
            </div>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">Beschrijving</label>
                <textarea type="textarea" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" placeholder="Beschrijving...">{{{ old('description') }}}</textarea>
            </div>

            <div class="form-group">
                <br>
                <input class="btn btn-primary" type="submit" value="Versturen">
            </div>
        </form>
    </div>
</div>

@endsection
