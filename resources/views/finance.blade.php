@extends('layouts.app')
@section('content')

<div class="overlap">
    <div class ="center">
        @if($financeDocument != null)
            <embed
            src="{{ 'storage/'.$financeDocument->filePath }}"
            style="width:80%; height:1000px;"
            frameborder="0"
            >
        @else
            <h2> er zijn geen bestanden gevonden</h2>
        @endif
    </div>
</div>

@endsection
