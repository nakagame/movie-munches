@extends('layouts.app')

@section('title', 'All Casts')

@section('content')
    <form action="{{ route('movie.storeCasts', $movie->id) }}" method="post">
        @csrf
        @method('PATCH')

        <div class="row mb-2">
            <div class="col-auto">
                <a href="{{ route('movie.edit', $movie->id) }}" class="btn bg-transparent text-primary border-0 fs-4">
                    <i class="fa-solid fa-chevron-left"></i> Back
                </a>
            </div>
            <div class="col text-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>

        {{-- Selected Cast --}}
        <div class="row mb-4">
            <div class="col">
                <h2>Selected Cast</h2>
                <div class="list-group list-group-horizontal" style="overflow-x: auto;">
                    @forelse ($movie->movieCast as $movie_cast)
                        <div class="list-group-item text-center d-flex align-items-center">
                            <img src="{{ $movie_cast->cast->avatar }}" alt="{{ $movie_cast->cast->name }}" class="rounded-circle avatar-md me-2">
                            <p class="mb-0 fw-bold">{{ $movie_cast->cast->name }}</p>
                        </div>
                    @empty
                        <div class="list-group-item">No Casts selected yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
        {{-- Selected Cast End --}}

        {{-- Show All Casts --}}
        <div class="row row-cols-4 g-4 mb-5">
            @forelse ($all_casts as $cast)
                <div class="col">
                    <div class="card h-100">
                        <img src="{{ $cast->avatar }}" class="card-img-top" alt="{{ $cast->name }}" style="height: 200px; object-fit:cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $cast->name }}</h5>
                            <p class="card-text text-secondary">From <strong>{{ $cast->country }}</strong></p>
                            
                            <div class="mb-3 d-flex">
                                <input type="checkbox" name="cast[]" id="selected_casts_{{ $cast->id }}" class="form-check me-2" value="{{ $cast->id }}"
                                    {{ $movie->movieCast->contains('cast_id', $cast->id) ? 'checked' : '' }}>
                                <label for="selected_casts_{{ $cast->id }}" class="form-input"> Add Actor</label> 
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center lead text-white">No Casts yet.</p>
            @endforelse
        </div>
        {{-- Show All Casts End --}}

        {{-- Search Results --}}
        @if(isset($searched_casts))
            <div class="row row-cols-4 g-4 mb-3">
                @forelse ($searched_casts as $cast)
                    <div class="col">
                        <div class="card h-100">
                            <img src="{{ $cast->avatar }}" class="card-img-top" alt="{{ $cast->name }}" style="height: 200px; object-fit:cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $cast->name }}</h5>
                                <p class="card-text text-secondary">From <strong>{{ $cast->country }}</strong></p>
                                
                                <div class="mb-3 d-flex">
                                    <input type="checkbox" name="cast[]" id="selected_casts_{{ $cast->id }}" class="form-check me-2" value="{{ $cast->id }}"
                                        {{ $movie->movieCast->contains('cast_id', $cast->id) ? 'checked' : '' }}>
                                    <label for="selected_casts_{{ $cast->id }}" class="form-input"> Add Actor</label>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center lead text-white">No matching Casts found.</p>
                @endforelse
            </div>
        @endif
    {{-- Search Results end --}}
    </form> 
@endsection