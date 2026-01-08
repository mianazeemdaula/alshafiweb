# Specialist Role - Quick Reference

## URLs

### Specialist Orders
- **List**: `/admin/specialist-orders`
- **Create**: `/admin/specialist-orders/create`
- **View**: `/admin/specialist-orders/{id}`
- **Penalties**: `/admin/specialist-orders/penalties`

## Role Assignment

### Assign Specialist Role to User
```php
$user = User::find($userId);
$user->assignRole('specialist');
```

### Check if User is Specialist
```php
if ($user->isSpecialist()) {
    // User is a specialist
}
```

## Penalty Configuration

### Default Penalty Amount
Located in: `app/Models/SpecialistPenalty.php`
```php
const DEFAULT_PENALTY_AMOUNT = 200; // 200 PKR
```

### Manual Penalty Creation
```php
use App\Models\SpecialistPenalty;

SpecialistPenalty::create([
    'specialist_id' => $userId,
    'order_id' => $orderId,
    'penalty_amount' => 200,
    'reason' => 'Non-Delivery',
    'status' => 'applied',
    'notes' => 'Penalty reason...',
]);
```

### Apply Penalty Programmatically
```php
$penalty = SpecialistPenalty::find($penaltyId);
$penalty->apply();
```

### Reverse Penalty
```php
$penalty = SpecialistPenalty::find($penaltyId);
$penalty->reverse('Order was delivered');
```

## Order Queries

### Get All Specialist Orders
```php
$orders = Order::specialistOrders()->get();
```

### Get Orders by Specific Specialist
```php
$orders = Order::where('order_source', 'specialist')
    ->where('order_taker_id', $specialistId)
    ->get();
```

### Check if Order is Specialist Order
```php
if ($order->isSpecialistOrder()) {
    // This is a specialist order
}
```

## Statistics

### Total Specialist Orders
```php
$total = Order::where('order_source', 'specialist')->count();
```

### Total Revenue
```php
$revenue = Order::where('order_source', 'specialist')->sum('total');
```

### Total Penalties
```php
$penalties = SpecialistPenalty::where('status', 'applied')->sum('penalty_amount');
```

### Specialist Performance
```php
$specialist = User::find($specialistId);
$totalOrders = $specialist->specialistOrders()->count();
$totalPenalties = $specialist->specialistPenalties()
    ->where('status', 'applied')
    ->sum('penalty_amount');
```

## Penalty Triggers

### Automatic Penalty Application
Penalties are automatically applied when order status changes to:
- `returned`
- `cancelled`

### Automatic Penalty Reversal
Penalties are automatically reversed when order status changes to:
- `delivered`

## Creating Specialist Order via Code

```php
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();
try {
    // Create order
    $order = Order::create([
        'number' => 'SPEC-' . date('Ymd') . '-' . rand(1000, 9999),
        'order_source' => 'specialist',
        'order_taker_id' => $specialistId,
        'customer_name' => 'Customer Name',
        'customer_phone' => '1234567890',
        'payment_method_id' => 1,
        'city_id' => 1,
        'country_id' => 1,
        'street_address' => 'Address',
        'type' => 'call',
        'status' => 'open',
        'payment_status' => 'pending',
        'total' => 1000,
    ]);

    // Add order details
    OrderDetail::create([
        'order_id' => $order->id,
        'product_id' => 1,
        'qty' => 1,
        'price' => 1000,
    ]);

    DB::commit();
} catch (\Exception $e) {
    DB::rollBack();
    // Handle error
}
```

## Testing

### Create Test Specialist User
```bash
php artisan tinker
```

```php
$user = App\Models\User::factory()->create([
    'name' => 'Test Specialist',
    'email' => 'specialist@test.com',
]);
$user->assignRole('specialist');
```

### Create Test Order
```php
$order = App\Models\Order::create([
    'number' => 'SPEC-TEST-001',
    'order_source' => 'specialist',
    'order_taker_id' => $user->id,
    'customer_name' => 'Test Customer',
    'customer_phone' => '1234567890',
    'payment_method_id' => 1,
    'city_id' => 1,
    'country_id' => 1,
    'street_address' => 'Test Address',
    'type' => 'call',
    'status' => 'open',
    'payment_status' => 'pending',
    'total' => 1000,
]);
```

### Test Penalty Application
```php
$order->update(['status' => 'cancelled']);
// Check penalties
$penalty = $order->penalty;
```

## Important Notes

1. **Order Source**: Specialist orders must have `order_source` set to `'specialist'`
2. **Order Number Format**: `SPEC-YYYYMMDD-XXXX`
3. **Penalty Amount**: Default is 200 PKR, configurable in model
4. **Access Control**: Routes are protected by `role:admin|specialist` middleware
5. **Automatic Processing**: Penalties are handled by OrderObserver automatically

## Common Issues

### Issue: Specialist can't see orders
**Solution**: Check if order has `order_source = 'specialist'` and `order_taker_id` matches the specialist's ID

### Issue: Penalty not applied
**Solution**: Ensure OrderObserver is registered and order status changed to 'cancelled' or 'returned'

### Issue: Can't access specialist routes
**Solution**: Verify user has 'specialist' role assigned

## Support

For issues or questions, refer to:
- Implementation guide: `SPECIALIST_IMPLEMENTATION.md`
- Order Observer: `app/Observers/OrderObserver.php`
- Specialist Controller: `app/Http/Controllers/Admin/SpecialistOrderController.php`
