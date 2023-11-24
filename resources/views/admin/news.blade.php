@extends('layouts.appmin')
@section('title', 'Admin | Nieuws – ' . config('app.name'))
@section('content')
    <script>
        function CopyMe(oFileInput, sTargetID) {
            document.getElementById(sTargetID).value = oFileInput.value;
        }
    </script>
    <div class="row widthFix adminOverlap center removeAutoMargin">
        @if (session()->has('information'))
            <div class="alert alert-primary">
                {{ session()->get('information') }}
            </div>
        @endif
        <div class="col-auto col-md-8 col-sm-8">
            <div class="table-responsive">
                <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
                    data-show-columns="true">
                    <thead>
                        <tr class="tr-class-1">
                            <th data-field="title" data-sortable="true" data-width="250">Titel</th>
                            <th data-field="content" data-sortable="true">Inhoud</th>
                            <th data-field="imgPath" data-sortable="true" data-width="250">Foto pad</th>
                            <th data-field="update" data-sortable="false">Bewerken</th>
                            <th data-field="delete" data-sortable="false">Verwijderen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($news as $nieuws)
                            <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                <td data-value="{{ $nieuws->title }}">{{ $nieuws->title }}</td>
                                <td data-value="{{ $nieuws->content }}">{{ $nieuws->content }}</td>
                                <td data-value="{{ $nieuws->imgPath }}">{{ $nieuws->imgPath }}</td>
                                <td data-value="{{ $nieuws->id }}">
                                    <form method="post" action="/admin/news/edit">@csrf<input type="hidden" name="id"
                                            value="{{ $nieuws->id }}"><button type="submit"
                                            class="btn btn-primary">Bewerken</button></form>
                                </td>
                                <td data-value="{{ $nieuws->id }}">
                                    <form method="post" action="/admin/news/delete">@csrf<input type="hidden"
                                            name="id" value="{{ $nieuws->id }}"><button type="submit"
                                            class="btn btn-danger">Verwijderen</button></form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row widthFix adminOverlap center removeAutoMargin">
        <div id="contact" class="col-auto col-lg-6 col-md-6 col-sm-8">
            @if (session()->has('message'))
                <div class="alert alert-primary">
                    {{ session()->get('message') }}
                </div>
            @endif
            <form action="/admin/news/store" method="post" enctype="multipart/form-data">
                @csrf
                <br>
                <h2 class="h2">Nieuws toevoegen</h2>

                <div class="form-group">
                    <label for="voornaam">Titel*</label>
                    <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                        value="{{ old('title') }}" id="title" name="title" placeholder="Titel...">
                </div>

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Inhoud*</label>
                    <textarea type="textarea" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" name="content"
                        placeholder="Inhoud...">{{ old('content') }}</textarea>
                </div>

                <label for="photo">Foto</label>
                <div class="input-group mb-3 test">
                    <div class="input-group-prepend">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Upload bijhorende foto</label>
                            <input class="form-control" type="file" id="photo" name="photo">
                        </div>
                    </div>
                </div>

                <div class="form-group mx-auto my-3">
                    <br>
                    <input class="btn btn-primary" type="submit" value="Toevoegen">
                </div>
            </form>
        </div>
    </div>
@endsection
