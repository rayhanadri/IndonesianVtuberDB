<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\SimpleController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\VtuberController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/test', function () {
    return App\Http\Controllers\PostController::class;
});
Route::get('/', [PostController::class, 'index'])->name('front');
Route::get('/clip', [PostController::class, 'index_clip'])->name('clipIndex');
Route::get('/picture', [PostController::class, 'index_picture'])->name('pictureIndex');

Route::get('/vtuber', [VtuberController::class, 'index'])->name('vtuberData');
Route::get('/vtuber/show/{id}', [VtuberController::class, 'show'])->name('vtuberDetailObject');
Route::post('/vtuber_store', [VtuberController::class, 'store'])->name('vtuberStore');
Route::post('/vtuber_edit', [VtuberController::class, 'update'])->name('vtuberEdit');
Route::post('/vtuber_destroy', [VtuberController::class, 'destroy'])->name('vtuberDestroy');

Route::get('/p/{id}', [PostController::class, 'singlepost'])->name('postPage');
Route::get('/post/search', [PostController::class, 'search'])->name('postSearch');
Route::get('/post/show/{id}', [PostController::class, 'show'])->name('postDetailObject');
Route::post('/post_store', [PostController::class, 'store'])->name('postStore');
Route::post('/post_edit', [PostController::class, 'update'])->name('postEdit');
Route::post('/post_destroy', [PostController::class, 'destroy'])->name('postDestroy');

Route::get('/tag', [TagController::class, 'index'])->name('tagIndex');
Route::get('/tag/{tag}', [PostController::class, 'searchtag'])->name('postSearchTag');
Route::post('/tag_store', [TagController::class, 'store'])->name('tagStore');
Route::get('/tag_destroy/{id}', [TagController::class, 'destroy'])->name('tagDestroy');
Auth::routes();

Route::get('/register_xyz', [SimpleController::class, 'index'])->name('register_xyz');
