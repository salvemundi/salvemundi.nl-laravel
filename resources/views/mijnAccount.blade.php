@extends('layouts.app')

@section('content')
<div class="overlap">
<h2>Mijn account</h2>


<p><b>Naam:</b> {{ $user[0]->FirstName }} </p>
<p><b>Achternaam:</b> {{ $user[0]->LastName }} </p>
<p><b>Email:</b> {{ $user[0]->email }} </p>
<p><b>Telefoonnummer:</b> {{ $user[0]->PhoneNumber }} </p>
{!! '<img class="pfPhoto" src="storage/'.$user[0]->ImgPath.'" />' !!}
</div>
@endsection
