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
    <div class="col-auto col-md-6 col-sm-12">
        <div class="table-responsive">
            <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
            data-show-columns="true">
            <thead>
                <tr class="tr-class-1">
                    <th data-field="name" data-sortable="true">Naam</th>
                    <th data-field="nameNotMember" data-sortable="true">Naam niet leden</th>
                    <th data-field="price" data-sortable="true">Telefoonnummer</th>
                    <th data-field="description" data-sortable="true">Email</th>
                    <th data-field="link" data-sortable="true">Verjaardag</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                    <td data-value="{{ $user->DisplayName }}">{{$user->DisplayName}}</td>
                    <td data-value="{{ $user->name }}">{{$user->name}}</td>
                    <td data-value="{{ $user->PhoneNumber }}">{{$user->PhoneNumber}}</td>
                    <td data-value="{{ $user->email }}">{{ $user->email }}</td>
                    <td data-value="{{ $user->birthday }}">{{date('d-m-Y', strtotime($user->birthday))}}</td>
                </tr>
                @endforeach
                @foreach ($emails as $email)
                <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                    <td data-value=""></td>
                    <td data-value=""></td>
                    <td data-value="{{ $email }}">{{ $email }}</td>
                    <td data-value=""></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection
