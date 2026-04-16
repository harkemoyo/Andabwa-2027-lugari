# Google OAuth Integration Setup Guide

This guide will help you integrate Google OAuth authentication into your Laravel application.

## Prerequisites

1. **Install Laravel Socialite** (if not already installed):
   ```bash
   composer require laravel/socialite
   ```

## Step 1: Google Cloud Console Setup

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Enable the following APIs:
   - Google+ API
   - Google OAuth2 API
4. Go to "Credentials" > "Create Credentials" > "OAuth 2.0 Client ID"
5. Configure the OAuth consent screen:
   - Application type: Web application
   - Authorized redirect URIs: `http://your-domain.com/auth/google/callback`
   - For local development: `http://localhost:8000/auth/google/callback`

## Step 2: Environment Configuration

Add the following to your `.env` file:

```env
# Enable Google OAuth
GOOGLE_OAUTH_ENABLED=true

# Google OAuth Credentials
GOOGLE_CLIENT_ID=your_google_client_id_here
GOOGLE_CLIENT_SECRET=your_google_client_secret_here
GOOGLE_REDIRECT_URI=http://your-domain.com/auth/google/callback
```

## Step 3: Service Configuration

Add Google provider to `config/services.php`:

```php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URI'),
],
```

## Step 4: Database Migration

Add Google OAuth fields to users table:

```php
// In your create_users_table migration
$table->string('google_id')->nullable();
$table->text('google_token')->nullable();
$table->text('google_refresh_token')->nullable();
```

Run the migration:
```bash
php artisan migrate
```

## Step 5: Routes

Add Google OAuth routes to `routes/web.php`:

```php
// Add these routes inside the guest middleware group
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
```

## Step 6: Update Login Page

Replace the disabled Google button in `resources/views/auth/login.blade.php`:

```blade
{{-- Replace this --}}
<button type="button" disabled
        class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
    <!-- Google SVG -->
    Sign in with Google (Coming Soon)
</button>

{{-- With this --}}
<a href="{{ route('auth.google') }}"
   class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
    <!-- Google SVG -->
    Sign in with Google
</a>
```

## Step 7: Update User Model

Add Google OAuth fields to User model fillable array:

```php
protected $fillable = [
    'name',
    'email',
    'password',
    'google_id',
    'google_token',
    'google_refresh_token',
];
```

## Step 8: Testing

1. Clear your config cache:
   ```bash
   php artisan config:clear
   ```

2. Test the authentication flow:
   - Visit `/login`
   - Click "Sign in with Google"
   - Complete Google authentication
   - Verify you're logged in

## Security Notes

- Always validate the Google OAuth tokens
- Store refresh tokens securely
- Implement proper session management
- Consider implementing email verification for OAuth users
- Add rate limiting to prevent abuse

## Troubleshooting

### Common Issues

1. **"Invalid redirect URI" error**
   - Ensure the redirect URI in Google Console matches exactly
   - Check for trailing slashes

2. **"Access denied" error**
   - Verify OAuth consent screen is properly configured
   - Check that required APIs are enabled

3. **Socialite exception**
   - Verify Google credentials in .env file
   - Check that Laravel Socialite is properly installed

### Debug Mode

For debugging, you can enable verbose logging in `.env`:

```env
LOG_LEVEL=debug
```

## Features to Consider

1. **Account Linking**: Allow existing users to link Google accounts
2. **Multiple Providers**: Add other OAuth providers (GitHub, Facebook, etc.)
3. **Role Assignment**: Automatically assign roles to OAuth users
4. **Profile Sync**: Sync user profile data from Google periodically
5. **Two-Factor Authentication**: Add 2FA for enhanced security

## Production Deployment

1. Use HTTPS in production
2. Set proper CORS headers
3. Monitor OAuth usage and errors
4. Implement proper logging for authentication events
5. Consider using environment-specific Google OAuth credentials
