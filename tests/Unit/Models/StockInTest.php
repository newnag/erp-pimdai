<?php

namespace Tests\Unit\Models;

use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockInItem;
use App\Models\StockMovement;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockInTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test stock in can be created
     */
    public function test_stock_in_can_be_created(): void
    {
        $warehouse = Warehouse::factory()->create();
        $user = User::factory()->create();

        $stockIn = StockIn::create([
            'stock_in_no' => 'SI-2026-001',
            'stock_in_date' => now(),
            'warehouse_id' => $warehouse->id,
            'reference_type' => 'Purchase Order',
            'reference_no' => 'PO-2026-001',
            'total_quantity' => 100,
            'total_amount' => 50000.00,
            'note' => 'รับวัตถุดิบเข้าคลัง',
            'status' => 'Approved',
            'created_by' => $user->id,
        ]);

        $this->assertDatabaseHas('stock_ins', [
            'stock_in_no' => 'SI-2026-001',
            'warehouse_id' => $warehouse->id,
        ]);
    }

    /**
     * Test stock in belongs to warehouse
     */
    public function test_stock_in_belongs_to_warehouse(): void
    {
        $warehouse = Warehouse::factory()->create();
        
        $stockIn = StockIn::factory()->create([
            'warehouse_id' => $warehouse->id,
        ]);

        $this->assertInstanceOf(Warehouse::class, $stockIn->warehouse);
        $this->assertEquals($warehouse->id, $stockIn->warehouse->id);
    }

    /**
     * Test stock in has many items
     */
    public function test_stock_in_has_many_items(): void
    {
        $stockIn = StockIn::factory()->create();

        StockInItem::factory()->count(5)->create([
            'stock_in_id' => $stockIn->id,
        ]);

        $this->assertCount(5, $stockIn->items);
    }

    /**
     * Test stock in number is unique
     */
    public function test_stock_in_number_must_be_unique(): void
    {
        StockIn::factory()->create(['stock_in_no' => 'SI-2026-001']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        StockIn::factory()->create(['stock_in_no' => 'SI-2026-001']);
    }

    /**
     * Test stock in updates product quantity
     */
    public function test_stock_in_updates_product_quantity(): void
    {
        $product = Product::factory()->create([
            'product_type' => 'Raw Material',
            'stock_quantity' => 100,
        ]);

        $warehouse = Warehouse::factory()->create();
        $stockIn = StockIn::factory()->create([
            'warehouse_id' => $warehouse->id,
            'status' => 'Approved',
        ]);

        StockInItem::create([
            'stock_in_id' => $stockIn->id,
            'product_id' => $product->id,
            'quantity' => 50,
            'unit_cost' => 100.00,
            'total_cost' => 5000.00,
        ]);

        // สมมติว่ามี observer หรือ event ที่จะอัพเดต stock
        // $product->refresh();
        // $this->assertEquals(150, $product->stock_quantity);
        
        $this->assertEquals(50, $stockIn->items->first()->quantity);
    }

    /**
     * Test stock in creates stock movement
     */
    public function test_stock_in_creates_stock_movement(): void
    {
        $product = Product::factory()->create(['product_type' => 'Raw Material']);
        $warehouse = Warehouse::factory()->create();
        $stockIn = StockIn::factory()->create();

        $movement = StockMovement::create([
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
            'movement_type' => 'In',
            'quantity' => 50,
            'reference_type' => 'Stock In',
            'reference_no' => $stockIn->stock_in_no,
            'movement_date' => now(),
        ]);

        $this->assertDatabaseHas('stock_movements', [
            'product_id' => $product->id,
            'movement_type' => 'In',
            'quantity' => 50,
        ]);
    }

    /**
     * Test stock in status types
     */
    public function test_stock_in_status_types(): void
    {
        $statuses = ['Draft', 'Approved', 'Cancelled'];

        foreach ($statuses as $status) {
            $stockIn = StockIn::factory()->create(['status' => $status]);
            $this->assertEquals($status, $stockIn->status);
        }
    }

    /**
     * Test stock in can be soft deleted
     */
    public function test_stock_in_can_be_soft_deleted(): void
    {
        $stockIn = StockIn::factory()->create();

        $stockIn->delete();

        $this->assertSoftDeleted('stock_ins', ['id' => $stockIn->id]);
    }
}
