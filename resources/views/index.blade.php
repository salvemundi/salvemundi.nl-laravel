@extends('layouts.app')

@section('content')
@if(session('userName'))
<div class="overlap">
    <h4>Welcome <b>{{ session('userName') }}!</h4></b>
    <h4>Welcome <b>{{ session('userName') }}!</h4></b>

    <h4>Welcome <b>{{ session('userName') }}!</h4></b>

    <h4>Welcome <b>{{ session('userName') }}!</h4></b>

    <h4>Welcome <b>{{ session('userName') }}!</h4></b>

    <h4>Welcome <b>{{ session('userName') }}!</h4></b>

    <h4>Welcome <b>{{ session('userName') }}!</h4></b>
    <h4>Welcome <b>{{ session('userName') }}!</h4></b>

    <h4>Welcome <b>{{ session('userName') }}!</h4></b>
    <h4>Welcome <b>{{ session('userName') }}!</h4></b>
    <h4>Welcome <b>{{ session('userName') }}!</h4></b>
    <h4>Welcome <b>{{ session('userName') }}!</h4></b>
    <h4>Welcome <b>{{ session('userName') }}!</h4></b>
    <h4>Welcome <b>{{ session('userName') }}!</h4></b>
    <h4>Welcome <b>{{ session('userName') }}!</h4></b>
</div>
@else
<div class="overlap">
    <h4>Log in or get yeeted.</h4>
    <h4>Log in or get yeeted.</h4>
    <h4>Log in or get yeeted.</h4>
    <h4>Log in or get yeeted.</h4>
    <h4>Log in or get yeeted.</h4>
    <h4>Log in or get yeeted.</h4>
    <h4>Log in or get yeeted.</h4>
    <h4>Log in or get yeeted.</h4>
    <h4>Log in or get yeeted.</h4>
    <h4>Log in or get yeeted.</h4>
    <h4>Log in or get yeeted.</h4>
    <h4>Log in or get yeeted.</h4>
    <h4>Log in or get yeeted.</h4>
    <h4>Log in or get yeeted.</h4>
    <h4>Log in or get yeeted.</h4>
    <h4>Log in or get yeeted.</h4>
    <h4>Log in or get yeeted.</h4>
    <h4>Log in or get yeeted.</h4>
</div>
@endif
@endsection
