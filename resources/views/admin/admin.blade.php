@extends('layouts.appmin')
@section('content')
<div class="adminOverlap">
    <div class="row">
        <div class="col-md-6">
            <div class="stati svdark">
                <div><p>Aantal Leden</p></div>
                <i style="display: flex" class="fas fa-users"> <p class="dashboard-font">{{ $userCount }}</p></i>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stati svdark">
                <div><p>Aantal intro inschrijvingen</p></div>
                <i style="display: flex" class="fas fa-list"> <p class="dashboard-font">{{ $introCount }}</p> </i>
            </div>
        </div>
        @if($whatsappLinks != null)
            <div class="col-md-6">
                <div class="stati svdark">
                    <div><p>Laatste whatsappLink</p></div>
                    <i style="display: flex" class="fas fa-users"> <p class="dashboard-font">{{ $whatsappLinks->updated_at }}</p> </i>
                </div>
            </div>
        @endif
        <div class="col-md-6">
            <div class="stati svdark">
                <div><p>Aantal sponsoren</p></div>
                <i style="display: flex" class="fas fa-users"> <p class="dashboard-font">{{ $sponsorsCount }}</p> </i>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stati svdark">
                <div><p>Aantal transacties</p></div>
                <i style="display: flex" class="fas fa-users"> <p class="dashboard-font">{{ $transactionCount}}</p> </i>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stati svdark">
                <div><p>Aantal leden die moeten betalen</p></div>
                <i style="display: flex" class="fas fa-users"> <p class="dashboard-font">{{ $OpenPaymentsCount }}</p> </i>
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
