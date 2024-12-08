# Appractic Project

## Deployment Guide for Cloudways

### Pre-deployment Steps
1. Ensure your codebase is ready:
   ```bash
   composer install --optimize-autoloader --no-dev
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

2. Set up your `.env` file:
   - Copy `.env.example` to `.env`
   - Update the following values:
     - `APP_ENV=production`
     - `APP_DEBUG=false`
     - `APP_URL=https://your-domain.com`
     - Database credentials (from Cloudways)
     - Redis credentials (if using Redis)

### Deployment Steps on Cloudways

1. **Server Setup**
   - Create a new server on Cloudways
   - Choose your preferred region
   - Select PHP 8.1 or higher
   - Select the server size based on your needs

2. **Application Setup**
   - Create a new application
   - Select PHP + Laravel as application type
   - Set your application name

3. **Deploy via Git**
   - Go to Application Settings > Git/SVN
   - Add your repository URL
   - Set branch to `main`
   - Deploy

4. **Post-deployment Steps**
   ```bash
   # Generate application key
   php artisan key:generate

   # Run migrations
   php artisan migrate --force

   # Clear all caches
   php artisan optimize:clear
   
   # Rebuild cache
   php artisan optimize
   ```

5. **File Permissions**
   ```bash
   chmod -R 755 storage bootstrap/cache
   chown -R www-data:www-data storage bootstrap/cache
   ```

### Important Notes

1. **SSL Certificate**
   - Enable SSL from Cloudways panel
   - Force HTTPS in application settings

2. **Cron Jobs**
   Add this cron job in Cloudways panel:
   ```
   * * * * * cd /home/master/applications/[app-name]/public_html && php artisan schedule:run >> /dev/null 2>&1
   ```

3. **Cache**
   - Enable Redis if needed
   - Update `.env` cache settings accordingly

4. **Monitoring**
   - Set up New Relic (optional)
   - Configure server monitoring in Cloudways panel

### Troubleshooting

1. If you encounter 500 errors:
   - Check storage permissions
   - Verify `.env` file exists
   - Review Laravel logs

2. For performance issues:
   - Enable OPcache
   - Configure Redis
   - Use Laravel's built-in caching

3. For deployment issues:
   - Verify Git credentials
   - Check deployment logs
   - Ensure composer dependencies are resolved

### Security Best Practices

1. Keep `APP_DEBUG=false` in production
2. Set proper file permissions
3. Use HTTPS only
4. Configure proper headers in `.htaccess`
5. Keep all packages updated
