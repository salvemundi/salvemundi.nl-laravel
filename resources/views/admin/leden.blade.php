n@extends('layouts.appmin')
@section('content')
<script>
    function CopyMe(oFileInput, sTargetID) {
        document.getElementById(sTargetID).value = oFileInput.value;
    }
</script>

<div class="row widthFix adminOverlap mijnSlider">
    @if(session()->has('message'))
        <div class="alert alert-primary">
            {{ session()->get('message') }}
        </div>
    @endif
    @if(session()->has('information'))
        <div class="alert alert-primary">
            {{ session()->get('information') }}
        </div>
    @endif
    <div class="col-md-12">
        <div class="table-responsive centerTable">
            <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
                data-show-columns="true">
                <thead>
                    <tr class="tr-class-1">
                        <th data-field="firstName" data-sortable="true">Voornaam</th>
                        <th data-field="lastName" data-sortable="true">Achternaam</th>
                        <th data-field="email" data-sortable="true">E-mail</th>
                        <th data-field="commissie" data-sortable="true">Toevoegen aan commissie</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                            <td data-value="{{ $user->FirstName }}">{{$user->FirstName}}</td>
                            <td data-value="{{ $user->LastName }}">{{$user->LastName}}</td>
                            <td data-value="{{ $user->email }}">{{$user->email}}</td>
                            <td data-value="{{ $user->commissie }}"><form method="get" action="/admin/leden/groepen"><input type="hidden" name="id" id="id" value="{{ $user->id }}"><button class="btn btn-primary">Commissies</button></form></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
