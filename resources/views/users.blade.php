@extends('layouts.app')

@section('content')
@foreach ($user as $users)

<p>This is user {{$users->getDisplayName() }}</p>
    
@endforeach

@endsection
