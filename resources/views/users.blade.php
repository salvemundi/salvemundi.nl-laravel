@extends('layouts.app')

@section('content')
<div class="overlap">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" id="{{ $groupsBestuur->DisplayName }}">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $groupsBestuur->DisplayName }}</h4>
                        <p class="card-text">{{ $groupsBestuur->Description }} <br> E-mail: <a
                                href="mailto:{{ $groupsBestuur->email }}">{{ $groupsBestuur->email }}</a></p>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            @foreach($groupsBestuur->users as $users)
            @if($users->visibility == 1)
            <div class="col-md-6">
                <div class="card">
                    {!! '<img class="pfPhoto" src="storage/'.$users->ImgPath.'" />' !!}
                    <div class="card-body">
                        <p class="card-text">{{ $users->DisplayName }} <br> {{ $users->email }}</p>
                    </div>
                </div>
                <br>
            </div>
            @endif
            @endforeach
        </div>

        <div class="row">
            @foreach($groups as $group)
            <div class="col-md-12" id="{{ $group->DisplayName }}">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $group->DisplayName }}</h4>
                        <p class="card-text">{{ $group->Description }}</p>
                        <p class="card-text">E-mail: <a href="mailto:{{ $group->email }}">{{ $group->email }}</a></p>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            @foreach($group->users as $user)
            @if($user->visibility == 1)
            <div class="col-md-6">
                <div class="card">
                    {!! '<img class="pfPhoto" src="storage/'.$user->ImgPath.'" />' !!}
                    <div class="card-body">
                        <p class="card-text">{{ $user->DisplayName }} <br> {{ $user->email }}</p>
                    </div>
                </div>
                <br>
            </div>
            @endif
            @endforeach
            @endforeach
        </div>
    </div>
</div>
@endsection
