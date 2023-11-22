@extends('layouts.appmin')
@section('content')
    <div class="row widthFix adminOverlap mijnSlider">
        <div class="col-md-12 center groot">
            {{ $permission->description }} routes
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
                                    <th data-field="name" data-sortable="true">Groep naam</th>
                                    <th data-field="delete" data-sortable="true">Verwijderen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permission->routes as $route)
                                    <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                        <td data-value="{{ $route->route }}">{{ $route->route }}</td>
                                        <td data-value="{{ $route->id }}">
                                            <form method="post"
                                                action="/admin/rechten/{{ $permission->id }}/routes/{{ $route->id }}/delete">
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
                                    <th data-field="name" data-sortable="true">Groep naam</th>
                                    <th data-field="toevoegen" data-sortable="false">Toevoegen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($routesNotInUse as $route)
                                    <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                        <td data-value="{{ $route->route }}">{{ $route->route }}</td>
                                        <td data-value="{{ $route->id }}">
                                            <form method="post"
                                                action="/admin/rechten/{{ $permission->id }}/routes/{{ $route->id }}/store">
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
