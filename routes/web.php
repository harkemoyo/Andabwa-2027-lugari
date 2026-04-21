<?php

use App\Livewire\Pages\Blog\Feed;
use App\Livewire\Pages\Blog\Show;
use App\Livewire\Pages\Blog\External;
use App\Livewire\Pages\Blog\AllProjects;
use App\Models\WidgetImpression;
use Illuminate\Support\Facades\Route;

// Authentication routes
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    });

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/register', function (Request $request) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/');
    });


    Route::get('/auth/google', function () {
        return Socialite::driver('google')->redirect();
    })->name('auth.google');

    Route::get('/auth/google/callback', function () {
        $googleUser = Socialite::driver('google')->user();

        // Find or create user
        $user = \App\Models\User::firstOrCreate([
            'email' => $googleUser->getEmail(),
        ], [
            'name' => $googleUser->getName(),
            'google_id' => $googleUser->getId(),
            'google_token' => $googleUser->token,
            'google_refresh_token' => $googleUser->refreshToken,
            'password' => bcrypt(Str::random(24)), // Random password for OAuth users
        ]);

        Auth::login($user);
        return redirect()->intended('/');
    })->name('auth.google.callback');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});

// page routes
// Route::livewire('/about')

// Blog routes
Route::livewire('/', Feed::class)->name('home');
Route::livewire('/blog/projects', AllProjects::class)->name('blog.all-projects');
Route::livewire('/blog/{post:slug}', Show::class)->name('posts.show');
Route::livewire('/blog/external/{slug}', External::class)->name('blog.external');
// In routes/web.php
Route::post('/widget/impression', function (Request $request) {
    WidgetImpression::create([
        'widget_id' => $request->widget_id,
        'session_id' => session()->getId(),
    ]);

    return response()->json(['ok' => true]);
});



