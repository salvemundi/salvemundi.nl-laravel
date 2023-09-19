@extends('layouts.appmin')
@section('content')
    <div class="row widthFix adminOverlap center removeAutoMargin">
        <div class="col-auto col-md-10 col-sm-8 mt-5">
            <h2>{{$committee->DisplayName}}</h2>
            <a href="/admin/groepen" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Terug</a>
            <div class="">
                <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
                       data-show-columns="true">
                    <thead>
                    <tr class="tr-class-1">
                        <th data-field="diplayName" data-sortable="true">Naam</th>
                        <th data-field="email" data-sortable="true">E-mail</th>
                        <th data-field="verwijderen" data-sortable="true">Verwijderen</th>
                        <th data-field="commissieleider" data-sortable="true">Maak commissieleider</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($committee->users as $user)
                            <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                <td data-value="{{ $user->getDisplayName() }}">{{$user->getDisplayName() }}</td>
                                <td data-value="{{ $user->email }}">{{$user->email}}</td>
                                <td>
                                    <form method="post" action="/admin/leden/groepen/delete">
                                        @csrf
                                        <input type="hidden" name="groupId" id="groupId" value="{{ $committee->id }}">
                                        <input type="hidden" name="userId" id="userId" value="{{ $user->id }}">
                                        <button type="submit" class="btn btn-danger">Verwijderen</button>
                                    </form>
                                </td>
                                <td>
                                    @if(!$user->pivot->isCommitteeLeader)
                                        <form method="post" action="/admin/groepen/{{$committee->id}}/makeLeader/{{$user->id}}/">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Maak Commissieleider</button>
                                        </form>
                                    @else
                                        <button class="btn btn-primary" style="color: white !important;" disabled>Huidige Commissieleider</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
