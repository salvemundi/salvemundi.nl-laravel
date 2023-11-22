@extends('layouts.appmin')
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
            <a class="btn btn-primary mt-4" href="/admin/activiteiten"><i class="fas fa-arrow-left"></i> Ga terug</a>
            <div class="table-responsive">
                <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
                    data-show-columns="true">
                    <thead>
                        <tr class="tr-class-1">
                            <th data-field="name" data-sortable="true">Naam</th>
                            <th data-field="price" data-sortable="true">Icon</th>
                            <th data-field="description" data-sortable="true">Kleur</th>
                            <th data-field="delete" data-sortable="false">Verwijderen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tags as $tag)
                            <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                <td data-value="{{ $tag->name }}">{{ $tag->name }}</td>
                                <td data-value="{{ $tag->icon }}">{{ $tag->icon }}</td>
                                <td data-value="{{ $tag->colorClass }}">{{ $tag->colorClass }}</td>
                                <td data-value="{{ $tag->id }}">
                                    <form method="post" action="/admin/activiteiten/tags/delete/{{ $tag->id }}">
                                        @csrf<button type="submit" class="btn btn-danger">Verwijderen</button></form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row widthFix adminOverlap center removeAutoMargin">
        <div id="contact" class="col-md-6">
            @if (session()->has('message'))
                <div class="alert alert-primary">
                    {{ session()->get('message') }}
                </div>
            @endif
            <form action="/admin/activiteiten/tags/store" method="post">
                @csrf
                <br>
                <h2 class="h2">Tag toevoegen</h2>

                <div class="form-group">
                    <label for="name">Naam*</label>
                    <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}"
                        id="tagName" name="tagName" placeholder="Naam...">
                </div>

                <div class="form-group">
                    <label for="link">Icon</label>
                    <input class="form-control{{ $errors->has('link') ? ' is-invalid' : '' }}" value="{{ old('link') }}"
                        id="tagIcon" name="tagIcon" placeholder="fas fa-book">
                </div>

                <div class="form-group">
                    <label for="link">Kleur klasse</label>
                    <input class="form-control{{ $errors->has('link') ? ' is-invalid' : '' }}" value="{{ old('link') }}"
                        id="tagColorClass" name="tagColorClass"
                        placeholder="bootstrap color theme (primary, success, etc.)">
                </div>

                <div class="form-group mx-auto my-3">
                    <input class="btn btn-primary" type="submit" value="Toevoegen">
                </div>
            </form>
        </div>
    </div>
@endsection
