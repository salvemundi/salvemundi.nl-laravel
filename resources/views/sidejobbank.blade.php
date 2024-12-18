@extends('layouts.app')
@section('title', 'Bijbanen bank – ' . config('app.name'))
@section('content')
    <div class="overlap">
        <div class="row center">
            <h1 class="center">Bijbanen bank</h1>
            <div class="col-md-12 center">
                <a class="btn btn-primary" href="https://forms.office.com/r/cALSNrkJgu">Vacature plaatsen</a>
            </div>
            @if (!$sideJobBank->isEmpty())
                <div class="container w-100 mb-5 mt-3 align-items-start align-content-start">
                    <div class="row w-100 align-items-start align-content-start mx-0">
                        <div class="mb-3 card p-2 col-lg-3 col-sm-12">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div>
                                        <h3 class="card-title">Filters </h3>
                                    </div>
                                    <div style="margin-left: auto;">
                                        <a id="resetButton" class="btn btn-primary text-white">Reset</a>
                                    </div>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <h5 class="card-text">Selecteer studie richting</h5>

                                        @foreach (App\Enums\StudyProfile::asSelectArray() as $key => $value)
                                            @if ($key == 0 || $key == 6)
                                                @continue;
                                            @endif
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="{{ $key }}"
                                                    id="checkStudy">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    {{ $value }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </li>
                                    <li class="list-group-item">
                                        <h5 class="card-text">Locatie</h5>
                                        @foreach ($sideJobBank->unique('city') as $job)
                                            @if (isset($job->city))
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="{{ $job->city }}" id="checkCity">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        {{ $job->city }}
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </li>
                                    <li class="list-group-item">
                                        <h5 id="salDisplay" class="card-text">Bruto salaris per uur</h5>
                                        <div class="d-flex">
                                            <p>€{{ $minSalary }}</p>
                                            <input type="range" value="{{ $minSalary ?? 0 }}" min="{{ $minSalary ?? 0 }}"
                                                max="{{ $maxSalary }}" step="1" name="salaryRange"
                                                class="form-range custom-range" id="salaryRange">
                                            <p>€{{ $maxSalary }}</p>
                                        </div>
                                    </li>
                                </ul>

                            </div>
                        </div>
                        <div class="ps-lg-3  px-0 flex-grow-1 col-lg-6 col-sm-12">
                            @foreach ($sideJobBank as $job)
                                <div id="{{ $job->city ?? 'b' }}"
                                    class="p-2 card mb-3 filter-this-card {{ \App\Enums\StudyProfile::coerce($job->studyProfile)->value }} {{ $job->minSalaryEuroBruto ?? 0 }} {{ $job->maxSalaryEuroBruto ?? 0 }}">
                                    <div class="card-body">
                                        <h2 class="card-title">{{ $job->name }}</h2>
                                        @if ($job->position != null)
                                            <h6 class="card-text fw-bold">Positie: {{ $job->position }}</h6>
                                        @endif
                                        <div class="container px-0 m-0">
                                            <div class="row">
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <h5>Omschrijving:</h5>
                                                    <p class="card-text w-75" style="white-space: pre-line">
                                                        {{ $job->description }}</p>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4 flex-grow-1">
                                                    <h5>Skills gevraagd:</h5>
                                                    @if ($job->skills()->get()->count() > 0)
                                                        <ul class="list-group list-group-flush">
                                                            @foreach ($job->skills()->get() as $skill)
                                                                <li class="list-group-item">{{ $skill->name }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <p class="card-text">Niet opgegeven</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-2 container-fluid px-0">
                                            <div class="row">
                                                <div><i class="fas fa-map-marker-alt"></i>
                                                    {{ $job->city ?? 'Niet bekend' }}</div>
                                                <div><i class="fas fa-euro-sign"></i>
                                                    {{ $job->minSalaryEuroBruto ?? 'Onderhandelbaar' }} @if (isset($job->minSalaryEuroBruto) && isset($job->maxSalaryEuroBruto))
                                                        tot
                                                        @endif {{ $job->maxSalaryEuroBruto ?? null }} @if (isset($job->minSalaryEuroBruto))
                                                            euro per uur
                                                        @endif
                                                </div>
                                                <div><i class="fas fa-clock"></i>
                                                    {{ $job->minAmountOfHoursPerWeek ?? 'Onderhandelbaar' }} @if (isset($job->minAmountOfHoursPerWeek) && isset($job->maxAmountOfHoursPerWeek))
                                                        tot
                                                        @endif {{ $job->maxAmountOfHoursPerWeek ?? null }} @if (isset($job->minAmountOfHoursPerWeek))
                                                            uur per week
                                                        @endif
                                                </div>

                                                @if (session('id') != null)
                                                    <div>
                                                        @if (isset($job->emailContact))
                                                            <div>
                                                                <i class="far fa-envelope" style="color: white;"></i>
                                                                <a class="me-1 text-decoration-underline"
                                                                    href="mailto:{{ $job->emailContact }}">
                                                                    {{ $job->emailContact }}</a>
                                                            </div>
                                                        @endif
                                                        @if (isset($job->phoneNumberContact))
                                                            <div>
                                                                <i class="fas fa-phone"></i><a
                                                                    class="text-decoration-underline"
                                                                    href="tel:{{ $job->phoneNumberContact }}">
                                                                    {{ $job->phoneNumberContact }}</a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                                <div class="col-md-12">
                                                    <p class="card-text textCard text-muted">Geplaatst op
                                                        {{ date('d-m-Y', strtotime($job->created_at)) }}
                                                </div>
                                                @if ($job->linkToJobOffer)
                                                    <div class="flex-grow-1 justify-content-center align-self-center">
                                                        <a href="{{ $job->linkToJobOffer }}"
                                                            class="btn btn-primary float-end text-white">Naar vacature <i
                                                                class="far fa-share-square"></i> </a>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
        </div>
    @else
        <h2 class="center">Er zijn geen bijbanen gevonden</h2>
        @endif
    </div>
    <script>
        const checkboxes = document.querySelectorAll('input[type=checkbox]');
        const MinSalary = document.getElementById('salaryRange');
        const resetButton = document.getElementById('resetButton');
        resetButton.addEventListener('click', resetFilter);

        const MinSalaryOfAll = {{ $minSalary }};
        MinSalary.addEventListener('change', filterCards);
        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', filterCards);
        });

        $('#salaryRange').on('input', function() {
            $('#salDisplay').text("Bruto salaris per uur: €" + $(this).val());
        });

        function resetFilter() {

            MinSalary.value = MinSalaryOfAll
            checkboxes.forEach((checkbox) => {
                checkbox.checked = false;
            });
            $('#salDisplay').text("Bruto salaris per uur");
            filterCards()
        }

        function filterSalary(cardMinSalary, cardMaxSalary) {
            let minSal = parseFloat(MinSalary.value)
            let minSalOfAll = parseFloat(MinSalaryOfAll)
            let minSalCard = parseFloat(cardMinSalary);
            let maxSalCard = parseFloat(cardMaxSalary);
            if (minSal === minSalOfAll) {
                return true;
            }
            if (minSalCard === 0) {
                return false;
            }
            if (cardMaxSalary > 0) {
                return minSal >= minSalCard && minSal <= maxSalCard
            } else {
                return minSal >= minSalCard;
            }
        }


        function filterCards() {
            const selectedCategories = [];
            const selectedLocations = [];
            checkboxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    if (checkbox.id === "checkStudy") {
                        selectedCategories.push(checkbox.value);
                    } else {
                        selectedLocations.push(checkbox.value);
                    }
                }
            });

            const cards = document.querySelectorAll('.filter-this-card');

            cards.forEach((card) => {
                const cardMaxSalary = card.classList[6];
                const cardMinSalary = card.classList[5];
                const cardCategory = card.classList[4];
                const cardLocation = card.id;
                let shouldDisplay = false;
                let catBool = new RegExp(selectedCategories.join('|')).test(String(cardCategory))
                let locBool = new RegExp(selectedLocations.join('|')).test(String(cardLocation))
                if (selectedCategories.length > 0 && selectedLocations.length > 0) {
                    shouldDisplay = catBool && locBool
                } else {
                    if (selectedCategories.length > 0 && catBool && filterSalary(cardMinSalary, cardMaxSalary)) {
                        shouldDisplay = true;
                    }
                    if (selectedLocations.length > 0 && locBool && filterSalary(cardMinSalary, cardMaxSalary)) {
                        shouldDisplay = true;
                    }
                    if (selectedCategories.length === 0 && selectedLocations.length === 0 && filterSalary(
                            cardMinSalary, cardMaxSalary)) {
                        shouldDisplay = true;
                    }
                }

                if (shouldDisplay) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
@endsection
