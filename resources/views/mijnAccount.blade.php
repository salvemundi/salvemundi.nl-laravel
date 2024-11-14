@extends('layouts.app')
@section('title', 'Mijn account – ' . config('app.name'))
@section('content')
    <script src="js/scrollonload.js"></script>
    <div class="overlap" id="navlink">
        @if (session()->has('message'))
            <div class="alert alert-primary">
                {{ session()->get('message') }}
            </div>
        @endif

        <h2>Mijn account</h2>
        <p>Zie hier jouw accountgegevens, transacties & overige informatie bestemd voor Salve Mundi Leden.</p>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            @if ($authorized)
                <li class="nav-item">
                    <a class="nav-link tabber" id="admin-tab" href="/admin"><i class="fas fa-user-cog"></i> Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link tabber" id="admin-new-tab" href="/management"><i class="fas fa-user-cog"></i> Admin (ALPHA)</a>
                </li>
            @endif
            <li class="nav-item">
                <button class="nav-link tabber active" id="gegevens-tab" data-bs-toggle="tab" data-bs-target="#gegevens"
                    type="button" role="tab" aria-controls="contact" aria-selected="false"><i class="fas fa-user"></i>
                    Gegevens</button>
            </li>
            <li class="nav-item">
                <button class="nav-link tabber" id="inschrijvingen-tab" data-bs-toggle="tab"
                    data-bs-target="#inschrijvingen" type="button" role="tab" aria-controls="contact"
                    aria-selected="false"><i class="fa fa-credit-card"></i>
                    Transacties</button>
            </li>
            <li class="nav-item">
                <button class="nav-link tabber" id="whatsapp-tab" data-bs-toggle="tab" data-bs-target="#whatsapp"
                    type="button" role="tab" aria-controls="contact" aria-selected="false"><i
                        class="fab fa-whatsapp"></i> Whatsapp</button>
            </li>
            <li class="nav-item">
                <button class="nav-link tabber" id="regels-tab" data-bs-toggle="tab" data-bs-target="#regels" type="button"
                    role="tab" aria-controls="contact" aria-selected="false"><i class="fas fa-heart"></i>
                    Regels</button>
            </li>
        </ul>
        <div class="tab-content mb-3" id="myTabContent">
            <div id="gegevens" class="tabcontent tab-pane fade show showMyAcc active" role="tabcontent"
                aria-labelledby="gegevens-tab" class="tabcontent">
                <h2>Jouw gegevens:</h2>
                @if ($subscriptionActive === 0)
                    <form action="/mijnAccount/pay" method="post">
                        @csrf
                        <p>
                            <b>Lidmaatschap: </b>
                            <button type="submit" class="myAccountBtn btn btn-secondary" data-toggle="tooltip"
                                data-placement="top"
                                title="Het kan zijn dat jouw lidmaatschap nog geldig is. Dit komt door de nieuwe website. Dit wordt opgelost als je weer hebt betaald. Als dat niet zo is moet je contact opnemen met het bestuur">
                                Non actief
                            </button>
                            <br>
                            <b>Coupon: </b>
                            <input type="text" class="form-control" name="coupon" placeholder="Coupon code hier...">
                            <br>
                            <button type="submit" class="btn btn-primary">Betaal</button>
                        </p>
                    </form>
                @else
                    <div style="float:left; display:inline;">
                        <p><b>Lidmaatschap: </b>
                            <button type="button" class="myAccountBtn btn btn-success" disabled>Actief</button>
                        </p>
                    </div>
                    <div style="float:left; display:inline;">
                        <form method="post" action="/mijnAccount/cancel">
                            @csrf
                            <button type="submit" class="myAccountBtn btn btn-danger">Annuleer</button>
                        </form>
                    </div>
                    <br>
                    <br>
                    <br>
                    <p><b>Je lidmaatschap is geldig tot: </b>{{ $expiryDate }}</p>
                @endif

                <form method="post" action="mijnAccount/store" enctype="multipart/form-data">
                    @csrf
                    @if ($user->visibility === 1)
                        <input class="inp-cbx" id="cbx" name="cbx" type="checkbox" checked
                            style="display: none" />
                    @elseif($user->visibility === 0)
                        <input class="inp-cbx" id="cbx" name="cbx" type="checkbox" style="display: none" />
                    @endif
                    <label class="cbx" for="cbx"><span>
                            <svg width="12px" height="10px" viewbox="0 0 12 10">
                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                            </svg></span><span>Ik wil op de website komen als ik bij een commissie hoor.</span></label>
                    <br>
                    <br>
                    <p><b>Naam:</b> {{ $user->DisplayName }} </p>
                    <p><b>Email:</b> {{ $user->email }} </p>
                    <div class="form-group">
                        @if ($user->PhoneNumber === null)
                            <label for="phoneNumber">Telefoonnummer</label>
                            <input type="tel"
                                class="form-control{{ $errors->has('phoneNumber') ? ' is-invalid' : '' }}"
                                value="{{ old('phoneNumber') }}" id="phoneNumber" name="phoneNumber"
                                placeholder="Telefoonnummer...">
                        @else
                            <p><b>Telefoonnummer:</b> {{ $user->PhoneNumber }} </p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="minecraft"><b>Minecraft Gebruikersnaam</b></label>
                        <input type="text"
                            class="w-auto form-control{{ $errors->has('minecraft') ? ' is-invalid' : '' }}"
                            value="{{ $user->minecraftUsername ?: old('minecraft') }}" id="minecraft" name="minecraft"
                            placeholder="Minecraft naam...">
                    </div>
                    <div class="form-group">
                        @if ($user->birthday === null)
                            <label for="birthday">Geboortedatum</label>
                            <input type="date" class="form-control{{ $errors->has('birthday') ? ' is-invalid' : '' }}"
                                value="{{ old('birthday') }}" id="birthday" name="birthday"
                                placeholder="Verjaardag...">
                        @else
                            <p><b>Verjaardag:</b> {{ date('d-m-Y', strtotime($user->birthday)) }}</p>
                        @endif
                    </div>

                    <p><b>Profiel foto:</b></p>
                    {!! '<img class="pfPhoto" src="storage/' . $user->ImgPath . '" />' !!}
                    <br>
                    <br>

                    <a class="btn btn-primary" onclick="myClickOnUrHand()">Foto bewerken</a>
                    <br>
                    <p id="demo"></p>

                    <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                    <button type="submit" class="btn btn-primary">Opslaan</button>
                </form>
            </div>

            <div id="inschrijvingen" class="tabcontent" role="tabpanel" aria-labelledby="inschrijvingen-tab">
                <h1>Transacties</h1>
                <form method="post" action="/mijnAccount/pay">
                    @csrf
                    <input type="hidden" name="firstName" value="{{ $user->FirstName }}">
                    <input type="hidden" name="lastName" value="{{ $user->LastName }}">
                    <input type="hidden" name="insertion" value="{{ $user->insertion }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">
                    <input type="hidden" name="phoneNumber" value="{{ $user->PhoneNumber }}">
                    @if ($subscriptionActive === 0)
                        <p>
                            <b>Lidmaatschap: </b>
                            <button type="submit" class="myAccountBtn btn btn-secondary" data-toggle="tooltip"
                                data-placement="top"
                                title="Het kan zijn dat jouw lidmaatschap nog geldig is. Dit komt door de nieuwe website. Dit wordt opgelost als je weer hebt betaald. Als dat niet zo is moet je contact opnemen met het bestuur">
                                Non actief
                            </button>
                        </p>
                </form>
            @else
                <div style="float:left; display:inline;">
                    <p><b>Lidmaatschap: </b>
                        <button type="button" class="myAccountBtn btn btn-success" disabled>Actief</button>
                    </p>
                </div>
                <div style="float:left; display:inline;">
                    <form method="post" action="/mijnAccount/cancel">
                        <input type="hidden" name="userId" value="{{ session('id') }}">
                        <button type="submit" class="myAccountBtn btn btn-danger">Annuleer</button>
                    </form>
                </div>
                @endif
                <table id="table" data-toggle="table">
                    <thead>
                        <tr>
                            <th data-field="toegekend">Toegekend aan</th>
                            <th data-field="inschrijving">Inschrijving</th>
                            <th data-field="paymentStatus">Betalings status</th>
                            <th data-field="price">Totaal prijs</th>
                            <th data-field="creationDate">Datum</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($transactions->count() > 0)
                            @foreach ($transactions as $transaction)
                                <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                    <td data-value="toegekend">
                                        {{ $user->FirstName }}
                                    </td>
                                    <td data-value="inschrijving">
                                        {{ $transaction->product? $transaction->product->name: $transaction->merch()->withTrashed()->first()->name }}
                                    </td>
                                    <td data-value="beschrijving">
                                        {{ App\Enums\paymentStatus::fromvalue($transaction->paymentStatus)->key }}</td>
                                    <td data-value="beschrijving">
                                        {{ '€ ' . $transaction->amount == 0 ? $transaction->product->amount : $transaction->amount }}
                                    </td>
                                    <td data-value="creationDate">{{ $transaction->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <div id="whatsapp" class="tabcontent" role="tabpanel" aria-labelledby="whatsapp-tab">
                <h1>Whatsapp</h1>
                <p>Op vrijwillige basis mag je deelnemen aan onze whatsapp groepen.</p>
                <table id="table" data-toggle="table" data-show-columns="true">
                    <thead>
                        <tr>
                            <th data-field="link">Link</th>
                            <th data-field="naam">Naam</th>
                            <th data-field="beschrijving">Beschrijving</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($whatsapplink as $whatsapp)
                            <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                <td data-value="link"><a class="text-decoration-underline"
                                        href="{{ $whatsapp->link }}">{{ $whatsapp->link }}</a></td>
                                <td data-value="naam">{{ $whatsapp->name }}</td>
                                <td data-value="beschrijving">{{ $whatsapp->description }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="regels" class="tabcontent" role="tabpanel" aria-labelledby="regels-tab">
                <h1>Regels</h1>
                <p>Dit zijn de regels binnnen Salve Mundi</p>
                <table id="table" data-toggle="table" data-show-columns="true">
                    <thead>
                        <tr>
                            <th data-field="naam">naam</th>
                            <th data-field="link">link</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rules as $rule)
                            <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                <td data-value="naam">{{ $rule->name }}</td>
                                <td data-value="link"><a class="text-decoration-underline"
                                        href="{{ $rule->link }}">{{ $rule->link }}</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function CopyMe(oFileInput, sTargetID) {
            document.getElementById(sTargetID).value = oFileInput.value;
        }
    </script>
@endsection
