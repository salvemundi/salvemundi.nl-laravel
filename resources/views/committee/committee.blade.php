@extends('layouts.app')
@section('content')

<div class="overlap">
    <div class="row">
        <div class="col-12 col-md-6 px-1 px-md-5">
            <h1 class="center">{{htmlspecialchars($committee->DisplayName)}}</h1>
            <p class="center">
                {{htmlspecialchars($committee->Description)}}
            </p>
        </div>
        <div class="col-12 col-md-6 px-1 px-md-5">
            <img class="imgIndex" src="../storage/committees/{{ htmlspecialchars($committee->AzureID) }}.png" onerror="this.src='../storage/images/group-salvemundi-placeholder.svg'">
        </div>
    </div>

    <br>
    <div class="row">
        @foreach (htmlspecialchars($committee->users as $committeeMember))
            <div class="col-12 col-sm-6 col-lg-3 my-2">
                <div class="card">
                        {!! '<img class="img-fluid" src="../storage/'.htmlspecialchars($committeeMember->ImgPath).'" />' !!}
                    <div class="card-body card-body-no-padding mt-2">
                        <h5 class="card-title text-center">{{htmlspecialchars($committeeMember->DisplayName)}}</h5>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
