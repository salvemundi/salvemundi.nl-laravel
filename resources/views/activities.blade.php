@extends('layouts.app')
@section('title', 'Activiteiten – ' . config('app.name'))
@section('content')
<script src="js/scrollonload.js"></script>
<div class="overlap">
    <div class="container">
        @if(session()->has('message'))
            <div class="alert alert-primary">
                {{ session()->get('message') }}
            </div>
        @endif
        @if(!$activiteiten->isEmpty())
        <div class="container-fluid">
            <div class="row justify-content-center">
            @foreach ($activiteiten as $activiteit)
                <div style="width: 25rem;" class="d-flex p-3 align-items-stretch">
                    <input type="hidden" name="id" id="id" value="{{ session('id') }}">
                    <input type="hidden" name="activityId" id="activityId" value="{{ $activiteit->id }}">
                    <a data-bs-toggle="modal" data-bs-target="#showModal{{ $activiteit->id }}">
                        <div class="card"  style="min-height: 50vh; max-height: 50vh;" data-toggle="tooltip" data-placement="top" title="Klik om volledig te lezen!" style="">
                            @if($activiteit->imgPath != null)
                                {!! '<img class="img-fluid mx-auto card-img-top" src="/'. Thumbnailer::generate("storage/" . $activiteit->imgPath, "60%") .'" />' !!}
                            @endif
                            <div class="card-body" style="overflow: hidden; cursor: pointer">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">{{ $activiteit->name }}</h5>
                                    <div class="ms-4 center">
                                        @foreach($activiteit->tags as $tag)
                                            <h5 class="ms-2">
                                                <span class="badge {{ $tag->colorClass }}"><i class="{{ $tag->icon }}"></i> {{ $tag->name }}</span>
                                            </h5>
                                        @endforeach
                                    </div>
                                </div>

                                <p style="white-space: pre-line" class="card-text">{{$activiteit->description, 300}}</p>
                                <p class="card-text textCard text-muted">Geplaatst op {{date('d-m-Y', strtotime($activiteit->created_at))}}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
            </div>
        </div>
        @endif

        <!-- Button trigger modal -->
        @foreach ($activiteiten as $activiteit)
            <!-- Modal -->
            <div class="modal fade" id="showModal{{ $activiteit->id }}" tabindex="583208700" style="z-index: 534324;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-lg" style="z-index: 100000;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $activiteit->name }}</h5>
                            <div class="ms-auto center">
                                @foreach($activiteit->tags as $tag)
                                    <h5 class="ms-2">
                                        <span class="badge {{ $tag->colorClass }}"><i class="{{ $tag->icon }}"></i> {{ $tag->name }}</span>
                                    </h5>
                                @endforeach
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        @if($activiteit->imgPath != null)
                            {!! '<img style="max-width: 50%;" class="mx-auto img-fluid" src="/'. Thumbnailer::generate("storage/" . $activiteit->imgPath, "60%") .'" />' !!}
                        @endif
                        <h1 class="mt-3 center"> {{ $activiteit->name }} </h1>
                        <div class="modal-body">
                            <p style="white-space: pre-line" class="card-text">{{ $activiteit->description }}</p>
                            @if(session('userName'))
                                <p style="white-space: pre-line" class="card-text">{!!  preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a style="text-decoration: underline !important; color: blue;" href="$1">$1</a>', $activiteit->membersOnlyContent) !!}</p>
                            @endif
                        </div>

                        <div class="modal-footer">
                            <div class="col row">
                                <div class="col-12">
                                    <p class="card-text textCard text-muted">Geplaatst op {{date('d-m-Y', strtotime($activiteit->created_at))}}</p>

                                        @if(!$activiteit->isFull())
                                                @if($userIsActive)
                                                    @if(App\Http\Controllers\ActivitiesController::userHasPayedForActivity($activiteit->id))
                                                        @if($activiteit->oneTimeOrder)
                                                            <button class="btn btn-success disabled"><i class="fas fa-check"></i> Ingeschreven</button>
                                                        @else
                                                            <form method="POST" action="/activiteiten/signup">
                                                                @csrf
                                                                <input type="hidden" name="activityId" id="activityId" value="{{ $activiteit->id }}">
                                                                <button type="submit" class="btn btn-primary">Inschrijven € {{ $activiteit->amount }}</button>
                                                            </form>
                                                         @endif
                                                    @else
                                                        <form method="POST" action="/activiteiten/signup">
                                                            @csrf
                                                            <input type="hidden" name="activityId" id="activityId" value="{{ $activiteit->id }}">
                                                            <button type="submit" class="btn btn-primary">Inschrijven € {{ $activiteit->amount }}</button>
                                                        </form>
                                                     @endif
                                                @else
                                                    @if(session('id'))
                                                        <p class="card-text textCard text-danger"><u>Je lidmaatschap is niet meer geldig, verleng deze voor korting op deze activiteit!</u></p>
                                                    @else
                                                        <p class="card-text textCard text-danger"><u>Je hebt geen lidmaatschap, word lid voor korting op deze activiteit!</u></p>
                                                    @endif

                                                    @if($activiteit->membersOnly && !$userIsActive)
                                                        <button class="btn btn-danger">Alleen voor Leden</button>
                                                    @else
                                                        <div class="col-12">
                                                            <button class="btn btn-primary buttonActiviteiten" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample-{{ $activiteit->id }}" aria-expanded="false" aria-controls="collapseExample">
                                                                Inschrijven
                                                            </button>
                                                        </div>

                                                        <div class="collapse mt-3" id="collapseExample-{{ $activiteit->id }}">
                                                            <div class="card card-body">
                                                                <form method="POST" action="/activiteiten/signup">
                                                                    @csrf
                                                                    @if($activiteit->isGroupSignup)
                                                                        <input type="hidden" name="activityId" id="activityId" value="{{ $activiteit->id }}">
                                                                        <label for="amountOfTickets" class="form-label">Aantal Tickets</label>
                                                                        <input required type="number" min="1" max="" class="form-control" id="amountOfTickets" name="amountOfTickets" aria-describedby="basic-addon3">
                                                                        <select class="form-select" name="select" aria-label="Default select example">
                                                                            <option value="1">One</option>
                                                                            <option value="2">Two</option>
                                                                            <option value="3">Three</option>
                                                                        </select>
                                                                        <div id="ticketInputs">

                                                                        </div>
                                                                    @else
                                                                        <input type="hidden" name="activityId" id="activityId" value="{{ $activiteit->id }}">
                                                                        <div class="input-group mb-3 me-4">
                                                                            <span class="input-group-text" id="basic-addon3">Naam</span>
                                                                            <input required type="text" class="form-control" id="nameActivity" name="nameActivity" aria-describedby="basic-addon3">
                                                                            <br>
                                                                        </div>
                                                                        <div class="input-group mb-3 me-4">
                                                                            <span class="input-group-text" id="basic-addon3">Email</span>
                                                                            <input required type="email" class="form-control" id="email" name="email" aria-describedby="basic-addon3">
                                                                        </div>
                                                                        <button type="submit" class="btn btn-primary buttonActiviteiten float-right">Afrekenen € {{ $activiteit->amount_non_member }}</button>
                                                                    @endif
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                        @else
                                            @if(App\Http\Controllers\ActivitiesController::userHasPayedForActivity($activiteit->id) && $activiteit->oneTimeOrder)
                                                <button class="btn btn-success disabled"><i class="fas fa-check"></i> Ingeschreven</button>
                                            @else
                                                <p class="card-text textCard text-danger"><u>Deze activiteit is helaas vol!</u></p>
                                            @endif
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<script src="{{ mix('js/GroupSelectTickets.js') }}"></script>

@endsection
