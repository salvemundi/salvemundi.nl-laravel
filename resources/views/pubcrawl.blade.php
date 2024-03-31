@extends('layouts.app')
@section('title', 'Kroegentocht – ' . config('app.name'))
@section('content')
    <script src="{{ mix('js/GroupSelectTickets.js') }}"></script>

    <div class="overlap">
        <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                @include('include.messageStatus')
                @if(isset($product))
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6">{!! '<img class="card-img-top mb-5 mb-md-0" src="/' .
                        Thumbnailer::generate('storage/' . str_replace('public/', '', $product->imgPath), '60%') .
                        '" />' !!}</div>
                    <div class="col-md-6">
                        <h1 class="display-5 fw-bolder">{{ $product->name }}</h1>

                        <form method="POST" action="/activiteiten/signup">
                            @csrf
                            <input type="hidden" required name="activityId" id="activityId" value="{{ $product->id }}">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" required name="email">
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
                                @if ($product->isFull()) disabled @endif class="btn btn-primary mt-2">Inschrijven €
                                {{ $product->amount }}</button>
                            <script>
                                generateTicketInputs({{ $product->id }}, {{ $product->amount }})
                                document.getElementById("amountOfTickets{{ $product->id }}").addEventListener("input", function() {
                                    generateTicketInputs({{ $product->id }}, {{ $product->amount }})
                                });
                            </script>
                        </form>
                    </div>
                </div>
                @else
                <h2 class="center">Er is nog geen kroegentocht aangekondigd, probeer het later opnieuw!</h2>
                @endif
            </div>
        </section>
    </div>
@endsection
