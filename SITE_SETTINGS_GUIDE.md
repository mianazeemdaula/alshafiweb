# Site Settings System

This document describes the site settings system that allows administrators to configure various theme and site-wide settings from the admin panel.

## Overview

The site settings system provides a flexible way to manage configuration values without modifying code. It's particularly useful for:
- Custom header and footer code (Google Analytics, tracking pixels, etc.)
- Site-wide information (name, description, contact details)
- Theme customizations
- Any dynamic configuration that needs to be editable via admin panel

## Features

- **Organized by Groups**: Settings are organized into logical groups (general, theme, seo, etc.)
- **Multiple Field Types**: Support for text, textarea, code, number, email, and URL fields
- **Caching**: Automatic caching for better performance
- **Easy Access**: Global helper function for quick access in views
- **Admin Interface**: Full CRUD interface for managing settings

## Database Structure

The `site_settings` table stores all settings with the following columns:
- `key`: Unique identifier for the setting
- `value`: The actual setting value
- `type`: Field type (text, textarea, code, image, number, email, url)
- `group`: Organizational group name
- `label`: Human-readable label
- `description`: Optional help text

## Usage

### Accessing Settings in Views

Use the global `setting()` helper function:

```blade
<!-- Get a setting value -->
{{ setting('site_name') }}

<!-- Get with default value -->
{{ setting('contact_email', 'info@example.com') }}

<!-- Use in conditionals -->
@if(setting('maintenance_mode'))
    <div class="alert">Site is under maintenance</div>
@endif
```

### Accessing Settings in Controllers

```php
use App\Models\SiteSetting;

// Option 1: Using the helper function
$siteName = setting('site_name');

// Option 2: Using the model directly
$siteName = SiteSetting::get('site_name', 'Default Name');

// Set a value programmatically
SiteSetting::set('site_name', 'New Name');
```

### Using Header and Footer Code

To enable header and footer code injection, add these to your main layout file:

**In the `<head>` section:**
```blade
<head>
    <!-- Your existing head content -->
    
    <!-- Custom Header Code -->
    {!! setting('header_code') !!}
</head>
```

**Before closing `</body>` tag:**
```blade
    <!-- Your existing body content -->
    
    <!-- Custom Footer Code -->
    {!! setting('footer_code') !!}
</body>
```

**Important:** Use `{!! !!}` (unescaped) instead of `{{ }}` for code fields to allow HTML/JavaScript execution.

## Admin Management

### Accessing the Settings Panel

Navigate to: `/admin/settings`

### Managing Settings

1. **View All Settings**: The index page shows all settings organized by groups
2. **Edit Group**: Click "Edit Group" to modify all settings in a group at once
3. **Edit Single Setting**: Click "Edit" on individual settings for more control
4. **Create New Setting**: Click "Add New Setting" to create a custom setting
5. **Clear Cache**: Use the "Clear Cache" button to refresh cached settings

### Creating a New Setting

When creating a new setting, you'll need to provide:
- **Key**: Unique identifier (use lowercase with underscores, e.g., `custom_css`)
- **Label**: Display name (e.g., "Custom CSS")
- **Type**: Field type that determines how the value is edited
- **Group**: Organizational group (can use existing or create new)
- **Value**: Optional default value
- **Description**: Optional help text

## Pre-configured Settings

The system comes with these default settings:

### General Group
- `site_name`: Website name
- `site_description`: Brief site description
- `contact_email`: Primary contact email
- `contact_phone`: Primary contact phone

### Theme Group
- `header_code`: Custom code for `<head>` section (Google Analytics, meta tags, custom CSS)
- `footer_code`: Custom code before `</body>` (tracking scripts, custom JavaScript)

## Common Use Cases

### Google Analytics

1. Go to `/admin/settings`
2. Click "Edit Group" for Theme Settings
3. In the "Header Code" field, paste:
```html
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'GA_MEASUREMENT_ID');
</script>
```
4. Save changes

### Custom CSS

Add custom CSS in the header code:
```html
<style>
  /* Your custom CSS */
  .custom-button {
    background-color: #007bff;
    color: white;
  }
</style>
```

### Facebook Pixel

Add in the header code:
```html
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', 'YOUR_PIXEL_ID');
  fbq('track', 'PageView');
</script>
<noscript>
  <img height="1" width="1" style="display:none"
       src="https://www.facebook.com/tr?id=YOUR_PIXEL_ID&ev=PageView&noscript=1"/>
</noscript>
```

## Performance

The settings system uses Laravel's caching system to optimize performance:
- Individual settings are cached for 1 hour
- Cache is automatically cleared when settings are updated
- Manual cache clearing is available via the "Clear Cache" button

## Setup Instructions

1. **Run the migration:**
```bash
php artisan migrate
```

2. **Add helper function to your layout:**
Edit your main layout file (usually `resources/views/layouts/web.blade.php` or `app.blade.php`):

In the `<head>` section:
```blade
{!! setting('header_code') !!}
```

Before closing `</body>`:
```blade
{!! setting('footer_code') !!}
```

3. **Regenerate Composer autoload:**
```bash
composer dump-autoload
```

4. **Access the settings panel:**
Navigate to `/admin/settings` in your browser

## API Reference

### Helper Function

```php
setting(string $key, mixed $default = null): mixed
```

### Model Methods

```php
// Get a setting
SiteSetting::get(string $key, mixed $default = null): mixed

// Set a setting
SiteSetting::set(string $key, mixed $value): SiteSetting

// Get all settings grouped
SiteSetting::getAllGrouped(): Collection

// Get settings for a specific group
SiteSetting::getGroup(string $group): Collection

// Clear all caches
SiteSetting::clearCache(): void
```

## Troubleshooting

### Settings not updating in frontend

Clear the cache:
1. Via admin panel: Click "Clear Cache" button
2. Via artisan: `php artisan cache:clear`

### Helper function not found

Run `composer dump-autoload` to regenerate autoload files.

### Code not executing

Make sure you're using `{!! !!}` instead of `{{ }}` for code fields in your blade templates.
