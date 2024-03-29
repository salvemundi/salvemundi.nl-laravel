<!-- Modal -->
<div class="modal fade" id="showModal{{ $activiteit->id }}" tabindex="583208700" style="z-index: 534324;" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" style="z-index: 100000;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $activiteit->name }}</h5>
                <div class="ms-auto center">
                    @foreach ($activiteit->tags as $tag)
                        <h5 class="ms-2">
                            <span class="badge {{ $tag->colorClass }}"><i class="{{ $tag->icon }}"></i>
                                {{ $tag->name }}</span>
                        </h5>
                    @endforeach
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @if ($activiteit->imgPath != null)
                {!! '<img style="max-width: 25%;" class="mx-auto img-fluid" src="/' .
                    Thumbnailer::generate('storage/' . $activiteit->imgPath, '60%') .
                    '" />' !!}
            @endif
            <h1 class="mt-3 center"> {{ $activiteit->name }} </h1>
            <div class="modal-body">
                <p style="white-space: pre-line" class="card-text">{{ $activiteit->description }}</p>
                @if (session('userName'))
                    <p style="white-space: pre-line" class="card-text">{!! preg_replace(
                        '!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i',
                        '<a style="text-decoration: underline !important; color: blue;" href="$1">$1</a>',
                        $activiteit->membersOnlyContent,
                    ) !!}</p>
                @endif
            </div>

            <div class="modal-footer overflow-y-scroll" style="max-height: 20vh !important;">
                <div class="col row">
                    <div class="col-12">
                        <p class="card-text textCard text-muted">Geplaatst op
                            {{ date('d-m-Y', strtotime($activiteit->created_at)) }}</p>

                        @if (!$activiteit->isFull())
                            @if (Illuminate\Support\Facades\Auth::user() && Illuminate\Support\Facades\Auth::user()->hasActiveSubscription())
                                @if (App\Http\Controllers\ActivitiesController::userHasPayedForActivity($activiteit->id))
                                    @if ($activiteit->oneTimeOrder)
                                        <button class="btn btn-success disabled"><i class="fas fa-check"></i>
                                            Ingeschreven</button>
                                    @else
                                        @if ($activiteit->isGroupSignup)
                                            <form method="POST" action="/activiteiten/signup">
                                                @csrf
                                                <input type="hidden" name="activityId" id="activityId"
                                                    value="{{ $activiteit->id }}">
                                                @if (!\Illuminate\Support\Facades\Auth::check())
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="text" class="form-control" required name="email">
                                                @endif
                                                <label for="amountOfTickets" class="form-label">Aantal
                                                    Tickets</label>
                                                <input required type="number" min="1"
                                                    max="@if ($activiteit->maxTicketOrderAmount > 0) {{ $activiteit->maxTicketOrderAmount }} @endif"
                                                    value="1" class="form-control"
                                                    id="amountOfTickets{{ $activiteit->id }}" name="amountOfTickets"
                                                    aria-describedby="basic-addon3">

                                                <label for="association" class="form-label">Welke
                                                    vereniging?</label>
                                                <select class="form-select" id="association" name="association"
                                                    aria-label="Default select example">
                                                    @foreach ($activiteit->associations as $association)
                                                        <option value="{{ $association->id }}">
                                                            {{ $association->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div id="ticketInputs{{ $activiteit->id }}">

                                                </div>
                                                <button type="submit"
                                                    id="submitGroupTicketSignup{{ $activiteit->id }}"
                                                    class="btn btn-primary mt-2">Inschrijven €
                                                    {{ $activiteit->amount }}</button>
                                                <script>
                                                    generateTicketInputs({{ $activiteit->id }}, {{ $activiteit->amount }})
                                                    document.getElementById("amountOfTickets{{ $activiteit->id }}").addEventListener("input", function() {
                                                        generateTicketInputs({{ $activiteit->id }}, {{ $activiteit->amount }})
                                                    });
                                                </script>
                                            </form>
                                        @else
                                            <form method="POST" action="/activiteiten/signup">
                                                @csrf
                                                <input type="hidden" name="activityId" id="activityId"
                                                    value="{{ $activiteit->id }}">
                                                <button type="submit" class="btn btn-primary">Inschrijven
                                                    € {{ $activiteit->amount }}</button>
                                            </form>
                                        @endif
                                    @endif
                                @else
                                    @if ($activiteit->isGroupSignup)
                                        <form method="POST" action="/activiteiten/signup">
                                            @csrf
                                            <input type="hidden" name="activityId" id="activityId"
                                                value="{{ $activiteit->id }}">

                                            @if (!\Illuminate\Support\Facades\Auth::check())
                                                <label for="email" class="form-label">Email</label>
                                                <input type="text" class="form-control" required name="email">
                                            @endif

                                            <label for="amountOfTickets" class="form-label">Aantal
                                                Tickets</label>
                                            <input required type="number" min="1"
                                                max="@if ($activiteit->maxTicketOrderAmount > 0) {{ $activiteit->maxTicketOrderAmount }} @endif"
                                                value="1" class="form-control"
                                                id="amountOfTickets{{ $activiteit->id }}" name="amountOfTickets"
                                                aria-describedby="basic-addon3">

                                            <label for="association" class="form-label">Welke
                                                vereniging?</label>
                                            <select class="form-select" id="association" name="association"
                                                aria-label="Default select example">
                                                @foreach ($activiteit->associations as $association)
                                                    <option value="{{ $association->id }}">
                                                        {{ $association->name }}</option>
                                                @endforeach
                                            </select>
                                            <div id="ticketInputs{{ $activiteit->id }}">

                                            </div>
                                            <button type="submit" id="submitGroupTicketSignup{{ $activiteit->id }}"
                                                class="btn btn-primary mt-2">Inschrijven €
                                                {{ $activiteit->amount }}</button>
                                            <script>
                                                generateTicketInputs({{ $activiteit->id }}, {{ $activiteit->amount }})
                                                document.getElementById("amountOfTickets{{ $activiteit->id }}").addEventListener("input", function() {
                                                    generateTicketInputs({{ $activiteit->id }}, {{ $activiteit->amount }})
                                                });
                                            </script>
                                        </form>
                                    @else
                                        <form method="POST" action="/activiteiten/signup">
                                            @csrf
                                            <input type="hidden" name="activityId" id="activityId"
                                                value="{{ $activiteit->id }}">
                                            <button type="submit" class="btn btn-primary">Inschrijven €
                                                {{ $activiteit->amount }}</button>
                                        </form>
                                    @endif
                                @endif
                            @else
                                @if (session('id'))
                                    <p class="text-danger card-text textCard "><u>Je lidmaatschap is niet
                                            meer geldig, verleng deze voor korting op deze activiteit!</u>
                                    </p>
                                @else
                                    <p class="text-danger card-text textCard"><u>Je hebt geen lidmaatschap,
                                            word lid voor korting op deze activiteit!</u></p>
                                @endif

                                @if ($activiteit->membersOnly && !$userIsActive)
                                    <button class="btn btn-danger" disabled>Alleen voor Leden</button>
                                @else
                                    <div class="col-12">
                                        <button class="btn btn-primary buttonActiviteiten" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapseExample-{{ $activiteit->id }}"
                                            aria-expanded="false" aria-controls="collapseExample">
                                            Inschrijven
                                        </button>
                                    </div>

                                    <div class="collapse mt-3" id="collapseExample-{{ $activiteit->id }}">
                                        <div class="card card-body">
                                            <form method="POST" action="/activiteiten/signup">
                                                @csrf
                                                @if ($activiteit->isGroupSignup)
                                                    <input type="hidden" name="activityId" id="activityId"
                                                        value="{{ $activiteit->id }}">

                                                    @if (!\Illuminate\Support\Facades\Auth::check())
                                                        <label for="email" class="form-label">Email</label>
                                                        <input type="text" class="form-control" required
                                                            name="email">
                                                    @endif

                                                    <label for="amountOfTickets" class="form-label">Aantal
                                                        Tickets</label>
                                                    <input required type="number" min="1"
                                                        max="@if ($activiteit->maxTicketOrderAmount > 0) {{ $activiteit->maxTicketOrderAmount }} @endif"
                                                        value="1" class="form-control"
                                                        id="amountOfTickets{{ $activiteit->id }}"
                                                        name="amountOfTickets" aria-describedby="basic-addon3">

                                                    <label for="association" class="form-label">Welke
                                                        vereniging?</label>
                                                    <select class="form-select" id="association" name="association"
                                                        aria-label="Default select example">
                                                        @foreach ($activiteit->associations as $association)
                                                            <option value="{{ $association->id }}">
                                                                {{ $association->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div id="ticketInputs{{ $activiteit->id }}">

                                                    </div>
                                                    <button type="submit"
                                                        id="submitGroupTicketSignup{{ $activiteit->id }}"
                                                        class="btn btn-primary mt-2">Inschrijven €
                                                        {{ $activiteit->amount }}</button>

                                                    <script>
                                                        generateTicketInputs({{ $activiteit->id }}, {{ $activiteit->amount }})
                                                        document.getElementById("amountOfTickets{{ $activiteit->id }}").addEventListener("input", function() {
                                                            generateTicketInputs({{ $activiteit->id }}, {{ $activiteit->amount }})
                                                        });
                                                    </script>
                                                @else
                                                    <input type="hidden" name="activityId" id="activityId"
                                                        value="{{ $activiteit->id }}">
                                                    <div class="input-group mb-3 me-4">
                                                        <span class="input-group-text" id="basic-addon3">Naam</span>
                                                        <input required type="text" class="form-control"
                                                            id="nameActivity" name="nameActivity"
                                                            aria-describedby="basic-addon3">
                                                        <br>
                                                    </div>
                                                    <div class="input-group mb-3 me-4">
                                                        <span class="input-group-text" id="basic-addon3">Email</span>
                                                        <input required type="email" class="form-control"
                                                            id="email" name="email"
                                                            aria-describedby="basic-addon3">
                                                    </div>
                                                    <button type="submit"
                                                        class="btn btn-primary buttonActiviteiten float-right">Afrekenen
                                                        € {{ $activiteit->amount_non_member }}</button>
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @else
                            @if (App\Http\Controllers\ActivitiesController::userHasPayedForActivity($activiteit->id) && $activiteit->oneTimeOrder)
                                <button class="btn btn-success disabled"><i class="fas fa-check"></i>
                                    Ingeschreven</button>
                            @else
                                <p class="card-text textCard text-danger"><u>Deze activiteit is helaas
                                        vol!</u></p>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
