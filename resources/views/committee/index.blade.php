@extends('layouts.app')
@section('content')

<div class="overlap">
    <div class="row">
        <div class="col-12 col-md-6 px-1 px-md-5">
            <h1 class="center">De Commissies die de vereniging omhoog houden</h1>
            <p class="center">
                Salve Mundi heeft verschillende commissies die ieder verantwoordelijk zijn voor het functioneren van de vereniging.<br> Elke commissie heeft zijn eigen taken en verantwoordelijkheden, en samen zorgen zij ervoor dat Salve Mundi kan zijn zoals het is!
            </p>
        </div>
        <div class="col-12 col-md-6 px-1 px-md-5">
            <img class="imgIndex" src="images/SaMuFotos/IMG_0582.jpg">
        </div>
    </div>

    <br>
    <div class="row">
        @foreach ($committees as $committee)
            <div class="col-12 col-sm-6 col-lg-3 my-2">
                <a href="/commissies/{{ $committee->DisplayName }}">
                    <div class="card">
                        <img class="card-img-top" src="images/SaMuFotos/IMG_0582.jpg" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">{{$committee->DisplayName}}</h5>
                            <!-- <p class="card-text">{{$committee->email}}</p> -->
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>

    {{-- <div class="card" style="width: 18rem;">
        <img class="card-img-top" src="..." alt="Card image cap">
        <div class="card-body">
          <h5 class="card-title">Bestuur</h5>
          <p class="card-text">Het bestuur van Salve Mundi</p>
        </div>
    </div> --}}

@endsection
