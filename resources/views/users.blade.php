@extends('layouts.app')

@section('content')
<div class="overlap">

    <div class="card group mb-5" id="{{$groupsBestuur->DisplayName}}">
        <div class="row">
            <div class="col-md-10 pl-4">
                <h4 class="card-title">{{$groupsBestuur->DisplayName}}</h4>
                <p class="card-text">{{$groupsBestuur->Description}}</p>
                <p class="card-text">E-mail: <a href="mailto:{{$groupsBestuur->email}}">{{$groupsBestuur->email}}</a></p>
            </div>
        </div>
    </div>
    <br>
    @foreach ($groupsBestuur->users as $users)
        @if ($users->visibility == 1)
            <div class="card mb-3 user">
                <div class="row">
                    <div class="col-md-4">
                        {!! '<img class="pfPhoto" src="storage/'.$users->ImgPath.'" />' !!}
                    </div>
                    <div class="col-md-4">
                        <br>
                        <br>
                        <br>
                        <h4 class="card-title">{{ $users->DisplayName }}</h4>
                        <p class="card-text">{{ $users->email }}</p>
                    </div>
                </div>
            </div>
        @endif
    @endforeach



    @foreach ($groups as $group)
            <div class="card group mb-5" id="{{$group->DisplayName}}">
                <div class="row">
                    <div class="col-md-10 pl-4">
                        <h4 class="card-title">{{$group->DisplayName}}</h4>
                        <p class="card-text">{{$group->Description}}</p>
                        <p class="card-text">E-mail: <a href="mailto:{{$group->email}}">{{$group->email}}</a></p>
                    </div>
                </div>
            </div>
        @foreach ($group->users as $user)
            @if ($user->visibility == 1)
                <div class="card mb-3 user">
                    <div class="row">
                        <div class="col-md-4">
                            {!! '<img class="pfPhoto" src="storage/'.$user->ImgPath.'" />' !!}
                        </div>
                        <div class="col-md-4">
                            <br>
                            <br>
                            <br>
                            <h4 class="card-title">{{ $user->DisplayName }}</h4>
                            <p class="card-text">{{ $user->email }}</p>

                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endforeach
</div>
@endsection
