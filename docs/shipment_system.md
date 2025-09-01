# Shipment Management System Documentation

## Overview

The shipment management system provides comprehensive functionality to ship orders using multiple courier services (TRAX, TCS, and Leopards) through a unified interface.

## Features

### 1. Multi-Courier Support
- **TRAX/Sonic**: Fast courier service with API integration
- **TCS**: Popular Pakistani courier service
- **Leopards**: COD specialist courier service

### 2. Unified Interface
- Single interface for all courier services
- Consistent parameter mapping across different APIs
- Sandbox and production mode support

### 3. Complete Order Lifecycle
- Order placement → Shipment creation → Tracking → Delivery
- Automatic status updates
- Real-time tracking integration

## How to Use

### 1. Configure Courier Services

#### Access Admin Panel
1. Go to `/admin/courier-services`
2. Add or configure courier services
3. Set API credentials and environment mode (sandbox/production)

#### Required Information per Courier:

**TRAX/Sonic:**
- API Key
- Pickup Address ID
- Store ID (optional)
- Service Type ID

**TCS:**
- Username
- Password
- Cost Center
- Location ID

**Leopards:**
- API Key
- API Password
- Shipment Mode (Normal/Overnight/Express)
- Packet Type (Normal/Document/Fragile)

### 2. Create Shipments

#### From Order Page
1. Go to any order in admin panel
2. Click "Ship Order" button in the shipment section
3. Fill in shipment details
4. Click "Create & Book Shipment"

#### From Shipments Page
1. Go to `/admin/shipments`
2. Click "Create Shipment"
3. Select order and courier
4. Fill in package and address details
5. Submit to create and book

### 3. Track Shipments

#### Real-time Tracking
- Click "Track" button on any shipment
- Get real-time status from courier API
- Automatic status synchronization

#### Status Management
- Manual status updates
- Automatic order status updates
- Delivery confirmation handling

### 4. Manage Shipments

#### Available Actions
- **View**: See complete shipment details
- **Edit**: Update package details and status
- **Track**: Get latest tracking information
- **Cancel**: Cancel shipment with reason

#### Status Flow
1. **Pending**: Shipment created but not booked
2. **Booked**: Successfully booked with courier
3. **Picked Up**: Courier has collected the package
4. **In Transit**: Package is being transported
5. **Out for Delivery**: Package is out for final delivery
6. **Delivered**: Package successfully delivered
7. **Cancelled**: Shipment cancelled
8. **Returned**: Package returned to sender

## API Integration

### Unified Service Methods

```php
// Book a shipment
$response = $courierService->bookShipment($courier, $shipmentData);

// Track a shipment
$response = $courierService->trackShipment($courier, $trackingNumber);

// Cancel a shipment
$response = $courierService->cancelShipment($courier, $shipmentId);

// Get available cities
$response = $courierService->getCities($courier);
```

### Standard Parameters

All courier services use these standard parameters:
- `pickup_name`, `pickup_phone`, `pickup_address`, `pickup_city`
- `delivery_name`, `delivery_phone`, `delivery_address`, `delivery_city`
- `weight`, `cod_amount`, `declared_value`
- `special_instructions`, `reference`

## Database Structure

### Tables

#### `courier_service_configs`
- Stores API credentials and configuration for each courier
- Supports JSON extra fields for flexible settings
- Environment mode switching (sandbox/production)

#### `shipments`
- Complete shipment records
- Links orders to courier services
- Status tracking and timestamps
- Address and package information

### Relationships
- Order → hasOne → Shipment
- Shipment → belongsTo → Order
- Shipment → belongsTo → CourierServiceConfig

## Configuration

### Environment Variables
The system uses existing database configuration. Courier-specific settings are stored in the database for flexibility.

### Sandbox vs Production
Each courier service can be configured for:
- **Sandbox**: Testing environment with fake transactions
- **Production**: Live environment with real shipments

Toggle between modes in the admin panel without code changes.

## Troubleshooting

### Common Issues

1. **Courier API Connection Failed**
   - Check API credentials in courier service configuration
   - Verify network connectivity
   - Ensure sandbox/production mode is correct

2. **Shipment Booking Failed**
   - Verify all required fields are provided
   - Check city names match courier's city list
   - Ensure package weight is within limits

3. **Tracking Not Working**
   - Confirm tracking number is available
   - Check if shipment is actually booked with courier
   - Verify courier service is active

### Support

For technical issues:
1. Check application logs for detailed error messages
2. Test API connection using the built-in test function
3. Verify courier service credentials and configuration
4. Check courier service status and availability

## Best Practices

1. **Test First**: Always test in sandbox mode before production
2. **Monitor Status**: Regularly check shipment statuses
3. **Customer Communication**: Keep customers informed of tracking information
4. **Data Backup**: Maintain shipment records for reference
5. **API Limits**: Be aware of courier API rate limits

## Future Enhancements

Potential improvements for the system:
- Automatic tracking updates via webhooks
- Bulk shipment creation
- Custom packaging options
- Rate comparison between couriers
- Customer tracking portal
- SMS/Email notifications
- Delivery scheduling
- Return shipment management
