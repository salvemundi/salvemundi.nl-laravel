@extends('layouts.appmin')
@section('content')
    <div class="adminOverlap container">
        <div class="row mb-2">
            <div class="col-md-6 mt-3">
                <a href="/admin/leden">
                    <div class="card adminCard grow">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                                <div class="col">
                                    <h6 class="text-uppercase text-muted mb-2">Aantal leden met lidmaatschap /
                                        totaal:</h6>
                                    <span class="h2 mb-0"><i style="display: flex" class="fas fa-users"> <p
                                                    class="dashboard-font">&nbsp;{{$userCountPaid}} / {{ $userCount }}</p></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 mt-3">
                <a href="/admin/leden">
                    <div class="card adminCard grow">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                                <div class="col">
                                    <h6 class="text-uppercase text-muted mb-2">Aantal leden in commissies</h6>
                                    <span class="h2 mb-0"><i style="display: flex" class="fas fa-chart-pie"> <p
                                                    class="dashboard-font"> &nbsp;{{ $membersInCommittees }}</p></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6">
                <a href="/stickers">
                    <div class="card adminCard grow">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                                <div class="col">
                                    <h6 class="text-uppercase text-muted mb-2">Laatste sticker</h6>
                                    <span class="h2 mb-0"><i style="display: flex" class="fas fa-sticky-note">
                                            &nbsp;
                                            <h4 class="dashboard-font">
                                                @if($latestSticker !== null)
                                                    {{ $latestSticker->user->insertion ? $latestSticker->user->FirstName. " " . $latestSticker->user->insertion . " " . $latestSticker->user->LastName : $latestSticker->user->FirstName. " ". $latestSticker->user->LastName . ", geplakt op ". \Carbon\Carbon::parse($latestSticker->created_at)->format("d-m-Y")}}
                                                @else
                                                    Nog niemand heeft een sticker geplaatst
                                                @endif
                                            </h4>
                                        </i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="/admin/leden">
                    <div class="card adminCard grow">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                                <div class="col">
                                    <h6 class="text-uppercase text-muted mb-2">Aantal inschrijvingen in de afgelopen
                                        maand</h6>
                                    <span class="h2 mb-0"><i style="display: flex" class="fas fa-users"> <p
                                                    class="dashboard-font"> &nbsp;{{ $newMembersSinceLastMonth }}</p></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6">
                <a href="/pizza">
                    <div class="card adminCard grow">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                                <div class="col">
                                    <h6 class="text-uppercase text-muted mb-2">Aantal pizzas besteld</h6>
                                    <span class="h2 mb-0"><i style="display: flex" class="fas fa-pizza-slice"> &nbsp;<p
                                                    class="dashboard-font"> {{$pizzas}}</p></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="/admin/leden">
                    <div class="card adminCard grow">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                                <div class="col">
                                    <h6 class="text-uppercase text-muted mb-2">Komende jarige joppies</h6>
                                    <span class="h2 mb-0">
                                            <h4 class="dashboard-font">
                                                @if(!$nextBirthdays->isEmpty())
                                                    @foreach($nextBirthdays as $user)
                                                        {{ $user->insertion ? $user->FirstName. " " . $user->insertion . " " . $user->LastName : $user->FirstName. " ". $user->LastName . ", op ". \Carbon\Carbon::parse($user->birthday)->format("d-m-Y")}}
                                                        <br>
                                                    @endforeach
                                                @else
                                                    Niemand is jarig de komende tijd
                                                @endif
                                            </h4>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6">
                <a href="/admin/activiteiten">
                    <div class="card adminCard grow">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                                <div class="col">
                                    <h6 class="text-uppercase text-muted mb-2">Aantal inschrijvingen laatste vier
                                        activiteiten</h6>
                                    @foreach($activities as $activity)
                                        @if($activity->limit > 0)
                                            <span class="h2 mb-0"><h4 class="dashboard-font">{{ $activity->name }}: {{$activity->countSignups()}} / {{ $activity->limit }}</h4></span>
                                        @else
                                            <span class="h2 mb-0"> <h4
                                                        class="dashboard-font">{{ $activity->name }}: {{$activity->countSignups()}}</h4></span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <script>
        function CopyMe(oFileInput, sTargetID) {
            document.getElementById(sTargetID).value = oFileInput.value;
        }

    </script>

    {{-- <script src="extensions/resizable/bootstrap-table-resizable.js"></script> --}}
@endsection
