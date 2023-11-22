@if (session()->has('error'))
    <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
@endif
@if (session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif
@if (session()->has('message'))
    <div class="alert alert-primary">
        {{ session()->get('message') }}
    </div>
@endif
