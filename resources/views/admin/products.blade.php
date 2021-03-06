@extends('layouts.appmin')
@section('content')

<div class="adminOverlap">

    <div class="row widthFix center">

        <div class="col-md-9">

            <div class="table-responsive">

                <table
                       id="table"
                       data-toggle="table"
                       data-search="true"
                       data-sortable="true"
                       data-pagination="true"
                       data-show-columns="true">
                    <thead>
                        <tr class="tr-class-1">
                            <th data-field="name" data-sortable="true">Naam</th>
                            <th data-field="amount" data-sortable="true">Prijs</th>
                            <th data-field="interval" data-sortable="true">Vernieuwing</th>
                            <th data-field="description" data-sortable="false">Beschrijving</th>
                            <th data-field="delete" data-sortable="false">Verwijderen</th>
                            <th data-field="edit" data-sortable="false">Bewerken</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                                <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                    <td data-value="{{ $product->name }}">{{$product->name}}</td>
                                    <td data-value="{{ $product->amount }}">{{$product->amount}}</td>
                                    <td data-value="{{ $product->interval }}">{{ $product->interval }}</td>
                                    <td data-value="{{ $product->description }}">{{$product->description}}</td>
                                    @if($product->index == null)
                                        <td data-value="{{ $product->id }}"><form method="post" action="/admin/products/delete">@csrf<input type="hidden" name="id" id="id" value="{{ $product->id }}"><button type="submit" class="btn btn-danger">Verwijderen</button></form></td>
                                    @else
                                    <td>Verwijderen niet mogelijk</td>
                                    @endif
                                    <td data-value="{{ $product->id }}"><form method="get" action="/admin/products/edit">@csrf<input type="hidden" name="id" id="id" value="{{ $product->id }}"><button type="submit" class="btn btn-primary">Bewerken</button></form></td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function CopyMe(oFileInput, sTargetID) {
        document.getElementById(sTargetID).value = oFileInput.value;
    }
</script>
{{-- <div class="adminOverlap center">
<div id="contact" class="col-md-6">
    @if(session()->has('message'))
        <div class="alert alert-primary">
            {{ session()->get('message') }}
        </div>
    @endif
    <form action="/admin/sponsors/add/store" method="post" enctype="multipart/form-data">
        @csrf
        <br>
        <h2 class="h2">Product toevoegen</h2>

        <div class="test">
            <br>
            <label for="name">Naam</label>
            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" type="text" id="name" name="name" placeholder="Naam...">
        </div>

        <div class="test">
            <br>
            <label for="reference">Referentie / Website</label>
            <input class="form-control{{ $errors->has('reference') ? ' is-invalid' : '' }}" value="{{ old('reference') }}" type="text" id="reference" name="reference" placeholder="Referentie / Website...">
        </div>

        <div class="test">
            <br>
            <label for="photo">Foto</label>
            <div class="input-group mb-3 test">
                <div class="input-group-prepend">
                    <div class="custom-file" style="width: 80px;">
                        <label class="input-group-text form-control" id="inputGroupFileAddon01" for="photo">Browse </label>
                        <input type="file" onchange="CopyMe(this, 'txtFileName');" class="custom-file-input" style="height: 0px;" id="photo" name="photo" aria-describedby="inputGroupFileAddon01">
                    </div>
                </div>
                <div class="custom-file form-control">
                    <input style="border: hidden;" id="txtFileName" type="text" readonly="readonly" />
                </div>
            </div>
        </div>

        <div class="test">
            <br>
            <input class="btn btn-primary" type="submit" value="Toevoegen">
        </div>
    </form>
</div>
</div> --}}
@endsection
