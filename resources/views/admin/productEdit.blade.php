@extends('layouts.appmin')
@section('content')


<div class="adminOverlap center">
    <div id="contact" class="col-md-6">
        @if(session()->has('message'))
            <div class="alert alert-primary">
                {{ session()->get('message') }}
            </div>
        @endif
        <form action="/admin/products/edit/store" method="post" enctype="multipart/form-data">
            @csrf
            <br>
            <h2 class="h2">Product bewerken</h2>

            <div class="test">
                <br>
                <label for="name">Naam</label>
                <input
                    disabled
                    class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                    value="{{ $product->name }}" type="text" id="name" name="name" placeholder="Naam...">
            </div>

            <div class="test">
                <br>
                <label for="reference">Prijs</label>
                <input
                    class="form-control{{ $errors->has('reference') ? ' is-invalid' : '' }}"
                    value="{{ $product->amount }}" type="number" min="0" step=".01" id="reference" name="reference"
                    placeholder="Prijs">
            </div>

            <div class="test">
                <br>
                <input class="btn btn-primary" type="submit" value="Opslaan">
            </div>
        </form>
    </div>
</div>
@endsection
