@extends('layouts.app')
@section('content')

<div class="overlap">
    {{-- <div class="row">
    @foreach ($activiteiten as $activiteit)
        <div class="card">
            <div class="card-body activiteit">
                    <h2 class="card-title center"><b>{{$activiteit->name}}</b></h2>
                <hr>
                <div class="row center" id="activiteitDescription">
                    <p class="card-text center"style="width:100%;">{{$activiteit->description}}</p>
                </div>
                <div class="row justify-content-between">
                    <div class="col-md-2">
                        <p class="card-text text-muted">geplaatst op {{date('d-m-Y', strtotime($activiteit->created_at))}}</p>
                    </div>
                    <div class="col-md-2">
                        <a href="#" class="btn btn-primary buttonActiviteiten">inschrijven €{{$activiteit->price}}</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    </div> --}}

        {{-- @foreach ($activiteiten as $activiteit)
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <h2 class="card-title center"><b>{{$activiteit->name}}</b></h2>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
        @endforeach --}}
<div class="container-fluid">
        <div class="row">
            @foreach ($activiteiten as $activiteit)
                <div class="card" id="{{$activiteit->name}}">
                    <div class="card-body">
                        <h4 class="card-title center">{{$activiteit->name}}</h4>
                        <p class="card-text" style="white-space: pre-line">{{$activiteit->description}}</p>
                        <div class="row">
                            <div class="col-md-12">
                                <p class="card-text textCard text-muted">Geplaatst op {{date('d-m-Y', strtotime($activiteit->created_at))}}
                                <a href="#" class="btn btn-primary buttonActiviteiten float-right">inschrijven €{{$activiteit->amount}}</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            @endforeach
        </div>
    </div>
</div>

@endsection
