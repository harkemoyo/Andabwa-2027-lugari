# Deployment Checklist for andabwa_2027_lugari_master

## S3 Configuration
- [ ] Update AWS_ACCESS_KEY_ID with actual access key
- [ ] Update AWS_SECRET_ACCESS_KEY with actual secret key
- [ ] Verify AWS_BUCKET name matches S3 bucket
- [ ] Set AWS_URL to your S3 endpoint
- [ ] Test S3 connectivity with `php artisan storage:link --force`

## Database Configuration
- [ ] Update database credentials in production
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Seed data: `php artisan db:seed --force`

## Real-time Updates (Reverb)
- [ ] Start Reverb server: `php artisan reverb:start`
- [ ] Update REVERB_HOST to production domain
- [ ] Configure firewall for port 8080
- [ ] Test WebSocket connection

## Performance Optimization
- [ ] Clear caches: `php artisan config:clear && php artisan cache:clear && php artisan route:clear && php artisan view:clear`
- [ ] Optimize: `php artisan optimize`
- [ ] Build assets: `npm run build`

## Security
- [ ] Set APP_DEBUG=false in production
- [ ] Verify HTTPS configuration
- [ ] Check file permissions on storage directory
- [ ] Test media uploads and public access

## Post-Deployment Tests
- [ ] Test media upload functionality
- [ ] Verify S3 public access URLs work
- [ ] Test real-time updates in admin panel
- [ ] Check all pages load correctly
