<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['role' => 'Inventory']);
    }

    /**
     * Test user can view products list
     */
    public function test_user_can_view_products_list(): void
    {
        $this->actingAs($this->user);

        Product::factory()->count(10)->create();

        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertViewIs('products.index');
    }

    /**
     * Test user can create finished goods product
     */
    public function test_user_can_create_finished_goods_product(): void
    {
        $this->actingAs($this->user);

        $category = ProductCategory::factory()->create();

        $productData = [
            'product_code' => 'PROD001',
            'product_name' => 'สินค้าทดสอบ',
            'product_type' => 'Finished Goods',
            'category_id' => $category->id,
            'unit' => 'ชิ้น',
            'cost_price' => 100.00,
            'selling_price' => 150.00,
            'stock_quantity' => 100,
            'min_stock_level' => 10,
        ];

        $response = $this->post('/products', $productData);

        $response->assertRedirect('/products');
        $this->assertDatabaseHas('products', [
            'product_code' => 'PROD001',
            'product_type' => 'Finished Goods',
        ]);
    }

    /**
     * Test user can update finished goods stock directly
     */
    public function test_user_can_update_finished_goods_stock_directly(): void
    {
        $this->actingAs($this->user);

        $product = Product::factory()->create([
            'product_type' => 'Finished Goods',
            'stock_quantity' => 100,
        ]);

        $response = $this->patch("/products/{$product->id}/stock", [
            'stock_quantity' => 150,
            'adjustment_note' => 'เพิ่มสต็อกจากการผลิต',
        ]);

        $response->assertRedirect();
        $this->assertEquals(150, $product->fresh()->stock_quantity);
    }

    /**
     * Test raw material requires stock in document
     */
    public function test_raw_material_requires_stock_in_document(): void
    {
        $this->actingAs($this->user);

        $product = Product::factory()->create([
            'product_type' => 'Raw Material',
        ]);

        // Attempting to update stock directly should be rejected
        $response = $this->patch("/products/{$product->id}/stock", [
            'stock_quantity' => 150,
        ]);

        $response->assertStatus(403); // Forbidden
    }

    /**
     * Test low stock products alert
     */
    public function test_low_stock_products_alert(): void
    {
        $this->actingAs($this->user);

        Product::factory()->create([
            'stock_quantity' => 5,
            'min_stock_level' => 10,
        ]);

        Product::factory()->create([
            'stock_quantity' => 50,
            'min_stock_level' => 10,
        ]);

        $response = $this->get('/products?filter=low_stock');

        $response->assertStatus(200);
    }

    /**
     * Test user can filter products by type
     */
    public function test_user_can_filter_products_by_type(): void
    {
        $this->actingAs($this->user);

        Product::factory()->create(['product_type' => 'Finished Goods']);
        Product::factory()->create(['product_type' => 'Raw Material']);

        $response = $this->get('/products?type=Finished+Goods');

        $response->assertStatus(200);
    }

    /**
     * Test inventory officer can access inventory module
     */
    public function test_inventory_officer_can_access_inventory_module(): void
    {
        $inventoryUser = User::factory()->create(['role' => 'Inventory']);

        $this->actingAs($inventoryUser);

        $response = $this->get('/products');

        $response->assertStatus(200);
    }

    /**
     * Test marketing cannot access inventory management
     */
    public function test_marketing_cannot_access_inventory_management(): void
    {
        $marketingUser = User::factory()->create(['role' => 'Marketing']);

        $this->actingAs($marketingUser);

        $response = $this->post('/products', []);

        $response->assertStatus(403); // Forbidden
    }
}
