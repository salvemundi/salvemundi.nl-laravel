@extends('layouts.appmin')
@section('content')
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

            <div class="test">
                <br>
                <label for="name">Naam</label>
                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" type="text" id="name" name="name" placeholder="Voornaam...">
            </div>

            <div class="test">
                <br>
                <label for="reference">Referentie / Website</label>
                <input class="form-control{{ $errors->has('reference') ? ' is-invalid' : '' }}" value="{{ old('reference') }}" type="text" id="reference" name="reference" placeholder="Tussenvoegsel...">
            </div>

            <div class="test">
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
            </div>

            <div class="test">
                <br>
                <input class="btn btn-primary" type="submit" value="Toevoegen">
            </div>
        </form>
    </div>
</div>

@endsection
