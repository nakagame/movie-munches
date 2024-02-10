<div class="modal fade" id="delete-movie-{{ $movie->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-danger bg-dark align-items-center">
            <div class="modal-header border-0 d-block text-center">
                <i class="fa-solid fa-trash-can icon-md bg-danger rounded-pill p-3"></i>
                <h3 class="display-6 modal-title text-danger mb-0">
                    Are you sure ?                    
                </h3>
            </div>
 
            <div class="modal-body">
                <p class="lead mb-0">
                    Do you really want to delete <span class="fw-bold">"{{ $movie->title }}"</span> ?
                </p>
            </div>
            <div class="modal-footer border-0">
                <form action="{{ route('movie.destroy', $movie->id) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>