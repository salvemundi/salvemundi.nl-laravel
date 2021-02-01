@extends('layouts.appmin')
@section('content')

<div class="adminOverlap">

    <div class="row">

        <div class="col-md-12">

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
                            <th data-field="year" data-sortable="true">Jaar</th>
                            <th data-field="filePath" data-sortable="true">File</th>
                            <th data-field="delete" data-sortable="false">Verwijderen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(session()->has('information'))
                        <div class="alert alert-primary">
                            {{ session()->get('information') }}
                        </div>
                        @endif
                        {{-- @if($financeDocument != null) --}}
                            @foreach ($document as $file)
                                    <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                        <td data-value="{{ $file->year }}">{{$file->year}}</td>
                                        <td data-value="{{ $file->filePath }}">{{$file->filePath}}</td>
                                        <td data-value="{{ $file->id }}"><form method="post" action="/admin/finance/delete">@csrf<input type="hidden" name="id" id="id" value="{{ $file->id }}"><button type="submit" class="btn btn-danger">Verwijderen</button></form></td>
                                    </tr>
                            @endforeach
                        {{-- @endif --}}
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
<div class="adminOverlap center">
<div id="contact" class="col-md-6">
    @if(session()->has('message'))
        <div class="alert alert-primary">
            {{ session()->get('message') }}
        </div>
    @endif
    <form method="POST" action="finance/store" enctype="multipart/form-data">
        @csrf
        <br>
        <h2 class="h2">File toevoegen</h2>

            <br>
            <label for="year">Jaar</label>
            <input class="form-control{{ $errors->has('year') ? ' is-invalid' : '' }}" value="{{ old('year') }}" type="text" id="year" name="year" placeholder="Jaar...">

            <br>
            <label for="filePath">File (pdf)</label>
            <div class="input-group mb-3 test">
                <div class="input-group-prepend">
                    <div class="custom-file" style="width: 80px;">
                        <label class="input-group-text form-control" id="inputGroupFileAddon01" for="filePath">Browse </label>
                        <input type="file" onchange="CopyMe(this, 'txtFileName');" class="custom-file-input" style="height: 0px;" id="filePath" name="filePath" aria-describedby="inputGroupFileAddon01">
                    </div>
                </div>
                <div class="custom-file form-control">
                    <input style="border: hidden;" id="txtFileName" type="text" readonly="readonly" />
                </div>
            </div>

            <br>
            <input class="btn btn-primary" type="submit" value="Toevoegen">
    </form>
</div>
</div>

@endsection