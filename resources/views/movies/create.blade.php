@extends('layouts.app')

@section('title', 'Post a Movie')

@section('content')
    <style>
        label, input[type="checkbox"] {
            font-size: 1.1rem;
        }
    </style>

    <div class="row justify-content-center">
        <div class="col-9">
            <h1>Post a Movie</h1>

            <div class="bg-black text-dark p-3 rounded">
                <form action="{{ route('movie.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label d-block text-white">Genre</label>
                        @if ($all_genre->isNotEmpty())
                            @foreach ($all_genre as $genre)
                            <div class="form-check form-check-inline text-white">
                                <input class="form-check-input" type="checkbox" name="genre[]" id="genre-{{ $genre->id }}" value="{{ $genre->id }}">
                                <label class="form-check-label font-monospace" for="genre-{{ $genre->id }}">{{ $genre->name }}</label>
                            </div>
                            @endforeach

                            @error('genre')
                                <p class="text-danger fw-bold">{{ $message }}</p>
                            @enderror
                        @else
                            <p class="text-primary mb-0">
                                Create a genre first
                            </p>
                        @endif
                    </div>
        
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" placeholder="Movie title" autofocus>
                        <label for="text">Movie Title</label>
                    </div>
                    @error('title')
                        <p class="text-danger fw-bold">{{ $message }}</p>
                    @enderror
        
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Leave a comment here" name="description" id="description" style="height: 100px">{{ old('description') }}</textarea>
                        <label for="description">Description</label>
                    </div>
                    @error('description')
                        <p class="text-danger fw-bold">{{ $message }}</p>
                    @enderror

                    <div class="row mb-4 algin-items-center">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="year" id="year" value="{{ old('year') }}" placeholder="Release Year">
                                <label for="year">Release Year</label>
                            </div>
                            @error('year')
                                <p class="text-danger fw-bold">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="number" class="form-control" name="release_time" id="release_time" value="{{ old('release_time') }}" placeholder="Release Time" min="0">
                                <label for="release_time">Release Time(Minutes)</label>
                            </div>
                            @error('release_time')
                                <p class="text-danger fw-bold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" name="rate" id="rate" value="{{ old('rate') }}" placeholder="Movie Rate" step="any" aria-describedby="rate-info" min="0" max="10">
                        <label for="rate">Movie Rate</label>
                        <div class="form-text text-white" id="rate-info">
                            Please review the movie 0 ~ 10.
                        </div>
                    </div>
                    @error('rate')
                        <p class="text-danger fw-bold">{{ $message }}</p>
                    @enderror
        
                    <div class="form-floating mb-3">
                        <input type="file" class="form-control" name="cover" id="cover" aria-describedby="cover-info">
                        <label for="cover">Movie Cover</label>
                        <div class="form-text text-white" id="cover-info">
                            Available Format: jpeg, jpg, png, gif only. <br>
                            Maximum file size is 1048KB.
                        </div>
                    </div>
                    @error('cover')
                        <p class="text-danger fw-bold">{{ $message }}</p>
                    @enderror

                    <hr class="text-white">

                    <h2 class="text-white">Option</h2>

                    <div class="row">
                        <div class="col">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Insert Video URL" name="movie_url" id="movie_url" style="height: 100px" aria-describedby="movie-url-store-info">{{ old('movie_url') }}</textarea>    
                                <label for="movie_url">Movie Video URL</label>
                                <div class="form-text" id="movie-url-store-info">
                                    <button type="button" class="btn bg-transparent border-0 text-primary p-0" data-bs-toggle="modal" data-bs-target="#info-movie-url">
                                        How to store Movie URL ?
                                    </button>
                                </div>
                            </div>
                            @error('movie_url')
                                <p class="text-danger fw-bold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="text-end">
                        <a href="{{ route('index') }}" class="btn btn-outline-primary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('movies.modal.info')
@endsection

