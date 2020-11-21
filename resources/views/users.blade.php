@extends('layouts.app')

@section('content')
<div class="overlap grid">
@foreach ($user as $users)

    <div class="card">
        <div class="row">
            <div class="col-md-4">
                <?php
            echo '<img class="pfPhoto" src="data:'.';base64,'.base64_encode($imgarray[0]).'" />';
            ?>
            </div>
            <div class="col-md-4">
                    <h4 class="card-title">{{$users->getDisplayName() }}</h4>
                    <p class="card-text">{{$users->getDisplayName() }}</p>
                    <p class="card-text">{{$users->getDisplayName() }}</p>
            </div>
            {{-- <img src="data:images/jpeg;base64,{{\O365\Profile::photo()}}"/> --}}
        </div>
    </div>

    @endforeach
</div>
@endsection
