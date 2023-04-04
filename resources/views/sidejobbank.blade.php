@extends('layouts.app')
@section('title', 'Bijbanen bank – ' . config('app.name'))
@section('content')
    <div class="overlap">
        <div class="row center">
            <h1 class="center">Bijbanen bank</h1>
            <div class="col-md-12 center">
                <a class="btn btn-primary" href="https://forms.office.com/r/cALSNrkJgu">Vacature plaatsen</a>
            </div>
            @if(!$sideJobBank->isEmpty())
                <div class="d-flex mb-5 mt-3 align-items-start align-content-start" style="max-width: 75% !important;">
                    <div class="card p-2">
                        <div class="card-body">
                            <h3 class="card-title">Filters </h3>

                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <h5 class="card-text">Selecteer studie richting</h5>

                                    @foreach(App\Enums\StudyProfile::asSelectArray() as $key => $value)
                                        @if($key == 0 || $key == 6) @continue; @endif
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{$key}}" id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                {{ $value }}
                                            </label>
                                        </div>
                                    @endforeach
                                </li>
                                <li class="list-group-item">
                                    <h5 class="card-text">Locatie</h5>
                                    @foreach($sideJobBank->unique('city') as $job)
                                        @if(isset($job->city))
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="{{$job->city}}" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    {{ $job->city }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </li>
                                <li class="list-group-item">
                                    <h5 class="card-text">Bruto salaris per uur</h5>
                                    <div class="d-flex">
                                        <p>{{ $minSalary }}</p>
                                        <input type="range" name="salaryRange" class="form-range" id="salaryRange">
                                        <p>{{ $maxSalary }}</p>
                                    </div>
                                </li>
                            </ul>

                        </div>
                    </div>
                    <div class="ps-3 flex-grow-1">
                        @foreach($sideJobBank as $job)
                            <div class="p-2 card mb-3">
                                <div class="card-body">
                                    <h2 class="card-title">{{ $job->name }}</h2>
                                    <p class="card-text" style="white-space: pre-line">{{ $job->description }}</p>
                                    <div>
                                        <i class="fas fa-map-marker-alt"></i> {{ $job->city ?? "Niet bekend" }}
                                        <i class="fas fa-euro-sign"></i> {{$job->minSalaryEuroBruto ?? 'Onderhandelbaar'}} @if(isset($job->minSalaryEuroBruto) && isset($job->maxSalaryEuroBruto)) tot @endif {{ $job->maxSalaryEuroBruto ?? null }} @if(isset($job->minSalaryEuroBruto)) euro per uur @endif
                                    </div>
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
                            <h2 class="center">Er zijn geen bijbanen gevonden</h2>
                        @endif
                    </div>
                </div>

        </div>
    </div>

@endsection
