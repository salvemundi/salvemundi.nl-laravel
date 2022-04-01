@extends('layouts.app')
@section('content')

<div class="overlap">
    <div class="row">
        <div class="col-12 col-md-6 px-1 px-md-5">
            <h1 class="center">De commissies die de vereniging omhoog houden</h1>
            <p class="center">
                Salve Mundi heeft verschillende commissies die ieder verantwoordelijk zijn voor het functioneren van de vereniging.<br> Elke commissie heeft zijn eigen taken en verantwoordelijkheden, en samen zorgen zij ervoor dat Salve Mundi kan zijn zoals het is!
            </p>
        </div>
        <div class="col-12 col-md-6 px-1 px-md-5">
            <img class="imgIndex" src="images/SaMuFotos/DSC07654.jpg">
        </div>
    </div>

    <br>
    <div class="row">
        <div class="col-12 col-sm-6 col-lg-3 my-2">
            <a href="/commissies/{{ $bestuur->DisplayName }}">
                <div class="card">
                    <img class="card-img-top" src="../storage/images/SalveMundi-Vector.svg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{$bestuur->DisplayName}}</h5>
                        <!-- <p class="card-text">{{$bestuur->email}}</p> -->
                    </div>
                </div>
            </a>
        </div>

        @foreach ($allCommitteesExceptBestuur as $committee)
            <div class="col-12 col-sm-6 col-lg-3 my-2">
                <a href="/commissies/{{ $committee->DisplayName }}">
                    <div class="card">
                        <img class="card-img-top" src="../storage/committees/{{ $committee->AzureID }}.png" alt="Card image cap" onerror="this.src='../storage/images/SalveMundi-Vector.svg'">
                        {{-- {!! '<img class="img-top" src="../storage/committees/'.$committee->DisplayName.'.png" />' !!} --}}
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
@endsection
