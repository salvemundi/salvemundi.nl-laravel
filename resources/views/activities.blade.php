@extends('layouts.app')
@section('content')
<script src="js/scrollonload.js"></script>
<div class="overlap">
    @if(!$activiteiten->isEmpty())
    <div class="container">
        <div class="row">
        @foreach ($activiteiten  as $activiteit)
            <div class="col-12 col-md-4 p-1">
                <div class="card">
                    @if($activiteit->imgPath != null)
                        {!! '<img class="card-img-top imgActivity" src="storage/'.$activiteit->imgPath.'" />' !!}
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $activiteit->name }}</h5>
                        <p style="white-space: pre-line" class="card-text">{{ $activiteit->description }}</p>
                        <p class="card-text textCard text-muted">Geplaatst op {{date('d-m-Y', strtotime($activiteit->created_at))}}
                        <br>
                        @if(session('id') != null)
                            @if($activiteit->amount > 0)
                                <form method="POST" action="/activiteiten/signup">
                                    @csrf
                                    <input type="hidden" name="id" id="id" value="{{ session('id') }}">
                                    <input type="hidden" name="activityId" id="activityId" value="{{ $activiteit->id }}">
                                    <button type="submit" class="btn btn-primary buttonActiviteiten float-right">Inschrijven € {{ $activiteit->amount }}</button>
                                </form>
                            @endif
                        @else
                            @if($activiteit->amount_non_member > 0)
                                <br>
                                <button class="btn btn-primary buttonActiviteiten float-right" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample-{{ $activiteit->id }}" aria-expanded="false" aria-controls="collapseExample">
                                    Inschrijven
                                </button>
                                <div class="collapse" id="collapseExample-{{ $activiteit->id }}">
                                    <div class="card card-body">
                                        <form method="POST" action="/activiteiten/signup">
                                            @csrf
                                            <input type="hidden" name="id" id="id" value="{{ session('id') }}">
                                            <input type="hidden" name="activityId" id="activityId" value="{{ $activiteit->id }}">
                                            <div style="">
                                                <div class="input-group mb-3 me-4">
                                                    <span class="input-group-text" id="basic-addon3">email</span>
                                                    <input required type="email" class="form-control" id="email" name="email" aria-describedby="basic-addon3">
                                                </div>
                                                <button type="submit" class="btn btn-primary buttonActiviteiten float-right">Afrekenen € {{ $activiteit->amount_non_member }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
    @endif
</div>
@endsection