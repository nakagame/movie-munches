@extends('layouts.app')

@section('title', 'Explore Movies')

@section('content')
    <div class="row justify-content-center">
        <div class="col-10">
            <p class="h5 text-white mb-4">
                Search results for "<span class="fw-bold">{{ $search }}</span>"
            </p>

            @forelse ($movies as $movie)
                <div class="row align-items-center mb-4 bg-dark p-2 rounded">
                    <div class="col-auto">
                        <img src="{{ $movie->cover }}" alt="{{ $movie->title }}" class="cover-size-sm">
                    </div>
                    <div class="col ps-0">
                        @if (Carbon\Carbon::parse($movie->created_at)->diffInDays(Carbon\Carbon::now()) <= 3)
                            <h1 class="text-primary h4">New</h1>
                        @endif
                        <a href="{{ route('movie.show', $movie->id) }}" class="text-decoration-none h3">
                            {{ $movie->title }}
                        </a>
                        <p class="mb-0 text-secondary">{{ $movie->year }}</p>
                        @foreach ($movie->movieGenre as $movie_genre)
                            <div class="badge bg-secondary">
                                {{ $movie_genre->genre->name }}
                            </div>
                        @endforeach
                    </div>
                </div>

            @empty
                <p class="lead text-center text-white display-6">No movies or Genres found.</p>
            @endforelse
        </div>
    </div>
@endsection