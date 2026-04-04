<?php 

use App\Livewire\Pages\Blog\Feed;
use App\Livewire\Pages\Blog\Show;
use App\Livewire\Pages\Blog\External;
use App\Livewire\Pages\Blog\AllProjects;
use Illuminate\Support\Facades\Route;

Route::livewire('/', Feed::class)->name('home');
Route::livewire('/blog/projects', AllProjects::class)->name('blog.all-projects');
Route::livewire('/blog/{post:slug}', Show::class)->name('posts.show');
Route::livewire('/blog/external/{slug}', External::class)->name('blog.external');



