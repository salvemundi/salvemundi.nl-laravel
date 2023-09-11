@extends('layouts.app')
@section('content')
<div class="overlap row pt-5">
    <div class="col-12 col-md-6 p-1 p-md-3 p-lg-5">
        @include('include.deletePizzaModal')
        <form action="/pizza/store" method="post" enctype="multipart/form-data">
            @csrf
            <br>
            <h2 class="h2 pt-5">Pizza toevoegen</h2>

            <div class="form-group">
                <label for="name">Deze bestelling is voor:</label>
                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" id="name" name="name" placeholder="Naam...">
            </div>

            <div class="form-group">
                <label for="type">Pizza</label>
                <input class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" value="{{ old('type') }}" id="type" name="type" placeholder="Pizza...">
            </div>

            <div class="form-group">
                <label for="Maat">Maat</label>
                <select class="form-select" name="size" aria-label="Default select example">
                    @foreach(App\Enums\PizzaSizes::asSelectArray() as $key => $value))
                        <option value="{{$key}}">{{$value}}</option>
                    @endforeach
                  </select>
            </div>

            <div class="form-group">
                <label for="description">Notities</label>
                <input class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ old('description') }}" id="description" name="description" placeholder="Notitie...">
            </div>

            <div class="mt-3">
                <input class="inp-cbx" id="cbx" name="cbx" type="checkbox" style="display: none"/>
                <label class="cbx" for="cbx">
                    <span>
                        <svg width="12px" height="10px" viewbox="0 0 12 10">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                        </svg>
                    </span>
                    Bij deze accepteer ik dat ik mijn pizza betaal (Tikkie komt in de döner dinsdag club).
                </label>
            </div>

            <div class="form-group mx-auto my-3">
                <br>
                <input class="btn btn-primary" id="submitPizza" disabled type="submit" value="Toevoegen">
            </div>
        </form>
    </div>
    <div class="col-12 col-md-6 p-1 p-md-3 p-lg-5">

        <div class="table-responsive pt-md-5">
            <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
                data-show-columns="true">
                <thead>
                    <tr class="tr-class-1">
                        <th data-field="name" data-sortable="true" data-width="250">Besteld voor</th>
                        <th data-field="type" data-sortable="true">Pizza soort</th>
                        <th data-field="size" data-sortable="true">Pizza grootte</th>
                        <th data-field="user" data-sortable="false">Toegevoegd door</th>
                        <th data-field="description" data-sortable="false">Notitie</th>
                        <th data-field="delete" data-sortable="false">Verwijder</th>

                    </tr>
                </thead>
                <tbody>
                    @if($pizzas != null)
                        @foreach ($pizzas as $pizza)
                            <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                <td data-field="name">{{$pizza->name}}</td>
                                <td data-field="type">{{$pizza->type}}</td>
                                <td data-field="size">{{App\Enums\PizzaSizes::coerce($pizza->size)->key}}</td>
                                <td data-field="user">{{$pizza->user->insertion? $pizza->user->FirstName. " ". $pizza->user->insertion . " ". $pizza->user->LastName : $pizza->user->FirstName . " " . $pizza->user->LastName}}</td>
                                <td data-field="description">{{$pizza->description}}</td>
                                <td data-field="delete">
                                @if($pizza->user->id == Illuminate\Support\Facades\Auth::user()->id)
                                    @include('include.deleteOwnPizzaModal', ['pizza' => $pizza])
                                    <button data-bs-toggle="modal" data-bs-target="#deletePizza{{$pizza->id}}" class="btn btn-danger">Verwijder</button>
                                @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <button data-bs-toggle="modal" data-bs-target="#deletePizzas" class="btn btn-danger mt-2">Verwijder alles</button>
        </div>
    </div>
</div>

<script>
        // Get references to the checkbox and button
        const checkbox = document.getElementById('cbx');
        const submitButton = document.getElementById('submitPizza');

        // Add an event listener to the checkbox
        checkbox.addEventListener('change', function () {
            // Check if the checkbox is selected
            if (checkbox.checked) {
                // If selected, remove the 'disabled' attribute from the button
                submitButton.removeAttribute('disabled');
            } else {
                // If not selected, add the 'disabled' attribute to the button
                submitButton.setAttribute('disabled', 'disabled');
            }
        });
</script>
@endsection
