<div class="modal fade" id="show-casts-{{ $movie->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-warning text-dark">
            <div class="modal-header border-warning">
                <h5 class="modal-title">All Casts</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @forelse ($movie->movieCast as $movie_cast)
                    <div class="row align-items-center mb-3">                
                        <div class="col-auto">
                            <img src="{{ $movie_cast->cast->avatar }}" alt="{{ $movie_cast->cast->name }}" class="avatar-lg rounded">
                        </div>
                        <div class="col">
                            <p class="mb-0 fw-bold lead text-truncate">{{ $movie_cast->cast->name }}</p>
                            <p class="text-secondary mb-0">{{ $movie_cast->cast->country }}</p>
                        </div>
                    </div>
                @empty
                    <div class="row">
                        <div class="col">
                            <p class="text-center lead text-white">
                                No Cast yet.
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

