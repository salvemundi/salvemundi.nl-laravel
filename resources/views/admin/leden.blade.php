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
                            <th>Achternaam</th>
                            <th>E-mail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                                <tr>
                                    <th>{{$user->FirstName}}</th>
                                    <th>{{$user->LastName}}</th>
                                    <th>{{$user->email}}</th>
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
