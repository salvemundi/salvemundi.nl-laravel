@extends('layouts.appmin')
@section('content')
<div class="row widthFix adminOverlap center removeAutoMargin">
    <div id="contact" class="col-auto col-lg-6 col-md-6 col-sm-8 mb-2">
        @if(session()->has('message'))
        <div class="alert alert-primary">
            {{ session()->get('message') }}
        </div>
        @endif
        <form action="/admin/clubs/store" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ $clubs->id }}" name="id" id="id">
            <br>
            <h2 class="h2">Club bewerken</h2>

            <div class="form-group">
                <label for="voornaam">Club naam*</label>
                <input class="form-control{{ $errors->has('clubName') ? ' is-invalid' : '' }}" value="{{ $clubs->clubName }}" id="clubName" name="clubName" placeholder="Club naam...">
            </div>

            <div class="form-group">
                <label for="voornaam">Bijnaam</label>
                <input class="form-control{{ $errors->has('nickName') ? ' is-invalid' : '' }}" value="{{ $clubs->nickName }}" id="nickName" name="nickName" placeholder="Bijnaam...">
            </div>

            <div class="form-group">
                <label for="voornaam">Naam oprichter</label>
                <input class="form-control{{ $errors->has('founderName') ? ' is-invalid' : '' }}" value="{{ $clubs->founderName }}" id="founderName" name="founderName" placeholder="Naam oprichter...">
            </div>

            <div class="form-group">
                <label for="voornaam">Whatsapp link*</label>
                <input class="form-control{{ $errors->has('whatsappLink') ? ' is-invalid' : '' }}" value="{{ $clubs->whatsappLink }}" id="whatsappLink" name="whatsappLink" placeholder="WhatsApp link...">
            </div>

            <div class="form-group">
                <label for="description">Omschrijving</label>
                <textarea class="form-control" value="{{{ old('description') }}}" type="textarea" id="description" name="description" placeholder="Omschrijving...">{{{ $clubs->description }}}</textarea>
            </div>

            <div class="form-group">
                <label for="voornaam">Discord link</label>
                <input class="form-control{{ $errors->has('discordLink') ? ' is-invalid' : '' }}" value="{{ $clubs->discordLink }}" id="discordLink" name="discordLink" placeholder="Discord link...">
            </div>

            <div class="form-group">
                <label for="voornaam">Andere link</label>
                <input class="form-control{{ $errors->has('otherLink') ? ' is-invalid' : '' }}" value="{{ $clubs->otherLink }}" id="otherLink" name="otherLink" placeholder="Andere link...">
            </div>

            <label for="photo">Foto</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="custom-file" style="width: 80px;">
                        <label class="input-group-text form-control" id="inputGroupFileAddon01" for="photo">Browse </label>
                        <input type="file" onchange="CopyMe(this, 'imgPath');" class="custom-file-input" style="height: 0px;" id="photo" name="photo" aria-describedby="inputGroupFileAddon01">
                    </div>
                </div>
                <div class="custom-file form-control">
                    <input style="border: hidden;" id="imgPath" name="imgPath" value="{{ $clubs->imgPath }}" type="text" readonly="readonly" />
                </div>
            </div>

            <div class="form-group">
                <input class="btn btn-primary" type="submit" value="Bewerken">
            </div>
        </form>
    </div>
</div>
@endsection
