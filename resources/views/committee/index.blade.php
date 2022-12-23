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
            <a href="/commissies/{{ htmlspecialchars($bestuur->DisplayName) }}">
                <div class="card">
                    <img class="card-img-top" src="../storage/committees/b16d93c7-42ef-412e-afb3-f6cbe487d0e0.png" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{htmlspecialchars($bestuur->DisplayName)}}</h5>
                        <a class="btn btn-primary ml-auto" href="/vorigBestuur">Naar vorige besturen</a>
                    </div>
                </div>
            </a>
        </div>

        @foreach ($allCommitteesExceptBestuur as $committee)
            <div class="col-12 col-sm-6 col-lg-3 my-2">
                <a href="/commissies/{{ htmlspecialchars($committee->DisplayName) }}">
                    <div class="card">
                        <img class="card-img-top" src="../storage/committees/{{ htmlspecialchars($committee->AzureID) }}.png" alt="Card image cap" onerror="this.src='../storage/images/group-salvemundi-placeholder.svg'">
                        <div class="card-body">
                            <h5 class="card-title">{{htmlspecialchars($committee->DisplayName)}}</h5>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
