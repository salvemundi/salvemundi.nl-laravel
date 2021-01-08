@extends('layouts.appmin')
@section('content')
<div class="adminOverlap">
    <div class="row">
        <div class="col-md-3">
            <div class="stati wisteria ">
                <div><p>Aantal Leden</p></div>
                <i style="display: flex" class="fas fa-users"> <p class="dashboard-font">{{ $userCount }}</p></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stati wisteria ">
                <div><p>Aantal intro inschrijvingen</p></div>
                <i style="display: flex" class="fas fa-list"> <p class="dashboard-font">{{ $introCount }}</p> </i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stati wisteria ">
                <div><p>Aantal Leden</p></div>
                <i style="display: flex" class="fas fa-users"> <p class="dashboard-font">324</p> </i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stati wisteria ">
                <div><p>Aantal Leden</p></div>
                <i style="display: flex" class="fas fa-users"> <p class="dashboard-font">324</p> </i>
            </div>
        </div>
    </div>
</div>
@endsection
