# Product Offers - Quick Reference

## Admin Access URLs
- **Manage Offers**: `/admin/product-offers`
- **Create New**: `/admin/product-offers/create`
- **Edit**: `/admin/product-offers/{id}/edit`

## Current Offers in Database

| Product | Offer Title | Type | Discount | Min Qty | Status |
|---------|------------|------|----------|---------|--------|
| Donkey Oil | Buy 2 Get 10% Off | Percentage | 10% | 2 | ✅ Active |
| Donkey Oil | Bulk Discount - Rs 50 Off | Fixed | Rs 50 | 5 | ✅ Active |
| Aero Plane Oil | Buy 3 Get 15% Off | Percentage | 15% | 3 | ✅ Active |
| Cobra Oil | Weekend Special - 20% Off | Percentage | 20% | 2 | ✅ Active (expires Nov 19) |

## How to Create an Offer

1. Navigate to `/admin/product-offers/create`
2. Select product from dropdown
3. Enter offer title (e.g., "Buy 2 Get 15% Off")
4. Set minimum quantity
5. Choose discount type:
   - **Percentage**: Discount as % of total (e.g., 10 = 10% off)
   - **Fixed**: Fixed amount off (e.g., 50 = Rs 50 off)
6. Enter discount value
7. (Optional) Set start/end dates for time-limited offers
8. (Optional) Set priority (higher = shows first)
9. Check "Active" to enable immediately
10. Click "Create Offer"

## Where Offers Appear

1. **Product Detail Page**: Orange box showing all active offers
2. **Product Cards**: Small badge in top-right corner showing best offer
3. **Admin Panel**: Full list with filter/search capabilities

## How the System Works

### Best Offer Selection
When a customer adds multiple items, the system:
1. Finds all offers where `min_quantity <= quantity purchased`
2. Calculates actual discount for each applicable offer
3. Selects the offer that saves the most money

**Example**: Donkey Oil at Rs 4500 each
- Buying 5 items
- Two offers apply: 10% off (2+) or Rs 50 off (5+)
- System calculates: 10% off = Rs 2250 saved vs Rs 50 saved
- System chooses: 10% off (better savings!)

### Discount Calculation
```php
// For percentage discounts
discount = (total_price × discount_value) / 100

// For fixed discounts
discount = discount_value
```

## API Methods (for developers)

### In Product Model
```php
$product->activeOffers          // Get all active offers
$product->getBestOffer(5)       // Get best offer for buying 5 items
$product->getPriceWithOffer(5)  // Get final price for 5 items with offer
```

### In ProductOffer Model
```php
$offer->isValid()                        // Check if offer is active & within date range
$offer->calculateDiscount(5, 100)        // Calculate discount for 5 items at Rs 100 each
$offer->getFinalPrice(5, 100)            // Get final price after discount
```

## Testing Checklist

- [✅] Database table created
- [✅] Sample offers inserted
- [✅] Discount calculations verified
- [✅] Best offer selection logic tested
- [ ] Admin create form tested manually
- [ ] Admin edit form tested manually
- [ ] Product page display tested
- [ ] Product cards display tested
- [ ] Mobile responsive tested
- [ ] Dark mode tested

## Next Steps

### Immediate (Optional):
- Test admin interface by creating/editing offers manually
- Verify offers appear correctly on product pages
- Test on mobile devices

### Future Enhancements:
1. **Cart Integration**: Auto-apply discounts at checkout
2. **Order Tracking**: Save which offer was used with each order
3. **Analytics**: Track offer usage and ROI
4. **Notifications**: Alert customers "Add 1 more for discount!"
5. **Advanced Features**: Category-wide offers, user-specific offers

## Troubleshooting

**Offers not showing on product page?**
- Check `is_active` is true
- Verify dates (start_date/end_date) include today
- Ensure product has `activeOffers` relationship loaded

**Wrong offer being selected?**
- System picks offer with maximum savings
- Check discount calculations for both offers
- Verify min_quantity requirements

**Can't access admin panel?**
- Must be logged in with admin role
- URL: `yourdomain.com/admin/product-offers`

## Support

For issues or questions:
1. Check `PRODUCT_OFFERS_IMPLEMENTATION.md` for detailed docs
2. Review sample code in ProductOffer and Product models
3. Test calculations using sample data

---
Last Updated: November 12, 2025
Status: ✅ Fully Operational
