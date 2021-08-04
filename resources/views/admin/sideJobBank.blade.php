@extends('layouts.appmin')
@section('content')
<script>
    function CopyMe(oFileInput, sTargetID) {
        document.getElementById(sTargetID).value = oFileInput.value;
    }
</script>
<div class="row widthFix adminOverlap mijnSlider center">
    @if(session()->has('information'))
    <div class="alert alert-primary">
        {{ session()->get('information') }}
    </div>
    @endif
    <div class="col-md-12 center">

        <div class="table-responsive center centerTable">

            <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
                data-show-columns="true">
                <thead>
                    <tr class="tr-class-1">
                        <th data-field="name" data-sortable="true" data-width="250">Naam bedrijf</th>
                        <th data-field="studyProfile" data-sortable="true" data-width="250">Studie richting</th>
                        <th data-field="description" data-sortable="true">Omschrijving bijbaan</th>
                        <th data-field="update" data-sortable="false">Bewerken</th>
                        <th data-field="delete" data-sortable="false">Verwijderen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sideJobBank as $job)
                        <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                            <td data-value="{{ $job->name }}">{{$job->name}}</td>
                            <td data-value="{{ $job->studyProfile }}">{{\App\Enums\StudyProfile::coerce($job->studyProfile)->description}}</td>
                            <td data-value="{{ $job->description }}">{{$job->description}}</td>
                            <td data-value="{{ $job->id }}"><form method="post" action="/admin/bijbaanbank/edit">@csrf<input type="hidden" name="id" value="{{ $job->id }}"><button type="submit" class="btn btn-primary">Bewerken</button></form></td>
                            <td data-value="{{ $job->id }}"><form method="post" action="/admin/bijbaanbank/delete">@csrf<input type="hidden" name="id" value="{{ $job->id }}"><button type="submit" class="btn btn-danger">Verwijderen</button></form></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row widthFix center adminOverlap mijnSlider">
    <div id="contact" class="col-md-6">
        @if(session()->has('message'))
        <div class="alert alert-primary">
            {{ session()->get('message') }}
        </div>
        @endif
        <form action="/admin/bijbaanbank/store" method="post" enctype="multipart/form-data">
            @csrf
            <br>
            <h2 class="h2">Bijbaan toevoegen</h2>

            <div class="form-group">
                <label for="voornaam">Naam*</label>
                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" id="name" name="name" placeholder="Naam...">
            </div>

            <label for="voornaam">Studie richting*</label>
            <select class="form-control" name="studyProfile">
                @foreach (\App\Enums\StudyProfile::getInstances() as $item)
                    <option value="{{ $item->value }}">{{$item->description}}</option>
                @endforeach
            </select>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">Omschrijving bijbaan*</label>
                <textarea type="textarea" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" placeholder="omschrijving bijbaan...">{{{ old('description') }}}</textarea>
            </div>

            <div class="form-group">
                <br>
                <input class="btn btn-primary" type="submit" value="Toevoegen">
            </div>
        </form>
    </div>
</div>
@endsection
