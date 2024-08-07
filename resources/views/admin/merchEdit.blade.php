@extends('layouts.appmin')
@section('title', 'Admin | Merch – ' . config('app.name'))
@section('content')
<script>
    function CopyMe(oFileInput, sTargetID) {
        document.getElementById(sTargetID).value = oFileInput.value;
    }
</script>

<div class="row widthFix adminOverlap center removeAutoMargin">
    <div id="contact" class="col-auto col-md-4 col-sm-8">
        @include('include.messageStatus')
        <a class="btn-primary btn mt-2" href="/admin/merch"><i class="fas fa-arrow-left"></i> Terug</a>
        <form method="POST" action="/admin/merch/store/{{ $merch->id }}" enctype="multipart/form-data">
            @csrf
            <br>
            <h2 class="h2">Merch bewerken</h2>

            <div class="form-group">
                <label for="year">Naam*</label>
                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') ?? $merch->name }}" type="text" id="name" name="name" placeholder="Naam...">
            </div>

            <div class="form-group">
                <label for="year">Prijs*</label>
                <input class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{ old('price') ?? $merch->price }}" type="number" step="0.01" id="price" name="price" placeholder="Prijs...">
            </div>

            <div class="form-group">
                <label for="discount">Korting in euros*</label>
                <input class="form-control{{ $errors->has('discount') ? ' is-invalid' : '' }}" value="{{ old('discount') ?? $merch->discount }}" type="number" step="0.01" id="discount" name="discount" placeholder="Korting...">
            </div>

            <div class="form-group">
                <label for="year">Beschrijving*</label>
                <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" type="text" id="desciption" name="description" placeholder="Beschrijving...">{{ old('description') ?? $merch->description }}</textarea>
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
                <input @if($merch->isPreOrder) checked @endif class="inp-cbx" id="cbx3" name="isPreOrder" type="checkbox" style="display: none" />
                <label class="cbx" for="cbx3"><span>
                        <svg width="12px" height="10px" viewbox="0 0 12 10">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                        </svg></span><span>Dit product is op basis van pre orders.</span></label>
            </div>
            <div class="input-group mb-3 test">
                <input @if($merch->preOrderNeedsPayment) checked @endif class="inp-cbx" id="cbx1" name="preOrderNeedsPayment" type="checkbox" style="display: none" />
                <label class="cbx" for="cbx1"><span>
                        <svg width="12px" height="10px" viewbox="0 0 12 10">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                        </svg></span><span>Pre order betalingen aan / uit.</span></label>
            </div>

            <div class="input-group mb-3 test">
                <input @if($merch->canSetNote) checked @endif class="inp-cbx" id="cbx5" name="canSetNote" type="checkbox" style="display: none" />
                <label class="cbx" for="cbx5"><span>
                        <svg width="12px" height="10px" viewbox="0 0 12 10">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                        </svg></span><span>Laat klanten een optionele notitie toevoegen.</span></label>
            </div>

            <div class="form-group">
                <label for="gender">Type*</label>
                <select id="typeSelect" class="form-select" name="type"
                        aria-label="Default select example">
                    @foreach (App\Enums\MerchType::asSelectArray() as $key => $type)
                        <option @if($merch->type == $key) selected @endif value="{{ $key }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="year">Aantal orders voor pre order notificatie (als de optie hierboven aan staat)*</label>
                <input class="form-control{{ $errors->has('amountPreOrdersBeforeNotification') ? ' is-invalid' : '' }}" value="{{ old('year') ?? $merch->amountPreOrdersBeforeNotification }}" type="number" min="0" id="price" name="amountPreOrdersBeforeNotification" placeholder="Aantal voor notificatie...">
            </div>

            <div class="form-group py-3">
                <input class="btn btn-primary" type="submit" value="Opslaan">
            </div>
        </form>
    </div>
</div>
@endsection
