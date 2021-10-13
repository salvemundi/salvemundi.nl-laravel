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
    <div class="col-auto col-md-10 col-sm-8">
        <div class="table-responsive">
            <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
                data-show-columns="true">
                <thead>
                    <tr class="tr-class-1">
                        <th data-field="clubName" data-sortable="true" data-width="250">Club naam</th>
                        <th data-field="nickName" data-sortable="true">Bijnaam</th>
                        <th data-field="imgPath" data-sortable="true" data-width="250">Foto pad</th>
                        <th data-field="founderName" data-sortable="false">Oprichter</th>
                        <th data-field="description" data-sortable="false">Omschrijving</th>
                        <th data-field="whatsappLink" data-sortable="false">WhatsApp link</th>
                        <th data-field="discordLink" data-sortable="true">Discord link</th>
                        <th data-field="otherLink" data-sortable="true">Andere link</th>
                        <th data-field="update" data-sortable="false">Bewerken</th>
                        <th data-field="delete" data-sortable="false">Verwijderen</th>
                    </tr>
                </thead>
                <tbody>
                    @if($clubs != null)
                        @foreach ($clubs as $club)
                            <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                <td data-value="{{ $club->clubName }}">{{$club->clubName}}</td>
                                <td data-value="{{ $club->nickName }}">{{$club->nickName}}</td>
                                <td data-value="{{ $club->imgPath }}">{{$club->imgPath}}</td>
                                <td data-value="{{ $club->founderName }}">{{$club->founderName}}</td>
                                <td data-value="{{ $club->description }}">{{Illuminate\Support\Str::limit($club->description, 20)}}</td>
                                <td data-value="{{ $club->whatsappLink }}">{{$club->whatsappLink}}</td>
                                <td data-value="{{ $club->discordLink }}">{{$club->discordLink}}</td>
                                <td data-value="{{ $club->otherLink }}">{{$club->otherLink}}</td>
                                <td data-value="{{ $club->id }}"><form method="post" action="/admin/clubs/edit">@csrf<input type="hidden" name="id" value="{{ $club->id }}"><button type="submit" class="btn btn-primary">Bewerken</button></form></td>
                                <td data-value="{{ $club->id }}"><form method="post" action="/admin/clubs/delete">@csrf<input type="hidden" name="id" value="{{ $club->id }}"><button type="submit" class="btn btn-danger">Verwijderen</button></form></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row widthFix adminOverlap center removeAutoMargin">
    <div id="contact" class="col-auto col-lg-6 col-md-6 col-sm-8 mb-2">
        @if(session()->has('message'))
        <div class="alert alert-primary">
            {{ session()->get('message') }}
        </div>
        @endif
        <form action="/admin/clubs/store" method="post" enctype="multipart/form-data">
            @csrf
            <br>
            <h2 class="h2">Clubs toevoegen</h2>

            <div class="form-group">
                <label for="voornaam">Club naam*</label>
                <input class="form-control{{ $errors->has('clubName') ? ' is-invalid' : '' }}" value="{{ old('clubName') }}" id="clubName" name="clubName" placeholder="Club naam...">
            </div>

            <div class="form-group">
                <label for="voornaam">Bijnaam</label>
                <input class="form-control{{ $errors->has('nickName') ? ' is-invalid' : '' }}" value="{{ old('nickName') }}" id="nickName" name="nickName" placeholder="Bijnaam...">
            </div>

            <div class="form-group">
                <label for="voornaam">Naam oprichter</label>
                <input class="form-control{{ $errors->has('founderName') ? ' is-invalid' : '' }}" value="{{ old('founderName') }}" id="founderName" name="founderName" placeholder="Naam oprichter...">
            </div>

            <div class="form-group">
                <label for="description">Omschrijving</label>
                <textarea class="form-control" value="{{{ old('description') }}}" type="textarea" id="description" name="description" placeholder="Omschrijving..."></textarea>
            </div>

            <div class="form-group">
                <label for="voornaam">Whatsapp link*</label>
                <input class="form-control{{ $errors->has('whatsappLink') ? ' is-invalid' : '' }}" value="{{ old('whatsappLink') }}" id="whatsappLink" name="whatsappLink" placeholder="WhatsApp link...">
            </div>

            <div class="form-group">
                <label for="voornaam">Discord link</label>
                <input class="form-control{{ $errors->has('discordLink') ? ' is-invalid' : '' }}" value="{{ old('discordLink') }}" id="discordLink" name="discordLink" placeholder="Discord link...">
            </div>

            <div class="form-group">
                <label for="voornaam">Andere link</label>
                <input class="form-control{{ $errors->has('otherLink') ? ' is-invalid' : '' }}" value="{{ old('otherLink') }}" id="otherLink" name="otherLink" placeholder="Andere link...">
            </div>

            <div class="input-group mb-3 test">
                <div class="input-group-prepend">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Upload bijhorende foto</label>
                        <input class="form-control" type="file" id="photo" name="photo">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <input class="btn btn-primary" type="submit" value="Toevoegen">
            </div>
        </form>
    </div>
</div>
@endsection
