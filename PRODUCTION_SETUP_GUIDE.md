# Production Setup Guide - Real-time Updates & Media Storage

## Overview
This guide provides production-grade configuration for real-time updates using Reverb/Pusher and proper media storage handling.

## 1. Storage Configuration

### Local Development
```env
# .env
FILESYSTEM_DISK=public
APP_URL=http://127.0.0.1:8080
```

### Production (Cloud/Laravel Cloud)
```env
# .env.production
FILESYSTEM_DISK=public
APP_URL=https://your-domain.com

# For S3/Cloud storage (optional, if using cloud storage)
BLOG_MEDIA_DISK=s3
BLOG_MEDIA_URL=https://your-bucket.s3.amazonaws.com/blog/media
BLOG_MEDIA_ROOT=s3://your-bucket/blog/media

AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket-name
AWS_ENDPOINT=https://s3.amazonaws.com
```

### Create Storage Symlink (Required for local & production)
```bash
php artisan storage:link
```

## 2. Broadcasting Configuration (Reverb/Pusher)

### Using Reverb (Recommended for Laravel)
```env
# .env
BROADCAST_CONNECTION=reverb
REVERB_APP_ID=local
REVERB_APP_KEY=local-key
REVERB_APP_SECRET=local-secret
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http
```

### Using Pusher (Alternative)
```env
# .env
BROADCAST_CONNECTION=pusher
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=mt1
PUSHER_HOST=api-mt1.pusher.com
PUSHER_PORT=443
PUSHER_SCHEME=https
```

### Frontend Configuration (resources/js/bootstrap.js)
Ensure Echo is configured correctly:
```javascript
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: env('BROADCAST_CONNECTION', 'reverb'),
    key: env('REVERB_APP_KEY') || env('PUSHER_APP_KEY'),
    // ... other configuration
});
```

## 3. Event Broadcasting Channels

### Active Channels
- `ui-updates` - Social links updates
- `footer` - Footer content updates
- `widgets-updates` - Widget updates

### Event Listeners
Components are configured to listen for both local Livewire events and broadcast events:

**Social Links Component:**
- `#[On('FooterUpdated')]` - Local event
- `#[On('SocialLinksUpdated')]` - Local event
- `echo:ui-updates,SocialLinksUpdated` - Broadcast event

**Navigation Logo Component:**
- `#[On('FooterUpdated')]` - Local event
- `echo:ui-updates,FooterUpdated` - Broadcast event

**Rotating Widgets Component:**
- `#[On('WidgetsUpdated')]` - Local event
- `echo:widgets-updates,widgets.updated` - Broadcast event

## 4. Database Seeding

### Run Seeders
```bash
php artisan db:seed --force
```

### Seeded Media Paths
Social link images are seeded with paths relative to storage:
- `social-links/facebook.gif`
- `social-links/instagram.gif`
- `social-links/x.gif`
- `social-links/whatsapp.gif`
- `social-links/linkedin.gif`

These files should exist in `storage/app/public/social-links/`

## 5. Production Deployment Checklist

### Pre-Deployment
- [ ] Run `php artisan storage:link`
- [ ] Verify media files exist in `storage/app/public/`
- [ ] Configure broadcasting connection (reverb/pusher)
- [ ] Set proper environment variables
- [ ] Test event broadcasting locally

### Post-Deployment
- [ ] Verify storage symlink is accessible
- [ ] Test social links images load correctly
- [ ] Test logo updates in real-time
- [ ] Test widget updates in real-time
- [ ] Monitor broadcast connection logs

## 6. Troubleshooting

### Images Not Showing
1. Check storage symlink exists: `public/storage -> storage/app/public`
2. Verify files exist in `storage/app/public/social-links/`
3. Check file permissions: `storage/app/public` should be readable
4. Run `php artisan storage:link` if symlink is missing

### Real-time Updates Not Working
1. Verify `BROADCAST_CONNECTION` is set correctly
2. Check Reverb/Pusher credentials
3. Ensure queue worker is running if using queued broadcasts
4. Check browser console for WebSocket connection errors
5. Verify event listeners are properly registered

### Widgets Not Updating
1. Check `WidgetsUpdated` event is being dispatched
2. Verify channel name matches: `widgets-updates`
3. Check component has proper listeners
4. Test with `php artisan tinker`:
   ```php
   event(new \App\Events\WidgetsUpdated());
   ```

## 7. Environment Variable Reference

### Required Variables
```env
APP_URL=https://your-domain.com
FILESYSTEM_DISK=public
BROADCAST_CONNECTION=reverb  # or pusher
```

### Reverb Configuration
```env
REVERB_APP_ID=your_app_id
REVERB_APP_KEY=your_app_key
REVERB_APP_SECRET=your_app_secret
REVERB_HOST=your-reverb-host
REVERB_PORT=443
REVERB_SCHEME=https
```

### Pusher Configuration (Alternative)
```env
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=mt1
```

### Optional S3 Configuration
```env
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket
```

## 8. Monitoring & Logging

### Enable Broadcast Logging (Development)
```env
BROADCAST_CONNECTION=log
```

### Check Event Broadcasting
Use Laravel Telescope or custom logging to verify events are dispatched:
```php
Log::info('Event dispatched', ['event' => 'WidgetsUpdated']);
```

## 9. Security Considerations

- Never commit `.env` files to version control
- Use environment-specific configuration
- Rotate Reverb/Pusher keys regularly
- Restrict S3 bucket access with IAM policies
- Enable HTTPS for all broadcast connections
- Validate all user inputs before storage
