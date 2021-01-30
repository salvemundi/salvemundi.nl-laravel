@extends('layouts.app')
@section('content')

<div class="overlap">
    <div class="mijnSlider">
        <div class="container-fluid">
            <div class="row">
                @foreach ($activiteiten as $activiteit)
                    <div class="card activityCard" id="{{$activiteit->name}}">
                        <div class="card-body">
                            <h4 class="card-title center">{{$activiteit->name}}</h4>
                            <p class="card-text" style="white-space: pre-line">{{$activiteit->description}}</p>
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
                    <br>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
