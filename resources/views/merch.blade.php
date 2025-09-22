@extends('layouts.app')
@section('title', 'Webshop – ' . config('app.name'))
@section('content')
    <script src="js/scrollonload.js"></script>
    <link href="{{ mix('css/merch.css') }}" rel="stylesheet">
    <div class="overlap">
        @include('include.messageStatus')
        <h1 class="center">Webshop</h1>
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 text-center py-5">
                    <h2 class="display-4">Merchandise is momenteel niet beschikbaar</h2>
                    <p class="lead">We zijn bezig met het ontwikkelen van nieuwe en spannende producten. Kom later terug voor updates!</p>
                </div>
            </div>
        </div>
    </div>
@endsection
