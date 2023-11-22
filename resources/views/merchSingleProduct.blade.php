@extends('layouts.app')
@section('title', 'Webshop – ' . config('app.name'))
@section('content')
    <script src="js/scrollonload.js"></script>
    <div class="overlap">
{{--        <h1 class="center">Webshop</h1>--}}
        <section class="py-5 w-75">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6">{!! '<img class="card-img-top mb-5 mb-md-0" src="/'. Thumbnailer::generate("storage/" . str_replace('public/','',$merch->imgPath), "60%") .'" />' !!}</div>
                    <div class="col-md-6">
                        <div class="small mb-1">SKU: BST-498</div>
                        <h1 class="display-5 fw-bolder">{{$merch->name}}</h1>
                        <div class="fs-5 mb-5">
                            @if($merch->discount > 0)
                                <span class="text-decoration-line-through">{{$merch->price}}</span>
                                <span>{{$merch->calculateDiscount}}</span>
                            @endif
                        </div>
                        <p style="white-space: pre-line" class="lead">{{$merch->description}}</p>
                        <h4>Maat / Size:</h4>
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="btnradio1">Radio 1</label>

                            <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio2">Radio 2</label>

                            <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio3">Radio 3</label>
                        </div>
                        <div class="d-flex mt-2">
                            <input class="form-control text-center me-3" id="inputQuantity" type="num" value="1" style="max-width: 3rem" />
                            <button class="btn btn-primary flex-shrink-0" type="button">
                                <i class="fas fa-shopping-basket"></i>
                                Nu kopen
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
