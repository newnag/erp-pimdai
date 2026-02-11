<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_categories')->insert([
            [
                'category_code' => 'CAT001',
                'category_name' => 'เครื่องพิมพ์ Inkjet',
                'description' => 'เครื่องพิมพ์แบบ Inkjet ทุกรุ่น',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_code' => 'CAT002',
                'category_name' => 'เครื่องพิมพ์ Digital',
                'description' => 'เครื่องพิมพ์ดิจิทัล ขนาดใหญ่',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_code' => 'CAT003',
                'category_name' => 'อุปกรณ์เสริม',
                'description' => 'อุปกรณ์และอะไหล่เสริม',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_code' => 'CAT004',
                'category_name' => 'วัตถุดิบ',
                'description' => 'วัตถุดิบสำหรับผลิต',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
