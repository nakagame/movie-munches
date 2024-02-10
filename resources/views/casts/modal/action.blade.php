{{-- Edit  --}}
<div class="modal fade" id="edit-cast-{{ $cast->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-success bg-dark">
            <div class="modal-header border-success">
                <h3 class="text-success mb-0">
                    <i class="fa-solid fa-pen"></i> Edit Cast Info
                </h3>
            </div>
            <form action="{{ route('admin.cast.update', $cast->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="name" class="form-label text-white">Cast Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $cast->name }}" autofocus>
                            @error('name')
                                <p class="text-warning">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="country" class="form-label text-white">Country</label>
                            <input type="text" name="country" id="country" class="form-control" value="{{ $cast->country }}">
                            @error('country')
                                <p class="text-warning">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
            
                    <div>
                        <label for="avatar" class="form-label text-white">Avatar</label>
                        <img src="{{ $cast->avatar }}" alt="{{ $cast->name }}" class="info-image-size mb-3">
                        <input type="file" name="avatar" id="avatar" class="form-control" aria-describedby="avatar-info">
                        <div class="form-text text-warning">
                            Available File Format: jpeg, jpg, png, gif only. <br>
                            Maximu file size is 1048KB.
                        </div>
                        @error('avatar')
                            <p class="text-warning">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Edit End --}}

{{-- Delete  --}}
<div class="modal fade" id="delete-cast-{{ $cast->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-danger bg-dark">
            <div class="modal-header border-danger">
                <h3 class="text-danger mb-0">
                    <i class="fa-solid fa-trash-can"></i> DELETE Cast : {{ $cast->name }}
                </h3>
            </div>
            <div class="modal-body">
                <p class="lead text-white  mb-0">
                    Are you sure you want to delete "<strong>{{ $cast->name }}</strong>" ?
                </p>
            </div>
            <div class="modal-footer border-0">
                <form action="{{ route('admin.cast.destroy', $cast->id) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- Delete end --}}

