@extends('layouts.app')
@section('title', 'Bijbanen bank – ' . config('app.name'))
@section('content')
    <div class="overlap">
        <div class="row center">
            <h1 class="center">Bijbanen bank</h1>
            <div class="col-md-12 center">
                <a class="btn btn-primary" href="https://forms.office.com/r/cALSNrkJgu">Vacature plaatsen</a>
            </div>
            @if(!$sideJobBank->isEmpty())
                @foreach($sideJobBank as $job)
                    <div class="cardNews">
                        <div class="card-body">
                            <h4><b><p class="card-title" id="{{ htmlspecialchars($job->name) }}">{{ htmlspecialchars($job->name) }}</p></b></h4>
                            <p class="card-text" style="white-space: pre-line">{{ htmlspecialchars($job->description) }}</p>
                            <div class="row">
                                @if(htmlspecialchars(session('id')) != null)
                                    <div class="col-md-12">
                                        <p class="card-text textCard text-muted">Geplaatst op {{date('d-m-Y', strtotime(htmlspecialchars($job->created_at)))}}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h2 class="center">Er zijn geen bijbanen gevonden</h2>
            @endif
        </div>
    </div>

@endsection
