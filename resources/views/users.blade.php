@extends('layouts.app')

@section('content')
<div class="overlap">
    <div class="card">
        <div class="row">
            @foreach ($user as $users)
            <div class="col-md-4">
                <img src="/images/headerLogoSamu.jpg" class="w-100">
            </div>
            <div class="col-md-4">
                <div class="card-block">
                    <h4 class="card-title">{{$users->getDisplayName() }}</h4>
                    <p class="card-text">{{$users->getDisplayName() }}</p>
                    <p class="card-text">{{$users->getDisplayName() }}</p>
                </div>
            </div>

            {{-- <img src="data:images/jpeg;base64,{{\O365\Profile::photo()}}"/> --}}
            @endforeach
        </div>
    </div>
</div>
@endsection