@extends('layouts.app')
@section('content')

<div class="overlap">
    <div class ="center">
        @if($financeDocument != null)
            <object
            data="{{ 'storage/'.$financeDocument->filePath }}"
            type="application/pdf"
            style="width:80%; height:1000px;"
            frameborder="0">
        </object>
        @else
            <h2> er zijn geen bestanden gevonden</h2>
        @endif
    </div>
</div>

@endsection
