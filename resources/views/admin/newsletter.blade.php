@extends('layouts.appmin')
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
        <div class="col-auto col-md-6 col-sm-8">
            <div class="table-responsive">
                <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
                    data-show-columns="true">
                    <thead>
                        <tr class="tr-class-1">
                            <th data-field="name" data-sortable="true">Naam</th>
                            <th data-field="filePath" data-sortable="true">File</th>
                            <th data-field="delete" data-sortable="false">Verwijderen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($newsletter as $file)
                            <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                <td data-value="{{ $file->name }}">{{ $file->name }}</td>
                                <td data-value="{{ $file->filePath }}">{{ $file->filePath }}</td>
                                <td data-value="{{ $file->id }}">
                                    <form method="post" action="/admin/newsletter/delete">@csrf<input type="hidden"
                                            name="id" id="id" value="{{ $file->id }}"><button type="submit"
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
        <div id="contact" class="col-auto col-md-6 col-sm-8">
            @if (session()->has('message'))
                <div class="alert alert-primary">
                    {{ session()->get('message') }}
                </div>
            @endif
            <form method="POST" action="newsletter/store" enctype="multipart/form-data">
                @csrf
                <br>
                <h2 class="h2">File toevoegen</h2>

                <div class="form-group">
                    <label for="name">Naam*</label>
                    <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}"
                        type="text" id="name" name="name" placeholder="Naam...">
                </div>

                <label for="filePath">File (pdf)*</label>
                <div class="input-group mb-3 test">
                    <div class="input-group-prepend">
                        <div class="mb-3">
                            <input class="form-control" type="file" id="filePath" name="filePath">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <input class="btn btn-primary py-3" type="submit" value="Toevoegen">
                </div>
            </form>
        </div>
    </div>
@endsection
