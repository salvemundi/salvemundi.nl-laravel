@extends('layouts.app')

@section('content')
<div class="overlap grid">

@foreach ($getCommissieMembers as $users)
<div class="card">
    <div class="row">
            @if($users != null)
                <div class="col-md-4">
                        {!! '<img class="pfPhoto" src="storage/'.$users->Image.'" />' !!}
                </div>
            @else
                <img class="pfPhoto" src="images/SalveMundiLogo.png"/>
            @endif
                <div class="col-md-4">
                    <br>
                    <br>
                    <br>
                    <h4 class="card-title">{{ $users->DisplayName }}</h4>
                    <p class="card-text">{{ $users->email }}</p>
                </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
