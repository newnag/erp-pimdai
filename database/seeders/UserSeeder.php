<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'admin',
                'password' => Hash::make('password'),
                'full_name' => 'ผู้ดูแลระบบ',
                'email' => 'admin@pimdai.com',
                'phone' => '0812345678',
                'role' => 'Admin',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'sales01',
                'password' => Hash::make('password'),
                'full_name' => 'พนักงานขาย 1',
                'email' => 'sales01@pimdai.com',
                'phone' => '0823456789',
                'role' => 'Sales',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'inventory01',
                'password' => Hash::make('password'),
                'full_name' => 'พนักงานคลังสินค้า 1',
                'email' => 'inventory01@pimdai.com',
                'phone' => '0834567890',
                'role' => 'Inventory',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'purchase01',
                'password' => Hash::make('password'),
                'full_name' => 'พนักงานจัดซื้อ 1',
                'email' => 'purchase01@pimdai.com',
                'phone' => '0845678901',
                'role' => 'Purchase',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'accountant01',
                'password' => Hash::make('password'),
                'full_name' => 'พนักงานบัญชี 1',
                'email' => 'accountant01@pimdai.com',
                'phone' => '0856789012',
                'role' => 'Accountant',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
