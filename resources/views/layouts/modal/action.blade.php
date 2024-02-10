<div class="modal fade" id="create-genre">
    <div class="modal-dialog">
        <div class="modal-content border-primary">
            <div class="modal-header border-primary">
                <h3 class="modal-title text-primary">
                    <i class="fa-solid fa-folder-plus"></i> Add a new genre
                </h3>
            </div>
            <form action="{{ route('admin.genre.store') }}" method="post">
                @csrf

                <div class="modal-body">
                    <label for="name" class="form-label text-dark">Genre</label>
                    <input type="text" name="name" id="name" class="form-control" aria-describedby="genre-info">
                    <div class="form-text" id="genre-info">
                        The genre shold be unique.
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>