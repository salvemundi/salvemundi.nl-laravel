@extends('layouts.appmin')
@section('title', 'Admin | Merch inventaris – ' . config('app.name'))
@section('content')
    <script>
        function CopyMe(oFileInput, sTargetID) {
            document.getElementById(sTargetID).value = oFileInput.value;
        }
    </script>
    <div class="row widthFix adminOverlap center removeAutoMargin">
        <div class="col-auto col-md-6 col-sm-8">
            @include('include.messageStatus')
            <a class="btn-primary btn mt-2" href="/admin/merch"><i class="fas fa-arrow-left"></i> Terug</a>
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
                                <td data-value="{{ $size->merch_gender }}">
                                    {{ App\Enums\MerchGender::coerce($size->pivot->merch_gender)->description }}</td>
                                <td data-value="{{ $size->pivot->amount }}">
                                    <form method="post"
                                        action="/admin/merch/inventory/{{ $merch->id }}/save/{{ $size->id }}">
                                        @csrf
                                        <div class="d-flex">
                                            <input name="amount" type="number" min=0 value="{{ $size->pivot->amount }}"
                                                class="form-control text-center me-3" />
                                            <button type="submit" class="btn-primary btn">Opslaan</button>
                                        </div>
                                    </form>
                                </td>
                                <td data-value="{{ $size->id }}">
                                    <form method="post"
                                        action="/admin/merch/inventory/{{ $merch->id }}/delete/{{ $size->id }}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Verwijder</button>
                                    </form>
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
            <form method="POST" action="/admin/merch/inventory/{{ $merch->id }}/attach" enctype="multipart/form-data">
                @csrf
                <br>
                <h2 class="h2">Maat koppelen</h2>

                <div class="form-group">
                    <label for="size">Maat*</label>
                    <select class="form-select" name="size" aria-label="Default select example">
                        @foreach ($allSizes as $size)
                            <option value="{{ $size->id }}">{{ $size->size }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="year">Aantal*</label>
                    <input class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}"
                        value="{{ old('amount') }}" type="number" id="amount" name="amount" placeholder="Aantal...">
                </div>

                <div class="form-group">
                    <label for="gender">Pasvorm*</label>
                    <select class="form-select" name="gender" aria-label="Default select example">
                        @foreach (App\Enums\MerchGender::asSelectArray() as $key => $gender)
                            <option value="{{ $key }}">{{ $gender }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group py-3">
                    <input class="btn btn-primary" type="submit" value="Toevoegen">
                </div>
            </form>
        </div>
    </div>
@endsection
