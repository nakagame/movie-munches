<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DiscussionRoomController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\CastController;
use App\Http\Controllers\Admin\UsersController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', [MovieController::class, 'index'])->name('index');
    Route::get('/movies', [MovieController::class, 'search'])->name('search');

    // User
    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function() {
        Route::get('/{id}/show', [UserController::class, 'show'])->name('show');
        Route::patch('/{id}/update', [UserController::class, 'update'])->name('update');
    });

    // Movise
    Route::group(['prefix' => 'movie', 'as' => 'movie.'], function() {
        Route::get('/create', [MovieController::class, 'create'])->name('create');
        Route::get('/{id}/show', [MovieController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [MovieController::class, 'edit'])->name('edit');
        Route::get('/{movie_id}/show/cast', [MovieController::class, 'showCasts'])->name('showCasts');

        Route::post('/store', [MovieController::class, 'store'])->name('store');

        Route::patch('/{id}/update', [MovieController::class, 'update'])->name('update');
        Route::patch('/{movie_id}/store/cast', [MovieController::class, 'storeCasts'])->name('storeCasts');
    
        Route::delete('/{movie_id}/destroy', [MovieController::class, 'destroy'])->name('destroy');
    });

    // Discussion Room
    Route::group(['prefix' => 'discussion-room', 'as' => 'discussion-room.'], function() {
        Route::get('/', [DiscussionRoomController::class, 'index'])->name('index');
        Route::get('/{id}/disucussion-room', [DiscussionRoomController::class, 'show'])->name('show');
        Route::post('/store', [DiscussionRoomController::class, 'store'])->name('store');
        Route::patch('/{id}/update', [DiscussionRoomController::class, 'update'])->name('update');
        Route::patch('/{id}/visble', [DiscussionRoomController::class, 'visble'])->name('visble');
        Route::delete('/{id}/hide', [DiscussionRoomController::class, 'hide'])->name('hide');
    });

    // Comments
    Route::group(['prefix' => 'comment', 'as' => 'comment.'], function() {
        Route::post('/{id}/store', [CommentController::class, 'store'])->name('store');
        Route::delete('/{id}/destroy', [CommentController::class, 'destroy'])->name('destroy');
        Route::delete('/{id}/banned', [CommentController::class, 'banned'])->name('banned');
    });

    // Admin
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function() {
        // Genre
        Route::group(['prefix' => 'genre', 'as' => 'genre.'], function() {
            Route::get('/', [GenreController::class, 'index'])->name('index');
            Route::post('/store', [GenreController::class, 'store'])->name('store');
            Route::patch('/{id}/update', [GenreController::class, 'update'])->name('update');
            Route::delete('/{id}/destroy', [GenreController::class, 'destroy'])->name('destroy');
        });

        // Cast
        Route::group(['prefix' => 'cast', 'as' => 'cast.'], function() {
            Route::get('/', [CastController::class, 'index'])->name('index');
            Route::post('/store', [CastController::class, 'store'])->name('store');
            Route::patch('/{id}/update', [CastController::class, 'update'])->name('update');
            Route::delete('/{id}/destroy', [CastController::class, 'destroy'])->name('destroy');
        });

        // Users
        Route::group(['prefix' => 'user', 'as' => 'user.'], function() {
            Route::get('/', [UsersController::class, 'index'])->name('index');
            Route::patch('/{id}/activate', [UsersController::class, 'activate'])->name('activate');
            Route::patch('/{id}/add-admin', [UsersController::class, 'addAdmin'])->name('addAdmin');
            Route::patch('/{id}/remove-admin', [UsersController::class, 'removeAdmin'])->name('removeAdmin');
            Route::delete('/{id}/deactive', [UsersController::class, 'deactive'])->name('deactive');
        });

    });
});

