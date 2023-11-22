<div class="modal fade" style="z-index: 1000000;" id="deletePizzas" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Verwijder alle pizzas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="/pizza/delete/all">
                @csrf
                <div class="modal-body">
                    <h5>Weet je zeker dat je alle pizza bestellingen wil verwijderen?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Verwijder</button>
                </div>
            </form>
        </div>
    </div>
</div>
