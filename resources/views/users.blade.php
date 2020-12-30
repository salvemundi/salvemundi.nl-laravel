@extends('layouts.app')

@section('content')
<div class="overlap">
    @foreach ($groupsBestuur as $groupBestuur)
    <div class="card group mb-5" id="{{$groupBestuur->groupName}}">
        <div class="row">
            <div class="col-md-10 pl-4">
                <h4 class="card-title">{{$groupBestuur->groupName}}</h4>
                <p class="card-text">{{$groupBestuur->Description}}</p>
                <p class="card-text">E-mail: <a href="mailto:{{$groupBestuur->email}}">{{$groupBestuur->email}}</a></p>
            </div>
        </div>
    </div>
    <br>
    @foreach ($membersBestuur as $users)
    <div class="card mb-3">
        <div class="row">
            <div class="col-md-4">
                {!! '<img class="pfPhoto" src="storage/'.$users->Image.'" />' !!}
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
    @endforeach
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
    @foreach ($getCommissieMembers as $users)
        @if ($users->groupID == $group->id)
            <div class="card mb-3">
                <div class="row">
                    <div class="col-md-4">
                        {!! '<img class="pfPhoto" src="storage/'.$users->Image.'" />' !!}
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
    @endforeach
</div>
@endsection
