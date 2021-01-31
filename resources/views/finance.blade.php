@extends('layouts.app')
@section('content')

<div class="overlap">
    <div class ="center">
        <embed
        src="{{ 'storage/'.$financeDocument->filePath }}"
        style="width:80%; height:1000px;"
        frameborder="0"
        >
    </div>
</div>

@endsection
