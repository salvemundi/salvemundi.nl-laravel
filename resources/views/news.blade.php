@extends('layouts.app')
@section('content')

<div class="overlap">
<div class="container-fluid">
        <div class="row center">
            @foreach ($news as $nieuws)
            @if($nieuws->imgPath == null)
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title center"><b>{{$nieuws->title}}</b></h4>
                        <p class="card-text">{{$nieuws->content}}</p>
                        <div class="row">
                            <div class="col-md-12">
                                <p class="card-text textCard text-muted">Geplaatst op {{date('d-m-Y', strtotime($nieuws->created_at))}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-6">
                    <div class="card">
                        <div class="row">
                            {!! '<img class="pfPhoto card-img-top" src="storage/'.$nieuws->imgPath.'" />' !!}
                        </div>
                        <div class="row">
                            <div class="card-body">
                                <h4 class="card-title center"><b>{{$nieuws->title}}</b></h4>
                                <p class="card-text">{{$nieuws->content}}</p>
                                <p class="card-text textCard text-muted">Geplaatst op {{date('d-m-Y', strtotime($nieuws->created_at))}}</p>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
                <br>
            @endif
            @endforeach
        </div>
    </div>
</div>

@endsection
