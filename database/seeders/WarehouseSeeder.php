<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('warehouses')->insert([
            [
                'warehouse_code' => 'WH001',
                'warehouse_name' => 'คลังสินค้าหลัก',
                'location' => 'กรุงเทพมหานคร',
                'postcode' => '10400',
                'manager_name' => 'นายสมบัติ ใจดี',
                'email' => 'warehouse@pimdai.com',
                'phone' => '021234567',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'warehouse_code' => 'WH002',
                'warehouse_name' => 'คลังสาขา 1',
                'location' => 'ปทุมธานี',
                'postcode' => '12000',
                'manager_name' => null,
                'email' => null,
                'phone' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
