@extends('layouts.appmin')
@section('title', 'Admin | Clubs – ' . config('app.name'))
@section('content')
    <script>
        function CopyMe(oFileInput, sTargetID) {
            document.getElementById(sTargetID).value = oFileInput.value;
        }
    </script>
    <div class="row widthFix adminOverlap center removeAutoMargin">
        @if (session()->has('information'))
            <div class="alert alert-primary">
                {{ session()->get('information') }}
            </div>
        @endif
        <div class="col-auto col-md-10 col-sm-8">
            <div class="table-responsive">
                <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
                    data-show-columns="true">
                    <thead>
                        <tr class="tr-class-1">
                            <th data-field="clubName" data-sortable="true" data-width="250">Titel</th>
                            <th data-field="nickName" data-sortable="true">begin</th>
                            <th data-field="imgPath" data-sortable="true" data-width="250">einde</th>
                            <th data-field="founderName" data-sortable="false">Bewerken</th>
                            <th data-field="delete" data-sortable="false">Verwijderen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($items != null)
                            @foreach ($items as $icalitem)
                                <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                    <td data-value="{{ $icalitem->title }}">{{ $icalitem->title }}</td>
                                    <td data-value="{{ $icalitem->startDate }}">{{ $icalitem->startDate }}</td>
                                    <td data-value="{{ $icalitem->endDate }}">{{ $icalitem->endDate }}</td>
                                    <td data-value="{{ $icalitem->id }}">
                                        <a href="/admin/calendar/{{ $icalitem->id }}/edit"
                                            class="btn btn-primary">Bewerken</a>
                                    </td>
                                    <td data-value="{{ $icalitem->id }}">
                                        <form method="post" action="/admin/calendar/{{ $icalitem->id }}/delete">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Verwijderen
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row widthFix adminOverlap center removeAutoMargin">
        <div id="contact" class="col-auto col-lg-6 col-md-6 col-sm-8 mb-2">
            @include('include/messageStatus')
            <form action="/admin/calendar/store" method="post">
                @csrf
                <br>
                <h2 class="h2">Kalender item toevoegen</h2>

                <div class="form-group">
                    <label for="title">Titel*</label>
                    <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                        value="{{ old('title') }}" id="title" name="title" placeholder="Titel...">
                </div>

                <div class="form-group">
                    <label for="description">Omschrijving</label>
                    <textarea class="form-control" value="{{ old('description') }}" type="textarea" id="description" name="description"
                        placeholder="Omschrijving..."></textarea>
                </div>

                <div class="form-group">
                    <label for="start">Start datum*</label>
                    <input class="form-control{{ $errors->has('start') ? ' is-invalid' : '' }}"
                        value="{{ old('start') }}" id="start" name="start" placeholder="Start datum..."
                        type="datetime-local">
                </div>

                <div class="form-group">
                    <label for="end">Eind datum</label>
                    <input class="form-control{{ $errors->has('end') ? ' is-invalid' : '' }}" value="{{ old('end') }}"
                        id="discordLink" name="end" placeholder="Eind datum..." type="datetime-local">
                </div>

                <div class="form-group mt-2">
                    <input class="btn btn-primary" type="submit" value="Toevoegen">
                </div>
            </form>
        </div>
    </div>
@endsection
