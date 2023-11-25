@extends('layouts.app')
@section('title', 'Webshop – ' . config('app.name'))
@section('content')
    <script src="js/scrollonload.js"></script>
    <div class="overlap">
        <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6">{!! '<img class="card-img-top mb-5 mb-md-0" src="/' .
                        Thumbnailer::generate('storage/' . str_replace('public/', '', $merch->imgPath), '60%') .
                        '" />' !!}</div>
                    <div class="col-md-6">
                        <div class="small mb-1">SKU: BST-498</div>
                        <h1 class="display-5 fw-bolder">{{ $merch->name }}</h1>
                        <div class="fs-5 mb-5">
                            @if ($merch->discount > 0)
                                <span class="text-decoration-line-through">€ {{ $merch->price }}</span>
                                <span>€ {{ $merch->calculateDiscount() }}</span>
                            @endif
                        </div>
                        <p style="white-space: pre-line" class="lead">{{ $merch->description }}</p>
                        <h4>Maat / Size:</h4>
                        <form method="post" action="/merch/purchase/{{ $merch->id }}">
                            @csrf
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                @php
                                    // TODO: Improve this templating mechanism. It is here to automatically check the first available size option.
                                    $count = 0;
                                @endphp
                                @foreach ($sizes as $size)
                                    @foreach ($merch->merchSizes as $merchSize)
                                        @if ($merchSize->id == $size->id)
                                            <input type="radio" class="btn-check"
                                                @if ($count == 0 && $merchSize->id == $size->id && $merchSize->pivot->amount > 0) checked @endif
                                                @if (($merchSize->id == $size->id && $merchSize->pivot->amount == 0) || $merchSize->id != $size->id) disabled @endif name="merchSize"
                                                value="{{ $merchSize->id }}" id="{{ $size->id }}" autocomplete="off">
                                            <label class="btn btn-outline-primary"
                                                for="{{ $size->id }}">{{ $size->size }}</label>
                                        @endif
                                    @endforeach
                                    @php
                                        $count++;
                                    @endphp
                                @endforeach
                                @if ($merch->merchSizes->count() == 0)
                                    <p class="text-danger">Helaas is alles uitverkocht!</p>
                                @endif
                            </div>
                            <div class="d-flex mt-2">
                                <button class="btn btn-primary flex-shrink-0" type="submit"
                                    @if ($merch->merchSizes->count() == 0) disabled @endif>
                                    <i class="fas fa-shopping-basket"></i>
                                    Nu kopen
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
