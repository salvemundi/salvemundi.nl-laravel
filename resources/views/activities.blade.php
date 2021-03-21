@extends('layouts.app')
@section('content')
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
                                <a href="{{ $activiteit->formsLink }}" class="btn btn-primary buttonActiviteiten float-right">Inschrijven @if($activiteit->amount > 0)€{{$activiteit->amount}}@endif</a></p>
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
                            <a href="{{ $activiteit->formsLink }}" class="btn btn-primary buttonActiviteiten float-right">Inschrijven @if($activiteit->amount > 0)€{{$activiteit->amount}}@endif</a></p>
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
