@extends('layouts.app')

@section('title', 'Profile:'. Auth::user()->name)
@section('content')
    <div class="row justify-content-center">
        <div class="col-8 bg-white rounded">
            <div class="row p-4">
                <div class="col-auto">
                    @if ($user->avatar)
                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="avatar-lg img-thumbnail rounded-circle">
                    @else
                        <i class="fa-solid fa-user bg-secondary rounded p-2 icon-lg"></i>
                    @endif
                </div>
                <div class="col">
                    <h2 class="text-dark mb-0">{{ $user->name }}</h2>
                    <p class="text-muted lead mb-0">{{ $user->email }}</p>
                    <stron class="text-primary">
                        {{ $user->role_id === 1 ? 'Admin' : 'User' }}
                    </stron>
                </div>
                <div class="col text-end">
                    @if (Auth::user()->id === $user->id)
                        <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#edit-profile-{{ $user->id }}">Edit Profile</button>
                    @endif
                </div>
                @include('profile.modal.action')
            </div>

            <div class="row p-4">
                <div class="col">
                    <h3 class="text-dark">My Discussion</h3>
                    @if ($discussions->isNotEmpty())
                        <table class="table table-hover table-white bg-white border">
                            <thead class="table-secondary">
                                <tr>
                                    <th>ID</th>
                                    <th>TITLE</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($discussions as $discussion)
                                    <tr>
                                        <td>{{ $discussion->id }}</td>
                                        <td class="text-truncate">{{ $discussion->title }}</td>
                                        <td>
                                            <a href="{{ route('discussion-room.show', $discussion->id) }}" class="text-decoration-none">
                                                <i class="fa-solid fa-right-to-bracket"></i> Join
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>    
                    @endif

                    <div class="d-flex justify-content-center">
                        {{ $discussions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection