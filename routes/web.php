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
<<<<<<< Updated upstream
=======

// pages routes
// Route::view('/', 'pages.home');
Route::view('/about', 'pages.about');
Route::view('/live', 'pages.live');
Route::view('/services', 'pages.services');
Route::view('/services/consulting', 'pages.consulting');
Route::view('/services/development', 'pages.development');
Route::view('/contact', 'pages.contact');

// In routes/web.php
Route::post('/widget/impression', function (Request $request) {
    WidgetImpression::create([
        'widget_id' => $request->widget_id,
        'session_id' => session()->getId(),
    ]);

    return response()->json(['ok' => true]);
});
>>>>>>> Stashed changes



