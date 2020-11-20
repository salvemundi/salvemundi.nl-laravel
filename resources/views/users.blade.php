@extends('layouts.app')

@section('content')
@foreach ($user as $users)

<p>This is user {{$users->getDisplayName() }}</p>

{{-- <img src="data:image/jpeg;base64,{{\O365\Profile::photo()}}"/>  --}}

@endforeach

@endsection
