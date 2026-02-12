<?php

namespace Tests\Unit\Models;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupplierTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test supplier can be created
     */
    public function test_supplier_can_be_created(): void
    {
        $supplier = Supplier::create([
            'supplier_code' => 'SUP001',
            'supplier_name' => 'บริษัท ซัพพลายเออร์ จำกัด',
            'supplier_type' => 'Manufacturer',
            'email' => 'supplier@example.com',
            'phone' => '021234567',
            'tax_id' => '0987654321098',
            'address' => '456 ถนนซัพพลาย',
            'district' => 'บางนา',
            'province' => 'กรุงเทพมหานคร',
            'postal_code' => '10260',
            'contact_person' => 'นายซัพพลาย ดีดี',
            'contact_phone' => '0898765432',
            'payment_terms' => 'Net 30',
            'credit_limit' => 500000.00,
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('suppliers', [
            'supplier_code' => 'SUP001',
            'supplier_name' => 'บริษัท ซัพพลายเออร์ จำกัด',
        ]);
    }

    /**
     * Test supplier code is unique
     */
    public function test_supplier_code_must_be_unique(): void
    {
        Supplier::factory()->create(['supplier_code' => 'SUP001']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Supplier::factory()->create(['supplier_code' => 'SUP001']);
    }

    /**
     * Test supplier belongs to created by user
     */
    public function test_supplier_belongs_to_created_by_user(): void
    {
        $user = User::factory()->create();
        
        $supplier = Supplier::factory()->create([
            'created_by' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $supplier->creator);
        $this->assertEquals($user->id, $supplier->creator->id);
    }

    /**
     * Test supplier can be soft deleted
     */
    public function test_supplier_can_be_soft_deleted(): void
    {
        $supplier = Supplier::factory()->create();

        $supplier->delete();

        $this->assertSoftDeleted('suppliers', ['id' => $supplier->id]);
    }

    /**
     * Test active supplier scope
     */
    public function test_active_supplier_scope(): void
    {
        Supplier::factory()->create(['is_active' => true]);
        Supplier::factory()->create(['is_active' => true]);
        Supplier::factory()->create(['is_active' => false]);

        $activeSuppliers = Supplier::active()->get();

        $this->assertEquals(2, $activeSuppliers->count());
    }

    /**
     * Test supplier has many purchase orders
     */
    public function test_supplier_has_many_purchase_orders(): void
    {
        $supplier = Supplier::factory()->create();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $supplier->purchaseOrders);
    }

    /**
     * Test supplier types
     */
    public function test_supplier_types(): void
    {
        $types = ['Manufacturer', 'Distributor', 'Wholesaler', 'Retailer'];

        foreach ($types as $type) {
            $supplier = Supplier::factory()->create(['supplier_type' => $type]);
            $this->assertEquals($type, $supplier->supplier_type);
        }
    }

    /**
     * Test supplier full address accessor
     */
    public function test_supplier_full_address_accessor(): void
    {
        $supplier = Supplier::factory()->create([
            'address' => '456 ถนนซัพพลาย',
            'district' => 'บางนา',
            'province' => 'กรุงเทพมหานคร',
            'postal_code' => '10260',
        ]);

        $expectedAddress = '456 ถนนซัพพลาย บางนา กรุงเทพมหานคร 10260';
        $this->assertEquals($expectedAddress, $supplier->full_address);
    }
}
