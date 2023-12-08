@extends('layouts.app')
@section('content')
    <script src="js/scrollonload.js"></script>
    <div class="overlap">
        <div class="row center">
            @foreach ($previousBoard as $bestuur)
                @if ($bestuur->fotoPath == null)
                    <div class="cardNews">
                        <div class="card-body">
                            <h4><b>
                                    <p class="card-title">{{ $bestuur->year }}</p>
                                </b></h4>
                            <p class="card-text mb-5" style="white-space: pre-line">{{ $bestuur->bestuur }}</p>
                        </div>
                    </div>
                @else
                    <div class="cardNews">
                        {!! '<img class="img-fluid" src="storage/' . $bestuur->fotoPath . '" />' !!}
                        <div class="card-body">
                            <h4><b>
                                    <p class="card-title">{{ $bestuur->year }}</p>
                                </b></h4>
                            <p class="card-text mb-5" style="white-space: pre-line">{{ $bestuur->bestuur }}</p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
