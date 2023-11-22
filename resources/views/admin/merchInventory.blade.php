@extends('layouts.appmin')
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
                        <th data-field="name" data-sortable="true">Maat</th>
                        <th data-field="price" data-width="800" data-sortable="true">Pasvorm</th>
                        <th data-field="discount" data-width="200" data-sortable="true">Aantal in inventaris</th>
                        <th data-field="delete" data-width="200" data-sortable="true">Verwijderen</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($merch->merchSizes as $size)
                        <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                            <td data-value="{{ $size->size }}">{{ $size->size }}</td>
                            <td data-value="{{ $size->merch_gender }}">{{ App\Enums\MerchGender::coerce($size->merch_gender)->description }}</td>
                            <td data-value="{{ $size->pivot->amount }}">
                                <div class="d-flex">
                                    <input type="number" value="{{ $size->pivot->amount }}" class="form-control text-center me-3"/>
                                    <button type="submit" class="btn-primary btn">Opslaan</button>
                                </div>
                            </td>
                            <td data-value="{{$size->id}}">
                                <button type="submit" class="btn btn-danger">Verwijder</button>
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
