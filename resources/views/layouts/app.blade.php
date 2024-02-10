<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    {{-- Font Awsome  --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Original CSS --}}
    <link rel="stylesheet" href="{{ asset('build/css/style.css') }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body style="background-image: url(https://images.unsplash.com/photo-1524712245354-2c4e5e7121c0?q=80&w=1932&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D); background-size: cover; background-repeat: no-repeat; background-attachment: fixed;">
    <div id="app" class="text-white">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('build/images/movie-munchies.png') }}" alt="logo" style="width:100%; height: 75px; border-radius: 10px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                     @if (Auth::check())
                        {{-- search bar --}}
                        <form action="{{ route('search') }}" class="d-flex mx-auto w-75" role="search">
                            <div class="input-group">
                                <input name="search" class="form-control" type="search" placeholder="Search Movie Title or Genre" aria-label="Search" value="{{ old('search') }}">
                                <button class="btn bg-white border-0 text-secondary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                        {{-- search bar --}}                         
                     @endif
                    
                    <!-- Right Side Of Navbar -->
                    @guest
                    
                    @else
                        @if (Auth::user()->role_id === 1)
                        <ul class="navbar-nav">
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-target="#create-genre" data-bs-toggle="modal">
                                        {{ __('Create a genre') }}
                                    </a>
                                    @include('layouts.modal.action')
                                </li>
                            @endif
                        </ul>
                        @endif
                    @endguest
     
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    {{-- Admin Controls --}}
                                    @can('admin')
                                        <a href="{{ route('movie.create') }}" class="dropdown-item">
                                            {{ __('Post a Movie') }}
                                        </a>   

                                        <a href="{{ route('admin.user.index') }}" class="dropdown-item">
                                            {{ __('Users') }}
                                        </a>   
                                        
                                        <a href="{{ route('admin.cast.index') }}" class="dropdown-item">
                                            {{ __('Casts') }}
                                        </a>   

                                        <a href="{{ route('admin.genre.index') }}" class="dropdown-item">
                                            {{ __('Genres') }}
                                        </a>   

                                        <hr class="dropdown-divider">
                                    @endcan
                                    {{-- Admin Controls End --}}

                                    <a href="{{ route('profile.show', Auth::user()->id) }}" class="dropdown-item">
                                        {{ __('Profile') }}
                                    </a>   

                                    <a href="{{ route('discussion-room.index') }}" class="dropdown-item">
                                        {{ __('Discussion Room') }}
                                    </a>   

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-9">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>