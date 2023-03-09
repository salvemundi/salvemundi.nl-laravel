@extends('layouts.app')

@section('content')
    <div class="overlap">
        <div class="row center">
            <h1 class="center">Waar moet de prullenbak zak gelaten worden??</h1>
            <video controls>
                <source src="{{asset('/images/prullenbak.mp4')}}" type="video/mp4">
            </video>
        </div>
    </div>
@endsection
