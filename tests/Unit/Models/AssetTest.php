<?php

namespace Tests\Unit\Models;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Depreciation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test asset can be created
     */
    public function test_asset_can_be_created(): void
    {
        $category = AssetCategory::factory()->create();
        $user = User::factory()->create();

        $asset = Asset::create([
            'asset_code' => 'AST001',
            'asset_name' => 'เครื่องคอมพิวเตอร์',
            'category_id' => $category->id,
            'purchase_date' => now(),
            'purchase_price' => 30000.00,
            'salvage_value' => 3000.00,
            'useful_life_years' => 5,
            'depreciation_method' => 'Straight Line',
            'current_value' => 30000.00,
            'accumulated_depreciation' => 0.00,
            'location' => 'สำนักงานชั้น 2',
            'serial_number' => 'SN12345678',
            'status' => 'Active',
            'description' => 'คอมพิวเตอร์สำหรับงานบัญชี',
            'created_by' => $user->id,
        ]);

        $this->assertDatabaseHas('assets', [
            'asset_code' => 'AST001',
            'asset_name' => 'เครื่องคอมพิวเตอร์',
        ]);
    }

    /**
     * Test asset code is unique
     */
    public function test_asset_code_must_be_unique(): void
    {
        Asset::factory()->create(['asset_code' => 'AST001']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Asset::factory()->create(['asset_code' => 'AST001']);
    }

    /**
     * Test asset belongs to category
     */
    public function test_asset_belongs_to_category(): void
    {
        $category = AssetCategory::factory()->create();
        
        $asset = Asset::factory()->create([
            'category_id' => $category->id,
        ]);

        $this->assertInstanceOf(AssetCategory::class, $asset->category);
        $this->assertEquals($category->id, $asset->category->id);
    }

    /**
     * Test asset depreciation methods
     */
    public function test_asset_depreciation_methods(): void
    {
        $methods = ['Straight Line', 'Declining Balance', 'Sum of Years Digits'];

        foreach ($methods as $method) {
            $asset = Asset::factory()->create(['depreciation_method' => $method]);
            $this->assertEquals($method, $asset->depreciation_method);
        }
    }

    /**
     * Test asset calculates straight line depreciation
     */
    public function test_asset_calculates_straight_line_depreciation(): void
    {
        $asset = Asset::factory()->create([
            'purchase_price' => 30000.00,
            'salvage_value' => 3000.00,
            'useful_life_years' => 5,
            'depreciation_method' => 'Straight Line',
        ]);

        $annualDepreciation = ($asset->purchase_price - $asset->salvage_value) / $asset->useful_life_years;

        $this->assertEquals(5400.00, $annualDepreciation);
    }

    /**
     * Test asset has many depreciation records
     */
    public function test_asset_has_many_depreciation_records(): void
    {
        $asset = Asset::factory()->create();

        Depreciation::factory()->count(3)->create([
            'asset_id' => $asset->id,
        ]);

        $this->assertCount(3, $asset->depreciations);
    }

    /**
     * Test asset status types
     */
    public function test_asset_status_types(): void
    {
        $statuses = ['Active', 'Under Maintenance', 'Disposed', 'Sold'];

        foreach ($statuses as $status) {
            $asset = Asset::factory()->create(['status' => $status]);
            $this->assertEquals($status, $asset->status);
        }
    }

    /**
     * Test asset can be soft deleted
     */
    public function test_asset_can_be_soft_deleted(): void
    {
        $asset = Asset::factory()->create();

        $asset->delete();

        $this->assertSoftDeleted('assets', ['id' => $asset->id]);
    }

    /**
     * Test asset net book value calculation
     */
    public function test_asset_net_book_value_calculation(): void
    {
        $asset = Asset::factory()->create([
            'purchase_price' => 30000.00,
            'accumulated_depreciation' => 6000.00,
        ]);

        $netBookValue = $asset->purchase_price - $asset->accumulated_depreciation;

        $this->assertEquals(24000.00, $netBookValue);
    }

    /**
     * Test active asset scope
     */
    public function test_active_asset_scope(): void
    {
        Asset::factory()->create(['status' => 'Active']);
        Asset::factory()->create(['status' => 'Active']);
        Asset::factory()->create(['status' => 'Disposed']);

        $activeAssets = Asset::where('status', 'Active')->get();

        $this->assertEquals(2, $activeAssets->count());
    }
}
