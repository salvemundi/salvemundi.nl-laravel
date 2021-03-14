@extends('layouts.appmin')
@section('content')
<div class="adminOverlap">
    <div class="mijnSlider">
        <div class="row">
            <div class="col-md-6">
                <a href="/admin/leden">
                    <div class="stati svdark">
                        <div><p><h3>Aantal Leden</h3></p></div>
                        <i style="display: flex" class="fas fa-users"> <p class="dashboard-font">{{ $userCount }}</p></i>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="/admin/intro">
                    <div class="stati svdark">
                        @if($introSetting->settingValue  == 1)
                        <div><p><h3>Aantal intro inschrijvingen</h3></p></div>
                        <i style="display: flex" class="fas fa-list"> <p class="dashboard-font">{{ $introCount }}</p> </i>
                        @else
                        <div><p><h6><b>De intro inschrijving staat uit</b></h6></p></div>
                        <i style="display: flex" class="fas fa-list"> <p class="dashboard-font"></p> </i>
                        @endif
                    </div>
                </a>
            </div>
            @if($whatsappLinks != null)
                <div class="col-md-6">
                    <a href="/admin/whatsapp">
                        <div class="stati svdark">
                            <div><p><h3>Laatste whatsapp link</h3></p></div>
                            <i style="display: flex" class="fab fa-whatsapp"> <p class="dashboard-font">{{ $whatsappLinks->updated_at->format('d/m/Y') }}</p> </i>
                        </div>
                    </a>
                </div>
            @endif
            <div class="col-md-6">
                <a href="/admin/sponsors">
                    <div class="stati svdark">
                        <div><p><h3>Aantal sponsoren</h3></p></div>
                        <i style="display: flex" class="fas fa-hand-holding-usd"> <p class="dashboard-font">{{ $sponsorsCount }}</p> </i>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="/admin/transactie">
                    <div class="stati svdark">
                        <div><p><h3>Aantal transacties</h3></p></div>
                        <i style="display: flex" class="fas fa-money-bill-wave"> <p class="dashboard-font">{{ $transactionCount}}</p> </i>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="/admin/leden">
                    <div class="stati svdark">
                        <div><p><h3>Aantal leden die moeten betalen</h3></p></div>
                        <i style="display: flex" class="fas fa-users"> <p class="dashboard-font">{{ $OpenPaymentsCount }}</p> </i>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function CopyMe(oFileInput, sTargetID) {
        document.getElementById(sTargetID).value = oFileInput.value;
    }

</script>

{{-- <script src="extensions/resizable/bootstrap-table-resizable.js"></script> --}}
@endsection
