@extends('layouts.stickerapp')
@section('content')

<br><br><br><br><br>
<div class="justify-content-center m-md-5 m-2">
    <div id="map" class="mx-auto" style="height: 800px"></div>
</div>

@if(session('userName'))
    <div class="row widthFix adminOverlap center removeAutoMargin">
        <div class="col-auto col-md-8 col-sm-8">
            <div class="table-responsive">
                <table id="table" data-toggle="table" data-search="true" data-sortable="true" data-pagination="true"
                    data-show-columns="true">
                    <thead>
                        <tr class="tr-class-1">
                            <th data-field="longitude" data-sortable="true" data-width="250">Latitude</th>
                            <th data-field="latitude" data-sortable="true">Longitude</th>
                            <th data-field="date" data-sortable="true">Datum</th>
                            <th data-field="delete" data-sortable="true">Verwijderen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userStickers as $sticker)
                            <tr id="tr-id-3" class="tr-class-2" data-title="bootstrap table">
                                <td data-value="{{ $sticker->latitude }}">{{$sticker->latitude}}</td>
                                <td data-value="{{ $sticker->longitude }}">{{$sticker->longitude}}</td>
                                <td data-value="{{ $sticker->created_at }}">{{$sticker->created_at}}</td>
                                <td data-value="{{ $sticker->id }}"><form method="post" action="/stickers/delete">@csrf<input type="hidden" name="id" id="id" value="{{ $sticker->id }}"><button type="submit" class="btn btn-danger" onclick="return confirm('Weet je zeker dat je deze sticker wilt verwijderen? Dit kan NIET ongedaan gemaakt worden');">Verwijderen</button></form></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row widthFix adminOverlap center removeAutoMargin">
        <div id="contact" class="col-auto col-lg-6 col-md-6 col-sm-8">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
            @if(session()->has('information'))
                <div class="alert alert-primary">
                    {{ session()->get('information') }}
                </div>
            @endif

            <form action="stickers/store" method="post" enctype="multipart/form-data">
                @csrf
                <br>
                <h2 class="h2">Sticker toevoegen</h2>

                <div class="form-group">
                    <label for="latitude">Latitude*</label>
                    <input class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}" value="{{ old('latitude') }}" id="latitude" name="latitude" placeholder="Latitude...">
                </div>

                <div class="form-group">
                    <label for="longitude">Longitude*</label>
                    <input class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}" value="{{ old('longitude') }}" id="longitude" name="longitude" placeholder="Longitude...">
                </div>

                <div class="form-group mx-auto my-3">
                    <br>
                    <input class="btn btn-primary" type="submit" value="Toevoegen">
                    <a class="btn btn-primary" onclick="getLocation()">Pak huidige locatie</a>
                </div>
            </form>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>

    <script>
        // Get input fields
        var x = document.getElementById("latitude");
        var y = document.getElementById("longitude");

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.innerHTML="Geolocation is not supported by this browser.";
            }
        }

        function showPosition(position) {
            // Fill in input field value
            x.value=position.coords.latitude;
            y.value=position.coords.longitude;
        }
    </script>
@endif

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>

<script>
    // Get locations with this specific notation, otherwise it would not work
    var locations = {!! json_encode($stickers); !!}
    // Custom icon
    var icon = L.icon({
        iconUrl: 'data:image/png;base64,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',
        iconSize: [40, 25],
    });

    var map = L.map('map').setView([52.1326, 5.2913], 8);
    mapLink =
    '<a href="http://openstreetmap.org">OpenStreetMap</a>';
    L.tileLayer(
    'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; ' + mapLink + ' Contributors',
        maxZoom: 18,
    }).addTo(map);

    var today = new Date().toISOString().slice(0, 10)

    // For loop to put multiple markers
    for (var i = 0; i < locations.length; i++) {
        var startDate  = locations[i].created_at;
        var endDate    = today;

        var diffInMs   = new Date(endDate) - new Date(startDate)
        var diffInDays = diffInMs / (1000 * 60 * 60 * 24);
        var days = Math.round(diffInDays);

        if (days <= 0) {
            days = 0;
        }

        console.log(locations)
        marker = new L.marker([locations[i].latitude, locations[i].longitude], {icon: icon})
            .bindPopup(days.toString() + " dagen geleden")
            .addTo(map);
    }

</script>

@endsection
