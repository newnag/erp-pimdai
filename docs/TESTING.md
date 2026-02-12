# Testing Guide - ERP PIMDAI

## Overview
เอกสารนี้อธิบายการใช้งาน Test Suite ของระบบ ERP PIMDAI ซึ่งครอบคลุมทุกโมดูลตามเอกสาร SRS

## Test Structure

```
tests/
├── Feature/                    # Feature Tests (Integration/E2E)
│   ├── Auth/
│   │   └── AuthenticationTest.php
│   ├── CustomerManagementTest.php
│   └── InventoryManagementTest.php
│
├── Unit/                       # Unit Tests (Isolated)
│   ├── UserTest.php
│   └── Models/
│       ├── CustomerTest.php
│       ├── QuotationTest.php
│       ├── BillingTest.php
│       ├── InvoiceTest.php
│       ├── ProductTest.php
│       ├── StockInTest.php
│       ├── PurchaseOrderTest.php
│       ├── SupplierTest.php
│       ├── AssetTest.php
│       ├── ExpenseTest.php
│       ├── AttendanceTest.php
│       ├── SurveyCallTest.php
│       └── ClaimTest.php
│
└── TestCase.php                # Base Test Case
```

## Test Coverage by Module

### 1. Authentication & User Management
- ✅ User Model Tests (UserTest.php)
- ✅ Authentication Flow (AuthenticationTest.php)
- ✅ Password Reset
- ✅ Role-based Access

### 2. Sales Module
- ✅ Customer Management (CustomerTest.php)
- ✅ Quotation System (QuotationTest.php)
- ✅ Billing/Delivery (BillingTest.php)
- ✅ Invoice/Receipt (InvoiceTest.php)
- ✅ Survey Call (SurveyCallTest.php)
- ✅ Claim & Fix (ClaimTest.php)

### 3. Inventory Module
- ✅ Product Registry (ProductTest.php)
- ✅ Stock In Operations (StockInTest.php)
- ✅ Finished Goods vs Raw Material
- ✅ Stock Movement Tracking

### 4. Purchase Module
- ✅ Supplier Management (SupplierTest.php)
- ✅ Purchase Order (PurchaseOrderTest.php)

### 5. Accounting & Assets
- ✅ Asset Management (AssetTest.php)
- ✅ Depreciation Calculation
- ✅ Expense Tracking (ExpenseTest.php)

### 6. HR Module
- ✅ Attendance System (AttendanceTest.php)
- ✅ Work Hours Calculation
- ✅ Overtime Tracking

## Running Tests

### Run All Tests
```bash
php artisan test
```

### Run Specific Test Suite
```bash
# Unit Tests Only
php artisan test --testsuite=Unit

# Feature Tests Only
php artisan test --testsuite=Feature
```

### Run Specific Test File
```bash
php artisan test tests/Unit/UserTest.php
php artisan test tests/Feature/Auth/AuthenticationTest.php
```

### Run Specific Test Method
```bash
php artisan test --filter test_user_can_be_created
```

### Run Tests with Coverage
```bash
php artisan test --coverage
php artisan test --coverage-html coverage/
```

### Run Tests in Parallel
```bash
php artisan test --parallel
```

## Test Database Configuration

### Using SQLite In-Memory (Recommended for Testing)
เพิ่มใน `phpunit.xml`:
```xml
<php>
    <env name="DB_CONNECTION" value="sqlite"/>
    <env name="DB_DATABASE" value=":memory:"/>
</php>
```

### Using MySQL Test Database
```env
# .env.testing
DB_CONNECTION=mysql
DB_DATABASE=erp_pimdai_test
```

## Writing New Tests

### Unit Test Example
```php
<?php

namespace Tests\Unit\Models;

use App\Models\YourModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class YourModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_model_can_be_created(): void
    {
        $model = YourModel::create([
            'field' => 'value',
        ]);

        $this->assertDatabaseHas('your_table', [
            'field' => 'value',
        ]);
    }
}
```

### Feature Test Example
```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_access_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/your-route');

        $response->assertStatus(200);
    }
}
```

## Test Assertions

### Database Assertions
```php
// Check record exists
$this->assertDatabaseHas('users', ['email' => 'test@example.com']);

// Check record doesn't exist
$this->assertDatabaseMissing('users', ['email' => 'test@example.com']);

// Check soft deleted
$this->assertSoftDeleted('users', ['id' => 1]);
```

