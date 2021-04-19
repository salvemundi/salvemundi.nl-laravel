@extends('layouts.appmin')
@section('content')
<div class="row widthFix adminOverlap mijnSlider center">

    <div class="w-100 mt-2" id="showprogress" style="display: none;">
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" id="progresstinatie" style="width: 100%" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
    <div style="margin-top: 15px; margin-left: 15px">
        <div class="alert alert-success success" style="display: none;" role="alert">
            De database is ge-synchroniseerd met Azure!
        </div>

        <form id="ajaxform">
            <button class="btn btn-primary save-data" data-toggle="tooltip" data-placement="right" title="Dit kan enkele minuten duren...">Sync met Azure</button>
        </form>
    </div>

    <div class="col-md-12">
        <h2>Betaald</h2>
        <div class="table-responsive centerTable">
            <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
                data-show-columns="true">
                <thead>
                    <tr class="tr-class-1">
                        <th data-field="firstName" data-sortable="true">Voornaam</th>
                        <th data-field="lastName" data-sortable="true">Achternaam</th>
                        <th data-field="email" data-sortable="true">E-mail</th>
                        <th data-field="removeLeden" data-sortable="true">Commissies</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usersPaid as $user)
                        <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                            <td data-value="{{ $user->FirstName }}">{{$user->FirstName}}</td>
                            <td data-value="{{ $user->LastName }}">{{$user->LastName}}</td>
                            <td data-value="{{ $user->email }}">{{$user->email}}</td>
                            <td data-value="{{ $user->id }}"><form method="get" action="/admin/leden/groepen">@csrf<input type="hidden" name="id" id="id" value="{{ $user->id }}"><button class="btn btn-primary">Commissies</button></form></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-12">
        <h2>Niet betaald</h2>
        <div class="table-responsive centerTable">
            <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
                data-show-columns="true">
                <thead>
                    <tr class="tr-class-1">
                        <th data-field="firstName" data-sortable="true">Voornaam</th>
                        <th data-field="lastName" data-sortable="true">Achternaam</th>
                        <th data-field="email" data-sortable="true">E-mail</th>
                        <th data-field="commissieLeden" data-sortable="true">Commissies</th>
                        <th data-field="removeLeden" data-sortable="true">Leden verwijderen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usersUnPaid as $user)
                        <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                            <td data-value="{{ $user->FirstName }}">{{$user->FirstName}}</td>
                            <td data-value="{{ $user->LastName }}">{{$user->LastName}}</td>
                            <td data-value="{{ $user->email }}">{{$user->email}}</td>
                            <td data-value="{{ $user->commissie }}"><form method="get" action="/admin/leden/groepen">@csrf<input type="hidden" name="id" id="id" value="{{ $user->id }}"><button class="btn btn-primary">Commissies</button></form></td>
                            <td data-value="{{ $user->id }}"><button type="button" data-toggle="modal" data-target="#deleteModal{{ $user->id }}" class="btn btn-danger">Verwijderen</button></td>
                        </tr>
                        <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Waarschuwing!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Weet je zeker dat je de gebruiker <b>{{ $user->FirstName." ".$user->LastName}}</b> wilt verwijderen?
                                    </div>
                                    <div class="modal-footer">

                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluit</button>
                                        <form method="post" action="/admin/removeLeden/delete">
                                            @csrf
                                            <input type="hidden" name="id" id="id" value="{{ $user->id }}">
                                            <button type="button" class="btn btn-danger">Verwijder</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(".save-data").click(function(event){
        event.preventDefault();
        document.getElementById("showprogress").style.display = "inline";
        let _token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ route('admin.sync') }}",
            type: "POST",
            data: {
                _token: _token
            },
            success: function (response) {
                console.log(response);
                if (response) {
                    $('.success').show()
                    document.getElementById("showprogress").style.display = "none";
                    $("#ajaxform")[0].reset();
                }
            },
        });
    });
</script>
@endsection
