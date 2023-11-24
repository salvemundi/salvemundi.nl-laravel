@extends('layouts.appmin')
@section('title', 'Admin | Producten – ' . config('app.name'))
@section('content')
    <div class="row widthFix adminOverlap center removeAutoMargin">
        <div class="col-auto col-md-6 col-sm-8">
            <div class="table-responsive">
                <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
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
                                <td data-value="{{ $product->name }}">{{ $product->name }}</td>
                                <td data-value="{{ $product->amount }}">{{ $product->amount }}</td>
                                <td data-value="{{ $product->interval }}">{{ $product->interval }}</td>
                                <td data-value="{{ $product->description }}">{{ $product->description }}</td>
                                @if ($product->index == null)
                                    <td data-value="{{ $product->id }}">
                                        <form method="post" action="/admin/products/delete">@csrf<input type="hidden"
                                                name="id" id="id" value="{{ $product->id }}"><button
                                                type="submit" class="btn btn-danger">Verwijderen</button></form>
                                    </td>
                                @else
                                    <td>Verwijderen niet mogelijk</td>
                                @endif
                                <td data-value="{{ $product->id }}">
                                    <form method="get" action="/admin/products/edit">@csrf<input type="hidden"
                                            name="id" id="id" value="{{ $product->id }}"><button
                                            type="submit" class="btn btn-primary">Bewerken</button></form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function CopyMe(oFileInput, sTargetID) {
            document.getElementById(sTargetID).value = oFileInput.value;
        }
    </script>
@endsection
