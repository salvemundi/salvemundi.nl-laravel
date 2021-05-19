@extends('layouts.app')
@section('content')
<div class="overlap">
    <p><h1 class="center"> We hebben geen agenda meer dankzij deze geweldig mooie nieuwe website</h1> <br>
        <h3 class="center">dus hier heb je een rickroll </h3></p>
        <div>
            <video class="navImg center mijnSlider" autoplay muted loop disablePictureInPicture id="vid">
                <source src="{{asset('/images/rickroll.mp4')}}" type="video/mp4">
            Your browser does not support the video tag.
            </video>
        </div>
</div>
@endsection
