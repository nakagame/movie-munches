{{-- Edit  --}}
<div class="modal fade" id="edit-genre-{{ $genre->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-warning bg-dark">
            <div class="modal-header border-warning">
                <h3 class="text-warning mb-0">
                    <i class="fa-solid fa-pen"></i> Edit Movie Genre
                </h3>
            </div>
            <form action="{{ route('admin.genre.update', $genre->id) }}" method="post">
                @csrf
                @method('PATCH')

                <div class="modal-body">
                    <label for="name" class="form-label text-white">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $genre->name }}" placeholder="ex) The latest Gojira movie" required>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-warning" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Edit  --}}

{{-- delete  --}}
<div class="modal fade" id="delete-genre-{{ $genre->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-danger bg-dark">
            <div class="modal-header border-danger">
                <h3 class="text-danger mb-0">
                    <i class="fa-solid fa-pen"></i> Danger Movie Genre
                </h3>
            </div>
            <form action="{{ route('admin.genre.destroy', $genre->id) }}" method="post">
                @csrf
                @method('DELETE')

                <div class="modal-body">
                    <p class="lead mb-0 text-white">
                        Are you sure you want to delete "<strong>{{ $genre->name }}</strong>" ?
                    </p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- delete  --}}
