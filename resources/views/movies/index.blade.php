@extends('layouts.app')

@section('title', 'Home')

@section('content')
    {{-- movie slide show  --}}
    <div class="row justify-content-center mb-5">
        <div class="col">
            <div id="carouselMovieInterval" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @forelse ($latest_movies as $key => $movie)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}" data-bs-interval="10000">
                            <a href="{{ route('movie.show', $movie->id) }}">
                                <img src="{{ $movie->cover }}" class="d-block cover-size" alt="{{ $movie->title }}">
                                <div class="carousel-caption d-none d-md-block p-4 bg-dark rounded">
                                    @if (Carbon\Carbon::parse($movie->created_at)->diffInDays(Carbon\Carbon::now()) <= 3)
                                        <div class="text-primary h4 fw-bold position-absolute top-0 end-0">
                                            <img src="{{ asset('build/images/new.png') }}" style="width: 70px; object-fit:cover;">
                                        </div>
                                    @endif
                                    <h2 class="mb-1">{{ $movie->title }}</h2>
                                    <p class="text-truncate lead mb-0">
                                        {{ $movie->description }}
                                    </p>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p class="lead text-secondary">No Movies yet.</p>
                    @endforelse
                </div>
                @if ($latest_movies->isNotEmpty())
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselMovieInterval" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselMovieInterval" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button> 
                @endif
            </div>
        </div>
    </div>
    {{-- movie slide show end --}}

    {{-- movie Ranking --}}
    <div class="row">
        <div class="col">
            <h3 class="h4 text-warning">Top 5 on Movie Munchies this week</h3>

            @if ($latest_top5_movies->isNotEmpty())
                <div class="row row-cols-5 5">
                    @foreach ($latest_top5_movies as $movie)
                        <div class="col">
                            <a href="{{ route('movie.show', $movie->id) }}" class="text-decoration-none">
                                <div class="card h-100">
                                    <img src="{{ $movie->cover }}" class="card-img-top" alt="{{ $movie->title }}" style="height:300px; object-fit: cover">
                                    <div class="card-body p-2">
                                        <i class="fa-solid fa-star text-warning icon-xs"></i>&nbsp; <strong>{{ $movie->rate }}</strong>
                                        <h5 class="card-title text-truncate mt-2">
                                            {{ $movie->title }}
                                            @if (Carbon\Carbon::parse($movie->created_at)->diffInDays(Carbon\Carbon::now()) < 3)
                                                <span class="d-block text-primary mb-0">(New)</span>
                                            @endif
                                        </h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    {{-- movie Ranking end --}}

@endsection

