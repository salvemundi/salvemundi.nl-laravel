@extends('layouts.app')

@section('content')
    <script src="js/scrollonload.js"></script>
<div class="overlap">

    <nav class='myAccount'>
        <a href="/admin">
            <i class="fas fa-user-cog"></i>
            <b>Admin</b>
        </a>
        <a href="#">
            <i class="fa fa-credit-card"></i>
            <b>Transacties</b>
        </a>
        <a href="#">
            <i class="fab fa-whatsapp"></i>
            <b>Whatsapp</b>
        </a>
        <a href="#">
            <i class="fas fa-heart"></i>
            <b>Regels</b>
        </a>
        <span></span>
    </nav>

    <!-- <a href="https://www.youtube.com/channel/UC7hSS_eujjZOEQrjsda76gA/videos" target="_blank" id="ytd-url">My YouTube Channel</a> -->

    <h2>Mijn account</h2>

    <p><b>Naam:</b> {{ $user->FirstName }} </p>
    <p><b>Achternaam:</b> {{ $user->LastName }} </p>
    <p><b>Email:</b> {{ $user->email }} </p>
    <p><b>Telefoonnummer:</b> {{ $user->PhoneNumber }} </p>
    {!! '<img class="pfPhoto" src="storage/'.$user->ImgPath.'" />' !!}
</div>
@endsection
