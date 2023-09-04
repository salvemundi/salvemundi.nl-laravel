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
                    <th data-field="name" data-sortable="true">Coupon naam</th>
                    <th data-field="price" data-sortable="true">Kortings prijs</th>
                    <th data-field="description" data-sortable="true">Beschrijving</th>
                    <th data-field="link" data-sortable="true">Een malig gebruik</th>
                    <th data-field="imgPath" data-sortable="true">Is gebruikt</th>
                    <th data-field="membersOnly" data-sortable="true">Valuta</th>
                    <th data-field="edit" data-sortable="false">Bewerken</th>
                    <th data-field="delete" data-sortable="false">Verwijderen</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($coupons as $coupon)
                <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                    <td data-value="{{ $coupon->name }}">{{$coupon->name}}</td>
                    <td data-value="{{ $coupon->value }}">{{$coupon->value}}</td>
                    <td data-value="{{ $coupon->description }}">{{Illuminate\Support\Str::limit($coupon->description, 100)}}</td>
                    <td data-value="{{ $coupon->isOneTimeUse }}">{{$coupon->isOneTimeUse ? 'Ja' : 'Nee'}}</td>
                    <td data-value="{{ $coupon->hasBeenUsed }}">{{$coupon->hasBeenUsed ? 'Ja' : 'Nee' }}</td>
                    <td data-value="{{ $coupon->currency }}">{{$coupon->currency}}</td>
                    <td data-value="{{ $coupon->id }}"><form method="get" action="/admin/coupons/edit/{{$coupon->id}}"><button type="submit" class="btn btn-primary">Bewerken</button></form></td>
                    <td data-value="{{ $coupon->id }}"><form method="post" action="/admin/coupons/delete/{{$coupon->id}}">@csrf<button type="submit" class="btn btn-danger">Verwijderen</button></form></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>

<div class="row widthFix adminOverlap center removeAutoMargin">
    <div id="contact" class="col-md-6">
        @if(session()->has('message'))
        <div class="alert alert-primary">
            {{ session()->get('message') }}
        </div>
        @endif
        <form action="/admin/coupons/create" method="post">
            @csrf
            <br>
            <h2 class="h2">Coupon toevoegen</h2>

            <div class="form-group">
                <label for="name">Coupon naam*</label>
                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" id="name" name="name" placeholder="Naam...">
            </div>

           <div class="form-group">
                <label for="exampleFormControlTextarea1">Beschrijving</label>
                <textarea type="textarea" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" placeholder="Beschrijving...">{{{ old('description') }}}</textarea>
            </div>

            <div class="form-group">
                <label for="Achternaam">Korting in euros*</label>
                <input type="number" min="1" step=".01" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{ old('price') }}" id="price" name="price" placeholder="Prijs...">
            </div>

            <div class="form-group">
                <label for="name">Valuta*</label>
                <input value="EUR" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" id="name" name="valuta" placeholder="Valuta...">
            </div>

            <div class="form-group">
                <label for="Achternaam">Kan maar een keer gebruikt worden*</label>
                <select name="isOneTimeUse" class="form-select" aria-label="Default select example">
                    <option value="1">Ja</option>
                    <option value="0">Nee</option>
                </select>
            </div>

            <div class="form-group mx-auto my-3">
                <input class="btn btn-primary" type="submit" value="Toevoegen">
            </div>
        </form>
    </div>
</div>
@endsection
