@extends('layouts.app')
@section('title', $merch->name . ' | Merch – ' . config('app.name'))
@section('content')
    <script src="js/scrollonload.js"></script>
    <div class="overlap">
        <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                @include('include.messageStatus')
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
                        <form method="post" action="/merch/purchase/{{ $merch->id }}" id="merchForm">
                            @csrf
                            <div class="form-group">
                                <label for="gender">Pasvorm*</label>
                                <select id="genderSelect" class="form-select" name="gender"
                                    aria-label="Default select example">
                                    @foreach (App\Enums\MerchGender::asSelectArray() as $key => $gender)
                                        <option value="{{ $key }}">{{ $gender }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <h4>Maat / Size:</h4>

                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                @php
                                    $firstAvailableSize = null;
                                    $atLeastOneAvailable = false;
                                @endphp

                                @forelse ($sizes as $size)
                                    @php
                                        $selected = $merch->merchSizes->first(function ($merchSize) use ($size) {
                                            return $merchSize->id == $size->id && $merchSize->pivot->amount > 0 || $merch->isPreOrder;
                                        });
                                        $disabled = (!$selected || $selected->pivot->amount == 0) && !$merch->isPreOrder;

                                        if (!$firstAvailableSize && !$disabled) {
                                            $firstAvailableSize = $size;
                                            $atLeastOneAvailable = true;
                                        }
                                    @endphp

                                    <input type="radio" class="btn-check"
                                        {{ $firstAvailableSize && $size->id == $firstAvailableSize->id ? 'checked' : '' }}
                                        {{ $disabled ? 'disabled' : '' }} name="merchSize"
                                        value="{{ $size->id }}" id="{{ $size->id }}" autocomplete="off">
                                    <label class="btn btn-outline-primary"
                                        for="{{ $size->id }}">{{ $size->size }}</label>

                                @empty
                                    <p class="text-danger">
                                        {{ $atLeastOneAvailable ? 'Helaas is alles uitverkocht!' : 'Selecteer een maat' }}
                                    </p>
                                @endforelse
                            </div>
                            @if($merch->preOrderNeedsPayment)
                            <div class="mt-2">
                                <p>Voor deze pre-order hoef je niet meteen te betalen, je krijgt later een betaal verzoek.</p>
                            </div>

                            <div class="input-group mb-3 test">
                                <input class="inp-cbx" id="cbx1" required name="acceptPayment" type="checkbox" style="display: none" />
                                <label class="cbx" for="cbx1"><span>
                                        <svg width="12px" height="10px" viewbox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg></span><span>Ik accepteer dat ik bij deze pre-order de aangegeven prijs achteraf betaal.</span></label>
                            </div>
                            @endif
                            <div class="d-flex mt-2">

                                <button class="btn btn-primary flex-shrink-0" type="submit">
                                    @if($merch->preOrderNeedsPayment || $merch->isPreOrder)
                                        <i class="fas fa-shopping-basket"></i>
                                        Pre order
                                    @else
                                    {{ !$atLeastOneAvailable ? 'disabled' : '' }}>
                                    <i class="fas fa-shopping-basket"></i>
                                    {{ $atLeastOneAvailable ? 'Nu kopen' : 'Helaas is alles uitverkocht!' }}
                                    @endif
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var genderSelect = document.getElementById('genderSelect');
            var merchForm = document.getElementById('merchForm');
            var sizeRadios = merchForm.querySelectorAll('input[name="merchSize"]');
            @if(!$merch->isPreOrder){
            var availableSizes = @json($merch->merchSizes);
            }
            @else{
              var availableSizes = @json($sizes);
            }
            @endif

            // Function to update the checked state and enabled/disabled state of radio buttons based on the selected gender
            function updateSizes() {
                var selectedGender = genderSelect.value;

                sizeRadios.forEach(function(radio) {
                    var sizeId = radio.id;
                    var isPreOrder = {{$merch->isPreOrder}};

                    // Check if the size is available for the selected gender
                    var sizeAvailable = availableSizes.some(function(size) {
                      if(isPreOrder > 0) {
                        return true;
                      } else {
                        return size.id == sizeId && size.pivot.merch_gender == selectedGender &&
                            size.pivot.amount > 0;
                      }
                    });

                    // Update the checked state based on whether the size is available
                    radio.checked = sizeAvailable;
                    // Update the disabled state based on whether the size is available
                    radio.disabled = !sizeAvailable;
                });
            }

            // Attach an event listener to the gender select to update sizes on change
            genderSelect.addEventListener('change', function() {
                updateSizes();
            });

            // Initial update based on the default selected gender
            updateSizes();
        });
    </script>

@endsection
