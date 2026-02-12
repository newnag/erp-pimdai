<?php

namespace Tests\Unit\Models;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test product can be created
     */
    public function test_product_can_be_created(): void
    {
        $category = ProductCategory::factory()->create();

        $product = Product::create([
            'product_code' => 'PROD001',
            'product_name' => 'สินค้าทดสอบ',
            'product_type' => 'Finished Goods',
            'category_id' => $category->id,
            'unit' => 'ชิ้น',
            'cost_price' => 100.00,
            'selling_price' => 150.00,
            'stock_quantity' => 100,
            'min_stock_level' => 10,
            'max_stock_level' => 500,
            'description' => 'รายละเอียดสินค้า',
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('products', [
            'product_code' => 'PROD001',
            'product_name' => 'สินค้าทดสอบ',
        ]);
    }

    /**
     * Test product code is unique
     */
    public function test_product_code_must_be_unique(): void
    {
        Product::factory()->create(['product_code' => 'PROD001']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Product::factory()->create(['product_code' => 'PROD001']);
    }

    /**
     * Test product belongs to category
     */
    public function test_product_belongs_to_category(): void
    {
        $category = ProductCategory::factory()->create();
        
        $product = Product::factory()->create([
            'category_id' => $category->id,
        ]);

        $this->assertInstanceOf(ProductCategory::class, $product->category);
        $this->assertEquals($category->id, $product->category->id);
    }

    /**
     * Test product types
     */
    public function test_product_types(): void
    {
        $finishedGoods = Product::factory()->create(['product_type' => 'Finished Goods']);
        $rawMaterial = Product::factory()->create(['product_type' => 'Raw Material']);

        $this->assertEquals('Finished Goods', $finishedGoods->product_type);
        $this->assertEquals('Raw Material', $rawMaterial->product_type);
    }

    /**
     * Test product profit margin calculation
     */
    public function test_product_profit_margin_calculation(): void
    {
        $product = Product::factory()->create([
            'cost_price' => 100.00,
            'selling_price' => 150.00,
        ]);

        $profitMargin = (($product->selling_price - $product->cost_price) / $product->cost_price) * 100;

        $this->assertEquals(50.00, $profitMargin);
    }

    /**
     * Test product stock is low
     */
    public function test_product_stock_is_low(): void
    {
        $lowStockProduct = Product::factory()->create([
            'stock_quantity' => 5,
            'min_stock_level' => 10,
        ]);

        $normalStockProduct = Product::factory()->create([
            'stock_quantity' => 50,
            'min_stock_level' => 10,
        ]);

        $this->assertLessThan($lowStockProduct->min_stock_level, $lowStockProduct->stock_quantity);
        $this->assertGreaterThanOrEqual($normalStockProduct->min_stock_level, $normalStockProduct->stock_quantity);
    }

    /**
     * Test product can be soft deleted
     */
    public function test_product_can_be_soft_deleted(): void
    {
        $product = Product::factory()->create();

        $product->delete();

        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }

    /**
     * Test product has many stock movements
     */
    public function test_product_has_many_stock_movements(): void
    {
        $product = Product::factory()->create();

        StockMovement::factory()->count(3)->create([
            'product_id' => $product->id,
        ]);

        $this->assertCount(3, $product->stockMovements);
    }

    /**
     * Test active product scope
     */
    public function test_active_product_scope(): void
    {
        Product::factory()->create(['is_active' => true]);
        Product::factory()->create(['is_active' => true]);
        Product::factory()->create(['is_active' => false]);

        $activeProducts = Product::active()->get();

        $this->assertEquals(2, $activeProducts->count());
    }

    /**
     * Test finished goods can update stock directly
     */
    public function test_finished_goods_can_update_stock_directly(): void
    {
        $product = Product::factory()->create([
            'product_type' => 'Finished Goods',
            'stock_quantity' => 100,
        ]);

        $product->update(['stock_quantity' => 150]);

        $this->assertEquals(150, $product->fresh()->stock_quantity);
    }

    /**
     * Test product search by code or name
     */
    public function test_product_search_by_code_or_name(): void
    {
        Product::factory()->create([
            'product_code' => 'PROD001',
            'product_name' => 'สินค้า A',
        ]);

        Product::factory()->create([
            'product_code' => 'PROD002',
            'product_name' => 'สินค้า B',
        ]);

        $search1 = Product::where('product_code', 'PROD001')->first();
        $search2 = Product::where('product_name', 'like', '%สินค้า B%')->first();

        $this->assertEquals('PROD001', $search1->product_code);
        $this->assertEquals('สินค้า B', $search2->product_name);
    }
}
