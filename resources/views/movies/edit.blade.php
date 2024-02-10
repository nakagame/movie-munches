@extends('layouts.app')

@section('title', 'Edit:'.$movie->title)

@section('content')
    <h1 class="mb-4 text-trancate">Edit: {{ $movie->title}} </h1>

    <form action="{{ route('movie.update', $movie->id) }}" method="post" enctype="multipart/form-data" class="text-dark">
        @csrf
        @method('PATCH')

        <div class="row mb-4">
            <div class="col">
                <div class="mb-4">
                    <label class="form-label d-block text-white">Genre</label>
                    @foreach ($all_genre as $genre)
                        <div class="form-check form-check-inline text-white">
                            <input class="form-check-input" type="checkbox" name="genre[]" id="genre-{{ $genre->id }}" value="{{ $genre->id }}"
                                {{ $movie->movieGenre->contains('genre_id', $genre->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="genre-{{ $genre->id }}">{{ $genre->name }}</label>
                        </div>
                    @endforeach
        
                    @error('genre')
                        <p class="text-danger fw-bold">{{ $message }}</p>
                    @enderror
                </div>
        
                <div class="form-floating mb-4">
                    <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $movie->title) }}" placeholder="Movie title" autofocus>
                    <label for="text">Movie Title</label>
                </div>
                @error('title')
                    <p class="text-danger fw-bold">{{ $message }}</p>
                @enderror
        
                <div class="form-floating mb-4">
                    <textarea class="form-control" placeholder="Leave a comment here" name="description" id="description" style="height: 100px">{{ old('description', $movie->description) }}</textarea>
                    <label for="description">Description</label>
                </div>
                @error('description')
                    <p class="text-danger fw-bold">{{ $message }}</p>
                @enderror
        
                <div class="row mb-4 algin-items-center">
                    <div class="col">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="year" id="year" value="{{ old('year', $movie->year) }}" placeholder="Release Year">
                            <label for="year">Release Year</label>
                        </div>
                        @error('year')
                            <p class="text-danger fw-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <input type="number" class="form-control" name="release_time" id="release_time" value="{{ old('release_time', $movie->release_time) }}" placeholder="Release Time" min="0">
                            <label for="release_time">Release Time(Minutes)</label>
                        </div>
                        @error('release_time')
                            <p class="text-danger fw-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-floating mb-4">
                    <input type="number" class="form-control" name="rate" id="rate" value="{{ old('rate', $movie->rate) }}" placeholder="Movie Rate" step="any" aria-describedby="rate-info" min="0" max="10">
                    <label for="rate">Movie Rate</label>
                    <div class="form-text text-white" id="rate-info">
                        Please review the movie 0 ~ 10.
                    </div>
                </div>
                @error('rate')
                    <p class="text-danger fw-bold">{{ $message }}</p>
                @enderror
            </div>

            <div class="col">
                <div class="form-floating mb-4">
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
                <img src="{{ $movie->cover }}" alt="{{ $movie->title }}" class="cover-size-md ">
            </div>
        </div>

        <hr class="text-white">

        <h2 class="text-white">Option</h2>

        <div class="row mb-4">
            <div class="col">
                <div class="form-floating">
                    @if ($movie->movie_url)
                        <textarea class="form-control" placeholder="Insert Video URL" name="movie_url" id="movie_url" style="height: 100px">{{ old('movie_url', $movie->movie_url) }}</textarea>
                    @else
                        <textarea class="form-control" placeholder="Insert Video URL" name="movie_url" id="movie_url" style="height: 100px" aria-describedby="movie-url-store-info">{{ old('movie_url') }}</textarea>    
                    @endif
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
            <div class="col">
                <div class="row">
                    <div class="col-auto">
                        <label for="cast" class="form-label text-white d-inline me-2">
                            Cast 
                        </label>
                    </div>
                    <div class="col text-end">
                        <a href="{{ route('movie.showCasts', $movie->id) }}" class="text-decoration-none">Show All</a>
                    </div>
                </div>

                <ul class="list-group list-group-horizontal">
                    @forelse ($movie->movieCast->take(5) as $index => $movie_cast)
                        <li class="list-group-item text-center d-flex align-items-center bg-dark border-0">
                            <img src="{{ $movie_cast->cast->avatar }}" alt="{{ $movie_cast->cast->name }}" class="rounded-circle avatar-md me-2" title="{{ $movie_cast->cast->name }}">
                        </li>
                    @empty
                        <li class="list-group-item">No Casts selected yet.</li>
                    @endforelse
                </ul>
                <p class="text-warning mb-0 mt-2">
                    * It shows you only 5 selected casts here. <br>
                      If you want to see all casts and add casts, please click "Show All".
                </p>
            </div>
        </div>

        <div class="text-end">
            <a href="{{ route('movie.show', $movie->id) }}" class="btn btn-outline-success me-2">Cancel</a>
            <button type="submit" class="btn btn-success">Save</button>
        </div>
    </form>

    @include('movies.modal.info')
@endsection