@extends('layouts.appmin')
@section('content')
{{-- <script>
    function CopyMe(oFileInput, sTargetID) {
        document.getElementById(sTargetID).value = oFileInput.value;
    }
</script> --}}

<div class="row widthFix adminOverlap center removeAutoMargin">
    @if(session()->has('information'))
    <div class="alert alert-primary">
        {{ session()->get('information') }}
    </div>
    @endif

    <div id="contact" class="col-auto col-md-6 col-sm-12">
        @if(session()->has('message'))
        <div class="alert alert-primary">
            {{ session()->get('message') }}
        </div>
        @endif

        <form action="/admin/bijbaanbank/edit/store" method="post" enctype="multipart/form-data">
            @csrf
            <br>
            <h2 class="h2">Bijbaan updaten</h2>
            <input type="hidden" value="{{ $sideJobBank->id }}" name="id" id="id">

            <div class="form-group">
                <label for="voornaam">Bijbaan naam</label>
                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $sideJobBank->name }}" id="name" name="name" placeholder="Bijbaan naam...">
            </div>

            <label for="voornaam">Studie richting*</label>
            <select class="form-control" name="studyProfile">
                <option selected value="{{$sideJobBank->studyProfile}}">{{\App\Enums\StudyProfile::coerce($sideJobBank->studyProfile)->description}}</option>
                @foreach (\App\Enums\StudyProfile::getInstances() as $item)
                    @if($sideJobBank->studyProfile != $item->value)
                        <option value="{{ $item->value }}">{{$item->description}}</option>
                    @endif
                @endforeach
            </select>

            <div class="form-group">
                <label for="hours">Bijbaan omschrijving</label>
                <textarea type="textarea" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" placeholder="Omschrijving...">{{{ $sideJobBank->description }}}</textarea>
            </div>

            <div class="form-group">
                <input class="btn btn-primary py-3" type="submit" value="Bewerken">
            </div>
        </form>
    </div>
</div>
@endsection
