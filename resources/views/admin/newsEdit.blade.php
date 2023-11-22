@extends('layouts.appmin')
@section('content')
    {{-- <script>
    function CopyMe(oFileInput, sTargetID) {
        document.getElementById(sTargetID).value = oFileInput.value;
    }
</script> --}}

    <div class="row widthFix adminOverlap center removeAutoMargin">
        @if (session()->has('information'))
            <div class="alert alert-primary">
                {{ session()->get('information') }}
            </div>
        @endif

        <div id="contact" class="col-md-6">
            @if (session()->has('message'))
                <div class="alert alert-primary">
                    {{ session()->get('message') }}
                </div>
            @endif

            <form action="/admin/news/edit/store" method="post" enctype="multipart/form-data">
                @csrf
                <br>
                <h2 class="h2">Nieuws updaten</h2>
                <input type="hidden" value="{{ $news->id }}" name="id" id="id">
                <div class="form-group">
                    <label for="voornaam">Titel*</label>
                    <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ $news->title }}"
                        id="title" name="title" placeholder="Titel...">
                </div>

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Inhoud*</label>
                    <textarea type="textarea" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" name="content"
                        placeholder="Inhoud...">{{ $news->content }}</textarea>
                </div>

                <label for="photo">Foto</label>
                <div class="input-group mb-3 test">
                    <div class="input-group-prepend">
                        <div class="custom-file" style="width: 80px;">
                            <label class="input-group-text form-control" id="inputGroupFileAddon01" for="photo">Browse
                            </label>
                            <input type="file" onchange="CopyMe(this, 'imgPath');" class="custom-file-input"
                                style="height: 0px;" id="photo" name="photo" aria-describedby="inputGroupFileAddon01">
                        </div>
                    </div>
                    <div class="custom-file form-control">
                        <input style="border: hidden;" id="imgPath" value="{{ $news->imgPath }}" name="imgPath"
                            type="text" readonly="readonly" />
                    </div>
                </div>

                <div class="form-group">
                    <input class="btn btn-primary py-3" type="submit" value="Bewerken">
                </div>
            </form>
        </div>
    </div>
@endsection
