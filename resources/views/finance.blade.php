@extends('layouts.app')
@section('content')
<script src="js/scrollonload.js"></script>
<div class="overlap">
    <div class ="center">
        @if($financeDocument != null)
            {{-- <object
            data="{{ 'storage/'.$financeDocument->filePath }}"
            style="width:80%; height:1000px;"
            frameborder="0">
        </object> --}}
        <iframe src="{{ 'storage/'.$financeDocument->filePath }}" style="width:80%; height:1000px" frameborder="0"></iframe>
        @else
            <h2> Er zijn geen bestanden gevonden</h2>
        @endif
    </div>
</div>

@endsection
