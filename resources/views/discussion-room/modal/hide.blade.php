{{-- Hidden --}}
<div class="modal fade" id="hidden-discussion-{{ $discussion->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-danger bg-dark">
            <div class="modal-header border-danger">
                <h3 class="text-danger mb-0">
                    <i class="fa-solid fa-eye-slash"></i> Hide this discussion
                </h3>
            </div>
            <div class="modal-body">
                <p class="lead text-white">
                    Are you sure you want to hide "{{ $discussion->title }}" ?
                </p>
            </div>
            <div class="modal-footer border-0">
                <form action="{{ route('discussion-room.hide', $discussion->id) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Hidden</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- Hidden End --}}