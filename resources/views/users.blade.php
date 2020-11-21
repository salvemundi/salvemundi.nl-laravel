@extends('layouts.app')

@section('content')
<div class="overlap">
@foreach ($user as $users)
<div class="card" style="width: 18rem;">
    <img class="card-img-left" src='src="data:images/jpeg;base64' alt="Card image cap">
    <div class="card-body">
      <h5 class="card-title">{{$users->getDisplayName() }}</h5>
      <div class="float-right">
      <p class="card-text-right">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
      </div>
    </div>
  </div>
{{-- <img src="data:images/jpeg;base64,{{\O365\Profile::photo()}}"/>  --}}

@endforeach
</div>
@endsection
