# Courier Webhook Integration Guide

This guide explains how to set up and configure webhooks for real-time shipment status updates from courier services.

## Overview

The webhook system automatically receives status updates from courier services and updates orders in real-time. This eliminates the need for manual status checking and provides customers with up-to-date information.

## Supported Couriers

- **Trax**: Webhook integration available (no authentication required per documentation)
- **TCS**: No webhook support - polling required for status updates
- **Leopards**: No webhook support - polling required for status updates

## Webhook Endpoints

Base URL: `https://yourdomain.com/api/webhooks`

- **Trax**: `POST /api/webhooks/trax`
- **TCS**: `POST /api/webhooks/tcs` (prepared for future use)
- **Leopards**: `POST /api/webhooks/leopards` (prepared for future use)
- **Test**: `POST /api/webhooks/test` (for testing purposes)

## Security Configuration

### Current Status
Based on courier documentation analysis:
- **Trax**: No authentication/signature verification required
- **TCS**: No webhook support documented
- **Leopards**: No webhook support documented

### Future Considerations
The webhook endpoints are prepared to handle signature verification if couriers implement it in the future. The middleware can be easily enabled by uncommenting the verification code.

### Environment Variables (Optional)

For future use if couriers implement signature verification:

```env
# Webhook Security Secrets (currently not required)
# TRAX_WEBHOOK_SECRET=your-trax-webhook-secret-here
# TCS_WEBHOOK_SECRET=your-tcs-webhook-secret-here
# LEOPARDS_WEBHOOK_SECRET=your-leopards-webhook-secret-here
```

## Status Mapping

The system maps courier-specific statuses to our internal order statuses:

### Internal Order Statuses
- `pending` - Order placed but not shipped
- `processing` - Order being prepared
- `shipped` - Order dispatched
- `delivered` - Order delivered to customer
- `cancelled` - Order cancelled
- `returned` - Order returned

### Courier Status Mappings

**Trax Statuses:**
- `Booked` → `processing`
- `In Transit`, `Out for Delivery` → `shipped`
- `Delivered` → `delivered`
- `Cancelled`, `RTO` → `cancelled`
- `Returned` → `returned`

**TCS Statuses:**
- `Booked`, `Picked Up` → `processing`
- `In Transit`, `Out for Delivery` → `shipped`
- `Delivered` → `delivered`
- `Cancelled`, `RTO` → `cancelled`
- `Returned` → `returned`

**Leopards Statuses:**
- `Booked`, `Picked` → `processing`
- `In Transit`, `Out for Delivery` → `shipped`
- `Delivered` → `delivered`
- `Cancelled`, `RTO` → `cancelled`
- `Returned` → `returned`

## Setup Instructions

### 1. Configure Webhook URLs with Couriers

**Trax Only (Currently Supported):**
- Contact Trax to register your webhook URL: `https://yourdomain.com/api/webhooks/trax`
- Method: POST
- No authentication headers required (per their documentation)
- Configure through their dashboard webhook settings

**TCS & Leopards:**
- Currently no webhook support documented
- Consider implementing polling mechanism for status updates
- Monitor for future webhook capabilities

### 2. Alternative Status Update Methods

For couriers without webhook support (TCS & Leopards):

**Option 1: Polling with Cron Jobs**
```bash
# Add to your crontab for regular status updates
*/10 * * * * php /path/to/artisan shipment:update-statuses
```

**Option 2: Manual Refresh**
- Implement manual status refresh buttons in admin panel
- Use existing tracking APIs to get latest status

### 3. Test Webhook Integration

Use the test endpoint to verify webhook functionality:

```bash
curl -X POST https://yourdomain.com/api/webhooks/test \
  -H "Content-Type: application/json" \
  -d '{
    "tracking_number": "TEST123",
    "status": "delivered",
    "timestamp": "2024-01-01 12:00:00"
  }'
```

## Webhook Payload Examples

### Trax Webhook Payload
```json
{
  "tracking_number": "TRX123456",
  "status": "Delivered",
  "status_code": "DEL",
  "timestamp": "2024-01-01T12:00:00Z",
  "location": "Karachi",
  "remarks": "Package delivered successfully"
}
```

### TCS Webhook Payload
```json
{
  "consignment_number": "TCS789012",
  "status": "Delivered",
  "date_time": "2024-01-01 12:00:00",
  "location": "Lahore",
  "remarks": "Delivered to recipient"
}
```

### Leopards Webhook Payload
```json
{
  "tracking_id": "LEO345678",
  "status": "Delivered",
  "updated_at": "2024-01-01T12:00:00",
  "city": "Islamabad",
  "comments": "Package delivered at doorstep"
}
```

## Logging and Monitoring

### Log Files

Webhook activities are logged in:
- `storage/logs/laravel.log` - General application logs
- Webhook-specific logs with context information

### Log Examples

```
[2024-01-01 12:00:00] local.INFO: Webhook received from Trax {"tracking_number":"TRX123456","status":"Delivered"}
[2024-01-01 12:00:01] local.INFO: Order status updated {"order_id":123,"old_status":"shipped","new_status":"delivered"}
```

## Error Handling

### Common Issues

1. **Invalid Signature**
   - Check webhook secret configuration
   - Verify courier service setup

2. **Shipment Not Found**
   - Ensure tracking numbers match exactly
   - Check shipment creation process

3. **Status Mapping Issues**
   - Review status mapping in CourierWebhookController
   - Add new statuses as needed

### Response Codes

- `200` - Webhook processed successfully
- `401` - Invalid signature or unauthorized
- `404` - Shipment not found
- `422` - Invalid payload data
- `500` - Internal server error

## Development and Testing

### Local Testing

For local development, signature verification is disabled. Use the test endpoint:

```bash
# Test webhook processing
curl -X POST http://localhost:8000/api/webhooks/test \
  -H "Content-Type: application/json" \
  -d '{
    "tracking_number": "TEST123",
    "status": "delivered"
  }'
```

### Production Deployment

1. Ensure all environment variables are set
2. Configure HTTPS for webhook URLs
3. Test each courier webhook individually
4. Monitor logs for any issues

## Maintenance

### Adding New Couriers

1. Add new webhook method in `CourierWebhookController`
2. Add status mapping logic
3. Register new route in `api.php`
4. Add webhook secret configuration
5. Update documentation

### Updating Status Mappings

Modify the `mapCourierStatus()` methods in `CourierWebhookController` to handle new or changed statuses from courier services.

## Support

For webhook integration issues:
1. Check application logs
2. Verify webhook configuration
3. Test with curl commands
4. Contact courier service support if needed

## Security Best Practices

1. Always use HTTPS for webhook URLs
2. Regularly rotate webhook secrets
3. Monitor for suspicious webhook calls
4. Implement rate limiting if needed
5. Log all webhook activities for audit trail