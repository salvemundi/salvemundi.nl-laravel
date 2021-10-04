@extends('layouts.app')
@section('content')

<div class="overlap">
    <div class="row mb-4">
        @foreach ($clubs as $club)
            <div class="px-2 mb-3 col-12 col-md-6">
                <div class="card" style="min-height: 16em;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            {{-- <img src="..." class="img-fluid rounded-start" alt="..."> --}}
                            {!! '<img class="img-fluid rounded-start" src="storage/'.$club->imgPath.'" />' !!}
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h2 class="card-title">{{ $club->clubName}}</h2>
                                <p class="card-text">
                                    @if (session('id') != null)
                                    <div class="row">
                                        <div class="col-auto">
                                            <a href="{{ $club->whatsappLink }}"><button class="btn btn-primary mb-3"><i class="fab fa-whatsapp"></i> Join club</button></a> <br>
                                        </div>
                                        @if ($club->discordLink)
                                            <div class="col-auto">
                                                <a href="{{ $club->discordLink }}"><button class="btn btn-primary mb-3" href="{{ $club->discordLink }}"><i class="fab fa-discord"></i> Join Discord</button></a> <br>
                                            </div>
                                        @endif
                                        @if ($club->otherLink)
                                            <div class="col-auto">
                                                <a href="{{ $club->otherLink}}"><button class="btn btn-primary mb-3" i class="fab fa-discord"></i> Join </button></a>  <br>
                                            </div>
                                        @endif
                                    </div>
                                    @endif
                                    <small class="text-muted">
                                        @if ($club->founderName != null)
                                            <b>Naam oprichter:</b> {{ $club->founderName }} <br>
                                        @endif
                                    </small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<div class="overlap">
    <div class="row justify-content-center mb-4">
        @foreach ($clubs as $club)
            <div class="col-md-3 col-sm-8 mb-3">
                <div class="card ">
                    <div class="col-auto col-md-12">
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
                            @endif
                            @if ($club->founderName)
                                <b>Naam oprichter:</b> {{ $club->founderName }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
