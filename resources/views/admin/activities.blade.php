@extends('layouts.appmin')
@section('content')
<script>
    function CopyMe(oFileInput, sTargetID) {
        document.getElementById(sTargetID).value = oFileInput.value;
    }
</script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">

<div class="row widthFix adminOverlap center removeAutoMargin">
    @if(session()->has('information'))
    <div class="alert alert-primary">
        {{ session()->get('information') }}
    </div>
    @endif
    <div class="col-auto col-md-10 col-sm-8">
        <a class="btn btn-primary mt-4" href="/admin/activiteiten/tags"><i class="fas fa-tags"></i> Tags</a>
        <div class="table-responsive">
            <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
            data-show-columns="true">
            <thead>
                <tr class="tr-class-1">
                    <th data-field="name" data-sortable="true">Activiteit naam</th>
                    <th data-field="price" data-sortable="true">Prijs</th>
                    <th data-field="description" data-sortable="true">Beschrijving</th>
                    <th data-field="link" data-sortable="true">Forms link</th>
                    <th data-field="imgPath" data-sortable="true" data-width="250">Foto pad</th>
                    <th data-field="membersOnly" data-sortable="true" data-width="250">Alleen leden</th>
                    <th data-field="tags">Tags</th>
                    <th data-field="edit" data-sortable="false">Bewerken</th>
                    <th data-field="delete" data-sortable="false">Verwijderen</th>
                    <th data-field="signups" data-sortable="false">Inschrijvingen</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activities as $activity)
                <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                    <td data-value="{{ $activity->name }}">{{$activity->name}}</td>
                    <td data-value="{{ $activity->amount }}">{{$activity->amount}}</td>
                    <td data-value="{{ $activity->description }}">{{Illuminate\Support\Str::limit($activity->description, 100)}}</td>
                    <td data-value="{{ $activity->formsLink }}">{{Illuminate\Support\Str::limit($activity->formsLink, 20)}}</td>
                    <td data-value="{{ $activity->imgPath }}">{{$activity->imgPath}}</td>
                    <td data-value="{{ $activity->membersOnly }}">{{$converted_res = $activity->membersOnly ? 'Ja' : 'Nee' }}</td>
                    <td data-value="{{ $activity->tags }}">@foreach($activity->tags as $tag) <span class="badge {{ $tag->colorClass }}"><i class="{{ $tag->icon }}"></i> {{ $tag->name }}</span> @endforeach</td>
                    <td data-value="{{ $activity->id }}"><a class="btn btn-primary" href="/admin/activities/{{$activity->id}}/edit">Bewerken</a></td>
                    <td data-value="{{ $activity->id }}"><form method="post" action="/admin/activities/delete">@csrf<input type="hidden" name="id" id="id" value="{{ $activity->id }}"><button type="submit" class="btn btn-danger">Verwijderen</button></form></td>
                    <td data-value="{{ $activity->id }}"><a href="/admin/activities/{{$activity->id}}/signups" class="btn btn-primary">Inschrijvingen</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>

