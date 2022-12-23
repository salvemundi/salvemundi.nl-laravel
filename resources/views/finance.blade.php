@extends('layouts.app')
@section('content')
<script src="js/scrollonload.js"></script>
<div class="overlap">
    <div class ="center">
        @if(htmlspecialchars($financeDocument != null))
        <iframe src="{{ 'storage/'.htmlspecialchars($financeDocument->filePath) }}" style="width:80%; height:1000px" frameborder="0"></iframe>
        @else
            <h2> Er zijn geen bestanden gevonden</h2>
        @endif
    </div>
</div>

@endsection
