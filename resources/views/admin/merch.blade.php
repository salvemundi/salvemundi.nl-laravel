@extends('layouts.appmin')
@section('title', 'Admin | Merch – ' . config('app.name'))

@section('content')

    <script>
        function CopyMe(oFileInput, sTargetID) {
            document.getElementById(sTargetID).value = oFileInput.value;
        }
    </script>
    <div class="row widthFix adminOverlap center removeAutoMargin">
        @include('include.messageStatus')
        <div class="col-auto col-md-6 col-sm-8">
            <div class="table-responsive">
                <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
                    data-show-columns="true">
                    <thead>
                        <tr class="tr-class-1">
                            <th data-field="name" data-sortable="true">Naam</th>
                            <th data-field="price" data-sortable="true">Prijs</th>
                            <th data-field="discount" data-sortable="true">Korting</th>
                            <th data-field="inventory" data-sortable="false">Inventaris</th>
                            <th data-field="delete" data-sortable="false">Verwijderen</th>
                            <th data-field="edit" data-sortable="false">Bewerken</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $merch)
                            <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                <td data-value="{{ $merch->name }}">{{ $merch->name }}</td>
                                <td data-value="{{ $merch->price }}">{{ $merch->price }}</td>
                                <td data-value="{{ $merch->discount }}">{{ $merch->discount }}</td>
                                <td data-value="{{ $merch->id }}"><a href="/admin/merch/inventory/{{ $merch->id }}"
                                        class="btn btn-primary">Inventaris</a></td>
                                <td data-value="{{ $merch->id }}">
                                    <form method="post" action="/admin/merch/delete/{{ $merch->id }}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Verwijderen</button>
                                    </form>
                                </td>
                                <td data-value="{{ $merch->id }}">
                                    <a href="/admin/merch/edit/{{ $merch->id }}" class="btn btn-primary">Bewerken</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row widthFix adminOverlap center removeAutoMargin">
        <div id="contact" class="col-auto col-md-4 col-sm-8">
            <form method="POST" action="/admin/merch/store" enctype="multipart/form-data">
                @csrf
                <br>
                <h2 class="h2">Merch toevoegen</h2>

                <div class="form-group">
                    <label for="year">Naam*</label>
                    <input class="form-control{{ $errors->has('year') ? ' is-invalid' : '' }}" value="{{ old('year') }}"
                        type="text" id="name" name="name" placeholder="Naam...">
                </div>

                <div class="form-group">
                    <label for="year">Prijs*</label>
                    <input class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}"
                        value="{{ old('year') }}" type="number" step="0.01" id="price" name="price"
                        placeholder="Prijs...">
                </div>

                <div class="form-group">
                    <label for="year">Beschrijving*</label>
                    <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" type="text" id="desciption"
                        name="description" placeholder="Beschrijving...">{{ old('year') }}</textarea>
                </div>

                <label for="filePath">Foto</label>
                <div class="input-group mb-3 test">
                    <div class="input-group-prepend">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Upload merch foto</label>
                            <input class="form-control" type="file" id="filePath" name="filePath">
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
