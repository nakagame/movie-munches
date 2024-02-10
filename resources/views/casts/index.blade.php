@extends('layouts.app')

@section('title', 'All Casts')

@section('content')
    {{-- Form  --}}
    <div class="row justify-content-center mb-5">
        <div class="col-8 bg-secondary rounded p-3">
            <h1>Add a New Cast</h1>

            <form action="{{ route('admin.cast.store') }}" method="post" enctype="multipart/form-data">
                @csrf
        
                <div class="row mb-3">
                    <div class="col">
                        <label for="name" class="form-label">Cast Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" autofocus>
                        @error('name')
                            <p class="text-warning">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" name="country" id="country" class="form-control" value="{{ old('country') }}">
                        @error('country')
                            <p class="text-warning">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
        
                <div class="mb-3">
                    <label for="avatar" class="form-label">Avatar</label>
                    <input type="file" name="avatar" id="avatar" class="form-control" aria-describedby="avatar-info">
                    <div class="form-text text-dark">
                        Available File Format: jpeg, jpg, png, gif only. <br>
                        Maximu file size is 1048KB.
                    </div>
                    @error('avatar')
                        <p class="text-warning">{{ $message }}</p>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-dark px-4">Add</button>
                </div>
            </form>
        </div>
    </div>
    {{-- Form End --}}

    {{-- Search Casts  --}}
    <div class="row algin-items-center mb-3">
        <div class="col-auto">
            <h2 class="h1">All Casts</h2>
        </div>
        <div class="col">
            <form role="search" id="searchForm">
                <div class="input-group">
                    <input name="search" class="form-control" type="search" placeholder="Search Cast Name or Country" aria-label="Search" value="{{ old('search') }}">
                    <button class="btn bg-white border-0 text-secondary">
                        <i class="fas fa-search"></i>
                    </button>
                    <button type="button" class="btn btn-danger" onclick="resetSearch()">Reset</button>
                </div>
            </form>
        </div>
    </div>
    {{-- Search Casts  --}}

    {{-- All Casts  --}}
    <div class="row row-cols-4 g-4 mb-3">
        @forelse ($all_casts as $cast)
            <div class="col">
                <div class="card h-100">
                    <img src="{{ $cast->avatar }}" class="card-img-top" alt="{{ $cast->name }}" style="height: 200px; object-fit:cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $cast->name }}</h5>
                        <p class="card-text text-secondary mb-1">From <strong class="text-dark">{{ $cast->country }}</strong></p>
                        <p class="mb-0 fw-bold">
                            Be in {{ $cast->movieCast->count() }} {{ $cast->movieCast->count() === 1 ? 'movie' : 'movies'  }}
                        </p>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button class="btn bg-transparent text-success p-0 border-0" data-bs-toggle="modal" data-bs-target="#edit-cast-{{ $cast->id }}">
                            Edit
                        </button>
                        @include('casts.modal.action')
                        <button class="btn bg-transparent text-danger p-0 ms-auto border-0" data-bs-toggle="modal" data-bs-target="#delete-cast-{{ $cast->id }}">
                            Delete
                        </button>
                        @include('casts.modal.action')
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center lead text-white">No Casts yet.</p>
        @endforelse
    </div>
    {{-- All Casts end --}}

    {{-- Search Results --}}
    @if(isset($searched_casts))
        <div class="row row-cols-4 g-4 mb-3">
            @forelse ($searched_casts as $cast)
                <div class="col">
                    <div class="card h-100">
                        <img src="{{ $cast->avatar }}" class="card-img-top" alt="{{ $cast->name }}" style="height: 200px; object-fit:cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $cast->name }}</h5>
                            <p class="card-text text-secondary">From <strong class="text-dark">{{ $cast->country }}</strong></p>
                            <p>
                                {{-- How many movies acted here --}}
                            </p>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button class="btn bg-transparent text-success p-0" data-bs-toggle="modal" data-bs-target="#edit-cast-{{ $cast->id }}">
                                Edit
                            </button>
                            @include('casts.modal.action')
                            <button class="btn bg-transparent text-danger p-0 ms-auto" data-bs-toggle="modal" data-bs-target="#delete-cast-{{ $cast->id }}">
                                Delete
                            </button>
                            @include('casts.modal.action')
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center lead text-white">No matching Casts found.</p>
            @endforelse
        </div>
    @endif
    {{-- Search Results end --}}

    <div class="d-flex justify-content-center">
        {{ $all_casts->links() }}
    </div>

    <script>
        function resetSearch() {
            document.querySelector('input[name="search"]').value = '';
            document.getElementById('searchForm').submit();
        }
    </script>   
@endsection
