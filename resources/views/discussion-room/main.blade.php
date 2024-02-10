@extends('layouts.app')

@section('title', $discussion->title)

@section('content')
    <div class="row align-items-center mb-3">
        <div class="col-auto">
            @if ($discussion->user->avatar)
                <img src="{{ $discussion->user->avatar }}" alt="{{ $discussion->user->name }}" class="avatar-md img-thumbnail rounded-circle">
            @else
                <i class="fa-solid fa-user text-white mx-auto b-clock icon-sm bg-secondary rounded-circle p-2"></i>
            @endif
        </div>
        <div class="col p-0">
            <a href="{{ route('profile.show', $discussion->user->id) }}" class="text-decoration-none h4">
                {{ $discussion->user->name }}          
            </a>   
        </div>
        <div class="col-auto text-secondary">
            {{ $discussion->created_at }}
        </div>
    </div>

    <h1 class="mb-4">
        {{ $discussion->title }}
    </h1>

    {{-- Comments  --}}

    {{-- Add a new comment  --}}
    <form action="{{ route('comment.store', $discussion->id) }}" method="post">
        @csrf

        <div class="row mb-3">
            @if (!empty($discussion->movie_id))
                <div class="col-auto">
                    <img src="{{ $discussion->movie->cover }}" alt="{{ $discussion->movie->title }}" class="cover-size-md">
                </div>
            @endif
            <div class="col">
                <label for="comment" class="form-label h4">
                    Comment as {{ Auth::user()->name }}
                </label>
                <textarea class="form-control" name="comment" id="comment" rows="3" placeholder="What are you thoughts?">{{ old('comment') }}</textarea>
                @error('comment')
                    <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-secondary rounded-pill">Comment</button>
                </div>
            </div>
        </div>
    </form>
    {{-- Add a new comment end --}}

    <hr>

    {{-- Show Comments  --}}
    @if ($discussion->comments->isNotEmpty())
        <ul class="list-group mt-2">
            @foreach ($discussion->comments as $comment)
                <li class="list-group-item border-0 rounded p-2 mb-4">
                    <div class="row align-items-center mb-2">
                        <div class="col-auto">
                            @if ($comment->user->avatar)
                                <img src="{{ $comment->user->avatar }}" alt="{{ $comment->user->name }}" class="rounded-circle avatar-md">
                            @else
                                <i class="fa-solid fa-user text-white mx-auto b-clock icon-sm bg-secondary rounded-circle p-2"></i>
                            @endif
                        </div>
                        <div class="col p-0">
                            <a href="{{ route('profile.show', $comment->user->id) }}" class="text-decoration-none h4">
                                {{ $comment->user->name }}          
                            </a>   
                        </div>
                        @if (Auth::user()->role_id === 1)
                            <div class="col-auto text-end">
                                <form action="{{ route('comment.banned', $comment->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    
                                    <button type="submit" class="border-0 bg-transparent text-danger p-0 xsmall">Ban Comment</button>                                                
                                </form>
                            </div>                        
                        @endif
                    </div>

                    <p class="d-inline fw-light lead">{{ $comment->body }}</p>

                    <form action="{{ route('comment.destroy', $comment->id) }}" method="post">
                        @csrf
                        @method('DELETE')

                        <span class="text-uppercase text-muted xsmall">
                            {{ date('M d, Y', strtotime($comment->created_at)) }}
                        </span>

                        @if (Auth::user()->id == $comment->user->id | Auth::user()->role_id === 1)
                            &middot;
                            <button type="submit" class="border-0 bg-transparent text-danger p-0 xsmall">Delete</button>                                                
                        @endif
                    </form>
                </li>
            @endforeach 
        </ul>  
    @endif
    {{-- Show Comments end  --}}

    {{-- Comments  end --}}
@endsection


