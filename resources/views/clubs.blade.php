@extends('layouts.app')
@section('title', 'Gezelligheidsclubs – ' . config('app.name'))
@section('content')

<div class="overlap">
    <div class="row">
        <div class="d-flex row col-md-10 col-lg-8 mx-auto">
            <h1 class="center">Gezelligheidsclubs</h1>
            <p>
                Salve Mundi heeft verschillende clubs waar leden aan deel kunnen nemen. Clubs zijn een vorm om te connecten met andere leden van de vereniging met vergelijkbare interesses. Zie jij hier een leuke club tussen staan waar jij deel van uit wil maken? Neem dan contact op met de club of join de groepsapp! <br>
                Wil je zelf een club oprichten? Maak dan een draaiboek met deze <u><a href="https://salvemundi.sharepoint.com/:w:/s/bestuur/EQWfBtpDCDpMmePkSBiAfHQBJXgsWGnxYOVmHXRHi7QufA" >template</a></u> en stuur het door naar <u><a href="mailto:bestruur@salvemundi.nl">bestuur@salvemundi.nl</a></u>.
            </p>
        </div>
        @if($clubs !== null)
            @foreach ($clubs as $club)
                <div class="px-2 mb-3 col-12 col-md-6">
                    <div class="card h-100" style="min-height: 15em;">
                        <div class="row g-0 h-100">
                            @if($club->imgPath != null)
                                <div class="col-md-5 d-flex align-items-center">
                                    {!! '<img class="img-fluid rounded-start h-100 w-100" style="object-fit: cover;" src="/'. Thumbnailer::generate("storage/" . $club->imgPath, "80%") .'" />' !!}
                                </div>
                            @endif
                            <div class="col-md-7">
                                <div class="card-body">
                                    <h2 class="card-title">{{ $club->clubName }}</h2>
                                    <div class="text-muted">{{ $club->nickName }}</div>

                                    <div class="card-text">
                                        @if (session('id') !== null)
                                            <div class="row">
                                                <div class="col-auto">
                                                    <a href="{{ $club->whatsappLink }}">
                                                        <button class="btn btn-primary mb-3"><i class="fab fa-whatsapp"></i> Join club</button>
                                                    </a>
                                                    <br>
                                                </div>
                                                @if ($club->discordLink)
                                                    <div class="col-auto">
                                                        <a href="{{ $club->discordLink }}" target="_blank">
                                                            <button class="btn btn-primary mb-3" href="{{ $club->discordLink }}">
                                                                <i class="fab fa-discord"></i> Join Discord
                                                            </button>
                                                        </a>
                                                        <br>
                                                    </div>
                                                @endif
                                                @if ($club->otherLink)
                                                    <div class="col-auto">
                                                        <a href="{{ $club->otherLink }}" target="_blank">
                                                            <button class="btn btn-primary mb-3">Join</button>
                                                        </a>
                                                        <br>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                        <p class="text-muted" style="white-space: pre-line">
                                            @if ($club->description !== null)
                                                {{ $club->description }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
