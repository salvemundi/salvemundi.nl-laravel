@extends('layouts.app')
@section('title', 'Activiteiten – ' . config('app.name'))
@section('content')
    <script src="js/scrollonload.js"></script>
    <script src="{{ mix('js/GroupSelectTickets.js') }}"></script>

    <div class="overlap">
        <div class="container">
            @include('include.messageStatus')
            @if (!$activiteiten->isEmpty())
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        @foreach ($activiteiten as $activiteit)
                            <div style="width: 25rem;" class="d-flex p-3 align-items-stretch">
                                <input type="hidden" name="id" id="id" value="{{ session('id') }}">
                                <input type="hidden" name="activityId" id="activityId" value="{{ $activiteit->id }}">
                                <a data-bs-toggle="modal" data-bs-target="#showModal{{ $activiteit->id }}">
                                    <div class="card" style="min-height: 50vh; cursor: pointer; max-height: 50vh;" data-toggle="tooltip"
                                        data-placement="top" title="Klik om volledig te lezen!" style="">
                                        @if ($activiteit->imgPath != null)
                                            {!! '<img class="img-fluid mx-auto card-img-top" src="/' .
                                                Thumbnailer::generate('storage/' . $activiteit->imgPath, '60%') .
                                                '" />' !!}
                                        @endif
                                        <div class="card-body" style="overflow: hidden; cursor: pointer">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="card-title">{{ $activiteit->name }}</h5>
                                                <div class="ms-4 center">
                                                    @foreach ($activiteit->tags as $tag)
                                                        <h5 class="ms-2">
                                                            <span class="badge {{ $tag->colorClass }}"><i
                                                                    class="{{ $tag->icon }}"></i>
                                                                {{ $tag->name }}</span>
                                                        </h5>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <p style="white-space: pre-line" class="card-text">
                                                {{ $activiteit->description, 300 }}</p>
                                            <p class="card-text textCard text-muted">Geplaatst op
                                                {{ date('d-m-Y', strtotime($activiteit->created_at)) }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <h1 class="center">Geen activiteiten gevonden</h1>
            @endif

            <!-- Button trigger modal -->
            @foreach ($activiteiten as $activiteit)
                @include('include.activityModal', ['activiteit' => $activiteit])
            @endforeach
        </div>
    </div>
@endsection
