<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;

Route::get('/',[HomeController::class,'index'])->middleware(['auth','verified'])->name('home');
Route::get('/u/{user:username}',[ProfileController::class,'index'])->name('profile');

Route::middleware('auth')->group(function () {
     /* Profile Routes */
    Route::post('/profile/update-images', [ProfileController::class, 'updateImages'])->name('profile.updateImages');
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
   
    /* Post Routes */
    Route::post('/post', [PostController::class, 'store'])->name('post.store');
    Route::put('/post/{post}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/post/{post}', [PostController::class, 'destroy'])->name('post.delete');
    Route::get('/post/download/{attachment}', [PostController::class, 'download'])->name('post.download');
    Route::post('/post/{post}/reaction', [PostController::class, 'postReaction'])->name('post.reaction');
    Route::post('/post/{post}/comment', [PostController::class, 'createComment'])->name('post.comment.create');
    Route::put('/post/{comment}/comment', [PostController::class, 'updateComment'])->name('post.comment.update');
    Route::delete('/post/{comment}/comment', [PostController::class, 'deleteComment'])->name('post.comment.delete');
});

require __DIR__.'/auth.php';
