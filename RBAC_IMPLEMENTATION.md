# Role-Based Access Control (RBAC) Implementation

## Overview
This document outlines the role-based access control system implemented in the Alshaafi Online application.

## Roles

### 1. Admin
Full access to all features and modules in the system.

**Access to:**
- Dashboard
- Categories Management
- Products Management
- Users Management
- Levels Management
- Orders Management
- News Management
- Suggestions Management
- Blog Categories Management
- Blog Posts Management
- Banners Management
- Courier Services Management
- Shipments Management
- Shipment Dashboard

### 2. Order Taker
Limited access specifically for order and shipment management.

**Access to:**
- Dashboard
- Orders Management (view, create, edit)
- Shipments Management (view, create, edit, track, download slip)
- Shipment Dashboard

**Restricted from:**
- Categories, Products, Users, Levels
- News, Suggestions, Blog, Banners
- Courier Services Configuration

### 3. Support
Similar access as Order Taker (can be customized separately if needed).

**Access to:**
- Dashboard
- Orders Management
- Shipments Management
- Shipment Dashboard

### 4. User
Regular customer access to the frontend application.

**Access to:**
- User Dashboard
- Profile Management
- Order History
- Product Reviews
- Referrals

## Implementation Details

### Database Changes
- No schema changes required
- Uses Spatie Laravel Permission package
- Roles are stored in `roles` table
- User-role associations in `model_has_roles` table

### Files Modified

1. **app/Http/Controllers/Admin/UserController.php**
   - Added role assignment in create/store methods
   - Added role update in edit/update methods
   - Pass roles to views

2. **resources/views/admin/users/create.blade.php**
   - Added role dropdown field
   - Validation for role selection

3. **resources/views/admin/users/edit.blade.php**
   - Added role dropdown field
   - Pre-select current user role

4. **resources/views/admin/users/index.blade.php**
   - Added Role column to user table
   - Display role badge with color coding
   - Fixed edit/delete route names

5. **resources/views/layouts/web.blade.php**
   - Updated sidebar with role-based menu items
   - Admin-only sections
   - Order Taker accessible sections

6. **resources/views/admin/partials/sidebar.blade.php**
   - Created reusable sidebar component
   - Role-based menu rendering

7. **routes/web.php**
   - Separated admin-only routes
   - Created order_taker accessible routes group
   - Applied appropriate middleware

8. **database/seeders/OrderTakerRoleSeeder.php**
   - New seeder for order_taker role
   - Permissions setup
   - Can be run separately

9. **database/seeders/DatabaseSeeder.php**
   - Added order_taker role creation

## How to Use

### Running the Seeder
To set up roles and permissions:

```bash
php artisan db:seed --class=OrderTakerRoleSeeder
```

### Creating a New User with Role

1. Navigate to **Admin Panel > Users > Create**
2. Fill in user details:
   - Name
   - Email
   - Mobile
   - Referral Code (optional)
   - Extra Discount (optional)
   - **Role** (required) - Select from dropdown
   - Password
   - Confirm Password
3. Click "Create User"

### Updating User Role

1. Navigate to **Admin Panel > Users**
2. Click edit icon for the user
3. Change the role from dropdown
4. Click "Update User"

### Testing Role Access

1. Create test users with different roles
2. Login as each user
3. Verify sidebar menu items based on role
4. Try accessing restricted routes directly

## Permissions

### Order Taker Permissions
- view orders
- create orders
- edit orders
- view shipments
- create shipments
- edit shipments
- track shipments
- download shipment slip

## Route Protection

Routes are protected using the `role` middleware from Spatie Permission package:

```php
// Admin only
Route::middleware('role:admin')->group(function () {
    // Admin routes
});

// Admin or Order Taker
Route::middleware('role:admin|order_taker')->group(function () {
    // Shared routes
});
```

## UI Customization

The sidebar dynamically shows/hides menu items based on user role using Blade directives:

```blade
@if(auth()->user()->hasRole('admin'))
    <!-- Admin only items -->
@endif

@if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('order_taker'))
    <!-- Shared items -->
@endif
```

## Security Considerations

1. Always validate role on both frontend and backend
2. Use middleware for route protection
3. Check permissions in controllers when needed
4. Don't rely solely on UI hiding

## Future Enhancements

1. Add more granular permissions
2. Create role management UI for admin
3. Add permission-based access (not just role-based)
4. Implement activity logging per role
5. Add custom permissions per order_taker user

## Testing Checklist

- [ ] Admin can access all modules
- [ ] Order Taker can access orders and shipments only
- [ ] Order Taker cannot access admin-only routes
- [ ] User CRUD properly assigns and updates roles
- [ ] Sidebar shows correct menu items per role
- [ ] Role filter works on users index page
- [ ] Role badge displays correctly in users table
