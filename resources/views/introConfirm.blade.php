@extends('layouts.app')

@section('content')

<script src="js/scrollonload.js"></script>
<div class="overlap">
    <div class="row center">
        @if($introSetting->settingValue == 0 || $introConfirmSetting->settingValue == 0)
            <script>window.location = "/";</script>
        @else
            <div id="contact" class="col-md-6">
                @if(session()->has('message'))
                <div class="alert alert-primary">
                    {{ session()->get('message') }}
                </div>
                @endif

                @if($message ?? '' != null)
                    <div class="alert alert-primary">
                        {{ $message ?? '' }}
                    </div>
                @endif
                <form action="/intro/store" method="post">
                    @csrf
                    <br>
                    <h2 class="h2">Aanmelden voor de intro</h2>
                    <p>Gegevens van je contactpersoon / ouders zijn verplicht. De betreffende invulvelden zul je zien na het invullen van je geboortedatum. Deze informatie wordt enkel in nood situaties gebruikt.</p>
                        <br>
                        <label for="voornaam">Voornaam*</label>
                        <input class="form-control{{ $errors->has('firstName') ? ' is-invalid' : '' }}" value="{{ old('firstName') }}" type="text" id="firstName" name="firstName" placeholder="Voornaam...">

                        <br>
                        <label for="Tussenvoegsel">Tussenvoegsel</label>
                        <input class="form-control{{ $errors->has('insertion') ? ' is-invalid' : '' }}" value="{{ old('insertion') }}" type="text" id="insertion" name="insertion" placeholder="Tussenvoegsel...">

                        <br>
                        <label for="Achternaam">Achternaam*</label>
                        <input class="form-control{{ $errors->has('lastName') ? ' is-invalid' : '' }}" value="{{ old('lastName') }}" type="text" id="lastName" name="lastName" placeholder="Achternaam...">

                        <br>
                        <label for="Geboortedatum">Geboortedatum*</label>
                        <input class="form-control{{ $errors->has('birthday') ? ' is-invalid' : '' }}" value="{{ old('birthday') }}" type="date" id="birthday" name="birthday" placeholder="MM-DD-JJJJ..." onblur="getAge()">

                        <div id="ShowIfBelow18" style="display: none;">
                            <br>
                            <label for="VoornaamVoogd">Voornaam ouder/verzorger*</label>
                            <input class="form-control{{ $errors->has('firstNameParent') ? ' is-invalid' : '' }}" value="{{ old('firstNameParent') }}" type="text" id="firstNameParent" name="firstNameParent" placeholder="Voornaam ouder/verzorger...">

                            <br>
                            <label for="AchternaamVoogd">Achternaam ouder/verzorger*</label>
                            <input class="form-control{{ $errors->has('lastNameParent') ? ' is-invalid' : '' }}" value="{{ old('lastNameParent') }}" type="text" id="lastNameParent" name="lastNameParent" placeholder="Achternaam ouder/verzorger...">

                            <br>
                            <label for="AdresVoogd">Adres ouder/verzorger*</label>
                            <input class="form-control{{ $errors->has('adressParent') ? ' is-invalid' : '' }}" value="{{ old('adressParent') }}" type="text" id="addressParent" name="addressParent" placeholder="Adres ouder/verzorger...">

                            <br>
                            <label for="TelefoonnummerVoogd">Telefoonnummer ouder/verzorger*</label>
                            <input class="form-control{{ $errors->has('phoneNumberParent') ? ' is-invalid' : '' }}" value="{{ old('phoneNumberParent') }}" type="text" id="phoneNumberParent" name="phoneNumberParent" placeholder="Telefoonnummer ouder/verzorger...">
                        </div>

                        <div id="ShowIfAbove18" style="display: none;">
                            <br>
                            <label for="VoornaamVoogd">Voornaam contactpersoon*</label>
                            <input class="form-control{{ $errors->has('firstNameParent') ? ' is-invalid' : '' }}" value="{{ old('firstNameParent') }}" type="text" id="firstNameContact" name="firstNameContact" placeholder="Voornaam contactpersoon...">

                            <br>
                            <label for="AchternaamVoogd">Achternaam contactpersoon*</label>
                            <input class="form-control{{ $errors->has('lastNameParent') ? ' is-invalid' : '' }}" value="{{ old('lastNameParent') }}" type="text" id="lastNameContact" name="lastNameContact" placeholder="Achternaam contactpersoon...">

                            <br>
                            <label for="TelefoonnummerVoogd">Telefoonnummer contactpersoon*</label>
                            <input class="form-control{{ $errors->has('phoneNumberParent') ? ' is-invalid' : '' }}" value="{{ old('phoneNumberParent') }}" type="text" id="phoneNumberContact" name="phoneNumberContact" placeholder="Telefoonnummer contactpersoon...">
                        </div>

                        <br>
                        <label for="Email">E-mail*</label>
                        <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" type="email" id="email" name="email" placeholder="E-mail...">

                        <br>
                        <label for="Telefoonnummer">Telefoon nummer*</label>
                        <input class="form-control{{ $errors->has('phoneNumber') ? ' is-invalid' : '' }}" value="{{ old('phoneNumber') }}" type="phoneNumber" id="phoneNumber" name="phoneNumber" placeholder="Telefoon nummer...">

                        <br>
                        <label for="medicalIssues">Allergieën/ medicijnen</label>
                        <input class="form-control" value="{{ old('medicalIssues') }}" type="text" id="medicalIssues" name="medicalIssues" placeholder="Allergieën/ medicijnen...">

                        <br>
                        <label for="specials">Andere bijzonderheden</label>
                        <textarea class="form-control" value="{{{ old('specials') }}}" type="textarea" id="specials" name="specials" placeholder="bijzonderheden..."></textarea>

                        <br>
                        <input class="inp-cbx" id="cbx" name="checkbox" type="checkbox" style="display: none"/>
                        <label class="cbx{{ $errors->has('checkbox') ? ' is-invalid' : '' }}" value="{{old('checkbox') }}" for="cbx"><span>
                            <svg width="12px" height="10px" viewbox="0 0 12 10">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                            </svg></span><span>Ik accepteer de <a href="https://salvemundi.sharepoint.com/:w:/g/ESpPjIBFAeNKv-jFSsoIlpIBrihiqYzlV2MLsl4__TsohA?e=Ccn8mR" target="blank" style="text-decoration: underline !important;">algemene voorwaarden</a>*</span></label>
                            <br>
                            <br>
                            Tijdens de intro zullen er corona sneltesten afgenomen worden
                        <br>
                        <input class="inp-cdx" id="cdx" name="checkboxCorona" type="checkbox" style="display: none"/>
                        <label class="cdx{{ $errors->has('checkboxCorona') ? ' is-invalid' : '' }}" value="{{old('checkboxCorona') }}" for="cdx"><span>
                            <svg width="12px" height="10px" viewbox="0 0 12 10">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                            </svg></span><span>Ik ga akkoord met het afnemen van een corona sneltest indien nodig*</span></label>
                            <br><br>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="introYear" id="exampleRadios" value="{{App\Enums\IntroStudentYear::FirstYear()}}" checked>
                            <label class="form-check-label" for="exampleRadios">
                                Ik ben aankomend student
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="introYear" id="exampleRadios2" value="{{App\Enums\IntroStudentYear::SecondYear()}}">
                            <label class="form-check-label" for="exampleRadios2">
                                Ik ben al student
                            </label>
                        </div>
                        <br>
                        <b><label for="transport">Kies je vervoer*</label></b>

                        <p>
                            Omdat er niet op onze locatie geslapen mag worden hebben wij bussen geregeld die s' ochtends van Eindhoven naar onze locatie rijden en s' avonds je weer terug naar eindhoven brengt.
                        </p>
                        <p>
                            Veel van onze medestudenten zullen camperen op een nabijgelegen camping los van het evenement. Dit is op eigen risico en eigen verantwoording. Reserveren is alleen mogelijk via de telefoon als je aangeeft dat je voor de intro van Salve Mundi komt. Er zal geen actieve begeleiding of verzorging vanuit Salve Mundi plaats vinden op deze camping.
                        </p>
                        <p>
                            Je kan natuurlijk ook je eigen vervoer regelen.
                        </p>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="transport" id="exampleRadios4" value="{{App\Enums\Transport::camping()}}" checked>
                            <label class="form-check-label" for="exampleRadios4">
                                Camping
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="transport" id="exampleRadios3" value="{{App\Enums\Transport::bus()}}">
                            <label class="form-check-label" for="exampleRadios3">
                                Bus
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="transport" id="exampleRadios5" value="{{App\Enums\Transport::own_transport()}}">
                            <label class="form-check-label" for="exampleRadios5">
                                Eigen vervoer
                            </label>
                        </div>
                        <br>
                        <input class="btn btn-primary" type="submit" value="Versturen">
                </form>
            </div>
        @endif
    </div>
</div>


<script>
    function getAge() {
        var dateString = document.getElementById("birthday").value;
        if(dateString !="")
        {
            var today = new Date();
            var birthDate = new Date(dateString);
            var age = today.getFullYear() - birthDate.getFullYear();
            var month = today.getMonth() - birthDate.getMonth();
            var date = today.getDate() - birthDate.getDate();

            if (month < 0 || (month === 0 && today.getDate() < birthDate.getDate()))
            {
                age--;
            }
            if(month< 0)
            {
                month += 12;
            }
            if(date< 0)
            {
                date += 30;
            }
            if(age < 18 || age > 100)
            {
                document.getElementById("ShowIfBelow18").style.display = "inline";
                document.getElementById("ShowIfAbove18").style.display = "none";
            }
            else
            {
                document.getElementById("ShowIfBelow18").style.display = "none";
                document.getElementById("ShowIfAbove18").style.display = "inline";
            }
        }
    }
    </script>
@endsection
