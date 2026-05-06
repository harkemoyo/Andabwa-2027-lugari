<?php

use App\Livewire\Pages\Blog\Feed;
use App\Livewire\Pages\Blog\Show;
use App\Livewire\Pages\Blog\External;
use App\Livewire\Pages\Blog\AllProjects;
use App\Livewire\DynamicLandingPage;
use App\Livewire\Pages\HomePage;
use App\Livewire\StreamRoom;
use App\Models\WidgetImpression;
// Authentication routes
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Log;

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

        $user = User::create([
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
        try {
            $googleUser = Socialite::driver('google')->user();

            // Engineer Standard: Use updateOrCreate to handle existing users
            // and update their tokens without crashing.
            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                    // If the user already exists, keep their password. If new, generate one.
                    'password' => User::where('email', $googleUser->getEmail())->value('password')
                        ?? bcrypt(Str::random(24)),
                    'email_verified_at' => now(), // Automatically verify Google users
                ]
            );

            Auth::login($user, true); // Log in and 'Remember Me'

            request()->session()->regenerate();

            return redirect()->intended('/');
        } catch (\Exception $e) {
            // Log the error for your debugging
            Log::error('Google Auth Failed: ' . $e->getMessage());

            return redirect('/')->withErrors([
                'email' => 'Unable to authenticate with Google. Please try again.',
            ]);
        }
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

// MAIN  page routes
// Add the name 'streams.show' to the end of the route
Route::get('/streaming', HomePage::class)->name('home-page');

// Stream room route - public access
Route::get('/stream/{stream:uuid}', StreamRoom::class)->name('stream.show');

// Blog routes
Route::livewire('/', Feed::class)->name('home');
Route::livewire('/blog/projects', AllProjects::class)->name('blog.all-projects');
Route::livewire('/blog/{post:slug}', Show::class)->name('posts.show');
Route::livewire('/blog/external/{slug}', External::class)->name('blog.external');
// We use {stream:slug} to tell Laravel to find the stream by its slug column

// In routes/web.php
Route::post('/widget/impression', function (Request $request) {
    WidgetImpression::create([
        'widget_id' => $request->widget_id,
        'session_id' => session()->getId(),
    ]);

    return response()->json(['ok' => true]);
});


// 🔥 ENGINEER STANDARD: Catch-all dynamic route at the absolute bottom
Route::get('/{slug}', DynamicLandingPage::class)->name('landing-page.show');
