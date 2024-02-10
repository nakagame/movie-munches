@extends('layouts.app')

@section('title', 'Admin:All Users')

@section('content')
    <h1>All Users</h1>

    <div class="row row-cols-4 g-4">
        @foreach ($all_users as $user)
            <div class="col">
                <div class="card h-100">
                    <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none {{ $user->trashed() ? 'disabled' : '' }}" @if($user->trashed()) onclick="return false;" @endif>
                        @if ($user->avatar)
                            <img src="{{ $user->avatar }}" class="card-img-top" alt="{{ $user->name }}" style="height: 200px; object-fit: cover;">
                        @else
                            <img src="{{ asset('build/images/sample.png') }}" class="card-img-top" alt="{{ $user->name }}" style="height: 200px; object-fit: cover;">
                        @endif
                    </a>
                    
                    <div class="position-absolute top-0 end-0 mt-2 me-2">
                        @if ($user->trashed())
                            <i class="fa-solid fa-circle-xmark text-secondary icon-sm"></i>
                        @else
                            <i class="fa-solid fa-circle-check text-success icon-sm"></i>  
                        @endif
                    </div>
                    <div class="card-body">
                        <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none {{ $user->trashed() ? 'disabled' : '' }}" @if($user->trashed()) onclick="return false;" @endif>
                            <h5 class="card-title">{{ $user->name }}</h5>
                        </a>
                        <p class="card-text mb-0">{{ $user->email }}</p>
                        <p class="card-text text-secondary">{{ $user->role_id === 1 ? 'admin' : 'user' }}</p>
                        <div class="d-flex justify-content-between">
                            @if (Auth::user()->id !== $user->id && $user->role_id !== 1)
                                @if ($user->trashed())
                                    <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#active-user-{{ $user->id }}">
                                        Active
                                    </button>
                                    @include('users.modal.action')
                                @else
                                    <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deactive-user-{{ $user->id }}">
                                        Deactive
                                    </button>
                                    @include('users.modal.action')
                                @endif
                            @endif
                            
                            @auth
                                @if (Auth::user()->id !== $user->id && empty($user->deleted_at))
                                    @if ($user->role_id === 1)
                                        <form action="{{ route('admin.user.removeAdmin', $user->id) }}" method="post">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" class="btn btn-secondary btn-sm">
                                                <i class="fa-solid fa-plus"></i>&nbsp; User
                                            </button>
                                        </form>    
                                    @else
                                        <form action="{{ route('admin.user.addAdmin', $user->id) }}" method="post">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fa-solid fa-plus"></i>&nbsp; Admin
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center">
        {{ $all_users->links() }}
    </div>
@endsection