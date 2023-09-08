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
        <form class="mt-3"  action="/admin/activiteiten/{{$activity->id}}/addMember" method='POST'>
            @csrf
            <select name="addUser" class="form-select" aria-label="Default select example">
                @foreach($allMembers as $user)
                    <option value="{{$user->id}}">{{ $user->FirstName. " ". $user->LastName . "---" . $user->email}}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Voeg toe</button>
        </form>
        <div class="table-responsive">
            <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
            data-show-columns="true">
            <thead>
                <tr class="tr-class-1">
                    <th data-field="name" data-sortable="true">Naam</th>
                    <th data-field="nameNotMembers" data-sortable="true">Naam niet leden</th>
                    <th data-field="price" data-sortable="true">Telefoonnummer</th>
                    <th data-field="description" data-sortable="true">Email</th>
                    <th data-field="link" data-sortable="true">Verjaardag</th>
                    <th data-field="deleteFromActivity" data-sortable="false">Verwijder van activiteit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                    <td data-value="{{ $user->DisplayName }}">{{$user->DisplayName}}</td>
                    <td data-value=""></td>
                    <td data-value="{{ $user->PhoneNumber }}">{{$user->PhoneNumber}}</td>
                    <td data-value="{{ $user->email }}">{{ $user->email }}</td>
                    <td data-value="{{ $user->birthday }}">{{date('d-m-Y', strtotime($user->birthday))}}</td>
                    <td data-value="{{$user->id}}">
                        <form method="post" action="/admin/activiteiten/{{ $activity->id }}/remove/{{$user->id}}">
                            @csrf
                            <button class="btn btn-danger" type="submit">Verwijder</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @foreach ($userTransactionInfo as $user)
                    <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                        <td data-value=""></td>
                        <td data-value="{{ $user[1] }}">{{ $user[1] }}</td>
                        <td data-value=""></td>
                        <td data-value="{{ $user[0] }}">{{ $user[0] }}</td>
                        <td data-value=""></td>
                        <td data-value=""></td>
                    </tr>
                @endforeach
                @if($activity->amount_non_member == 0)
                    @foreach ($nonMembersFree as $user)
                        <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                            <td data-value=""></td>
                            <td data-value="{{ $user->name }}">{{ $user->name }}</td>
                            <td data-value=""></td>
                            <td data-value="{{ $user->email }}">{{ $user->email }}</td>
                            <td data-value=""></td>
                            <td data-value=""></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection
