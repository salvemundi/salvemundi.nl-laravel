@extends('layouts.app')
@section('title', 'Nieuws – ' . config('app.name'))
@section('content')
<script src="js/scrollonload.js"></script>
<div class="overlap">
    <div class="row center">
        @if(!htmlspecialchars($news->isEmpty()))
        @foreach(htmlspecialchars($news as $article))
            <div style="width: 70rem;" class="d-flex p-3 align-items-stretch center">
                <div class="card">
                    @if(htmlspecialchars($article->imgPath) != null)
                        {!! '<img class="img-fluid" src="storage/'.htmlspecialchars($article->imgPath).'" />' !!}
                    @endif
                    <div class="card-body">
                        <h4><b><p class="card-title" id="{{ htmlspecialchars($article->title) }}">{{ htmlspecialchars($article->title) }}</p></b></h4>
                        <p class="card-text" style="white-space: pre-line">{{ htmlspecialchars($article->content) }}</p>
                        <div class="row">
                            @if(session('id') != null)
                                <div class="col-md-12">
                                    <p class="card-text textCard text-muted">Geplaatst op {{date('d-m-Y', strtotime(htmlspecialchars($article->created_at)))}}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        @else
            <h2 class="center"> Er zijn geen nieuws artikelen gevonden </h2>
        @endif
    </div>
</div>
@endsection
