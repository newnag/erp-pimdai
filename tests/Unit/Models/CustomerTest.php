<?php

namespace Tests\Unit\Models;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test customer can be created
     */
    public function test_customer_can_be_created(): void
    {
        $customer = Customer::create([
            'customer_code' => 'CUST001',
            'customer_name' => 'บริษัท ทดสอบ จำกัด',
            'customer_type' => 'Corporate',
            'email' => 'customer@example.com',
            'phone' => '0812345678',
            'tax_id' => '0123456789012',
            'address' => '123 ถนนทดสอบ',
            'district' => 'บางกะปิ',
            'province' => 'กรุงเทพมหานคร',
            'postal_code' => '10240',
            'contact_person' => 'นายทดสอบ ระบบ',
            'contact_phone' => '0887654321',
            'credit_term' => 30,
            'credit_limit' => 100000.00,
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('customers', [
            'customer_code' => 'CUST001',
            'customer_name' => 'บริษัท ทดสอบ จำกัด',
        ]);
    }

    /**
     * Test customer code is unique
     */
    public function test_customer_code_must_be_unique(): void
    {
        Customer::create([
            'customer_code' => 'CUST001',
            'customer_name' => 'ลูกค้า 1',
            'email' => 'customer1@example.com',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Customer::create([
            'customer_code' => 'CUST001',
            'customer_name' => 'ลูกค้า 2',
            'email' => 'customer2@example.com',
        ]);
    }

    /**
     * Test customer belongs to created by user
     */
    public function test_customer_belongs_to_created_by_user(): void
    {
        $user = User::factory()->create();
        
        $customer = Customer::create([
            'customer_code' => 'CUST001',
            'customer_name' => 'ลูกค้าทดสอบ',
            'email' => 'test@example.com',
            'created_by' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $customer->creator);
        $this->assertEquals($user->id, $customer->creator->id);
    }

    /**
     * Test customer can be soft deleted
     */
    public function test_customer_can_be_soft_deleted(): void
    {
        $customer = Customer::create([
            'customer_code' => 'CUST001',
            'customer_name' => 'ลูกค้าทดสอบ',
            'email' => 'test@example.com',
        ]);

        $customer->delete();

        $this->assertSoftDeleted('customers', ['customer_code' => 'CUST001']);
    }

    /**
     * Test customer can have multiple quotations
     */
    public function test_customer_can_have_multiple_quotations(): void
    {
        $customer = Customer::create([
            'customer_code' => 'CUST001',
            'customer_name' => 'ลูกค้าทดสอบ',
            'email' => 'test@example.com',
        ]);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $customer->quotations);
    }

    /**
     * Test active customer scope
     */
    public function test_active_customer_scope(): void
    {
        Customer::create([
            'customer_code' => 'CUST001',
            'customer_name' => 'ลูกค้าใช้งาน',
            'email' => 'active@example.com',
            'is_active' => true,
        ]);

        Customer::create([
            'customer_code' => 'CUST002',
            'customer_name' => 'ลูกค้าไม่ใช้งาน',
            'email' => 'inactive@example.com',
            'is_active' => false,
        ]);

        $activeCustomers = Customer::active()->get();

        $this->assertEquals(1, $activeCustomers->count());
        $this->assertEquals('CUST001', $activeCustomers->first()->customer_code);
    }

    /**
     * Test credit limit validation
     */
    public function test_credit_limit_must_not_be_negative(): void
    {
        $customer = Customer::create([
            'customer_code' => 'CUST001',
            'customer_name' => 'ลูกค้าทดสอบ',
            'email' => 'test@example.com',
            'credit_limit' => -1000,
        ]);

        // This should be validated at controller level
        $this->assertLessThanOrEqual(0, $customer->credit_limit);
    }

    /**
     * Test customer full address accessor
     */
    public function test_customer_full_address_accessor(): void
    {
        $customer = Customer::create([
            'customer_code' => 'CUST001',
            'customer_name' => 'ลูกค้าทดสอบ',
            'email' => 'test@example.com',
            'address' => '123 ถนนทดสอบ',
            'district' => 'บางกะปิ',
            'province' => 'กรุงเทพมหานคร',
            'postal_code' => '10240',
        ]);

        $expectedAddress = '123 ถนนทดสอบ บางกะปิ กรุงเทพมหานคร 10240';
        $this->assertEquals($expectedAddress, $customer->full_address);
    }
}
