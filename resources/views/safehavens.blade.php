@extends('layouts.app')
@section('content')
<script src="js/scrollonload.js"></script>
<div class="overlap text-center">
    <h1 class="center">Safehavens</h1> <br>
    <div class="container">
        <h3 class="center">Binnen Salve Mundi vinden wij een veilige en comfortable omgeving heel belangrijk voor al onze leden. Hierom hebben wij Safe havens aangesteld die een luisterend oor bieden, begrip tonen, en advies geven voor jouw situatie. Een Safe haven heeft een geheimhoudingsplicht dus je klachten of meldingen zullen nooit verspreid worden, ook niet naar het bestuur; Tenzij door jou anders aangegeven.</h3><br>
        <h3 class="center"> Onze safe havens zijn er voor (maar niet gelimiteerd tot) de volgende onderwerpen:</h3>
        <div class="center">
            <ul class="text-lg-start">
                <li>
                    <h4>Aggressie / geweld</h4>
                </li>
                <li>
                    <h4>(seksuele) Intimidatie</h4>
                </li>
                <li>
                    <h4>Pesten</h4>
                </li>
                <li>
                    <h4>Discriminatie</h4>
                </li>
                <li>
                    <h4>(seksueel) Grens onverschrijdend gedrag</h4>
                </li>
                <li>
                    <h4>Persoonlijke situaties</h4>
                </li>
            </ul>
        </div>
        <h4 class="center">We streven ernaar dat deze personen verschillen van geslacht en dat wij safehavens zowel binnen als buiten het bestuur hebben. Zo hopen we dat er altijd iemand is waar je je veilig genoeg bij voelt om je klachten of meldingen mee te delen. Als dit niet het geval is ben vooral niet bang om naar Fontys zelf te stappen.</h4>
        <a class="btn btn-primary" href="https://www.fontys.nl/fontyshelpt.htm">Fontys vertrouwenspersonen</a>

    </div>
    <h2 class="center mt-5">Onze Safehavens:</h2>
        <div class="row center">
    @foreach($safeHavens as $safeHaven)
        @if ($safeHaven->visibility)
            <div class="col-12 col-sm-6 col-lg-3 my-2">
                            <div class="card">
                                <img class="img-fluid"
                                     src="{{ '/' . Thumbnailer::generate('storage/' . $safeHaven->ImgPath, '240x240') }}"
                                     onerror="this.src='../storage/images/SalveMundi-Vector.svg'">
                                <div class="card-body card-body-no-padding mt-2">
                                    <h5 class="card-title text-center">{{ $safeHaven->getDisplayName() }}</h5>
                                    @if(\Illuminate\Support\Facades\Auth::check())
                                        <p class="card-text text-center">{{ $safeHaven->email }}</p>
                                        <p class="card-text text-center mb-5">{{ $safeHaven->PhoneNumber }}</p>
                                    @endif
                                </div>
                            </div>
                    </div>
                @endif
    @endforeach
    </div>
</div>

@endsection