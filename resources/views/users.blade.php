@extends('layouts.app')

@section('content')
@foreach ($user as $users)

<p>This is user {{ $users->getId() }}</p>


@endforeach

@endsection
