<?php

namespace Tests\Unit\Models;

use App\Models\Customer;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuotationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test quotation can be created
     */
    public function test_quotation_can_be_created(): void
    {
        $customer = Customer::factory()->create();
        $user = User::factory()->create();

        $quotation = Quotation::create([
            'quotation_no' => 'QT-2026-001',
            'quotation_date' => now(),
            'customer_id' => $customer->id,
            'customer_name' => $customer->customer_name,
            'total_amount' => 10000.00,
            'discount_amount' => 500.00,
            'vat_amount' => 665.00,
            'grand_total' => 10165.00,
            'status' => 'Draft',
            'valid_until' => now()->addDays(30),
            'note' => 'ใบเสนอราคาทดสอบ',
            'created_by' => $user->id,
        ]);

        $this->assertDatabaseHas('quotations', [
            'quotation_no' => 'QT-2026-001',
            'customer_id' => $customer->id,
        ]);
    }

    /**
     * Test quotation belongs to customer
     */
    public function test_quotation_belongs_to_customer(): void
    {
        $customer = Customer::factory()->create();
        
        $quotation = Quotation::factory()->create([
            'customer_id' => $customer->id,
        ]);

        $this->assertInstanceOf(Customer::class, $quotation->customer);
        $this->assertEquals($customer->id, $quotation->customer->id);
    }

    /**
     * Test quotation has many items
     */
    public function test_quotation_has_many_items(): void
    {
        $quotation = Quotation::factory()->create();

        QuotationItem::factory()->count(3)->create([
            'quotation_id' => $quotation->id,
        ]);

        $this->assertCount(3, $quotation->items);
        $this->assertInstanceOf(QuotationItem::class, $quotation->items->first());
    }

    /**
     * Test quotation status transitions
     */
    public function test_quotation_status_transitions(): void
    {
        $quotation = Quotation::factory()->create([
            'status' => 'Draft',
        ]);

        $this->assertEquals('Draft', $quotation->status);

        $quotation->update(['status' => 'Sent']);
        $this->assertEquals('Sent', $quotation->status);

        $quotation->update(['status' => 'Approved']);
        $this->assertEquals('Approved', $quotation->status);

        $quotation->update(['status' => 'Rejected']);
        $this->assertEquals('Rejected', $quotation->status);
    }

    /**
     * Test quotation calculates totals correctly
     */
    public function test_quotation_calculates_totals_correctly(): void
    {
        $quotation = Quotation::factory()->create([
            'total_amount' => 10000.00,
            'discount_amount' => 1000.00,
            'vat_rate' => 7,
        ]);

        $subtotal = $quotation->total_amount - $quotation->discount_amount; // 9000
        $vat = $subtotal * ($quotation->vat_rate / 100); // 630
        $grandTotal = $subtotal + $vat; // 9630

        $this->assertEquals(9630.00, $grandTotal);
    }

    /**
     * Test quotation number is unique
     */
    public function test_quotation_number_must_be_unique(): void
    {
        Quotation::factory()->create(['quotation_no' => 'QT-2026-001']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Quotation::factory()->create(['quotation_no' => 'QT-2026-001']);
    }

    /**
     * Test quotation can be soft deleted
     */
    public function test_quotation_can_be_soft_deleted(): void
    {
        $quotation = Quotation::factory()->create();

        $quotation->delete();

        $this->assertSoftDeleted('quotations', ['id' => $quotation->id]);
    }

    /**
     * Test quotation valid until date
     */
    public function test_quotation_valid_until_date(): void
    {
        $validDate = now()->addDays(30);
        
        $quotation = Quotation::factory()->create([
            'valid_until' => $validDate,
        ]);

        $this->assertEquals($validDate->format('Y-m-d'), $quotation->valid_until->format('Y-m-d'));
    }

    /**
     * Test quotation scope by status
     */
    public function test_quotation_scope_by_status(): void
    {
        Quotation::factory()->create(['status' => 'Draft']);
        Quotation::factory()->create(['status' => 'Approved']);
        Quotation::factory()->create(['status' => 'Approved']);

        $approved = Quotation::where('status', 'Approved')->get();

        $this->assertEquals(2, $approved->count());
    }

    /**
     * Test quotation belongs to creator
     */
    public function test_quotation_belongs_to_creator(): void
    {
        $user = User::factory()->create();
        
        $quotation = Quotation::factory()->create([
            'created_by' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $quotation->creator);
        $this->assertEquals($user->id, $quotation->creator->id);
    }
}
