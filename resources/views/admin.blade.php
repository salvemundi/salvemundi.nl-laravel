@extends('layouts.appmin')
@section('content')
<div class="adminOverlap">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Voornaam</th>
                            <th>Tussenvoegsel</th>
                            <th>Achternaam</th>
                            <th>Leeftijd</th>
                            <th>Betaald?</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($signins as $signin)
                                <tr>
                                    <th>{{$signin->firstName}}</th>
                                    <th>
                                        @if($signin->insertion != "")
                                            {{ $signin->insertion }}
                                        @endif
                                    </th>
                                    <th>{{$signin->lastName}}</th>
                                    <th>{{{ date("d-m-Y", strtotime($signin->birthday)) }}}</th>
{{--                                    <th>{{\App\Enums\paymentStatus::getDescription($signin->paymentStatus)}}</th>--}}
                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
