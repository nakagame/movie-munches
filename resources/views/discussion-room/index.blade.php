@extends('layouts.app')

@section('title', 'Comments')

@section('content')
    <style>
        a {
           font-weight: 800;
           font-size: 1rem;
        }
    </style>

    <h1>Discussion Room</h1>
    {{-- Rules --}}
    <h2 class="mt-4 text-warning">Rules</h2>
    <div class="row mb-4">
        <div class="col-4">
            <div class="list-group" id="list-tab" role="tablist">
                <a class="list-group-item list-group-item-action active" id="list-rule-1-list" data-bs-toggle="list" href="#list-rule-1" role="tab" aria-controls="list-rule-1">Be Respectful</a>
                <a class="list-group-item list-group-item-action" id="list-rule-2-list" data-bs-toggle="list" href="#list-rule-2" role="tab" aria-controls="list-rule-2">No Spam or Self-Promotion</a>
                <a class="list-group-item list-group-item-action" id="list-rule-3-list" data-bs-toggle="list" href="#list-rule-3" role="tab" aria-controls="list-rule-3">Use Clear and Appropriate Language</a>
                <a class="list-group-item list-group-item-action" id="list-rule-4-list" data-bs-toggle="list" href="#list-rule-4" role="tab" aria-controls="list-rule-4">Respect Privacy</a>
            </div>
        </div>
        <div class="col-8 bg-dark rounded p-3">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="list-rule-1" role="tabpanel" aria-labelledby="list-rule-1-list">
                    <p class="lead">
                        Treat others with kindness and respect. <br>
                        Avoid personal attacks, hate speech, and discriminatory language. <br>
                        Disagreements are fine, but express your opinions in a civil manner.
                    </p>
                </div>
                <div class="tab-pane fade" id="list-rule-2" role="tabpanel" aria-labelledby="list-rule-2-list">
                    <p class="lead">
                        Refrain from posting promotional content or advertisements. <br>
                        Avoid excessive self-promotion. <br>
                        Share valuable information rather than solely promoting your own interests.
                    </p>
                </div>
                <div class="tab-pane fade" id="list-rule-3" role="tabpanel" aria-labelledby="list-rule-3-list">
                    <p class="lead">
                        Communicate clearly and avoid offensive language. <br>
                        Refrain from using excessive profanity.
                    </p>
                </div>
                <div class="tab-pane fade" id="list-rule-4" role="tabpanel" aria-labelledby="list-rule-4-list">
                    <p class="lead">
                        Do not share personal information about others without their consent. <br>
                        Be mindful of the privacy of yourself and others.
                    </p>
                </div>
            </div>
        </div>
      </div>
    {{-- Rules --}}

    {{-- Discussion Room  --}}
    <div class="row align-items-center">
        <div class="col-auto">
            <h3 class="h2 text-warning">Disucssions</h3>
        </div>
        <div class="col text-end">
            <i class="fa-solid fa-plus text-primary"></i>
            <button class="btn bg-transparent text-primary p-0 border-0" data-bs-toggle="modal" data-bs-target="#create-new-topic">Add a new discussion room</button>
        </div>
        @include('discussion-room.modal.action')
    </div>

    <table class="table table-hover table-white bg-white align-middle border">
        <thead class="table-warning small">
            <tr>
                <th></th>
                <th>NAME</th>
                <th>MOVIE</th>
                <th>CREATOR</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($all_discussions as $discussion)
                @if ($discussion->user && !$discussion->user->trashed())
                    <tr>
                        <td>
                            @if ($discussion->user->id === Auth::user()->id && !$discussion->trashed())
                                <button class="btn btn-outline-secondary btn-sm" onclick="toggleForm({{ $discussion->id }})">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                            @endif
                        </td>
                        <td class="text-truncate">
                            <div id="editForm{{ $discussion->id }}" style="display: none;">
                                <form action="{{ route('discussion-room.update', $discussion->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
    
                                    <input type="text" name="title" id="title" class="form-control form-control-sm d-inline w-75" value="{{ $discussion->title }}" required  maxlength="100">
                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                        <i class="fa-solid fa-save"></i>
                                    </button>
                                </form>
                            </div>
    
                            <div id="defaultContent{{ $discussion->id }}">
                                {{ $discussion->title }}&nbsp;
                                @if (Carbon\Carbon::parse($discussion->created_at)->diffInDays(Carbon\Carbon::now()) <= 3)
                                    <span class="fw-bold text-primary">(New)</span>
                                @endif
                            </div>
                        </td>
                        <td class="text-truncate">
                            @if (empty($discussion->movie->title))
                                No Movie Title
                            @else
                                {{ $discussion->movie->title }}  
                            @endif
                        </td>
                        <td class="text-truncate">
                            {{ $discussion->user->name }}
                        </td>
                        @if (Auth::user()->role_id === 1)
                            @if ($discussion->trashed())
                                <td>
                                    <button class="btn bg-transparent border-0 text-success p-0" data-bs-target="#show-discussion-{{ $discussion->id }}" data-bs-toggle="modal">
                                        <i class="fa-solid fa-eye"></i> Visible 
                                    </button>
                                    @include('discussion-room.modal.show') 
                                </td>
                            @else
                                <td>
                                    <button class="btn bg-transparent border-0 text-danger p-0" data-bs-target="#hidden-discussion-{{ $discussion->id }}" data-bs-toggle="modal">
                                        <i class="fa-solid fa-eye-slash"></i> Hidden 
                                    </button>
                                    @include('discussion-room.modal.hide') 
                                </td>  
                            @endif    
                        @else
                            <td></td>                 
                        @endif
                        <td>
                            @if ($discussion->trashed())
                                <a class="text-decoration-none disabled text-secondary">
                                    <i class="fa-solid fa-right-to-bracket"></i> Join
                                </a>
                            @else
                                <a href="{{ route('discussion-room.show', $discussion->id) }}" class="text-decoration-none">
                                    <i class="fa-solid fa-right-to-bracket"></i> Join
                                </a>
                            @endif
                        </td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        <p class="lead mb-0">No Disuccion yet.</p> 
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{-- Discussion Room end --}}

    <div class="d-flex justify-content-center">
        {{ $all_discussions->links() }}
    </div>

    <script>
        function toggleForm(discussionId) {
            var editForm = document.getElementById('editForm' + discussionId);
            var defaultContent = document.getElementById('defaultContent' + discussionId);
    
            if (editForm.style.display === 'none') {
                editForm.style.display = 'block';
                defaultContent.style.display = 'none';
            } else {
                editForm.style.display = 'none';
                defaultContent.style.display = 'block';
            }
        }
    </script>
@endsection


