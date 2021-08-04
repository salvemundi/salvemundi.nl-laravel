@extends('layouts.app')
@section('content')
<div class="overlap">
    <div class="row center">
        <h1 class="center">Bijbaan bank</h1>
        @if(!$sideJobBank->isEmpty())
        @foreach($sideJobBank as $job)
        <div class="cardNews">
            <div class="card-body">
                <h4><b><p class="card-title" id="{{ $job->name }}">{{ $job->name }}</p></b></h4>
                <p class="card-text" style="white-space: pre-line">{{ $job->description }}</p>
                <div class="row">
                    @if(session('id') != null)
                        <div class="col-md-12">
                            <p class="card-text textCard text-muted">Geplaatst op {{date('d-m-Y', strtotime($job->created_at))}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
        @else
            <h2 class="center"> Er zijn geen bijbanen artikelen gevonden </h2>
        @endif
    </div>
</div>

@endsection
