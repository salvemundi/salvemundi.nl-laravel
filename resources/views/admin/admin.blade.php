@extends('layouts.appmin')
@section('content')
<div class="adminOverlap container">
    <div class="row mb-2">
        <div class="col-md-6 mt-3">
            <a href="/admin/leden">
                <div class="card adminCard grow">
                    <div class="card-body">
                        <div class="row align-items-center gx-0">
                            <div class="col">
                                <h6 class="text-uppercase text-muted mb-2">Aantal leden:</h6>
                                <span class="h2 mb-0"><i style="display: flex" class="fas fa-users"> <p class="dashboard-font"> &nbsp;{{ $userCount }}</p></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 mt-3">
            <a href="/admin/intro">
                <div class="card adminCard grow">
                    <div class="card-body">
                        <div class="row align-items-center gx-0">
                            <div class="col">
                                @if($introSetting->settingValue == 1)
                                    <h6 class="text-uppercase text-muted mb-2">Aantal intro inschrijvingen</h6>
                                    <span class="h2 mb-0"><i style="display: flex" class="fas fa-list"> <p class="dashboard-font"> &nbsp;{{ $introCount }}</p></i></span>
                                @else
                                    <h6 class="text-uppercase text-muted mb-2">De intro inschrijvingen staan uit</h6>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-6">
            <a href="/admin/sponsors">
                <div class="card adminCard grow">
                    <div class="card-body">
                        <div class="row align-items-center gx-0">
                            <div class="col">
                            <h6 class="text-uppercase text-muted mb-2">Aantal sponsoren</h6>
                                <span class="h2 mb-0"><i style="display: flex" class="fas fa-hand-holding-usd"> <p class="dashboard-font"> &nbsp;{{ $sponsorsCount }}</p></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="/admin/transactie">
                <div class="card adminCard grow">
                    <div class="card-body">
                        <div class="row align-items-center gx-0">
                            <div class="col">
                                <h6 class="text-uppercase text-muted mb-2">Aantal transacties</h6>
                                <span class="h2 mb-0"><i style="display: flex" class="fas fa-money-bill-wave"> <p class="dashboard-font"> &nbsp;{{ $transactionCount}}</p></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-6">
            <a href="/admin/leden">
                <div class="card adminCard grow">
                    <div class="card-body">
                        <div class="row align-items-center gx-0">
                            <div class="col">
                                <h6 class="text-uppercase text-muted mb-2">Aantal leden die moeten betalen</h6>
                                <span class="h2 mb-0"><i style="display: flex" class="fas fa-users"> <p class="dashboard-font"> &nbsp;{{ $OpenPaymentsCount }}</p></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @if($whatsappLinks != null)
            <div class="col-md-6">
                <a href="/admin/whatsapp">
                    <div class="card adminCard grow">
                        <div class="card-body">
                            <div class="row align-items-center gx-0">
                                <div class="col">
                                    <h6 class="text-uppercase text-muted mb-2">Laatste whatsapp link</h6>
                                    <span class="h2 mb-0"><i style="display: flex" class="fab fa-whatsapp"> <p class="dashboard-font"> &nbsp;{{ $whatsappLinks->updated_at->format('d/m/Y') }}</p></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endif
    </div>
</div>
<script>
    function CopyMe(oFileInput, sTargetID) {
        document.getElementById(sTargetID).value = oFileInput.value;
    }

</script>

{{-- <script src="extensions/resizable/bootstrap-table-resizable.js"></script> --}}
@endsection
