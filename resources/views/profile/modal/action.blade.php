<div class="modal fade" id="edit-profile-{{ $user->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-success bg-dark">
            <div class="modal-header border-success">
                <h3 class="text-success mb-0">
                    @if ($user->avatar)
                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="avatar-md rounded-circle">
                    @endif
                    Edit User Profile
                </h3>
            </div>
            <form action="{{ route('profile.update', $user->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="name" name="name" class="form-control" id="name" placeholder="John Doe" value="{{ $user->name }}" required>
                        <label for="name">Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" value="{{ $user->email }}" required>
                        <label for="email">Email address</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="file" name="avatar" class="form-control" id="avatar" aria-describedby="avatar-info">
                        <label for="avatar">Avatar</label>
                    </div>
                    <div class="form-text text-warning">
                        Available File: jpeg, jpgm png, gif only. <br>
                        Maximum file size is 1048KB.
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