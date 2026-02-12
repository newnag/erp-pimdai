<?php

namespace Tests\Unit\Models;

use App\Models\Billing;
use App\Models\BillingItem;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BillingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test billing can be created
     */
    public function test_billing_can_be_created(): void
    {
        $customer = Customer::factory()->create();
        $user = User::factory()->create();

        $billing = Billing::create([
            'billing_no' => 'BL-2026-001',
            'billing_date' => now(),
            'customer_id' => $customer->id,
            'customer_name' => $customer->customer_name,
            'total_amount' => 15000.00,
            'discount_amount' => 0.00,
            'vat_amount' => 1050.00,
            'grand_total' => 16050.00,
            'status' => 'Pending',
            'delivery_date' => now()->addDays(3),
            'delivery_address' => '123 ถนนทดสอบ',
            'note' => 'ส่งของภายใน 3 วัน',
            'created_by' => $user->id,
        ]);

        $this->assertDatabaseHas('billings', [
            'billing_no' => 'BL-2026-001',
            'customer_id' => $customer->id,
        ]);
    }

    /**
     * Test billing belongs to customer
     */
    public function test_billing_belongs_to_customer(): void
    {
        $customer = Customer::factory()->create();
        
        $billing = Billing::factory()->create([
            'customer_id' => $customer->id,
        ]);

        $this->assertInstanceOf(Customer::class, $billing->customer);
        $this->assertEquals($customer->id, $billing->customer->id);
    }

    /**
     * Test billing has many items
     */
    public function test_billing_has_many_items(): void
    {
        $billing = Billing::factory()->create();

        BillingItem::factory()->count(5)->create([
            'billing_id' => $billing->id,
        ]);

        $this->assertCount(5, $billing->items);
        $this->assertInstanceOf(BillingItem::class, $billing->items->first());
    }

    /**
     * Test billing status types
     */
    public function test_billing_status_types(): void
    {
        $statuses = ['Pending', 'Shipped', 'Delivered', 'Cancelled'];

        foreach ($statuses as $status) {
            $billing = Billing::factory()->create(['status' => $status]);
            $this->assertEquals($status, $billing->status);
        }
    }

    /**
     * Test billing number is unique
     */
    public function test_billing_number_must_be_unique(): void
    {
        Billing::factory()->create(['billing_no' => 'BL-2026-001']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Billing::factory()->create(['billing_no' => 'BL-2026-001']);
    }

    /**
     * Test billing can be soft deleted
     */
    public function test_billing_can_be_soft_deleted(): void
    {
        $billing = Billing::factory()->create();

        $billing->delete();

        $this->assertSoftDeleted('billings', ['id' => $billing->id]);
    }

    /**
     * Test billing delivery date
     */
    public function test_billing_delivery_date(): void
    {
        $deliveryDate = now()->addDays(5);
        
        $billing = Billing::factory()->create([
            'delivery_date' => $deliveryDate,
        ]);

        $this->assertEquals($deliveryDate->format('Y-m-d'), $billing->delivery_date->format('Y-m-d'));
    }
}
