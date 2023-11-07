@extends('layouts.appmin')
@section('content')

    @if(session()->has('information'))
    <div class="alert alert-primary">
        {{ session()->get('information') }}
    </div>
    @endif
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">

<div class="row widthFix adminOverlap center removeAutoMargin">
    <div id="contact" class="col-auto col-md-6 col-sm-12">
        @if(session()->has('message'))
        <div class="alert alert-primary">
            {{ session()->get('message') }}
        </div>
        @endif
        <form action="/admin/activities/edit/store" method="post" enctype="multipart/form-data">
            @csrf
            <br>
            <input type="hidden" value="{{ $activities->id }}" name="id" id="id">
            <h2 class="h2">Activiteit {{ $activities->name }} bewerken</h2>
            <p>Als de prijs 0.00 is dan wordt de activiteit als gratis geregistreerd.</p>

            <div class="form-group">
                <label for="name">Activiteit naam*</label>
                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $activities->name }}" id="name" name="name" placeholder="Naam...">
            </div>

            <div class="form-group">
                <label for="link">Microsoft forms link</label>
                <input class="form-control{{ $errors->has('link') ? ' is-invalid' : '' }}" value="{{ $activities->formsLink }}" id="link" name="link" placeholder="Forms link...">
            </div>

            <div class="form-group">
                <label for="Achternaam">Prijs*</label>
                <input type="number" min="0" step=".01" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{ $activities->amount }}" id="price" name="price" placeholder="Prijs...">
            </div>

            <div class="form-group">
                <label for="limit">Limiet*</label>
                <input type="number" min="0" class="form-control{{ $errors->has('limit') ? ' is-invalid' : '' }}" value="{{ $activities->limit }}" id="limit" name="limit" placeholder="Limiet aantal inschrijvingen...">
            </div>

            <div class="form-group">
                <label for="Achternaam">Prijs voor niet leden*</label>
                <input type="number" min="0" step=".01" class="form-control{{ $errors->has('price2') ? ' is-invalid' : '' }}" value="{{ $activities->amount_non_member }}" id="price2" name="price2" placeholder="Prijs...">
            </div>

            <div class="form-group mb-2">
                <label for="name">Tags* (ctrl click to deselect)</label>

                <select id="tags" name="tags[]" class="form-select" multiple aria-label="multiple select example">
                    @foreach($tags as $tag)
                        @php
                            $selected = false;
                            if ($activities->tags != null) {
                                foreach ($activities->tags as $activityTag) {
                                    if ($activityTag->id == $tag->id) {
                                        $selected = true;
                                        break;
                                    }
                                }
                            }
                        @endphp
                        <option @if($selected) selected @endif value="{{$tag->id}}">{{$tag->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">Beschrijving</label>
                <textarea type="textarea" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" placeholder="Beschrijving...">{{{ $activities->description }}}</textarea>
            </div>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">Beschrijving voor actieve leden</label>
                <textarea type="textarea" class="form-control{{ $errors->has('membersOnlyContent') ? ' is-invalid' : '' }}" name="membersOnlyContent" placeholder="Beschrijving...">{{{ $activities->membersOnlyContent }}}</textarea>
            </div>

            <div class="form-group" id="ticketsPerRound">
                <label for="exampleFormControlTextarea1">Hoeveel Tickets mogen er per keer besteld worden?</label>
                <input type="number" min="0"  class="form-control{{ $errors->has('maxTicketOrderAmount') ? ' is-invalid' : '' }}" name="maxTicketOrderAmount" placeholder="Tickets per keer..." value="{{ $activities->maxTicketOrderAmount }}"/>
            </div>

            <div class="form-group" id="associations">
                <label for="name">verenigingen die meedoen</label>
                <a class="btn btn-primary" id="addInputField"><i class="fas fa-plus fa-sm"></i></a>
                <div id="associationInputs">
                    @foreach($activities->associations as $association)
                        <div class="d-flex" id="{{$association->id}}">
                            <input type="text" name="associationName[]" class="form-control mb-2" value="{{$association->name}}">
                            <a onclick="document.getElementById({{$association->id}}).remove()" class="btn btn-primary mb-2"><i class="fas fa-minus fa-sm"></i></a>
                        </div>
                    @endforeach
                </div>
            </div>

            <label for="photo">Foto</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="custom-file" style="width: 80px;">
                        <label class="input-group-text form-control" id="inputGroupFileAddon01" for="photo">Browse </label>
                        <input type="file" onchange="CopyMe(this, 'imgPath');" class="custom-file-input" style="height: 0px;" id="photo" name="photo" aria-describedby="inputGroupFileAddon01">
                    </div>
                </div>
                <div class="custom-file form-control">
                    <input style="border: hidden;" id="imgPath" name="imgPath" value="{{ $activities->imgPath }}" type="text" readonly="readonly" />
                </div>
            </div>

            @if($activities->oneTimeOrder)
                <input class="inp-cbx" id="cbx" name="cbx" type="checkbox" checked style="display: none"/>
            @elseif(!$activities->oneTimeOrder)
                <input class="inp-cbx" id="cbx" name="cbx" type="checkbox" style="display: none"/>
            @endif
            <label class="cbx" for="cbx"><span>
            <svg width="12px" height="10px" viewbox="0 0 12 10">
            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
            </svg></span><span>Voor deze activiteit kan maar eenmaal ingeschreven worden per deelnemer</span></label>

            @if($activities->membersOnly)
                <input class="inp-cbx" id="cbx2" name="cbxMembers" type="checkbox" checked style="display: none"/>
            @else
                <input class="inp-cbx" id="cbx2" name="cbxMembers" type="checkbox" style="display: none"/>
            @endif
            <label class="cbx" for="cbx2"><span>
            <svg width="12px" height="10px" viewbox="0 0 12 10">
            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
            </svg></span><span>Alleen Salve Mundi leden?</span></label>

            @if($activities->isGroupSignup)
                <input class="inp-cbx" id="cbx3" name="cbxGroup" type="checkbox" checked style="display: none"/>
            @else
                <input class="inp-cbx" id="cbx3" name="cbxGroup" type="checkbox" style="display: none"/>
            @endif
            <label class="cbx" for="cbx3"><span>
            <svg width="12px" height="10px" viewbox="0 0 12 10">
            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
            </svg></span><span>Is op basis groep reservering?</span></label>

            <div class="form-group py-3">
                <input class="btn btn-primary" type="submit" value="Bewerken">
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
<script src="{{ mix('js/AdminPageActivityAssociations.js') }}"></script>

<script>
    new MultiSelectTag('tags')  // id
    document.getElementById('associations').style.display = "none"
    
    function UpdateForm() {
        let input = document.getElementById('ticketsPerRound');
        let input2 = document.getElementById('associations');

        input2.style.display = "none"
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
