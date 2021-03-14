@extends('layouts.app')

@section('content')


<div class="overlap">
    <div class="row center">
        @if($introSetting->settingValue == 0)
            <script>window.location = "/";</script>
        @else
            <div id="contact" class="col-md-6">
                {{-- @if(session()->has('message'))
                <div class="alert alert-primary">
                    {{ session()->get('message') }}
                </div>
                @endif --}}

                {{-- @if($message ?? '' != null)
                    <div class="alert alert-primary">
                        {{ $message ?? '' }}
                    </div>
                @endif --}}
                <form action="/intro/store" method="post">
                    @csrf
                    <br>
                    <h2 class="h2">Aanmelden voor de intro</h2>

                        <br>
                        <label for="voornaam">Voornaam</label>
                        <input class="form-control{{ $errors->has('firstName') ? ' is-invalid' : '' }}" value="{{ old('firstName') }}" type="text" id="firstName" name="firstName" placeholder="Voornaam...">

                        <br>
                        <label for="Tussenvoegsel">Tussenvoegsel</label>
                        <input class="form-control{{ $errors->has('insertion') ? ' is-invalid' : '' }}" value="{{ old('insertion') }}" type="text" id="insertion" name="insertion" placeholder="Tussenvoegsel...">

                        <br>
                        <label for="Achternaam">Achternaam</label>
                        <input class="form-control{{ $errors->has('lastName') ? ' is-invalid' : '' }}" value="{{ old('lastName') }}" type="text" id="lastName" name="lastName" placeholder="Achternaam...">

                        <br>
                        <label for="Geboortedatum">Geboortedatum</label>
                        <input class="form-control{{ $errors->has('birthday') ? ' is-invalid' : '' }}" value="{{ old('birthday') }}" type="date" id="birthday" name="birthday" placeholder="MM-DD-JJJJ..." onblur="getAge()">




                        <div id="ShowIfBelow18" style="display: none;">
                            <br>
                            <label for="VoornaamVoogd">Voornaam ouder/verzorger</label>
                            <input class="form-control{{ $errors->has('firstNameParent') ? ' is-invalid' : '' }}" value="{{ old('firstNameParent') }}" type="text" id="firstNameParent" name="firstNameParent" placeholder="Voornaam ouder/verzorger...">

                            <br>
                            <label for="AchternaamVoogd">Achternaam ouder/verzorger</label>
                            <input class="form-control{{ $errors->has('lastNameParent') ? ' is-invalid' : '' }}" value="{{ old('lastNameParent') }}" type="text" id="lastNameParent" name="lastNameParent" placeholder="Achternaam ouder/verzorger...">

                            <br>
                            <label for="AdresVoogd">Adres ouder/verzorger</label>
                            <input class="form-control{{ $errors->has('adressParent') ? ' is-invalid' : '' }}" value="{{ old('adressParent') }}" type="text" id="addressParent" name="addressParent" placeholder="Adres ouder/verzorger...">

                            <br>
                            <label for="TelefoonnummerVoogd">Telefoonnummer ouder/verzorger</label>
                            <input class="form-control{{ $errors->has('phoneNumberParent') ? ' is-invalid' : '' }}" value="{{ old('phoneNumberParent') }}" type="text" id="phoneNumberParent" name="phoneNumberParent" placeholder="Telefoonnummer ouder/verzorger...">
                        </div>


                        <br>
                        <label for="Email">E-mail</label>
                        <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" type="email" id="email" name="email" placeholder="E-mail...">

                        <br>
                        <label for="Telefoonnummer">Telefoon nummer</label>
                        <input class="form-control{{ $errors->has('phoneNumber') ? ' is-invalid' : '' }}" value="{{ old('phoneNumber') }}" type="phoneNumber" id="phoneNumber" name="phoneNumber" placeholder="Telefoon nummer...">

                        <br>
                        <label for="medicalIssues">Allergieën/ medicijnen</label>
                        <input class="form-control" type="text" id="medicalIssues" name="medicalIssues" placeholder="Allergieën/ medicijnen...">

                        <br>
                        <label for="specials">Andere bijzonderheden</label>
                        <textarea class="form-control" type="textarea" id="specials" name="specials" placeholder="bijzonderheden...">

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
            }
            else
            {
                document.getElementById("ShowIfBelow18").style.display = "none";
            }
        }
    }
    </script>
@endsection
