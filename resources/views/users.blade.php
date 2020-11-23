@extends('layouts.app')

@section('content')
<div class="overlap grid">


@foreach ($imguserarray as $users)
<?php
dd($imguserarray);
?>
<div class="card">
    <div class="row">


            @if($users != null)
                <div class="col-md-4">
                    <?php
                        dd($users);
                        echo '<img class="pfPhoto" src="data:'.';base64,'.base64_encode($users[1]).'" />';
                    ?>
                </div>
            @else
                <img class="pfPhoto" src="images/SalveMundiLogo.png"/>
            @endif

                <div class="col-md-4">
                    <h4 class="card-title">{{$users[0]->getDisplayName() }}</h4>
                </div>

        </div>
    </div>
    @endforeach
</div>
@endsection
