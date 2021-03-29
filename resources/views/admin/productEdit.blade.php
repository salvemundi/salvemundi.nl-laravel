@extends('layouts.appmin')
@section('content')


<div class="adminOverlap center">
    <div id="contact" class="col-md-6">
        @if(session()->has('message'))
            <div class="alert alert-primary">
                {{ session()->get('message') }}
            </div>
        @endif
        <form action="/admin/products/edit/store" method="post">
            @csrf
            <br>
            <h2 class="h2">Product bewerken</h2>
            <input type="hidden" value="{{ $product->id }}" name="id" id="id">
            <div class="test">
                <br>
                <label for="name">Naam</label>
            @if($product->index != null)
                <input
                    readonly="readonly"
                    class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                    value="{{ $product->name }}" type="text" id="name" name="name" placeholder="Naam...">
            @else
            <input
                    class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                    value="{{ $product->name }}" type="text" id="name" name="name" placeholder="Naam...">
            </div>
            @endif
            <div class="test">
                <br>
                <label for="reference">Prijs</label>
                <input
                    class="form-control{{ $errors->has('reference') ? ' is-invalid' : '' }}"
                    value="{{ $product->amount }}" type="number" min="0" step=".01" id="price" name="price"
                    placeholder="Prijs">
            </div>

            <div class="test">
                <br>
                <label for="reference">Redirect (Niet aankomen) :D</label>
                <input
                        class="form-control{{ $errors->has('reference') ? ' is-invalid' : '' }}"
                        value="{{ $product->redirect_url }}" type="text" min="0" step=".01" id="redirect_url" name="redirect_url"
                        placeholder="Redirect url...">
            </div>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">Beschrijving</label>
                <textarea type="textarea" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" placeholder="Beschrijving...">{{{ $product->description }}}</textarea>
            </div>

            <div class="test">
                <br>
                <input class="btn btn-primary" type="submit" value="Opslaan">
            </div>
        </form>
    </div>
</div>
@endsection
