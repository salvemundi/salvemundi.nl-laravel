@extends('layouts.app')

@section('content')

<script src="js/scrollonload.js"></script>
<div class="overlap">
    <div class="row center">
        <div id="contact" class="col-md-6">
            @if(session()->has('message'))
            <div class="alert alert-primary">
                {{ session()->get('message') }}
            </div>
            @endif
            <form action="/inschrijven/store" method="post">
                @csrf
                <br>
                <h2 class="h2">Inschrijven voor Salve Mundi</h2>
                    <br>
                    <label for="voornaam">Voornaam</label>
                    <input class="form-control{{ $errors->has('firstName') ? ' is-invalid' : '' }}" value="{{ old('firstName') }}" type="text" id="firstName" name="firstName" placeholder="Voornaam...">

                    <br>
                    <label for="Tussenvoegsel">Tussenvoegsel</label>
                    <input class="form-control{{ $errors->has('insertion') ? ' is-invalid' : '' }}" value="{{ old('insertion') }}" type="text" id="insertion" name="insertion" placeholder="Tussenvoegsel...">

                    <br>
                    <label for="Achternaam">Achternaam</label>
                    <input class="form-control{{ $errors->has('lastName') ? ' is-invalid' : '' }}" value="{{ old('lastName') }}" type="text" id="lastName" name="lastName" placeholder="Achternaam...">

                    <br>
                    <label for="Geboortedatum">Geboortedatum</label>
                    <input class="form-control{{ $errors->has('birthday') ? ' is-invalid' : '' }}" value="{{ old('birthday') }}" type="date" id="birthday" name="birthday" placeholder="MM-DD-JJJJ...">

                    <br>
                    <label for="Email">E-mail</label>
                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" type="email" id="email" name="email" placeholder="E-mail...">

                    <br>
                    <label for="Telefoonnummer">Telefoonnummer</label>
                    <input class="form-control{{ $errors->has('phoneNumber') ? ' is-invalid' : '' }}" value="{{ old('phoneNumber') }}" type="phoneNumber" id="phoneNumber" name="phoneNumber" placeholder="Telefoonnummer...">

                    {{-- <br>
                    <label for="Coupon">Coupon</label>
                    <input class="form-control{{ $errors->has('coupon') ? ' is-invalid' : '' }}" value="{{ old('coupon') }}" type="text" id="coupon" name="coupon" placeholder="Coupon..."> --}}

                    <br>
                    <input class="btn btn-primary mb-3" type="submit" value="Versturen">
            </form>
        </div>
    </div>
</div>
@endsection
