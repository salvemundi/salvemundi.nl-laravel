<div class="modal fade" style="z-index: 1000000;" id="deleteRoute{{ $route->id }}" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Verwijder route {{ $route->route }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="/admin/route/{{ $route->id }}/delete">
                @csrf
                <div class="modal-body">
                    <h5>Weet je zeker dat je deze route wil verwijderen? Dit houdt in dat alle groepen met deze route
                        dit pad niet meer kunnen benaderen tenzij zij de * route hebben.</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Verwijder</button>
                </div>
            </form>
        </div>
    </div>
</div>
