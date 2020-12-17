@extends('layouts.app')

@section('content')
<div class="overlap grid">
    @foreach ($groupsBestuur as $groupBestuur)
    <div class="card">
        <div class="row">
            <div class="col-md-4">
                <h4 class="card-title">{{$groupBestuur->groupName}}</h4>
                <p class="card-text">{{$groupBestuur->Description}}</p>
            </div>
        </div>
    </div>
    <br>
    @foreach ($membersBestuur as $users)
    <div class="card">
        <div class="row">
            <div class="col-md-4">
                {!! '<img class="pfPhoto" src="storage/'.$users->Image.'" />' !!}
            </div>
            <div class="col-md-4">
                {{-- <br>
                <br>
                <br> --}}
                <h4 class="card-title">{{ $users->DisplayName }}</h4>
                <p class="card-text">{{ $users->email }}</p>
            </div>
        </div>
    </div>
    @endforeach
    @endforeach

    @foreach ($groups as $group)
    <div class="card">
        <div class="row">
            <div class="col-md-12">
                <div class="card-block">
                    <div class="card-header">
                        <h4 class="card-title">{{$group->DisplayName}}</h4>
                    </div>
                </div>
                <p class="card-text">{{$group->Description}}</p>
            </div>
        </div>
    </div>
    @foreach ($getCommissieMembers as $users)
    @if ($users->groupID == $group->id)
    <div class="card">
        <div class="row">
            <div class="col-md-6">
                <h4 class="card-title">{{ $users->DisplayName }}</h4>
                <p class="card-text">{{ $users->email }}</p>
            </div>
            <div class="col-md-6">
                <div class="card-img-bottom">
                    {!! '<img class="pfPhoto" src="storage/'.$users->Image.'" />' !!}
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
    @endforeach
</div>
@endsection