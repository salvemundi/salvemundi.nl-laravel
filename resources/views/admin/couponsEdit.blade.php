@extends('layouts.appmin')
@section('title', 'Admin | Coupons – ' . config('app.name'))
@section('content')
    @if (session()->has('information'))
        <div class="alert alert-primary">
            {{ session()->get('information') }}
        </div>
    @endif
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">

    <div class="row widthFix adminOverlap center removeAutoMargin">
        <div id="contact" class="col-auto col-md-6 col-sm-12">
            @if (session()->has('message'))
                <div class="alert alert-primary">
                    {{ session()->get('message') }}
                </div>
            @endif
            <form action="/admin/coupons/edit/{{ $coupon->id }}" method="post">
                @csrf
                <br>
                <input type="hidden" value="{{ $coupon->id }}" name="id" id="id">
                <h2 class="h2">Coupon {{ $coupon->name }} bewerken</h2>
                <p>Als de prijs 0.00 is dan wordt de activiteit als gratis geregistreerd.</p>

                <h2 class="h2">Coupon toevoegen</h2>

                <div class="form-group">
                    <label for="name">Coupon naam*</label>
                    <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $coupon->name }}"
                        id="name" name="name" placeholder="Naam...">
                </div>

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Beschrijving</label>
                    <textarea type="textarea" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description"
                        placeholder="Beschrijving...">{{ $coupon->description }}</textarea>
                </div>

                <div class="form-group">
                    <label for="Achternaam">Korting in euros*</label>
                    <input type="number" min="1" step=".01"
                        class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{ $coupon->value }}"
                        id="price" name="price" placeholder="Prijs...">
                </div>

                <div class="form-group">
                    <label for="valuta">Valuta*</label>
                    <input value="EUR" class="form-control{{ $errors->has('valuta') ? ' is-invalid' : '' }}"
                        value="{{ $coupon->currency }}" id="valuta" name="valuta" placeholder="Valuta...">
                </div>

                <div class="form-group">
                    <label for="Achternaam">Kan maar een keer gebruikt worden*</label>
                    <select name="isOneTimeUse" class="form-select" aria-label="Default select example">
                        <option value="1">Ja</option>
                        <option value="0">Nee</option>
                    </select>
                </div>

                <div class="form-group py-3">
                    <input class="btn btn-primary" type="submit" value="Bewerken">
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
    <script>
        new MultiSelectTag('tags') // id
    </script>
@endsection
