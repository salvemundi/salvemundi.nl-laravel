@extends('layouts.app')
@section('content')
{{-- <div class="overlap">
    <div class="mijnSlider">
        <h1 class="center">Commissies</h1>
        <p class="center">
            test
        </p><br>
        <div class="container-fluid">
            <div class="row">
                @foreach($news as $nieuws)
                @if ($nieuws->imgPath == null)
                <div class="col-md-6" id="{{ $nieuws->title }}">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ $nieuws->title  }}</h4>
                            <p class="card-text">{{ $nieuws->content }}</p>
                                <p class="card-text textCard text-muted">Geplaatst op
                                    {{date('d-m-Y', strtotime($nieuws->created_at))}}
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            <br>
            <div class="row">
                @foreach($news as $nieuws)
                @if ($nieuws->imgPath != null)
                <div class="col-md-6" id="{{ $nieuws->title }}">
                    <div class="card">
                        {!! '<img class="pfPhoto" src="storage/'.$nieuws->imgPath.'" />' !!}
                        <div class="card-body">
                            <h4 class="card-title">{{ $nieuws->title  }}</h4>
                            <p class="card-text">{{ $nieuws->content }}</p>
                                <p class="card-text textCard text-muted">Geplaatst op
                                    {{date('d-m-Y', strtotime($nieuws->created_at))}}
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div> --}}

<div class="overlap mijnSlider">
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
</div>


@endsection
