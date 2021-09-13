@extends('layouts.app')
@section('content')
<script src="js/scrollonload.js"></script>
<div class="overlap">
    <div class="row center">
        @if(!$activiteiten->isEmpty())
        @foreach($activiteiten as $activiteit)
        @if($activiteit->imgPath == null)
            <div class="cardNews">
                <div class="card-body">
                    <h4><b><p class="card-title" id="{{ $activiteit->name }}">{{ $activiteit->name }}</p></h4></b>
                    <p class="card-text" style="white-space: pre-line">{{ $activiteit->description }}</p>
                    <div class="row">
                        @if(session('id') != null)
                            <div class="col-md-12">
                                <p class="card-text textCard text-muted">Geplaatst op {{date('d-m-Y', strtotime($activiteit->created_at))}}
                                    @if($activiteit->formsLink != null)
                                        @if($activiteit->amount > 0)
                                            <form method="POST" action="/activiteiten/signup">
                                                @csrf
                                                <input type="hidden" name="id" id="id" value="{{ session('id') }}">
                                                <input type="hidden" name="activityId" id="activityId" value="{{ $activiteit->id }}">
                                                <button type="submit" class="btn btn-primary buttonActiviteiten float-right">Inschrijven € {{ $activiteit->amount }}</button>
                                            </form>
                                        @else
                                            <a href="{{ $activiteit->formsLink }}" class="btn btn-primary buttonActiviteiten float-right">Inschrijven</a></p>
                                        @endif
                                @endif
                            </div>
                        @else
                            <div class="col-md-12">
                                <p class="card-text textCard text-muted">Geplaatst op {{date('d-m-Y', strtotime($activiteit->created_at))}}
                                    @if($activiteit->formsLink != null)
                                        @if($activiteit->amount > 0)
                                            <br>
                                            <button class="btn btn-primary buttonActiviteiten float-right" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                                Inschrijven
                                            </button>
                                            </p>
                                            <div class="collapse" id="collapseExample">
                                                <div class="card card-body">
                                                    <form method="POST" action="/activiteiten/signup">
                                                        @csrf
                                                        <input type="hidden" name="id" id="id" value="{{ session('id') }}">
                                                        <input type="hidden" name="activityId" id="activityId" value="{{ $activiteit->id }}">
                                                        <div style="display: inline-flex; flex-shrink: 0;">
                                                            <div class="input-group mb-3 me-4">
                                                                <span class="input-group-text" id="basic-addon3">email</span>
                                                                <input required type="email" class="form-control" id="email" name="email" aria-describedby="basic-addon3">
                                                            </div>
                                                            <button type="submit" style="flex-shrink: 0; height: 37.0333px;"class="btn btn-primary buttonActiviteiten float-right">Inschrijven € {{ $activiteit->amount_non_member }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        @else
                                            <a href="{{ $activiteit->formsLink }}" class="btn btn-primary buttonActiviteiten float-right">Inschrijven</a></p>
                                        @endif
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @else
        <div class="cardNews">
            {!! '<img class="img-fluid" src="storage/'.$activiteit->imgPath.'" />' !!}
            <div class="card-body">
                <h4><b><p class="card-title" id="{{ $activiteit->name }}">{{ $activiteit->name }}</p></h4></b>
                <p class="card-text" style="white-space: pre-line">{{ $activiteit->description }}</p>
                <div class="row">
                    @if(session('id') != null)
                        <div class="col-md-12">
                            <p class="card-text textCard text-muted">Geplaatst op {{date('d-m-Y', strtotime($activiteit->created_at))}}
                            @if($activiteit->formsLink != null)
                                @if($activiteit->amount > 0)
                                    <form method="POST" action="/activiteiten/signup">
                                        @csrf
                                        <input type="hidden" name="id" id="id" value="{{ session('id') }}">
                                        <input type="hidden" name="activityId" id="activityId" value="{{ $activiteit->id }}">
                                        <button type="submit" class="btn btn-primary buttonActiviteiten float-right">Inschrijven € {{ $activiteit->amount }}</button>
                                    </form>
                                @else
                                    <a href="{{ $activiteit->formsLink }}" class="btn btn-primary buttonActiviteiten float-right">Inschrijven</a></p>
                                @endif
                            @endif
                        </div>
                    @else
                    <div class="col-md-12">
                        <p class="card-text textCard text-muted">Geplaatst op {{date('d-m-Y', strtotime($activiteit->created_at))}}
                            @if($activiteit->formsLink != null)
                                @if($activiteit->amount > 0)
                                    <br>
                                    <button class="btn btn-primary buttonActiviteiten float-right" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                        Inschrijven
                                    </button>
                                    </p>
                                    <div class="collapse" id="collapseExample">
                                        <div class="card card-body">
                                            <form method="POST" action="/activiteiten/signup">
                                                @csrf
                                                <input type="hidden" name="id" id="id" value="{{ session('id') }}">
                                                <input type="hidden" name="activityId" id="activityId" value="{{ $activiteit->id }}">
                                                <div style="display: inline-flex; flex-shrink: 0;">
                                                    <div class="input-group mb-3 me-4">
                                                        <span class="input-group-text" id="basic-addon3">email</span>
                                                        <input required type="email" class="form-control" id="email" name="email" aria-describedby="basic-addon3">
                                                    </div>
                                                    <button type="submit" style="flex-shrink: 0; height: 37.0333px;"class="btn btn-primary buttonActiviteiten float-right">Inschrijven € {{ $activiteit->amount_non_member }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                @else
                                    <a href="{{ $activiteit->formsLink }}" class="btn btn-primary buttonActiviteiten float-right">Inschrijven</a></p>
                                @endif
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
        @endforeach
        @else
            <h2 class="center"> Er zijn geen activiteiten gevonden </h2>
        @endif
    </div>
</div>

@endsection
