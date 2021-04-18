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
                        <th data-field="name" data-sortable="true">Activiteit naam</th>
                        <th data-field="price" data-sortable="true">Prijs</th>
                        <th data-field="description" data-sortable="true">Beschrijving</th>
                        <th data-field="link" data-sortable="true">Forms link</th>
                        <th data-field="imgPath" data-sortable="true" data-width="250">Foto pad</th>
                        <th data-field="edit" data-sortable="false">Bewerken</th>
                        <th data-field="delete" data-sortable="false">Verwijderen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($activities as $activity)
                        <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                            <td data-value="{{ $activity->name }}">{{$activity->name}}</td>
                            <td data-value="{{ $activity->amount }}">{{$activity->amount}}</td>
                            <td data-value="{{ $activity->description }}">{{Illuminate\Support\Str::limit($activity->description, 100)}}</td>
                            <td data-value="{{ $activity->formsLink }}">{{Illuminate\Support\Str::limit($activity->formsLink, 20)}}</td>
                            <td data-value="{{ $activity->imgPath }}">{{$activity->imgPath}}</td>
                            <td data-value="{{ $activity->id }}"><form method="post" action="/admin/activities/edit">@csrf<input type="hidden" name="id" id="id" value="{{ $activity->id }}"><button type="submit" class="btn btn-primary">Bewerken</button></form></td>
                            <td data-value="{{ $activity->id }}"><form method="post" action="/admin/activities/delete">@csrf<input type="hidden" name="id" id="id" value="{{ $activity->id }}"><button type="submit" class="btn btn-danger">Verwijderen</button></form></td>
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
        <form action="/admin/activities/store" method="post" enctype="multipart/form-data">
            @csrf
            <br>
            <h2 class="h2">Activiteit toevoegen</h2>
            <p>Als de prijs 0.00 is dan wordt de activiteit als gratis geregistreerd.</p>

            <div class="form-group">
                <label for="name">Activiteit naam*</label>
                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" id="name" name="name" placeholder="Naam...">
            </div>

            <div class="form-group">
                <label for="link">Microsft forms link</label>
                <input class="form-control{{ $errors->has('link') ? ' is-invalid' : '' }}" value="{{ old('link') }}" id="link" name="link" placeholder="Forms link...">
            </div>

            <div class="form-group">
                <label for="Achternaam">Prijs*</label>
                <input type="number" min="0" step=".01" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{ old('price') }}" id="price" name="price" placeholder="Prijs...">
            </div>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">Beschrijving</label>
                <textarea type="textarea" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" placeholder="Beschrijving...">{{{ old('description') }}}</textarea>
            </div>

            <label for="photo">Foto</label>
            <div class="input-group mb-3 test">
                <div class="input-group-prepend">
                    <div class="custom-file" style="width: 80px;">
                        <label class="input-group-text form-control" id="inputGroupFileAddon01" for="photo">Browse </label>
                        <input type="file" onchange="CopyMe(this, 'imgPath');" class="custom-file-input" style="height: 0px;" id="photo" name="photo" aria-describedby="inputGroupFileAddon01">
                    </div>
                </div>
                <div class="custom-file form-control">
                    <input style="border: hidden;" id="imgPath" name="imgPath" type="text" readonly="readonly" />
                </div>
            </div>

            <div class="form-group">
                <br>
                <input class="btn btn-primary" type="submit" value="Toevoegen">
            </div>
        </form>
    </div>
</div>
@endsection
