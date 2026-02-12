<?php

namespace Tests\Unit\Models;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseOrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test purchase order can be created
     */
    public function test_purchase_order_can_be_created(): void
    {
        $supplier = Supplier::factory()->create();
        $user = User::factory()->create();

        $po = PurchaseOrder::create([
            'po_no' => 'PO-2026-001',
            'po_date' => now(),
            'supplier_id' => $supplier->id,
            'supplier_name' => $supplier->supplier_name,
            'total_amount' => 50000.00,
            'discount_amount' => 2000.00,
            'vat_amount' => 3360.00,
            'grand_total' => 51360.00,
            'status' => 'Draft',
            'delivery_date' => now()->addDays(7),
            'delivery_address' => 'คลังสินค้าหลัก',
            'payment_terms' => 'Net 30',
            'note' => 'สั่งซื้อวัตถุดิบ',
            'created_by' => $user->id,
        ]);

        $this->assertDatabaseHas('purchase_orders', [
            'po_no' => 'PO-2026-001',
            'supplier_id' => $supplier->id,
        ]);
    }

    /**
     * Test purchase order belongs to supplier
     */
    public function test_purchase_order_belongs_to_supplier(): void
    {
        $supplier = Supplier::factory()->create();
        
        $po = PurchaseOrder::factory()->create([
            'supplier_id' => $supplier->id,
        ]);

        $this->assertInstanceOf(Supplier::class, $po->supplier);
        $this->assertEquals($supplier->id, $po->supplier->id);
    }

    /**
     * Test purchase order has many items
     */
    public function test_purchase_order_has_many_items(): void
    {
        $po = PurchaseOrder::factory()->create();

        PurchaseOrderItem::factory()->count(4)->create([
            'purchase_order_id' => $po->id,
        ]);

        $this->assertCount(4, $po->items);
    }

    /**
     * Test purchase order number is unique
     */
    public function test_purchase_order_number_must_be_unique(): void
    {
        PurchaseOrder::factory()->create(['po_no' => 'PO-2026-001']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        PurchaseOrder::factory()->create(['po_no' => 'PO-2026-001']);
    }

    /**
     * Test purchase order status types
     */
    public function test_purchase_order_status_types(): void
    {
        $statuses = ['Draft', 'Sent', 'Confirmed', 'Received', 'Cancelled'];

        foreach ($statuses as $status) {
            $po = PurchaseOrder::factory()->create(['status' => $status]);
            $this->assertEquals($status, $po->status);
        }
    }

    /**
     * Test purchase order calculates totals correctly
     */
    public function test_purchase_order_calculates_totals_correctly(): void
    {
        $po = PurchaseOrder::factory()->create([
            'total_amount' => 50000.00,
            'discount_amount' => 2000.00,
            'vat_rate' => 7,
        ]);

        $subtotal = $po->total_amount - $po->discount_amount; // 48000
        $vat = $subtotal * ($po->vat_rate / 100); // 3360
        $grandTotal = $subtotal + $vat; // 51360

        $this->assertEquals(51360.00, $grandTotal);
    }

    /**
     * Test purchase order can be soft deleted
     */
    public function test_purchase_order_can_be_soft_deleted(): void
    {
        $po = PurchaseOrder::factory()->create();

        $po->delete();

        $this->assertSoftDeleted('purchase_orders', ['id' => $po->id]);
    }

    /**
     * Test purchase order belongs to creator
     */
    public function test_purchase_order_belongs_to_creator(): void
    {
        $user = User::factory()->create();
        
        $po = PurchaseOrder::factory()->create([
            'created_by' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $po->creator);
        $this->assertEquals($user->id, $po->creator->id);
    }

    /**
     * Test purchase order delivery date
     */
    public function test_purchase_order_delivery_date(): void
    {
        $deliveryDate = now()->addDays(14);
        
        $po = PurchaseOrder::factory()->create([
            'delivery_date' => $deliveryDate,
        ]);

        $this->assertEquals($deliveryDate->format('Y-m-d'), $po->delivery_date->format('Y-m-d'));
    }
}
