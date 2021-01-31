@extends('layouts.appmin')
@section('content')
<script>
    function CopyMe(oFileInput, sTargetID) {
        document.getElementById(sTargetID).value = oFileInput.value;
    }

</script>
{{-- <script src="extensions/resizable/bootstrap-table-resizable.js"></script> --}}
<div class="row center adminOverlap">
    <div class="row">
        <div class="col-md-12 center">

            <div class="table-responsive center" >

                <table
                       id="table"
                       data-toggle="table"
                       data-search="true"
                       data-sortable="true"
                       data-pagination="true"
                       data-show-columns="true">
                    <thead>
                        <tr class="tr-class-1">
                            <th data-field="title" data-sortable="true" data-width="250">Titel</th>
                            <th data-field="content" data-sortable="true">Inhoud</th>
                            <th data-field="imgPath" data-sortable="true" data-width="250">Foto pad</th>
                            <th data-field="delete" data-sortable="false">Verwijderen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($news as $nieuws)
                                <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                    <td data-value="{{ $nieuws->title }}">{{$nieuws->title}}</td>
                                    <td data-value="{{ $nieuws->content }}">{{$nieuws->content}}</td>
                                    <td data-value="{{ $nieuws->imgPath }}">{{$nieuws->imgPath}}</td>
                                    <td data-value="{{ $nieuws->id }}"><form method="post" action="/admin/news/delete">@csrf<input type="hidden" name="id" value="{{ $nieuws->id }}"><button type="submit" class="btn btn-danger">Verwijderen</button></form></td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row center adminOverlap mijnSlider">
    <div id="contact" class="col-md-6">
        @if(session()->has('message'))
        <div class="alert alert-primary">
            {{ session()->get('message') }}
        </div>
        @endif
        @if(session()->has('information'))
        <div class="alert alert-success">
            {{ session()->get('information') }}
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
                <label for="photo">Foto (optioneel)</label>
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
