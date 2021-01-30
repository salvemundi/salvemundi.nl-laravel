@extends('layouts.app')
@section('content')

<div class="overlap">
<div class="container-fluid">
        <div class="row center">
            @foreach ($previousBoard as $bestuur)
                <div class="col-md-7">
                    <div class="card" id="{{$bestuur->yaer}}">
                        @if($bestuur->fotoPath != null)
                            <div class="row">
                                {!! '<img class="pfPhoto" src="storage/'.$bestuur->fotoPath.'" />' !!}
                            </div>
                        @endif
                        <div class="card-body">
                            <h4 class="card-title center"><b>{{$bestuur->year}}</b></h4>
                            <p class="card-text" style="white-space: pre-line">{{$bestuur->bestuur}}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
