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
                        <th data-field="firstName" data-sortable="true">Voornaam</th>
                        <th data-field="lastName" data-sortable="true">Achternaam</th>
                        <th data-field="email" data-sortable="true">E-mail</th>
                        <th data-field="paymentStatus" data-sortable="true">Betalings Status</th>
                        <th data-field="phoneNumber" data-sortable="true">Telefoonnummer</th>
                        <th data-field="birthday" data-sortable="true">verjaardag</th>
                        <th data-field="medicalIssues" data-sortable="true">Allergieën/ medicijnen</th>
                        <th data-field="specials" data-sortable="true">andere bijzonderheden</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($introObjects as $user)
                        <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                            <td data-value="{{ $user->firstName }}">{{$user->firstName}}</td>
                            <td data-value="{{ $user->lastName }}">{{$user->lastName}}</td>
                            <td data-value="{{ $user->email }}">{{$user->email}}</td>
                            <td data-value="{{ $user->payment->paymentStatus }}">{{ \App\Enums\paymentStatus::fromValue($user->payment->paymentStatus)->key }}</td>
                            <td data-value="{{ $user->phoneNumber }}">{{$user->phoneNumber}}</td>
                            <td data-value="{{ $user->birthday }}">{{$user->birthday}}</td>
                            <td data-value="{{ $user->medicalIssues }}">{{$user->medicalIssues}}</td>
                            <td data-value="{{ $user->specials }}">{{$user->specials}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="introCheck widthFix center">
        <form method="POST" action="intro/store">
            @csrf
            @if($introSetting->settingValue == 1)
                <input class="inp-cbx" id="cbx" name="cbx" type="checkbox" checked style="display: none"/>
            @elseif($introSetting->settingValue == 0)
                <input class="inp-cbx" id="cbx" name="cbx" type="checkbox" style="display: none"/>
            @endif
            <label class="cbx" for="cbx"><span>
            <svg width="12px" height="10px" viewbox="0 0 12 10">
            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
            </svg></span><span>Intro inschrijvingen aan / uit zetten.</span></label>
            <button type="submit" class="btn btn-primary btn-sm">Opslaan</button>
            <a href="{{ route('export_excel.excel')}}" class="btn btn-primary btn-sm">Export to Excel</a>
        </form>
    </div>
</div>
@endsection
