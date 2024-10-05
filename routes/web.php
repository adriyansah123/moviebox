<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\Admin\AdminMovieController;

Route::get('/', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/watch/{id}', [MovieController::class, 'watch'])->name('movies.watch');
Route::get('/tvshow/{id}', [MovieController::class, 'episode'])->name('tvshow.episode');
Route::get('/tvshow/{id}/{season}/{episode}', [MovieController::class, 'watch'])->name('tvshow.watch');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminMovieController::class, 'index'])->name('admin.index');
    Route::get('/admin/movies/create', [AdminMovieController::class, 'create'])->name('movies.create');
    Route::post('/admin/movies/store', [AdminMovieController::class, 'store'])->name('movies.store');
    Route::post('/admin/episode/store', [AdminMovieController::class, 'storeEpisode'])->name('episode.store');
    Route::get('/admin/movies/search', [AdminMovieController::class, 'search'])->name('movies.search');
    Route::get('/admin/movies/episodelist/', [AdminMovieController::class, 'episodelist'])->name('movies.episodelist');
});

