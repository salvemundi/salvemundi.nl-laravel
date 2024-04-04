@extends('layouts.appmin')
@section('title', 'Admin | Merch – ' . config('app.name'))

@section('content')

<script>
    function CopyMe(oFileInput, sTargetID) {
        document.getElementById(sTargetID).value = oFileInput.value;
    }
</script>
<div class="row widthFix adminOverlap center removeAutoMargin">
    <div class="col-auto col-md-6 col-sm-8">
        @include('include.messageStatus')
        <a class="btn-primary btn mt-4" href="/admin/merch/orders"><i class="fas fa-list"></i> Alle bestellingen</a>
        <div class="table-responsive">
            <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true" data-show-columns="true">
                <thead>
                    <tr class="tr-class-1">
                        <th data-field="name" data-sortable="true">Naam</th>
                        <th data-field="price" data-sortable="true">Prijs</th>
                        <th data-field="discount" data-sortable="true">Korting</th>
                        <th data-field="inventory" data-sortable="false">Inventaris</th>
                        <th data-field="edit" data-sortable="false">Bewerken</th>
                        <th data-field="delete" data-sortable="false">Verwijderen</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $merch)
                    <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                        <td data-value="{{ $merch->name }}">{{ $merch->name }}</td>
                        <td data-value="{{ $merch->price }}">{{ $merch->price }}</td>
                        <td data-value="{{ $merch->discount }}">{{ $merch->discount }}</td>
                        <td data-value="{{ $merch->id }}"><a href="/admin/merch/inventory/{{ $merch->id }}" class="btn btn-primary">Inventaris</a></td>
                        <td data-value="{{ $merch->id }}">
                            <a href="/admin/merch/edit/{{ $merch->id }}" class="btn btn-primary">Bewerken</a>
                        </td>
                        <td data-value="{{ $merch->id }}">
                            <form method="post" action="/admin/merch/delete/{{ $merch->id }}">
                                @csrf
                                <button type="submit" class="btn btn-danger">Verwijderen</button>
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
        <form method="POST" action="/admin/merch/store" enctype="multipart/form-data">
            @csrf
            <br>
            <h2 class="h2">Merch toevoegen</h2>

            <div class="form-group">
                <label for="year">Naam*</label>
                <input class="form-control{{ $errors->has('year') ? ' is-invalid' : '' }}" value="{{ old('year') }}" type="text" id="name" name="name" placeholder="Naam...">
            </div>

            <div class="form-group">
                <label for="year">Prijs*</label>
                <input class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{ old('year') }}" type="number" step="0.01" id="price" name="price" placeholder="Prijs...">
            </div>

            <div class="form-group">
                <label for="year">Beschrijving*</label>
                <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" type="text" id="desciption" name="description" placeholder="Beschrijving...">{{ old('year') }}</textarea>
            </div>

            <div class="input-group mb-3 test">
                <div class="input-group-prepend">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Upload merch foto</label>
                        <input class="form-control" type="file" id="filePath" name="filePath">
                    </div>
                </div>
            </div>
            <div class="input-group mb-3 test">
                <input class="inp-cbx" id="cbx3" name="isPreOrder" type="checkbox" style="display: none" />
                <label class="cbx" for="cbx3"><span>
                        <svg width="12px" height="10px" viewbox="0 0 12 10">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                        </svg></span><span>Dit product is op basis van pre orders.</span></label>
            </div>
            <div class="input-group mb-3 test">
                <input class="inp-cbx" id="cbx1" name="preOrderNeedsPayment" type="checkbox" style="display: none" />
                <label class="cbx" for="cbx1"><span>
                        <svg width="12px" height="10px" viewbox="0 0 12 10">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                        </svg></span><span>Pre order betalingen aan / uit.</span></label>
            </div>

            <div class="form-group">
                <label for="gender">Type*</label>
                <select id="typeSelect" class="form-select" name="type"
                        aria-label="Default select example">
                    @foreach (App\Enums\MerchType::asSelectArray() as $key => $type)
                        <option value="{{ $key }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <label for="year">Aantal orders voor pre order notificatie (als de optie hierboven aan staat)*</label>
                <input class="form-control{{ $errors->has('amountPreOrdersBeforeNotification') ? ' is-invalid' : '' }}" value="{{ old('year') }}" type="number" min="0" id="price" name="amountPreOrdersBeforeNotification" placeholder="Aantal voor notificatie...">
            </div>

            <div class="form-group py-3">
                <input class="btn btn-primary" type="submit" value="Toevoegen">
            </div>
        </form>
    </div>
</div>
@endsection
