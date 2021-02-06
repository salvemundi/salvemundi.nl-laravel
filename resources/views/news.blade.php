@extends('layouts.app')
@section('content')

<div class="overlap mijnSlider">
@if(!$news->isEmpty())
    @foreach($news as $article)
        @if($article->imgPath == null)
            <div class="col-md-12" id="{{ $article->title }}">
                <div class="card center">
                    <div class="card-body">
                        <h4><p class="card-text">{{ $article->title }}</p></h4>
                        <p class="card-text" style="white-space: pre-line">{{ $article->content }}</p>
                        <p class="card-text textCard text-muted">Geplaatst op
                            {{date('d-m-Y', strtotime($article->created_at))}}
                    </div>
                </div>
                <br>
            </div>
        @else
            <div class="col-md-12" id="{{ $article->title }}">
                <div class="card cardNews center">
                    {!! '<img class="pfPhotoNews" src="storage/'.$article->imgPath.'" />' !!}
                    <div class="card-body">
                        <h4><p class="card-text">{{ $article->title }}</p></h4>
                        <p class="card-text">{{ $article->content }}</p>
                        <p class="card-text textCard text-muted">Geplaatst op
                            {{date('d-m-Y', strtotime($article->created_at))}}
                    </div>
                </div>
                <br>
            </div>
        @endif
    @endforeach
@else
    <h2 class="center"> Er zijn geen nieuws artikelen gevonden </h2>
@endif
</div>
@endsection
