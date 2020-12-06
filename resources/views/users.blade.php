@extends('layouts.app')

@section('content')
<div class="overlap grid">
    @foreach ($groupsBestuur as $groupBestuur)
    <div class="card group">
        <div class="row">
            <div class="col-md-4">
                {{-- {!! '<img class="pfPhoto" src="storage/'.$users->Image.'" />' !!} --}}
            </div>
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
        <h2>{{$group->DisplayName}}</h2>
        <p>{{$group->Description}}</p>
    @foreach ($getCommissieMembers as $users)
        @if ($users->groupID == $group->id)
            <div class="card">
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