@extends('layouts.appmin')
@section('title', 'Admin | Rechten – ' . config('app.name'))
@section('content')
    <div class="row widthFix adminOverlap mijnSlider">
        <div class="col-md-12 center groot">
            {{ $committee->DisplayName }}
        </div>
        <div class="col-md-6">
            <script>
                function CopyMe(oFileInput, sTargetID) {
                    document.getElementById(sTargetID).value = oFileInput.value;
                }
            </script>
            <div class="row widthFix adminOverlap mijnSlider center">
                @if (session()->has('message'))
                    <div class="alert alert-primary">
                        {{ session()->get('message') }}
                    </div>
                @endif
                @if (session()->has('information'))
                    <div class="alert alert-primary">
                        {{ session()->get('information') }}
                    </div>
                @endif
                <div class="center">

                    <div class="table-responsive center centerTable">
                        <table id="table" data-toggle="table" data-search="true" data-sortable="true"
                            data-pagination="true" data-show-columns="true">
                            <thead>
                                <tr class="tr-class-1">
                                    <th data-field="name" data-sortable="true">Recht naam</th>
                                    <th data-field="delete" data-sortable="true">Verwijderen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($committee->permissions as $permission)
                                    <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                        <td data-value="{{ $permission->description }}">{{ $permission->description }}</td>
                                        <td data-value="{{ $permission->id }}">
                                            <form method="post"
                                                action="/admin/groepen/{{ $committee->id }}/permissions/{{ $permission->id }}/delete">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Verwijderen</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row widthFix adminOverlap mijnSlider center">
                @if (session()->has('information'))
                    <div class="alert alert-primary">
                        {{ session()->get('information') }}
                    </div>
                @endif
                <div class="center">

                    <div class="table-responsive center centerTable">

                        <table id="table" data-toggle="table" data-search="true" data-sortable="true"
                            data-pagination="true" data-show-columns="true">
                            <thead>
                                <tr class="tr-class-1">
                                    <th data-field="name" data-sortable="true">Recht naam</th>
                                    <th data-field="toevoegen" data-sortable="false">Toevoegen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($nonAssignedPermissions as $permission)
                                    <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                        <td data-value="{{ $permission->description }}">{{ $permission->description }}</td>
                                        <td data-value="{{ $permission->id }}">
                                            <form method="post"
                                                action="/admin/groepen/{{ $committee->id }}/permissions/{{ $permission->id }}/store">
                                                @csrf
                                                <button type="submit" class="btn btn-primary">Toevoegen</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
