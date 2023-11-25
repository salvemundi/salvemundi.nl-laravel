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
                        <h1 class="display-5 fw-bolder">{{ $merch->name }}</h1>
                        <div class="fs-5 mb-5">
                            @if ($merch->discount > 0)
                                <span class="text-decoration-line-through">€ {{ $merch->price }}</span>
                                <span>€ {{ $merch->calculateDiscount() }}</span>
                            @else
                                <span class="text-decoration">€ {{ $merch->price }}</span>
                            @endif
                        </div>
                        <p style="white-space: pre-line" class="lead">{{ $merch->description }}</p>
                        <h4>Maat / Size:</h4>
                        <form method="post" action="/merch/purchase/{{ $merch->id }}">
                            @csrf
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                @php
                                    $firstAvailableSize = null;
                                    $atLeastOneAvailable = false;
                                @endphp

                                @forelse ($sizes as $size)
                                    @php
                                        $selected = $merch->merchSizes->first(function ($merchSize) use ($size) {
                                            return $merchSize->id == $size->id && $merchSize->pivot->amount > 0;
                                        });
                                        $disabled = !$selected || $selected->pivot->amount == 0;

                                        if (!$firstAvailableSize && !$disabled) {
                                            $firstAvailableSize = $size;
                                            $atLeastOneAvailable = true;
                                        }
                                    @endphp

                                    <input type="radio" class="btn-check"
                                        {{ ($firstAvailableSize && $size->id == $firstAvailableSize->id) ? 'checked' : '' }}
                                        {{ $disabled ? 'disabled' : '' }}
                                        name="merchSize" value="{{ optional($selected)->id }}" id="{{ $size->id }}" autocomplete="off">
                                    <label class="btn btn-outline-primary" for="{{ $size->id }}">{{ $size->size }}</label>

                                @empty
                                    <p class="text-danger">{{ $atLeastOneAvailable ? 'Helaas is alles uitverkocht!' : 'Selecteer een maat' }}</p>
                                @endforelse
                            </div>

                            <div class="form-group">
                                <label for="gender">Pasvorm*</label>
                                <select class="form-select" name="gender" aria-label="Default select example">
                                    @foreach (App\Enums\MerchGender::asSelectArray() as $key => $gender)
                                        <option value="{{ $key }}">{{ $gender }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-flex mt-2">
                                <button class="btn btn-primary flex-shrink-0" type="submit" {{ !$atLeastOneAvailable ? 'disabled' : '' }}>
                                    <i class="fas fa-shopping-basket"></i>
                                    {{ $atLeastOneAvailable ? 'Nu kopen' : 'Helaas is alles uitverkocht!' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
