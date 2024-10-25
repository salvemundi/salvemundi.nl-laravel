@extends('layouts.app')
@section('title', 'Webshop – ' . config('app.name'))
@section('content')
    <script src="js/scrollonload.js"></script>
    <link href="{{ mix('css/merch.css') }}" rel="stylesheet">
    <div class="overlap">
        @include('include.messageStatus')
        <h1 class="center">Webshop</h1>
        <div class="container mt-5">
            <div class="row">
                @foreach ($products as $merch)
                    <div class="col-md-4">
                        <div class="card product-card">
                            @if($merch->imgPath)
                            {!! '<img class="card-img-top" src="/' .
                                Thumbnailer::generate('storage/' . str_replace('public/', '', $merch->imgPath), '60%') .
                                '" />' !!}
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $merch->name }}</h5>

                                <div class="tags">
                                    <!-- "New" Tag -->
                                    @if ($merch->isNew)
                                        <span class="badge bg-success tag">Nieuw!</span>
                                    @endif
                                    <!-- "Discount" Tag -->
                                    @if ($merch->discount > 0)
                                        <span class="badge bg-primary tag">{{ $merch->calculateDiscountPercentage() }}%
                                            Korting!</span>
                                    @endif
                                </div>
                                <p class="card-text">
                                    {{ $merch->description }}
                                </p>
                                @if ($merch->discount > 0)
                                    <a href="/merch/{{ $merch->id }}"
                                        class="btn btn-primary mb-4 w-100 d-flex align-items-center">
                                        <div>
                                            <i class="fas fa-shopping-cart"></i>
                                            Bestellen
                                        </div>
                                        <p class="card-text ms-auto text-white">
                                            <strong>€ {{ $merch->calculateDiscount() }}</strong> <del class="text-muted"
                                                style="color: white !important;">
                                                € {{ $merch->price }}</del>
                                        </p>
                                    </a>
                                @else
                                    <a href="/merch/{{ $merch->id }}"
                                        class="btn btn-primary mb-4 w-100 d-flex align-items-center">
                                        <div>
                                            <i class="fas fa-shopping-cart"></i>
                                            Bestellen
                                        </div>
                                        <strong class="ms-auto">€ {{ $merch->price }}</strong>
                                    </a>
                                    <p class="card-text"></p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- Add more product cards as needed -->
            </div>
        </div>
    </div>
@endsection
