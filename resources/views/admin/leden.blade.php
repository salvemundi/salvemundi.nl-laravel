@extends('layouts.appmin')
@section('content')
<div class="row widthFix adminOverlap center removeAutoMargin">

    <div class="w-100 mt-2" id="showprogress" style="display: none;">
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" id="progresstinatie" style="width: 100%" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>

    <div class="col-auto col-md-10 col-sm-8">
        <div class="d-flex">
            <div class="buttonSync">
                <div class="alert alert-success success" style="display: none;" role="alert">
                    De database is ge-synchroniseerd met Azure!
                </div>
                <form id="ajaxform">
                    <button class="btn btn-primary save-data" data-toggle="tooltip" data-placement="right" title="Dit kan enkele minuten duren...">Sync met Azure</button>
                </form>
            </div>
            <div class="buttonSync ms-2">
                <form method="post" action="/admin/leden/unpaid/notify">
                    @csrf
                    <button class="btn btn-primary save-data" type="submit">Mail niet betaalde leden</button>
                </form>
            </div>
        </div>
        <h2>Betaald</h2>
        <div class="">
            <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
                data-show-columns="true">
                <thead>
                    <tr class="tr-class-1">
                        <th data-field="firstName" data-sortable="true">Voornaam</th>
                        <th data-field="lastName" data-sortable="true">Achternaam</th>
                        <th data-field="email" data-sortable="true">E-mail</th>
                        <th data-field="phone" data-sortable="true">Telefoon</th>
                        <th data-field="birthday" data-sortable="true">Geboortedatum</th>
                        <th data-field="permissions" data-sortable="true">Rechten</th>
                        <th data-field="commissie" data-sortable="true">Commissies</th>
                        <th data-field="removeLeden" data-sortable="true">Verwijderen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usersPaid as $user2)
                        <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                            <td data-value="{{ $user2->FirstName }}">{{$user2->FirstName}}</td>
                            <td data-value="{{ $user2->LastName }}">{{$user2->LastName}}</td>
                            <td data-value="{{ $user2->email }}">{{$user2->email}}</td>
                            <td data-value="{{ $user2->PhoneNumber }}">{{$user2->PhoneNumber}}</td>
                            <td data-value="{{ $user2->birthday }}">{{$user2->birthday}}</td>
                            <td data-value="{{ $user2->id }}"><a href="/admin/leden/{{ $user2->id }}/permissions/" class="btn btn-primary">Rechten</a></td>
                            <td data-value="{{ $user2->id }}"><form method="get" action="/admin/leden/groepen">@csrf<input type="hidden" name="id" id="id" value="{{ $user2->id }}"><button class="btn btn-primary">Commissies</button></form></td>
                            <td data-value="{{ $user2->AzureID }}"><button type="button" data-bs-toggle="modal" data-bs-target="#deleteModal1{{ $user2->AzureID }}" class="btn btn-danger">Verwijderen</button></td>
                        </tr>
                        <div class="modal fade" id="deleteModal1{{ $user2->AzureID }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Waarschuwing!</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Weet je zeker dat je de gebruiker <b>{{ $user2->FirstName." ".$user2->LastName}}</b> wilt verwijderen?
                                    </div>
                                    <div class="modal-footer">
                                        <form method="post" action="/admin/leden/delete">
                                            @csrf
                                            <input type="hidden" name="id" id="id" value="{{ $user2->id }}">
                                            <button type="submit" class="btn btn-danger">Verwijder</button>
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
    <div class="col-auto col-md-10 col-sm-8">
        <h2>Niet betaald</h2>
        <a data-bs-toggle="modal" data-bs-target="#disableAllModal" class="btn-warning btn btnDelAcc">Verander account status voor alle niet betaalde leden</a>
        <div class="table-responsive centerTable">
            <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
                data-show-columns="true">
                <thead>
                    <tr class="tr-class-1">
                        <th data-field="firstName" data-sortable="true">Voornaam</th>
                        <th data-field="lastName" data-sortable="true">Achternaam</th>
                        <th data-field="email" data-sortable="true">E-mail</th>
                        <th data-field="phone" data-sortable="true">Telefoon</th>
                        <th data-field="birthday" data-sortable="true">Geboortedatum</th>
                        <th data-field="commissieLeden" data-sortable="true">Commissies</th>
                        <th data-field="permissions" data-sortable="true">Rechten</th>
                        <th data-field="removeLeden" data-sortable="true">Leden verwijderen</th>
                        <th data-field="disableLeden" data-sortable="true">Leden disablen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usersUnPaid as $user)
                        <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                            <td data-value="{{ $user->FirstName }}">{{$user->FirstName}}</td>
                            <td data-value="{{ $user->LastName }}">{{$user->LastName}}</td>
                            <td data-value="{{ $user->email }}">{{$user->email}}</td>
                            <td data-value="{{ $user->PhoneNumber }}">{{$user->PhoneNumber}}</td>
                            <td data-value="{{ $user->birthday }}">{{$user->birthday}}</td>
                            <td data-value="{{ $user->commissie }}"><form method="get" action="/admin/leden/groepen">@csrf<input type="hidden" name="id" id="id" value="{{ $user->id }}"><button class="btn btn-primary">Commissies</button></form></td>
                            <td data-value="{{ $user->id }}"><a href="/admin/leden/{{ $user->id }}/permissions/" class="btn btn-primary">Rechten</a></td>
                            <td data-value="{{ $user->AzureID }}"><button type="button" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->AzureID }}" class="btn btn-danger">Verwijderen</button></td>
                            <td data-value="{{ $user->AzureID }}"><button type="button" data-bs-toggle="modal" data-bs-target="#disableModal{{ $user->AzureID }}" class="btn btn-secondary">Bijwerken</button></td>
                        </tr>
                        <div class="modal fade" id="deleteModal{{ $user->AzureID }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Waarschuwing!</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Weet je zeker dat je de gebruiker <b>{{ $user->FirstName." ".$user->LastName}}</b> wil verwijderen?
                                    </div>
                                    <div class="modal-footer">
                                        <form method="post" action="/admin/leden/delete">
                                            @csrf
                                            <input type="hidden" name="id" id="id" value="{{ $user->id }}">
                                            <button type="submit" class="btn btn-danger">Verwijder</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="disableModal{{ $user->AzureID }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Account van {{ $user->FirstName }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Verander account status van <b>{{ $user->FirstName." ".$user->LastName}}</b>.
                                    </div>
                                    <div class="modal-footer">
                                        <form method="post" action="/admin/leden/disable">
                                            @csrf
                                            <input type="hidden" name="id" id="id" value="{{ $user->id }}">
                                            <input type="hidden" name="mode" id="mode" value="false">
                                            <button type="submit" class="btn btn-danger">Non actief</button>
                                        </form>
                                        <form method="post" action="/admin/leden/disable">
                                            @csrf
                                            <input type="hidden" name="id" id="id" value="{{ $user->id }}">
                                            <input type="hidden" name="mode" id="mode" value="true">
                                            <button type="submit" class="btn btn-success">Actief</button>
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


<div class="modal fade" id="disableAllModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Waarschuwing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                Dit werkt de activatie status van alle accounts die niet betaalt hebben bij!
            </div>
            <div class="modal-footer">
                <form method="post" action="/admin/leden/disableall">
                    @csrf
                    <input type="hidden" name="mode" id="mode" value="false">
                    <button type="submit" class="btn btn-danger">Non actief</button>
                </form>
                <form method="post" action="/admin/leden/disableall">
                    @csrf
                    <input type="hidden" name="mode" id="mode" value="true">
                    <button type="submit" class="btn btn-success">Actief</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="deleteAllModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Waarschuwing!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Dit verwijdert alle leden die niet betaalt hebben uit azure en deze actie kan niet ongedaan worden!
            </div>
            <div class="modal-footer">
                <form method="post" action="/admin/leden/disableall">
                    @csrf
                    <button type="submit" class="btn btn-danger">Verwijder alle</button>
                </form>
            </div>
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
