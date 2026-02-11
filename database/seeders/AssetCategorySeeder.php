<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('asset_categories')->insert([
            [
                'category_code' => 'ASSET001',
                'category_name' => 'คอมพิวเตอร์และอุปกรณ์',
                'depreciation_rate' => 20.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_code' => 'ASSET002',
                'category_name' => 'เครื่องจักรและเครื่องมือ',
                'depreciation_rate' => 10.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_code' => 'ASSET003',
                'category_name' => 'เครื่องตกแต่งสำนักงาน',
                'depreciation_rate' => 20.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_code' => 'ASSET004',
                'category_name' => 'ยานพาหนะ',
                'depreciation_rate' => 25.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
