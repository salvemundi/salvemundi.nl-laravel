@extends('layouts.app')
@section('content')
<script src="js/scrollonload.js"></script>
<div class="overlap">
    <div class="row center">
        @foreach($previousBoard as $bestuur)
            @if($bestuur->fotoPath == null)
                <div class="cardNews">
                    <div class="card-body">
                        <h4><b><p class="card-title">{{ htmlspecialchars($bestuur->year) }}</p></b></h4>
                        <p class="card-text" style="white-space: pre-line">{{ htmlspecialchars($bestuur->bestuur) }}</p>
                    </div>
                </div>
            @else
            <div class="cardNews">
                {!! '<img class="img-fluid" src="storage/'.htmlspecialchars($bestuur->fotoPath).'" />' !!}
                <div class="card-body">
                    <h4><b><p class="card-title">{{ htmlspecialchars($bestuur->year) }}</p></b></h4>
                    <p class="card-text" style="white-space: pre-line">{{ htmlspecialchars($bestuur->bestuur) }}</p>
                </div>
            </div>
            @endif
        @endforeach
    </div>
</div>

@endsection
