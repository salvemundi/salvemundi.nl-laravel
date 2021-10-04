@extends('layouts.appmin')
@section('content')
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
        <div class="table-responsive">
            <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
                data-show-columns="true">
                <thead>
                    <tr class="tr-class-1">
                        <th data-field="year" data-sortable="true">Jaar</th>
                        <th data-field="bestuur" data-sortable="true">bestuur</th>
                        <th data-field="fotoPath" data-sortable="true">Foto pad</th>
                        <th data-field="delete" data-sortable="false">Verwijderen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($previousBoard as $bestuur)
                        <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                            <td data-value="{{ $bestuur->year }}">{{$bestuur->year}}</td>
                            <td data-value="{{ $bestuur->bestuur }}">{{$bestuur->bestuur}}</td>
                            <td data-value="{{ $bestuur->fotoPath }}">{{$bestuur->fotoPath}}</td>
                            <td data-value="{{ $bestuur->id }}"><form method="post" action="/admin/oud-bestuur/delete">@csrf<input type="hidden" name="id" id="id" value="{{ $bestuur->id }}"><button type="submit" class="btn btn-danger">Verwijderen</button></form></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row widthFix adminOverlap center removeAutoMargin">
    <div id="contact" class="col-auto col-md-4 col-sm-8">
        @if(session()->has('message'))
        <div class="alert alert-primary">
            {{ session()->get('message') }}
        </div>
        @endif
        <form action="/admin/oud-bestuur/store" method="post" enctype="multipart/form-data">
            @csrf
            <br>
            <h2 class="h2">Bestuur toevoegen</h2>

            <div class="form-group">
                <label for="name">Jaar*</label>
                <input class="form-control{{ $errors->has('year') ? ' is-invalid' : '' }}" value="{{ old('year') }}" type="number" id="year" name="year" placeholder="Jaar...">
            </div>

            <div class="form-group">
                <label for="reference">Bestuur*</label>
                <textarea class="form-control{{ $errors->has('bestuur') ? ' is-invalid' : '' }}" value="{{ old('bestuur') }}" type="text" id="bestuur" name="bestuur" placeholder="Bestuur..."></textarea>
            </div>

            <label for="photo">Foto</label>
            <div class="input-group mb-3 test">
                <div class="input-group-prepend">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Upload bestuurs foto</label>
                        <input class="form-control" type="file" id="fotoPath" name="fotoPath">
                    </div>
                </div>
            </div>

            <div class="form-group py-3">
                <input class="btn btn-primary" type="submit" value="Toevoegen">
            </div>
        </form>
    </div>
</div>
@endsection
