<div class="modal fade" id="create-new-topic">
    <div class="modal-dialog">
        <div class="modal-content border-primary bg-dark">
            <div class="modal-header border-primary">
                <h3 class="text-primary mb-0">
                    <i class="fa-solid fa-pen"></i> Create a new room
                </h3>
            </div>
            <form action="{{ route('discussion-room.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label"><span class="fw-bold">*</span> Room name</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" placeholder="ex) The latest Gojira movie" required>
                    </div>

                    <div class="mb-3">
                        @if ($all_movies->isNotEmpty())
                            <label for="movie_id" class="form-label">Which Movie do you want to talk about ? (Option)</label>
                            <select name="movie_id" id="movie_id" class="form-select">
                                <option value="" hidden>Select a movie</option>
                                @foreach ($all_movies as $movie)
                                    <option value="{{ $movie->id }}">{{ $movie->title }}</option>
                                @endforeach
                            </select>
                            <div class="form-text text-white">
                                Only one discussion room can be created per film.
                            </div>
                        @else
                            <p class="lead text-white">No movie posted yet.</p>
                        @endif             
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>


