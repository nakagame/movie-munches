{{-- show --}}
<div class="modal fade" id="show-discussion-{{ $discussion->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-success bg-dark">
            <div class="modal-header border-success">
                <h3 class="text-success mb-0">
                    <i class="fa-solid fa-eye"></i> Show this discussion
                </h3>
            </div>
            <div class="modal-body">
                <p class="lead text-white">
                    Are you sure you want to show "{{ $discussion->title }}" again ?
                </p>
            </div>
            <div class="modal-footer border-0">
                <form action="{{ route('discussion-room.visble', $discussion->id) }}" method="post">
                    @csrf
                    @method('PATCH')

                    <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Show</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- show End --}}

