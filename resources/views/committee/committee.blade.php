@extends('layouts.app')
@section('content')
    <div class="overlap">
        <div class="row">
            <div class="col-12 col-md-6 px-1 px-md-5">
                <h1 class="center">{{ $committee->DisplayName }}</h1>
                <p class="center">
                    {{ $committee->Description }}
                </p>
            </div>
            <div class="col-12 col-md-6 px-1 px-md-5">
                <img class="imgIndex"
                    src="{{ '/' . Thumbnailer::generate('storage/committees/' . $committee->AzureID . '.png', '1296x864') }}"
                    onerror="this.src='../storage/images/group-salvemundi-placeholder.svg'">
            </div>
        </div>

        <br>
        <div class="row">
            @foreach ($committee->users->sortBy(function ($user) {
            return !$user->pivot->isCommitteeLeader;
        }) as $committeeMember)
                @if ($committeeMember->visibility)
                    <div class="col-12 col-sm-6 col-lg-3 my-2">
                        @if ($committeeMember->pivot->isCommitteeLeader)
                            <div class="card border-3 overflow-hidden cardCommitteeLeaderStyle">
                            @else
                                <div class="card">
                        @endif
                        @if ($committeeMember->pivot->isCommitteeLeader)
                            <div class="card-img-overlay committeeLeaderOverlay">
                                <h5 class="card-title p-2 committeeLeaderTitleOverlay">Commissieleider</h5>
                            </div>
                        @endif
                        {!! '<img class="img-fluid" src="../storage/' . $committeeMember->ImgPath . '" />' !!}
                        <div class="card-body card-body-no-padding mt-2">
                            <h5 class="card-title text-center">{{ $committeeMember->DisplayName }}</h5>
                        </div>
                    </div>
        </div>
        @endif
        @endforeach
    </div>
    </div>
@endsection
