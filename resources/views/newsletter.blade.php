@extends('layouts.app')
@section('title', 'Nieuwsbrief – ' . config('app.name'))
@section('content')
<script src="js/scrollonload.js"></script>
<div class="overlap">
    <div class="row center">
        @if(!$newsletters->isEmpty())
            @foreach($newsletters as $newsletter)
            <div class="col-md-12 my-3 center">
                <iframe src="{{ 'storage/'.htmlspecialchars($newsletter->filePath) }}" style="width:80%; height:1000px" frameborder="0"></iframe>
            </div>
            @endforeach
        @else
            <h2 class="center">Er is geen nieuwsbrief geplaatst</h2>
        @endif
    </div>
</div>

@endsection
