# Production Migration Fix Commands

## Option 1: Manual Database Fix (Recommended for production)

### Step 1: Check what foreign keys exist on the orders table
```sql
SELECT 
    CONSTRAINT_NAME,
    COLUMN_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM information_schema.KEY_COLUMN_USAGE 
WHERE TABLE_SCHEMA = 'your_database_name' 
AND TABLE_NAME = 'orders' 
AND REFERENCED_TABLE_NAME IS NOT NULL;
```

### Step 2: Drop the existing foreign key (use the actual constraint name from step 1)
```sql
-- Replace 'actual_constraint_name' with the name found in step 1
ALTER TABLE `orders` DROP FOREIGN KEY `actual_constraint_name`;
```

### Step 3: Modify the column to be nullable
```sql
ALTER TABLE `orders` MODIFY COLUMN `user_id` BIGINT UNSIGNED NULL;
```

### Step 4: Add manual customer fields
```sql
ALTER TABLE `orders` 
ADD COLUMN `customer_name` VARCHAR(255) NULL AFTER `user_id`,
ADD COLUMN `customer_email` VARCHAR(255) NULL AFTER `customer_name`,
ADD COLUMN `customer_phone` VARCHAR(255) NULL AFTER `customer_email`;
```

### Step 5: Add the foreign key back with proper constraints
```sql
ALTER TABLE `orders` 
ADD CONSTRAINT `orders_user_id_foreign` 
FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) 
ON DELETE SET NULL;
```

## Option 2: Laravel Migration Commands

### Step 1: Rollback the problematic migration
```bash
php artisan migrate:rollback --step=1
```

### Step 2: Run the fixed migration
```bash
php artisan migrate
```

## Option 3: Reset migration status (if migration is stuck)

### Check migration status
```bash
php artisan migrate:status
```

### Mark the problematic migration as rolled back
```sql
DELETE FROM migrations WHERE migration = '2025_09_15_041913_make_user_id_nullable_and_add_manual_customer_fields_to_orders_table';
```

### Then run the fixed migration
```bash
php artisan migrate
```

## Verification Commands

### Check if the foreign key exists
```sql
SHOW CREATE TABLE orders;
```

### Check if columns were added successfully
```sql
DESCRIBE orders;
```

## Notes:
- Replace 'your_database_name' with your actual database name
- Always backup your database before running these commands in production
- Test these commands in a staging environment first if possible