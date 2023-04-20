@extends('layouts.appmin')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
    <script>
        function CopyMe(oFileInput, sTargetID) {
            document.getElementById(sTargetID).value = oFileInput.value;
        }
    </script>
    <div class="row widthFix adminOverlap center removeAutoMargin">
        @if(session()->has('information'))
            <div class="alert alert-primary">
                {{ session()->get('information') }}
            </div>
        @endif

        <div class="col-auto col-md-6 col-sm-8">
            @if(session()->has('message'))
                <div class="alert alert-primary">
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="table-responsive center centerTable">
                <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
                       data-show-columns="true">
                    <thead>
                    <tr class="tr-class-1">
                        <th data-field="name" data-sortable="true" data-width="250">Naam bedrijf</th>
                        <th data-field="studyProfile" data-sortable="true" data-width="250">Studie richting</th>
                        <th data-field="description" data-sortable="true">Omschrijving bijbaan</th>
                        <th data-field="salary" data-sortable="true">Salaris p.u.</th>
                        <th data-field="hours" data-sortable="true">Aantal uren</th>
                        <th data-field="update" data-sortable="false">Bewerken</th>
                        <th data-field="delete" data-sortable="false">Verwijderen</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($sideJobBank as $skill)
                        <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                            <td data-value="{{ $skill->name }}">{{$skill->name}}</td>
                            <td data-value="{{ $skill->studyProfile }}">{{\App\Enums\StudyProfile::coerce($skill->studyProfile)->description}}</td>
                            <td data-value="{{ $skill->description }}">{{$skill->description}}</td>
                            <td data-value="{{ $skill->minSalaryEuroBruto }}">{{$skill->minSalaryEuroBruto ?? 'Onderhandelbaar'}} @if(isset($skill->minSalaryEuroBruto) && isset($skill->maxSalaryEuroBruto))
                                    t/m
                                @endif {{ $skill->maxSalaryEuroBruto ?? null }}</td>
                            <td data-value="{{ $skill->minAmountOfHoursPerWeek }}">{{$skill->minAmountOfHoursPerWeek ?? 'Onderhandelbaar'}} @if(isset($skill->minAmountOfHoursPerWeek) && isset($skill->maxAmountOfHoursPerWeek))
                                    t/m
                                @endif {{ $skill->maxAmountOfHoursPerWeek ?? null }}</td>
                            <td data-value="{{ $skill->id }}">
                                <form method="post" action="/admin/bijbaanbank/edit">@csrf<input type="hidden" name="id"
                                                                                                 value="{{ $skill->id }}">
                                    <button type="submit" class="btn btn-primary text-white">Bewerken</button>
                                </form>
                            </td>
                            <td data-value="{{ $skill->id }}">
                                <form method="post" action="/admin/bijbaanbank/delete">@csrf<input type="hidden"
                                                                                                   name="id"
                                                                                                   value="{{ $skill->id }}">
                                    <button type="submit" class="btn btn-danger text-white">Verwijderen</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row widthFix adminOverlap center removeAutoMargin">
        <div id="contact" class="col-auto col-md-4 col-sm-8 d-flex">

            <div class="p-2">
                <form action="/admin/bijbaanbank/store" method="post" enctype="multipart/form-data">
                    @csrf
                    <h2 class="h2">Bijbaan toevoegen</h2>

                    <div class="form-group">
                        <label for="name">Naam*</label>
                        <input type="text" required class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                               value="{{ old('name') }}" id="name" name="name" placeholder="Naam...">
                    </div>
                    <div class="form-group">
                        <label for="position">Positie</label>
                        <input type="text" class="form-control{{ $errors->has('position') ? ' is-invalid' : '' }}"
                               value="{{ old('position') }}" id="position" name="position" placeholder="Positie...">
                    </div>
                    <div class="form-group">
                        <label for="name">Link naar vacature*</label>
                        <input type="text" class="form-control{{ $errors->has('link') ? ' is-invalid' : '' }}"
                               value="{{ old('link') }}" id="link" name="link" placeholder="Link...">
                    </div>

                    <div class="form-group mb-2">
                        <label for="name">Skills* (ctrl click to deselect)</label>

                        <select id="skills" name="skills[]" class="form-select" multiple aria-label="multiple select example">
                            @foreach($sideJobSkills as $skill)
                                <option value="{{$skill->id}}">{{$skill->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label for="city">Stad*</label>
                        <input type="text" list="cityOptions"
                               class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}"
                               value="{{ old('city') }}" id="city" name="city" placeholder="Eindhoven...">
                        <datalist id="cityOptions">
                            @foreach ($sideJobBank->unique('city') as $skill)
                                <option value="{{$skill->city}}">
                            @endforeach
                        </datalist>
                    </div>

                    <div class="input-group mb-2">
                        <span class="input-group-text">Min / max salaris per uur</span>
                        <input type="number" step=".01" name="minimumSalary" aria-label="Minimum" class="form-control">
                        <input type="number" step=".01" name="maximumSalary" aria-label="Maximum" class="form-control">
                    </div>

                    <div class="input-group">
                        <span class="input-group-text">Min / max aantal uren</span>
                        <input type="number" step=".1" name="minimumHours" aria-label="Minimum" class="form-control">
                        <input type="number" step=".1" name="maximumHours" aria-label="Maximum" class="form-control">
                    </div>

                    <label for="voornaam">Studie richting*</label>
                    <select class="form-control" name="studyProfile">
                        @foreach (\App\Enums\StudyProfile::getInstances() as $item)
                            <option value="{{ $item->value }}">{{$item->description}}</option>
                        @endforeach
                    </select>
                    <div class="form-group">
                        <label for="email">Email contact</label>
                        <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                               value="{{ old('name') }}" id="email" name="email" placeholder="Email...">
                    </div>
                    <div class="form-group">
                        <label for="phoneNumber">Telefoonnummer</label>
                        <input type="text" class="form-control{{ $errors->has('phoneNumber') ? ' is-invalid' : '' }}"
                               value="{{ old('name') }}" id="phoneNumber" name="phoneNumber" placeholder="Naam...">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Omschrijving bijbaan*</label>
                        <textarea type="textarea"
                                  class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                  name="description"
                                  placeholder="omschrijving bijbaan...">{{{ old('description') }}}</textarea>
                    </div>

                    <div class="form-group py-3">
                        <input class="btn btn-primary text-white" type="submit" value="Toevoegen">
                    </div>
                </form>
            </div>

            <div class="p-2">
                <h2 class="h2">Skill toevoegen</h2>

                <div class="table-responsive center centerTable">
                    <table id="table" data-toggle="table" data-search="true" data-sortable="true"
                           data-pagination="true"
                           data-show-columns="true">
                        <thead>
                        <tr class="tr-class-1">
                            <th data-field="name" data-sortable="true" data-width="250">Naam</th>
                            <th data-field="delete" data-sortable="false">Verwijderen</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($sideJobSkills as $skill)
                            <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                <td data-value="{{ $skill->name }}">{{$skill->name}}</td>
                                <td data-value="{{ $skill->id }}">
                                    <form method="post" action="/admin/skills/delete/{{ $skill->id }}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger text-white">Verwijderen</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <form action="/admin/skills/store" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="name">Naam*</label>
                        <input type="text" required
                               class="form-control{{ $errors->has('skillName') ? ' is-invalid' : '' }}"
                               value="{{ old('skillName') }}" id="skillName" name="skillName" placeholder="Skill...">
                    </div>

                    <div class="form-group py-3">
                        <input class="btn btn-primary text-white" type="submit" value="Toevoegen">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
    <script>
        new MultiSelectTag('skills')  // id
    </script>
@endsection
