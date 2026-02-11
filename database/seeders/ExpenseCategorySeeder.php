<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('expense_categories')->insert([
            [
                'category_code' => 'EXP001',
                'category_name' => 'ค่าเช่าสำนักงาน',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_code' => 'EXP002',
                'category_name' => 'ค่าน้ำ ค่าไฟ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_code' => 'EXP003',
                'category_name' => 'ค่าเดินทาง',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_code' => 'EXP004',
                'category_name' => 'ค่าโทรศัพท์',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_code' => 'EXP005',
                'category_name' => 'ค่าตลาด',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