### Authentication Assertions
```php
// Check authenticated
$this->assertAuthenticated();

// Check guest
$this->assertGuest();

// Check authenticated as specific user
$this->assertAuthenticatedAs($user);
```

### Response Assertions
```php
$response->assertStatus(200);
$response->assertRedirect('/dashboard');
$response->assertViewIs('users.index');
$response->assertViewHas('users');
$response->assertSee('Welcome');
$response->assertDontSee('Error');
```

### Model Assertions
```php
$this->assertEquals('expected', $actual);
$this->assertTrue($condition);
$this->assertFalse($condition);
$this->assertNull($value);
$this->assertNotNull($value);
$this->assertCount(5, $collection);
$this->assertInstanceOf(User::class, $object);
```

## Factory Usage

### Generate Test Data
```php
// Create single record
$user = User::factory()->create();

// Create multiple records
$users = User::factory()->count(10)->create();

// Create with specific attributes
$admin = User::factory()->admin()->create([
    'name' => 'Admin User',
]);

// Make instance without saving
$user = User::factory()->make();
```

## Testing Roles and Permissions

```php
public function test_admin_can_delete_user(): void
{
    $admin = User::factory()->admin()->create();
    $user = User::factory()->create();

    $response = $this->actingAs($admin)
        ->delete("/users/{$user->id}");

    $response->assertStatus(200);
}

public function test_sales_cannot_delete_user(): void
{
    $sales = User::factory()->sales()->create();
    $user = User::factory()->create();

    $response = $this->actingAs($sales)
        ->delete("/users/{$user->id}");

    $response->assertStatus(403); // Forbidden
}
```

## Best Practices

### 1. Use RefreshDatabase
```php
use Illuminate\Foundation\Testing\RefreshDatabase;

class YourTest extends TestCase
{
    use RefreshDatabase;
}
```

### 2. Test Isolation
- Each test should be independent
- Don't rely on test execution order
- Clean up after tests automatically with RefreshDatabase

### 3. Descriptive Test Names
```php
// Good ✅
public function test_user_can_create_customer_with_valid_data(): void

// Bad ❌
public function testCustomer(): void
```

### 4. Test One Thing
```php
// Good ✅
public function test_user_can_login(): void
{
    // Test only login
}

public function test_user_redirected_after_login(): void
{
    // Test only redirect
}

// Bad ❌
public function test_login_and_redirect_and_dashboard(): void
{
    // Testing too many things
}
```

### 5. Use Factories
```php
// Good ✅
$customer = Customer::factory()->create();

// Bad ❌
$customer = Customer::create([
    'customer_code' => 'CUST001',
    'customer_name' => 'Test',
    // ... many fields
]);
```

## Continuous Integration

### GitHub Actions Example
```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.4'
      - name: Install Dependencies
        run: composer install
      - name: Run Tests
        run: php artisan test
```

## Troubleshooting

### Tests Failing Due to Database
```bash
# Reset test database
php artisan migrate:fresh --env=testing

# Clear cache
php artisan config:clear
php artisan cache:clear
```

### Factory Not Found
```bash
# Make sure to create factories
php artisan make:factory ModelNameFactory
```

### Memory Issues
```bash
# Increase memory limit
php -d memory_limit=512M artisan test
```

## Coverage Goals

เป้าหมายความครอบคลุมของการทดสอบ:
- **Overall Coverage**: ≥ 80%
- **Model Tests**: ≥ 90%
- **Controller Tests**: ≥ 75%
- **Critical Business Logic**: 100%

## Additional Resources

- [Laravel Testing Documentation](https://laravel.com/docs/testing)
- [PHPUnit Documentation](https://phpunit.de/documentation.html)
- [Pest PHP (Alternative)](https://pestphp.com/)

---

## Quick Reference

### Run Tests
```bash
php artisan test                      # All tests
php artisan test --filter UserTest    # Specific test
php artisan test --parallel           # Parallel execution
php artisan test --coverage           # With coverage
```

### Create New Tests
```bash
php artisan make:test CustomerTest --unit
php artisan make:test CustomerManagementTest
```

### Create Factories
```bash
php artisan make:factory CustomerFactory --model=Customer
```

---

**Last Updated**: February 12, 2026  
**Version**: 1.0.0  
**Author**: ERP PIMDAI Development Team
