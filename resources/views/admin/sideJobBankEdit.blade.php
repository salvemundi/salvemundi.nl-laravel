@extends('layouts.appmin')
@section('title', 'Admin | Bijbanen bank – ' . config('app.name'))
@section('content')
    {{-- <script>
    function CopyMe(oFileInput, sTargetID) {
        document.getElementById(sTargetID).value = oFileInput.value;
    }
</script> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">

    <div class="row widthFix adminOverlap center removeAutoMargin">
        @if (session()->has('information'))
            <div class="alert alert-primary">
                {{ session()->get('information') }}
            </div>
        @endif

        <div id="contact" class="col-auto col-md-6 col-sm-12">
            @if (session()->has('message'))
                <div class="alert alert-primary">
                    {{ session()->get('message') }}
                </div>
            @endif

            <form action="/admin/bijbaanbank/edit/store" method="post" enctype="multipart/form-data">
                @csrf
                <br>
                <h2 class="h2">Bijbaan updaten</h2>
                <input type="hidden" value="{{ $sideJobBank->id }}" name="id" id="id">

                <div class="form-group">
                    <label for="voornaam">Bijbaan naam</label>
                    <input type="text" required class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                        value="{{ $sideJobBank->name }}" id="name" name="name" placeholder="Bijbaan naam...">
                </div>
                <div class="form-group">
                    <label for="position">Positie</label>
                    <input type="text" class="form-control{{ $errors->has('position') ? ' is-invalid' : '' }}"
                        value="{{ $sideJobBank->position }}" id="position" name="position" placeholder="Positie...">
                </div>
                <div class="form-group">
                    <label for="name">Link naar vacature*</label>
                    <input type="text" class="form-control{{ $errors->has('link') ? ' is-invalid' : '' }}"
                        value="{{ $sideJobBank->linkToJobOffer }}" id="link" name="link" placeholder="Link...">
                </div>

                <div class="form-group mb-2">
                    <label for="name">Skills* (ctrl click to deselect)</label>
                    <select id="skills" name="skills[]" class="form-select" multiple
                        aria-label="multiple select example">
                        @foreach ($sideJobSkills as $skill)
                            @if ($sideJobBank->skills->contains($skill))
                                <option selected value="{{ $skill->id }}">{{ $skill->name }}</option>
                            @else
                                <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-2">
                    <label for="city">Stad*</label>
                    <input type="text" list="cityOptions"
                        class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}"
                        value="{{ $sideJobBank->city }}" id="city" name="city" placeholder="Eindhoven...">
                    <datalist id="cityOptions">
                        @foreach ($allSideJobBank->unique('city') as $job)
                            <option value="{{ $job->city }}">
                        @endforeach
                    </datalist>
                </div>

                <div class="input-group mb-2">
                    <span class="input-group-text">Min / max salaris per uur</span>
                    <input type="number" step=".01" value="{{ $sideJobBank->minSalaryEuroBruto }}"
                        name="minimumSalary" aria-label="Minimum" class="form-control">
                    <input type="number" step=".01" value="{{ $sideJobBank->maxSalaryEuroBruto }}"
                        name="maximumSalary" aria-label="Maximum" class="form-control">
                </div>

                <div class="input-group mt-2">
                    <span class="input-group-text">Min / max aantal uren</span>
                    <input type="number" step=".1" value="{{ $sideJobBank->minAmountOfHoursPerWeek }}"
                        name="minimumHours" aria-label="Minimum" class="form-control">
                    <input type="number" step=".1" value="{{ $sideJobBank->maxAmountOfHoursPerWeek }}"
                        name="maximumHours" aria-label="Maximum" class="form-control">
                </div>

                <label for="voornaam">Studie richting*</label>
                <select class="form-control" name="studyProfile">
                    <option selected value="{{ $sideJobBank->studyProfile }}">
                        {{ \App\Enums\StudyProfile::coerce($sideJobBank->studyProfile)->description }}</option>
                    @foreach (\App\Enums\StudyProfile::getInstances() as $item)
                        @if ($sideJobBank->studyProfile != $item->value)
                            <option value="{{ $item->value }}">{{ $item->description }}</option>
                        @endif
                    @endforeach
                </select>
                <div class="form-group">
                    <label for="email">Email contact</label>
                    <input type="email" value="{{ $sideJobBank->emailContact }}"
                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email"
                        placeholder="Email...">
                </div>
                <div class="form-group">
                    <label for="phoneNumber">Telefoonnummer</label>
                    <input type="text" value="{{ $sideJobBank->phoneNumberContact }}"
                        class="form-control{{ $errors->has('phoneNumber') ? ' is-invalid' : '' }}" id="phoneNumber"
                        name="phoneNumber" placeholder="Naam...">
                </div>
                <div class="form-group mb-2">
                    <label for="hours">Bijbaan omschrijving</label>
                    <textarea type="textarea" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                        name="description" placeholder="Omschrijving...">{{ $sideJobBank->description }}</textarea>
                </div>

                <div class="form-group">
                    <input class="btn btn-primary text-white" type="submit" value="Bewerken">
                </div>
            </form>
            <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
            <script>
                new MultiSelectTag('skills') // id
            </script>
        </div>
    </div>
@endsection
