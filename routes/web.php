<?php 

use App\Livewire\Pages\Blog\Feed;
use App\Livewire\Pages\Blog\Show;
use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\Blog\Show as BlogShow;

Route::livewire('/', Feed::class)->name('home');
Route::livewire('/blog/{post:slug}', Show::class)->name('posts.show');
// Ensure you add ->name('blog.show') at the end
Route::get('/blog/{slug}', BlogShow::class)->name('blog.show');
// Remove the duplicate Route::get line and keep only this one
// Route::livewire('/blog/{post:slug}', Show::class)->name('blog.show');



