@extends('layouts.appmin')
@section('title', 'Admin | Clubs – ' . config('app.name'))
@section('content')
    <script>
        function CopyMe(oFileInput, sTargetID) {
            document.getElementById(sTargetID).value = oFileInput.value;
        }
    </script>

    <div class="row widthFix adminOverlap center removeAutoMargin">
        <div id="contact" class="col-auto col-lg-6 col-md-6 col-sm-8 mb-2">
            @include('include/messageStatus')
            <form action="/admin/calendar/{{ $item->id }}/store" method="post">
                @csrf
                <br>
                <h2 class="h2">Kalender item toevoegen</h2>

                <div class="form-group">
                    <label for="title">Titel*</label>
                    <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                        value="{{ $item->title ?: old('title') }}" id="title" name="title" placeholder="Titel...">
                </div>

                <div class="form-group">
                    <label for="description">Omschrijving</label>
                    <textarea class="form-control" value="{{ $item->description ?: old('description') }}" type="textarea" id="description"
                        name="description" placeholder="Omschrijving..."></textarea>
                </div>

                <div class="form-group">
                    <label for="start">Start datum*</label>
                    <input class="form-control{{ $errors->has('start') ? ' is-invalid' : '' }}"
                        value="{{ $item->startDate ?: old('start') }}" id="start" name="start"
                        placeholder="Start datum..." type="datetime-local">
                </div>

                <div class="form-group">
                    <label for="end">Eind datum</label>
                    <input class="form-control{{ $errors->has('end') ? ' is-invalid' : '' }}"
                        value="{{ $item->endDate ?: old('end') }}" id="discordLink" name="end"
                        placeholder="Eind datum..." type="datetime-local">
                </div>

                <div class="form-group mt-2">
                    <input class="btn btn-primary" type="submit" value="Opslaan">
                </div>
            </form>
        </div>
    </div>
@endsection
