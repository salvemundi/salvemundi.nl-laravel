@if (session()->has('error'))
    <div class="alert alert-danger mt-2">
        {{ session()->get('error') }}
    </div>
@endif
@if (session()->has('success'))
    <div class="alert alert-success mt-2">
        {{ session()->get('success') }}
    </div>
@endif
@if (session()->has('message'))
    <div class="alert alert-primary mt-2">
        {{ session()->get('message') }}
    </div>
@endif
