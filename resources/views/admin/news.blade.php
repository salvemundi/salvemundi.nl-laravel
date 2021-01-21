@extends('layouts.appmin')
@section('content')
<script>
    function CopyMe(oFileInput, sTargetID) {
        document.getElementById(sTargetID).value = oFileInput.value;
    }
</script>
<div class="row center adminOverlap">
    <div id="contact" class="col-md-6">
        @if(session()->has('message'))
        <div class="alert alert-primary">
            {{ session()->get('message') }}
        </div>
        @endif
        <form action="/admin/news/store" method="post" enctype="multipart/form-data">
            @csrf
            <br>
            <h2 class="h2">Nieuws toevoegen</h2>

            <div class="form-group">
                <label for="voornaam">Titel</label>
                <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}" id="title" name="title" placeholder="Titel...">
            </div>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">Inhoud</label>
                <textarea type="textarea" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" name="content" placeholder="Inhoud...">{{{ old('content') }}}</textarea>
            </div>

            <div class="form-group">
                <br>
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
            </div>

            <div class="form-group">
                <br>
                <input class="btn btn-primary" type="submit" value="Versturen">
            </div>
        </form>
    </div>
</div>

@endsection
