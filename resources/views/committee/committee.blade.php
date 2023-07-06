@extends('layouts.app')
@section('content')

<div class="overlap">
    <div class="row">
        <div class="col-12 col-md-6 px-1 px-md-5">
            <h1 class="center">{{$committee->DisplayName}}</h1>
            <p class="center">
                {{$committee->Description}}
            </p>
        </div>
        <div class="col-12 col-md-6 px-1 px-md-5">
            <img class="imgIndex" src="{{ '/' . Thumbnailer::generate('storage/committees/' . $committee->AzureID . '.png', '1296x864') }}" onerror="this.src='../storage/images/group-salvemundi-placeholder.svg'">
        </div>
    </div>

    <br>
    <div class="row">
        @foreach ($committee->users as $committeeMember)
            @if($committeeMember->visibility)
                <div class="col-12 col-sm-6 col-lg-3 my-2">
                    <div class="card">
                            {!! '<img class="img-fluid" src="../storage/'.$committeeMember->ImgPath.'" />' !!}
                        <div class="card-body card-body-no-padding mt-2">
                            <h5 class="card-title text-center">{{$committeeMember->DisplayName}}</h5>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

@endsection