<div class="row widthFix adminOverlap center removeAutoMargin">
    <div id="contact" class="col-md-6">
        @if(session()->has('message'))
        <div class="alert alert-primary">
            {{ session()->get('message') }}
        </div>
        @endif
        <form action="/admin/activities/store" method="post" enctype="multipart/form-data">
            @csrf
            <br>
            <h2 class="h2">Activiteit toevoegen</h2>
            <p>Als de prijs 0.00 is dan wordt de activiteit als gratis geregistreerd.</p>

            <div class="form-group">
                <label for="name">Activiteit naam*</label>
                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" id="name" name="name" placeholder="Naam...">
            </div>

            <div class="form-group">
                <label for="link">Microsoft forms link</label>
                <input class="form-control{{ $errors->has('link') ? ' is-invalid' : '' }}" value="{{ old('link') }}" id="link" name="link" placeholder="Forms link...">
            </div>

            <div class="form-group">
                <label for="Achternaam">Prijs*</label>
                <input type="number" min="0" step=".01" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{ old('price') }}" id="price" name="price" placeholder="Prijs...">
            </div>

            <div class="form-group">
                <label for="limit">Limiet*</label>
                <input type="number" min="0" class="form-control{{ $errors->has('limit') ? ' is-invalid' : '' }}" value="{{ old('limit') }}" id="limit" name="limit" placeholder="Limiet aantal inschrijvingen...">
            </div>

            <div class="form-group">
                <label for="price2">Prijs voor niet leden*</label>
                <input type="number" min="0" step=".01" class="form-control{{ $errors->has('price2') ? ' is-invalid' : '' }}" value="{{ old('price2') }}" id="price2" name="price2" placeholder="Prijs...">
            </div>

            <div class="form-group mb-2">
                <label for="name">Tags* (ctrl click to deselect)</label>

                <select id="tags" name="tags[]" class="form-select" multiple aria-label="multiple select example">
                    @foreach($tags as $tag)
                        <option value="{{$tag->id}}">{{$tag->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">Beschrijving</label>
                <textarea type="textarea" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" placeholder="Beschrijving...">{{{ old('description') }}}</textarea>
            </div>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">Beschrijving voor actieve leden</label>
                <textarea type="textarea" class="form-control{{ $errors->has('membersOnlyContent') ? ' is-invalid' : '' }}" name="membersOnlyContent" placeholder="Beschrijving...">{{{ old('membersOnlyContent') }}}</textarea>
            </div>

            <div class="form-group" id="ticketsPerRound">
                <label for="exampleFormControlTextarea1">Hoeveel Tickets mogen er per keer besteld worden?</label>
                <input type="number" min="0"  class="form-control{{ $errors->has('maxTicketOrderAmount') ? ' is-invalid' : '' }}" name="maxTicketOrderAmount" placeholder="Tickets per keer..." />
            </div>

            <div class="form-group" id="associations">
                <label for="name">verenigingen die meedoen</label>
                <a class="btn btn-primary" id="addInputField"><i class="fas fa-plus fa-sm"></i></a>
                <div id="associationInputs">

                </div>
            </div>

            <label for="photo">Foto</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Upload bijhorende foto</label>
                        <input class="form-control" type="file" id="photo" name="photo">
                    </div>
                </div>
            </div>

            <input class="inp-cbx" id="cbx" name="cbx" type="checkbox" checked style="display: none"/>

            <label class="cbx" for="cbx"><span>
            <svg width="12px" height="10px" viewbox="0 0 12 10">
            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
            </svg></span><span>Voor deze activiteit kan maar eenmaal ingeschreven worden per deelnemer</span></label>

            <input class="inp-cbx" id="cbx2" name="cbxMembers" type="checkbox" style="display: none"/>

            <label class="cbx" for="cbx2"><span>
            <svg width="12px" height="10px" viewbox="0 0 12 10">
            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
            </svg></span><span>Alleen Salve Mundi leden?</span></label>

            <input class="inp-cbx" id="cbx3" name="cbxGroup" type="checkbox" style="display: none"/>
            <label class="cbx" for="cbx3"><span>
            <svg width="12px" height="10px" viewbox="0 0 12 10">
            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
            </svg></span><span>Is op basis groep reservering?</span></label>

            <div class="form-group mx-auto my-3">
                <input class="btn btn-primary" type="submit" value="Toevoegen">
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
<script src="{{ mix('js/AdminPageActivityAssociations.js') }}"></script>

<script>
    new MultiSelectTag('tags')  // id
    function UpdateForm() {
        let input = document.getElementById('ticketsPerRound');
        let input2 = document.getElementById('associations');
        if(!document.getElementById("cbx3").checked) {
            input.style.display = "none"
            input2.style.display = "none"
        } else {
            input.style.display = "block"
            input2.style.display = "block"
        }
    }
    document.getElementById("cbx3").addEventListener("input", UpdateForm);
</script>
@endsection
