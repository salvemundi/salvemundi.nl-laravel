<div class="modal fade" style="z-index: 1000000;" id="deletePermission{{ $permission->id }}" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Verwijder {{ $permission->description }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="/admin/rechten/{{ $permission->id }}/delete">
                @csrf
                <div class="modal-body">
                    <h5>Weet je zeker dat je deze wil verwijderen? Dit houdt in dat alle commissies / gebruikers met
                        deze groep in hun rechten de nu aangewezen admin pagina's niet meer kunnen bereiken.</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Verwijder</button>
                </div>
            </form>
        </div>
    </div>
</div>
