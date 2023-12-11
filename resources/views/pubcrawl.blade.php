@extends('layouts.app')
@section('title', 'Kroegentocht – ' . config('app.name'))
@section('content')
    <script src="{{ mix('js/GroupSelectTickets.js') }}"></script>

    <div class="overlap">
        <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6">{!! '<img class="card-img-top mb-5 mb-md-0" src="/' .
                        Thumbnailer::generate('storage/' . str_replace('public/', '', $product->imgPath), '60%') .
                        '" />' !!}</div>
                    <div class="col-md-6">
                        <h1 class="display-5 fw-bolder">{{ $product->name }}</h1>
                        <form method="post" action="/merch/purchase/{{ $product->id }}" id="merchForm">
                            @csrf

                            <form method="POST" action="/activiteiten/signup">
                                @csrf
                                <input type="hidden" name="activityId" id="activityId" value="{{ $product->id }}">
                                @if (!\Illuminate\Support\Facades\Auth::check())
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" required name="email">
                                @endif
                                <label for="amountOfTickets" class="form-label">Aantal
                                    Tickets</label>
                                <input required type="number" min="1"
                                    @if ($product->maxTicketOrderAmount > 0) max="{{ $product->maxTicketOrderAmount }}"
                                       oninput="if (this.value > {{ $product->maxTicketOrderAmount }}) this.value = {{ $product->maxTicketOrderAmount }}" @endif
                                    value="1" class="form-control" id="amountOfTickets{{ $product->id }}"
                                    name="amountOfTickets" aria-describedby="basic-addon3">

                                <label for="association" class="form-label">Welke
                                    vereniging?</label>
                                <select class="form-select" id="association" name="association"
                                    aria-label="Default select example">
                                    @foreach ($product->associations as $association)
                                        <option value="{{ $association->id }}">
                                            {{ $association->name }}</option>
                                    @endforeach
                                </select>
                                <div id="ticketInputs{{ $product->id }}">

                                </div>
                                <button type="submit" id="submitGroupTicketSignup{{ $product->id }}"
                                    @if ($product->isFull()) disabled @endif
                                    class="btn btn-primary mt-2">Inschrijven €
                                    {{ $product->amount }}</button>
                                <script>
                                    generateTicketInputs({{ $product->id }}, {{ $product->amount }})
                                    document.getElementById("amountOfTickets{{ $product->id }}").addEventListener("input", function() {
                                        generateTicketInputs({{ $product->id }}, {{ $product->amount }})
                                    });
                                </script>
                            </form>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
