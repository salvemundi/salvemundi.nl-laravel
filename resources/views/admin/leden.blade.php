@extends('layouts.appmin')
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
        <div class="table-responsive centerTable">
            <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
                data-show-columns="true">
                <thead>
                    <tr class="tr-class-1">
                        <th data-field="firstName" data-sortable="true">Voornaam</th>
                        <th data-field="lastName" data-sortable="true">Achternaam</th>
                        <th data-field="email" data-sortable="true">E-mail</th>
                        <th data-field="date" data-sortable="true">Geboorte datum</th>
                        <th data-field="commissie" data-sortable="true">Commissie beheer</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                            <td data-value="{{ $user->FirstName }}">{{$user->FirstName}}</td>
                            <td data-value="{{ $user->LastName }}">{{$user->LastName}}</td>
                            <td data-value="{{ $user->email }}">{{$user->email}}</td>
                            @if($user->birthday == null)
                                <td data-value="{{ $user->birthday }}">Geboorte datum niet ingevuld</td>
                            @else
                                <td data-value="{{ $user->birthday }}">{{ date("d-m-Y", strtotime($user->birthday)) }}</td>
                            @endif
                            <td data-value="{{ $user->commissie }}"><form method="get" action="/admin/leden/groepen"><input type="hidden" name="id" id="id" value="{{ $user->id }}"><button class="btn btn-primary">Commissies</button></form></td>
                        </tr>
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
