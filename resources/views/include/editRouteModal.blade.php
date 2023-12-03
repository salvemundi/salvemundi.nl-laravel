<div class="modal fade" style="z-index: 1000000;" id="editRoute{{ $route->id }}" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Bewerk route {{ $route->route }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="/admin/route/{{ $route->id }}/store">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Route pad:</label>
                        <input type="text" name="route" class="form-control" value="{{ $route->route }}"
                            id="exampleFormControlInput1" placeholder="/admin/...">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Route beschrijving:</label>
                        <input type="text" name="description" class="form-control" value="{{ $route->description }}"
                            id="exampleFormControlInput1" placeholder="/admin/...">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
