@extends('layouts.app')

@section('title', $movie->title)

@section('content')
    <div class="row d-flex align-items-center">
        <div class="col-auto">
            <h1 class="mb-0">{{ $movie->title }}</h1>
            <p class="text-secondary mb-0">{{ $movie->year }} ・ {{ $movie->release_time }}m</p>
        </div>
        <div class="col text-end">
            <i class="fa-solid fa-star text-warning icon-sm"></i>
            <strong class="h3">{{ $movie->rate }}</strong> / 10

            @if (Auth::user()->role_id === 1)
                <a href="{{ route('movie.edit', $movie->id) }}" class="btn btn-sm btn-outline-warning ms-3">
                    Edit
                </a>
                <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-movie-{{ $movie->id }}">
                    Delete
                </button>
            @endif
        </div>
        @include('movies.modal.action')
    </div>

    <div class="row mb-5">
        <div class="col-7">
            <img src="{{ $movie->cover }}" alt="{{ $movie->title }}" class="cover-size">
        </div>
        <div class="col-5">
            @foreach ($movie->movieGenre as $movie_genre)
                <div class="badge bg-secondary p-2">
                    {{ $movie_genre->genre->name }}
                </div>
            @endforeach

            <h2 class="text-secondary mt-3">Description</h2>
            <p class="lead">{{ $movie->description }}</p>
            <p class="text-primary">Posted by &nbsp;<a href="{{ route('profile.show', $movie->user_id) }}" class="text-decoration-none">{{ $movie->user->name }}</a></p>
        </div>
    </div>

    <div class="row">
        <div class="col-7">
            <h3 class="h2 text-warning">Video</h3>
            {!! $movie->movie_url !!}
        </div>
        <div class="col ms-3">
            <div class="row align-items-center">
                <div class="col-auto">
                    <h4 class="h2 text-warning">Cast</h4>
                </div>
                <div class="col text-end">
                    <button class="btn bg-transparent text-warning p-0 border-0" data-bs-toggle="modal" data-bs-target="#show-casts-{{ $movie->id }}">
                        Show All
                    </button>        
                </div>
                @include('movies.modal.show')
            </div>
            
            @forelse ($movie->movieCast->take(3) as $movie_cast)
                <div class="row align-items-center mb-3 bg-dark p-2 rounded">                
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
@endsection