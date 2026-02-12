<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'ผู้ดูแลระบบ',
                'username' => 'admin',
                'email' => 'admin@pimdai.com',
                'password' => Hash::make('password'),
                'phone' => '0812345678',
                'role' => 'Admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'พนักงานขาย 1',
                'username' => 'sales01',
                'email' => 'sales01@pimdai.com',
                'password' => Hash::make('password'),
                'phone' => '0823456789',
                'role' => 'Sales',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'พนักงานคลังสินค้า 1',
                'username' => 'inventory01',
                'email' => 'inventory01@pimdai.com',
                'password' => Hash::make('password'),
                'phone' => '0834567890',
                'role' => 'Inventory',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'พนักงานจัดซื้อ 1',
                'username' => 'purchase01',
                'email' => 'purchase01@pimdai.com',
                'password' => Hash::make('password'),
                'phone' => '0845678901',
                'role' => 'Purchase',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'พนักงานบัญชี 1',
                'username' => 'accountant01',
                'email' => 'accountant01@pimdai.com',
                'password' => Hash::make('password'),
                'phone' => '0856789012',
                'role' => 'Accountant',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'พนักงานการตลาด 1',
                'username' => 'marketing01',
                'email' => 'marketing01@pimdai.com',
                'password' => Hash::make('password'),
                'phone' => '0867890123',
                'role' => 'Marketing',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
