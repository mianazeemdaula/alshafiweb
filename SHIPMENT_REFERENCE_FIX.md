# Shipment Reference Field - Bug Fix

## Issue Description
**Error:** "Failed to create shipment: Undefined array key 'success'"

**Cause:** When creating a shipment with a blank reference field, the application threw an error because:
1. The reference field (`order_id` in the courier API) was passed as `null` when blank
2. The UnifiedCourierService validated required parameters and returned an error response without a `success` key
3. The ShipmentController tried to access `$response['success']` which didn't exist, causing the "Undefined array key" error

## Root Causes

### 1. Missing Default Value for Reference
In `ShipmentController.php` line 157, the reference was passed directly without a fallback:
```php
'order_id' => $request->reference,  // This could be null/empty
```

### 2. Inconsistent Error Response Structure
In `UnifiedCourierService.php` line 35, the error response didn't include a `success` key:
```php
return ['status' => 'error', 'message' => "Missing required parameter: $param"];
```

### 3. Unsafe Array Key Access
In `ShipmentController.php` line 165, the code accessed the array key without checking if it exists:
```php
if ($response['success']) {  // Fails if 'success' key doesn't exist
```

## Fixes Applied

### Fix 1: Default Reference Value
**File:** `app/Http/Controllers/Admin/ShipmentController.php` (Line 157)

**Before:**
```php
'order_id' => $request->reference,
'special_instructions' => $request->special_instructions,
```

**After:**
```php
'special_instructions' => $request->special_instructions ?? '',
'order_id' => $request->reference ?? 'ORD-' . $order->id,
```

**Impact:** When reference is blank, it now automatically generates a reference like `ORD-123` using the order ID.

### Fix 2: Consistent Error Response Structure
**File:** `app/Services/UnifiedCourierService.php` (Line 34-39)

**Before:**
```php
foreach ($requiredParams as $param) {
    if (empty($params[$param])) {
        return ['status' => 'error', 'message' => "Missing required parameter: $param"];
    }
}
```

**After:**
```php
foreach ($requiredParams as $param) {
    if (empty($params[$param])) {
        return [
            'success' => false,
            'status' => 'error',
            'message' => "Missing required parameter: $param"
        ];
    }
}
```

**Impact:** All error responses now include the `success` key for consistent error handling.

### Fix 3: Safe Array Key Access
**File:** `app/Http/Controllers/Admin/ShipmentController.php` (Line 165)

**Before:**
```php
// Handle booking response
if ($response['success']) {
```

**After:**
```php
// Handle booking response - check for success or error status
if (isset($response['success']) && $response['success']) {
```

**Impact:** Safely checks if the `success` key exists before accessing it.

### Fix 4: Improved Error Handling
**File:** `app/Http/Controllers/Admin/ShipmentController.php` (Line 203-210)

**Before:**
```php
} else {
    return redirect()->back()->with('warning', 'Shipment created but booking failed: ' . $response['message']);
}
```

**After:**
```php
} else {
    // Handle error response
    $errorMessage = $response['message'] ?? $response['error'] ?? 'Unknown error occurred';
    
    Log::error('Shipment booking failed: ' . $errorMessage, ['response' => $response]);
    
    return redirect()->back()
        ->withInput()
        ->with('error', 'Failed to create shipment: ' . $errorMessage);
}
```

**Impact:** 
- Checks multiple possible error message keys (`message`, `error`)
- Provides fallback for unknown errors
- Logs the error for debugging
- Returns user input so they don't lose their data
- Shows proper error (not warning) message

### Fix 5: Consistent "Unsupported Courier" Response
**File:** `app/Services/UnifiedCourierService.php` (Line 59)

**Before:**
```php
default:
    return ['error' => 'Unsupported courier'];
```

**After:**
```php
default:
    return [
        'success' => false,
        'error' => 'Unsupported courier',
        'message' => 'The selected courier is not supported'
    ];
```

**Impact:** Unsupported courier errors now have consistent response structure.

## Testing Scenarios

### Scenario 1: Blank Reference Field
**Steps:**
1. Go to create shipment page
2. Fill in all required fields
3. Leave "Reference" field blank
4. Submit form

**Expected Result:**
✅ Shipment created successfully with auto-generated reference (e.g., `ORD-123`)

### Scenario 2: With Reference Field
**Steps:**
1. Go to create shipment page
2. Fill in all required fields
3. Enter custom reference (e.g., `MY-REF-001`)
4. Submit form

**Expected Result:**
✅ Shipment created successfully with custom reference `MY-REF-001`

### Scenario 3: Invalid Courier
**Steps:**
1. Manually trigger bookShipment with invalid courier name
2. Check response structure

**Expected Result:**
✅ Response includes `success: false` and proper error message

### Scenario 4: Missing Required Fields
**Steps:**
1. Create shipment with missing required field
2. Check error message

**Expected Result:**
✅ Clear error message showing which parameter is missing

## Response Structure Standard

All courier service methods should now return responses in this format:

### Success Response:
```php
[
    'success' => true,
    'tracking_number' => 'TRACK123',
    'shipment_id' => '12345',
    'message' => 'Success message',
    'raw_response' => [/* courier API response */]
]
```

### Error Response:
```php
[
    'success' => false,
    'status' => 'error',
    'message' => 'Human-readable error message',
    'error' => 'Technical error description',
    'raw_response' => [/* courier API response if available */]
]
```

## Files Modified

1. **app/Http/Controllers/Admin/ShipmentController.php**
   - Line 157: Added default value for `order_id` and `special_instructions`
   - Line 165: Added safe array key check with `isset()`
   - Lines 203-210: Improved error handling with multiple message sources

2. **app/Services/UnifiedCourierService.php**
   - Lines 34-39: Added `success: false` to validation error response
   - Line 59: Added consistent response structure for unsupported courier

## Benefits

✅ **No more crashes** when reference field is blank
✅ **Auto-generated references** when user doesn't provide one
✅ **Consistent error handling** across all courier services
✅ **Better debugging** with proper error logging
✅ **User-friendly** - preserves form input on error
✅ **Safe code** - no undefined array key access

## Migration Notes

No database migration needed. This is a code-only fix.

## Rollback Plan

If needed, revert commits to:
- `app/Http/Controllers/Admin/ShipmentController.php`
- `app/Services/UnifiedCourierService.php`

However, rollback is **not recommended** as the old code has the bug.

---

**Status:** ✅ Fixed and Tested
**Date:** October 14, 2025
**Impact:** Bug Fix - No Breaking Changes
