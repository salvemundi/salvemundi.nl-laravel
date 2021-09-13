@extends('layouts.appmin')
@section('content')
<script>
    function CopyMe(oFileInput, sTargetID) {
        document.getElementById(sTargetID).value = oFileInput.value;
    }
</script>
<div class="row widthFix adminOverlap mijnSlider center">
    @if(session()->has('information'))
    <div class="alert alert-primary">
        {{ session()->get('information') }}
    </div>
    @endif
    <div class="col-md-12 center">
        <div class="table-responsive center centerTable">
            <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
            data-show-columns="true">
            <thead>
                <tr class="tr-class-1">
                    <th data-field="name" data-sortable="true">Naam</th>
                    <th data-field="price" data-sortable="true">Telefoonnummer</th>
                    <th data-field="description" data-sortable="true">email</th>
                    <th data-field="link" data-sortable="true">Verjaardag</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                    <td data-value="{{ $user->firstName }}">{{$user->firstName." ".$user->lastName}}</td>
                    <td data-value="{{ $user->phoneNumber }}">{{$user->phoneNumber}}</td>
                    <td data-value="{{ $user->email }}">{{ $user->email }}</td>
                    <td data-value="{{ $user->birthday }}">{{ $user->birthday }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
