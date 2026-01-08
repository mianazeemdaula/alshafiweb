# Specialist Role - Setup Instructions

## Prerequisites
- Laravel application installed and configured
- Database connection established
- Spatie Laravel Permission package installed

## Step 1: Run Migrations

If you haven't already migrated the database:

```bash
php artisan migrate
```

This will create the `specialist_penalties` table.

## Step 2: Seed the Database

If you haven't already seeded the database:

```bash
php artisan db:seed
```

This will create the `specialist` role among other roles.

## Step 3: Create a Specialist User

### Option A: Using Artisan Tinker
```bash
php artisan tinker
```

Then execute:
```php
$user = App\Models\User::create([
    'name' => 'John Specialist',
    'email' => 'specialist@example.com',
    'password' => Hash::make('password123'),
    'mobile' => '1234567890',
    'ref_code' => strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8)),
]);

$user->assignRole('specialist');
```

### Option B: Using Admin Panel
1. Log in as admin
2. Navigate to Users section
3. Create a new user
4. Assign the "Specialist" role to the user

## Step 4: Verify Installation

### Check Role Exists
```bash
php artisan tinker
```
```php
Spatie\Permission\Models\Role::where('name', 'specialist')->exists();
// Should return: true
```

### Check Table Exists
```bash
php artisan tinker
```
```php
Schema::hasTable('specialist_penalties');
// Should return: true
```

### Check Routes
```bash
php artisan route:list --name=specialist-orders
```

You should see:
- `admin.specialist-orders.index`
- `admin.specialist-orders.create`
- `admin.specialist-orders.store`
- `admin.specialist-orders.show`
- `admin.specialist-orders.penalties`

## Step 5: Test the System

### 1. Login as Specialist
- Email: `specialist@example.com`
- Password: `password123` (or whatever you set)

### 2. Navigate to Specialist Orders
- Click on "Specialist Orders" in the sidebar menu
- You should see an empty orders list

### 3. Create a Test Order
- Click "New Order" button
- Fill in customer information
- Add at least one product
- Set shipping address
- Submit the form

### 4. Test Penalty System
Using Tinker:
```bash
php artisan tinker
```
```php
// Get the order you just created
$order = App\Models\Order::latest()->first();

// Change status to cancelled to trigger penalty
$order->update(['status' => 'cancelled']);

// Check if penalty was created
$penalty = $order->penalty;
dump($penalty); // Should show penalty details

// Reverse the penalty by marking as delivered
$order->update(['status' => 'delivered']);
$penalty->refresh();
dump($penalty->status); // Should be 'reversed'
```

## Step 6: Configuration (Optional)

### Change Default Penalty Amount
Edit `app/Models/SpecialistPenalty.php`:
```php
const DEFAULT_PENALTY_AMOUNT = 300; // Change to desired amount
```

### Customize Order Number Format
Edit `app/Http/Controllers/Admin/SpecialistOrderController.php` in the `store()` method:
```php
$orderNumber = 'CUSTOM-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
```

## Troubleshooting

### Problem: "Role specialist does not exist"
**Solution**:
```bash
php artisan db:seed --class=DatabaseSeeder
```
Or create manually:
```bash
php artisan tinker
```
```php
Spatie\Permission\Models\Role::create(['name' => 'specialist']);
```

### Problem: "Table specialist_penalties doesn't exist"
**Solution**:
```bash
php artisan migrate:fresh --seed
```
⚠️ Warning: This will delete all data!

### Problem: OrderObserver not triggering
**Solution**: Check if observer is registered in `app/Providers/EventServiceProvider.php` or `app/Providers/AppServiceProvider.php`:
```php
use App\Models\Order;
use App\Observers\OrderObserver;

public function boot()
{
    Order::observe(OrderObserver::class);
}
```

### Problem: Specialist can't access routes
**Solution**: Clear cache and check middleware:
```bash
php artisan route:clear
php artisan cache:clear
php artisan config:clear
```

## Verification Checklist

- [ ] Database migrated successfully
- [ ] Specialist role exists in database
- [ ] specialist_penalties table exists
- [ ] Test specialist user created
- [ ] Can login as specialist
- [ ] Can see "Specialist Orders" menu item
- [ ] Can create new order
- [ ] Can view order list
- [ ] Penalty applied on cancelled order
- [ ] Penalty reversed on delivered order
- [ ] Can view penalties page

## Next Steps

1. **Create Multiple Specialists**: Add more specialist users for testing
2. **Configure Products**: Ensure products are available for order creation
3. **Set up Cities**: Make sure cities and countries are properly configured
4. **Test Edge Cases**: Try different order statuses and scenarios
5. **Monitor Penalties**: Keep track of penalty applications

## Production Deployment

When deploying to production:

1. **Backup Database**
```bash
php artisan backup:run
```

2. **Run Migrations**
```bash
php artisan migrate --force
```

3. **Seed Only New Roles** (if needed)
```bash
php artisan tinker
```
```php
Spatie\Permission\Models\Role::firstOrCreate(['name' => 'specialist']);
```

4. **Clear Caches**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

5. **Test Thoroughly**
- Create test specialist user
- Place test orders
- Verify penalties work correctly
- Check all permissions

## Support & Documentation

- **Implementation Guide**: `SPECIALIST_IMPLEMENTATION.md`
- **Quick Reference**: `SPECIALIST_QUICK_REFERENCE.md`
- **Laravel Docs**: https://laravel.com/docs
- **Spatie Permission**: https://spatie.be/docs/laravel-permission

## Security Considerations

1. **Role Assignment**: Only admins should be able to assign specialist role
2. **Order Access**: Specialists can only see their own orders
3. **Penalty Reversal**: Consider if specialists should be able to reverse penalties
4. **Audit Logging**: Consider adding audit logs for penalty applications

---

**Setup Complete! 🎉**

Your Specialist role system is now ready to use. Specialists can:
- ✅ Create orders
- ✅ View their orders
- ✅ Track penalties
- ✅ Monitor performance

Non-delivery penalties will be automatically applied at 200 PKR when orders are cancelled or returned.
