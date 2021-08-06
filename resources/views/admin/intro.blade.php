@extends('layouts.appmin')
@section('content')
<script>
    function CopyMe(oFileInput, sTargetID) {
        document.getElementById(sTargetID).value = oFileInput.value;
    }
</script>
<div class="row widthFix adminOverlap mijnSlider center">
    @if(session()->has('information'))
    <div class="alert alert-primary">
        {{ session()->get('information') }}
    </div>
    @endif
    <div style="display:inline">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
{{--                <a class="nav-link active" id="inschrijvingen-tab" data-toggle="tab" href="#inschrijvingen" role="tab"--}}
{{--                   aria-controls="inschrijvingen" aria-selected="true"><i class="fa fa-credit-card"></i> Betaald</a>--}}
                <button class="nav-link tabber" id="contact-tab" data-bs-toggle="tab" data-bs-target="#inschrijvingen" type="button" role="tab" aria-controls="contact" aria-selected="false"><i class="fa fa-credit-card"></i> Betaald</button>

            </li>
            <li class="nav-item">
                <button class="nav-link tabber" id="contact-tab" data-bs-toggle="tab" data-bs-target="#gegevens" type="button" role="tab" aria-controls="contact" aria-selected="false"><i class="fas fa-user"></i> Ingeschreven</button>
{{--                <a class="nav-link" id="gegevens-tab" data-toggle="tab" href="#gegevens" role="tab"--}}
{{--                   aria-controls="gegevens" aria-selected="false"><i class="fas fa-user"></i> Ingeschreven</a>--}}
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div id="inschrijvingen" class="tabcontent tab-pane fade show showMyAcc active" role="tabcontent"
                 aria-labelledby="inschrijvingen-tab" class="tabcontent">
                <div class="col-md-12 center">
                    <div class="table-responsive center centerTable">
                        <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
                            data-show-columns="true">
                            <thead>
                                <tr class="tr-class-1">
                                    <th data-field="firstName" data-sortable="true">Voornaam</th>
                                    <th data-field="lastName" data-sortable="true">Achternaam</th>
                                    <th data-field="email" data-sortable="true">E-mail</th>
                                    <th data-field="paymentStatus" data-sortable="true">Betalings Status</th>
                                    <th data-field="phoneNumber" data-sortable="true">Telefoonnummer</th>
                                    <th data-field="birthday" data-sortable="true">verjaardag</th>
                                    <th data-field="medicalIssues" data-sortable="true">Allergieën/ medicijnen</th>
                                    <th data-field="specials" data-sortable="true">andere bijzonderheden</th>
                                    <th data-field="year" data-sortable="true">Jaar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($introObjects as $user)
                                    <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                        <td data-value="{{ $user->firstName }}">{{$user->firstName}}</td>
                                        <td data-value="{{ $user->lastName }}">{{$user->lastName}}</td>
                                        <td data-value="{{ $user->email }}">{{$user->email}}</td>
                                        <td data-value="{{ $user->payment->paymentStatus }}">{{ \App\Enums\paymentStatus::fromValue($user->payment->paymentStatus)->key }}</td>
                                        <td data-value="{{ $user->phoneNumber }}">{{$user->phoneNumber}}</td>
                                        <td data-value="{{ $user->birthday }}">{{$user->birthday}}</td>
                                        <td data-value="{{ $user->medicalIssues }}">{{$user->medicalIssues}}</td>
                                        <td data-value="{{ $user->specials }}">{{$user->specials}}</td>
                                        <td data-value="{{ $user->studentYear }}">{{ \App\Enums\IntroStudentYear::fromValue($user->studentYear)->key }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="gegevens" class="tabcontent" role="tabpanel" aria-labelledby="gegevens-tab">
                <div class="col-md-12 center">
                    <div class="table-responsive center centerTable">
                        <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
                               data-show-columns="true">
                            <thead>
                            <tr class="tr-class-1">
                                <th data-field="firstName" data-sortable="true">Voornaam</th>
                                <th data-field="lastName" data-sortable="true">Achternaam</th>
                                <th data-field="email" data-sortable="true">E-mail</th>
                                <th data-field="year" data-sortable="true">Jaar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($introSignUp as $user)
                                <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                    <td data-value="{{ $user->firstname }}">{{$user->firstname}}</td>
                                    <td data-value="{{ $user->lastname }}">{{$user->lastname}}</td>
                                    <td data-value="{{ $user->email }}">{{$user->email}}</td>
                                    <td data-value="{{ $user->studentYear }}">{{ \App\Enums\IntroStudentYear::fromValue($user->studentYear)->key }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



            <div class="introCheck widthFix center">
                <form method="POST" action="intro/store">
                    @csrf
                    @if($introSetting->settingValue == 1)
                        <input class="inp-cbx" id="cbx" name="cbx" type="checkbox" checked style="display: none"/>
                    @elseif($introSetting->settingValue == 0)
                        <input class="inp-cbx" id="cbx" name="cbx" type="checkbox" style="display: none"/>
                    @endif
                    <label class="cbx" for="cbx"><span>
                    <svg width="12px" height="10px" viewbox="0 0 12 10">
                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                    </svg></span><span>Intro inschrijvingen aan / uit zetten.</span></label>
                    <button type="submit" class="btn btn-primary btn-sm">Opslaan</button>
                </form> &nbsp; &nbsp;
                <form method="POST" action="intro/storeConfirm">
                    @csrf
                    @if($introConfirmSetting->settingValue == 1)
                        <input class="inp-cdx" id="cdx" name="cdx" type="checkbox" checked style="display: none"/>
                    @elseif($introConfirmSetting->settingValue == 0)
                        <input class="inp-cdx" id="cdx" name="cdx" type="checkbox" style="display: none"/>
                    @endif
                    <label class="cdx" for="cdx"><span>
                    <svg width="12px" height="10px" viewbox="0 0 12 10">
                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                    </svg></span><span>Intro inschrijvingen met betaling aan / uit zetten.</span></label>
                    <button type="submit" class="btn btn-primary btn-sm">Opslaan</button>

                    &nbsp;
                    <a href="{{ route('export_excel.excelBetaald')}}" class="btn btn-primary btn-sm">Export to Excel</a>
                    <a href="{{ route('export_excel.excelIedereen')}}" class="btn btn-primary btn-sm">Export niet betaalde to Excel</a>
{{--                    <div class="dropdown">--}}
{{--                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                            Dropdown button--}}
{{--                        </button>--}}
{{--                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">--}}
{{--                            <li><a href="mailto:?bcc={{ implode(',', $emailsFirstYear) }}" class="dropdown-item">Maak mail voor 1e jaars die niet betaald hebben</a></li>--}}
{{--                            <li><a href="mailto:?bcc={{ implode(',', $emailsSecondYear) }}" class="dropdown-item">Maak mail voor 2e jaars die niet betaald hebben</a></li>--}}
{{--                            <li><a href="mailto:?bcc={{ implode(',', $emailsSecondYear) }}" class="dropdown-item">Maak mail richting iedereen die niet betaald heeft</a></li>--}}
{{--                            <li><a href="mailto:?bcc={{ implode(',', $emailsSecondYear) }}" class="dropdown-item">Maak mail richting iedereen die betaald heeft</a></li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Mail
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="mailto:?bcc={{ implode(',', $emailsFirstYear) }}" class="dropdown-item">Maak mail voor 1e jaars die niet betaald hebben</a></li>
                            <li><a href="mailto:?bcc={{ implode(',', $emailsSecondYear) }}" class="dropdown-item">Maak mail voor 2e jaars die niet betaald hebben</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a href="mailto:?bcc={{ implode(',', $emailPaid) }}" class="dropdown-item">Maak mail richting iedereen die betaald heeft</a></li>
                            <li><a href="mailto:?bcc={{ implode(',', $emailNonPaid) }}" class="dropdown-item">Maak mail richting iedereen die niet betaald heeft</a></li>
                            <li><a href="mailto:?bcc={{ implode(',', $allEmails) }}" class="dropdown-item">Maak mail richting iedereen</a></li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
