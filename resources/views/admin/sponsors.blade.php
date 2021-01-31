@extends('layouts.appmin')
@section('content')

<div class="adminOverlap">

    <div class="row">

        <div class="col-md-12">

            <div class="table-responsive">

                <table
                       id="table"
                       data-toggle="table"
                       data-search="true"
                       data-sortable="true"
                       data-pagination="true"
                       data-show-columns="true">
                    <thead>
                        <tr class="tr-class-1">
                            <th data-field="name" data-sortable="true">Naam</th>
                            <th data-field="reference" data-sortable="true">Referentie</th>
                            <th data-field="imgPath" data-sortable="true">Foto pad</th>
                            <th data-field="delete" data-sortable="false">Verwijderen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sponsors as $sponsor)
                                <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                    <td data-value="{{ $sponsor->name }}">{{$sponsor->name}}</td>
                                    <td data-value="{{ $sponsor->reference }}">{{$sponsor->reference}}</td>
                                    <td data-value="{{ $sponsor->imagePath }}">{{$sponsor->imagePath}}</td>
                                    <td data-value="{{ $sponsor->id }}"><form method="post" action="/admin/sponsors/delete">@csrf<input type="hidden" name="id" id="id" value="{{ $sponsor->id }}"><button type="submit" class="btn btn-danger">Verwijderen</button></form></td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function CopyMe(oFileInput, sTargetID) {
        document.getElementById(sTargetID).value = oFileInput.value;
    }
</script>
<div class="adminOverlap center">
<div id="contact" class="col-md-6">
    @if(session()->has('message'))
        <div class="alert alert-primary">
            {{ session()->get('message') }}
        </div>
    @endif
    <form action="/admin/sponsors/add/store" method="post" enctype="multipart/form-data">
        @csrf
        <br>
        <h2 class="h2">Sponsor toevoegen</h2>

            <br>
            <label for="name">Naam</label>
            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" type="text" id="name" name="name" placeholder="Naam...">

            <br>
            <label for="reference">Referentie / Website</label>
            <input class="form-control{{ $errors->has('reference') ? ' is-invalid' : '' }}" value="{{ old('reference') }}" type="text" id="reference" name="reference" placeholder="Referentie / Website...">

            <br>
            <label for="photo">Foto</label>
            <div class="input-group mb-3 test">
                <div class="input-group-prepend">
                    <div class="custom-file" style="width: 80px;">
                        <label class="input-group-text form-control" id="inputGroupFileAddon01" for="photo">Browse </label>
                        <input type="file" onchange="CopyMe(this, 'txtFileName');" class="custom-file-input" style="height: 0px;" id="photo" name="photo" aria-describedby="inputGroupFileAddon01">
                    </div>
                </div>
                <div class="custom-file form-control">
                    <input style="border: hidden;" id="txtFileName" type="text" readonly="readonly" />
                </div>
            </div>

            <br>
            <input class="btn btn-primary" type="submit" value="Toevoegen">
    </form>
</div>
</div>
@endsection
