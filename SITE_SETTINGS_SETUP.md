# Site Settings System - Quick Setup

Follow these steps to activate the site settings system:

## Step 1: Run Database Migration

```bash
php artisan migrate
```

This will create the `site_settings` table and populate it with default settings.

## Step 2: Regenerate Autoload Files

```bash
composer dump-autoload
```

This ensures the helper function is available throughout your application.

## Step 3: Access the Admin Panel

Navigate to: `/admin/settings`

Default settings groups:
- **General Settings**: site_name, site_description, contact_email, contact_phone
- **Theme Settings**: header_code, footer_code

## Step 4: Test the Settings

### Add Google Analytics (Example)

1. Go to `/admin/settings`
2. Click "Edit Group" on Theme Settings
3. In the "Header Code" field, paste your Google Analytics code
4. Click "Save Changes"

### Verify Settings Work

Add this to any view file:
```blade
<p>Site Name: {{ setting('site_name') }}</p>
```

## Available Commands

```bash
# Clear all settings cache
php artisan cache:clear

# Or use the admin panel's "Clear Cache" button
```

## File Locations

- **Migration**: `database/migrations/2026_02_11_000000_create_site_settings_table.php`
- **Model**: `app/Models/SiteSetting.php`
- **Controller**: `app/Http/Controllers/Admin/SettingsController.php`
- **Views**: `resources/views/admin/settings/`
- **Routes**: Added to `routes/web.php` under admin section
- **Helper**: `app/helpers.php`
- **Documentation**: `SITE_SETTINGS_GUIDE.md`

## Quick Usage Examples

### In Blade Templates
```blade
<!-- Simple usage -->
{{ setting('site_name') }}

<!-- With default value -->
{{ setting('custom_key', 'default value') }}

<!-- Code injection (unescaped) -->
{!! setting('header_code') !!}
```

### In Controllers
```php
use App\Models\SiteSetting;

// Get a value
$value = setting('key_name');

// Set a value
SiteSetting::set('key_name', 'new value');
```

## Troubleshooting

**Problem**: Helper function not found
**Solution**: Run `composer dump-autoload`

**Problem**: Settings not updating
**Solution**: Clear cache via admin panel or run `php artisan cache:clear`

**Problem**: Code not executing in browser
**Solution**: Make sure you're using `{!! !!}` instead of `{{ }}` for code fields

## Next Steps

1. Customize default settings in `/admin/settings`
2. Add custom tracking codes (Google Analytics, Facebook Pixel, etc.)
3. Create additional settings as needed using "Add New Setting" button

For detailed documentation, see: `SITE_SETTINGS_GUIDE.md`
