@extends('layouts.app')
@section('content')

<div class="overlap">
    <div class="row justify-content-center mb-4">
        @foreach ($clubs as $club)
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="col-md-12">
                        @if ($club->imgPath != null)
                            {!! '<img class="img-fluid foto" src="storage/'.$club->imgPath.'" />' !!}
                        @endif
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            <h3>{{ $club->clubName }}</h3>
                            @if ($club->nickName != null)
                              {{ $club->nickName }} <br>
                            @endif
                            @if (session('id') != null)
                                <div class="row">
                                    <div class="col-auto">
                                        <a href="{{ $club->whatsappLink }}"><button class="btn btn-primary mb-3"><i class="fab fa-whatsapp"></i> Join club</button></a> <br>
                                    </div>
                                    @if ($club->discordLink)
                                        <div class="col-auto">
                                            <a href="{{ $club->discordLink }}"><button class="btn btn-primary mb-3" href="{{ $club->discordLink }}"><i class="fab fa-discord"></i> Join Discord Server club</button></a> <br>
                                        </div>
                                    @endif
                                    @if ($club->otherLink)
                                        <div class="col-auto">
                                            <a href="{{ $club->otherLink}}"><button class="btn btn-primary mb-3" i class="fab fa-discord"></i> Join </button></a>  <br>
                                        </div>
                                    @endif
                                </div>
                                <br>
                            @endif
                            @if ($club->founderName)
                                <b>Naam oprichter:</b> {{ $club->founderName }} <br>
                            @endif
                        </p>
                    </div>
                    <br>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
