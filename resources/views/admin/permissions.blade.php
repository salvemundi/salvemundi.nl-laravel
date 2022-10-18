@extends('layouts.appmin')
@section('content')
    <div class="row widthFix adminOverlap center removeAutoMargin">
        <div class="col-auto col-md-10 col-sm-8 mt-5">
            <h2>Bevoegdheids groepen</h2>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#addPermission">
                Groep toevoegen
            </button>
            @include('include.addPermissionModal')
            <div class="">
                <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
                       data-show-columns="true">
                    <thead>
                    <tr class="tr-class-1">
                        <th data-field="displayName" data-sortable="true">Naam</th>
                        <th data-field="routes" data-sortable="true">Routes</th>
                        <th data-field="edit">Bewerken</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($permissions as $permission)
                        <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                            <td data-value="{{ $permission->description }}">{{$permission->description}}</td>
                            <td data-value="{{ $permission->id }}">
                                <form method="get" action="/admin/rechten/{{$permission->id}}/routes">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Routes toepasbaar</button>
                                </form>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editPermission{{$permission->id}}">
                                    Bewerk
                                </button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deletePermission{{$permission->id}}">
                                    Verwijder
                                </button>
                            </td>
                        </tr>
                        @include('include.editPermissionModal',['permission' => $permission])
                        @include('include.deletePermissionModal',['permission' => $permission])

                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-auto col-md-10 col-sm-8 mt-5">
            <h2>Routes</h2>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#addRoute">
                Route toevoegen
            </button>
            @include('include.addRouteModal')
            <div class="">
                <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
                       data-show-columns="true">
                    <thead>
                    <tr class="tr-class-1">
                        <th data-field="diplayName" data-sortable="true">Route</th>
                        <th data-field="description" data-sortable="true">Beschrijving</th>
                        <th data-field="edit" data-sortable="true">Bewerken</th>
                        <th data-field="delete">Verwijder route</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($routes as $route)
                        <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                            <td data-value="{{ $route->route }}">{{$route->route}}</td>
                            <td data-value="{{ $route->description }}">{{$route->description}}</td>
                            <td data-value="{{ $route->id }}">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editRoute{{$route->id}}">
                                    Bewerk route
                                </button>
                            </td>
                            <td data-value="{{ $route->id }}">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteRoute{{$route->id}}">
                                    Verwijder route
                                </button>
                            </td>
                        </tr>
                        @include('include.editRouteModal',['route' => $route])
                        @include('include.deleteRouteModal',['route' => $route])
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
