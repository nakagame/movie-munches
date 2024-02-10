@extends('layouts.app')

@section('title', 'Genres')

@section('content')
    <div class="row justify-content-center">
        <div class="col-8">
            <h1>Genre</h1>

            <table class="table table-hover border algin-items-center table-white bg-white">
                <thead class="table-warning">
                    <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>COUNT</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($all_genres as $genre)
                        <tr>
                            <td>{{ $genre->id }}</td>
                            <td>{{ $genre->name }}</td>
                            <td>{{ $genre->movieGenre->count() }}</td>
                            <td>
                                <button class="btn btn-outline-warning me-2" data-bs-toggle="modal" data-bs-target="#edit-genre-{{ $genre->id }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                @include('genres.modal.action')

                                @if ($genre->movieGenre->count() === 0)
                                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete-genre-{{ $genre->id }}">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                @else
                                    <button class="btn btn-outline-secondary" disabled>
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>
                                <p class="lead text-center">No Genres yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection