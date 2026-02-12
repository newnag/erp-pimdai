<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user can be created
     */
    public function test_user_can_be_created(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'username' => 'testuser',
            'role' => 'Sales',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'username' => 'testuser',
        ]);
    }

    /**
     * Test password is hashed
     */
    public function test_password_is_hashed(): void
    {
        $user = User::factory()->create([
            'password' => 'plaintext',
        ]);

        $this->assertNotEquals('plaintext', $user->password);
        $this->assertTrue(strlen($user->password) > 50);
    }

    /**
     * Test user has role method
     */
    public function test_user_has_role_method(): void
    {
        $admin = User::factory()->admin()->create();
        $sales = User::factory()->sales()->create();

        $this->assertTrue($admin->hasRole('Admin'));
        $this->assertFalse($admin->hasRole('Sales'));
        $this->assertTrue($sales->hasRole('Sales'));
        $this->assertFalse($sales->hasRole('Admin'));
    }

    /**
     * Test user is active method
     */
    public function test_user_is_active_method(): void
    {
        $activeUser = User::factory()->create(['is_active' => true]);
        $inactiveUser = User::factory()->inactive()->create();

        $this->assertTrue($activeUser->isActive());
        $this->assertFalse($inactiveUser->isActive());
    }

    /**
     * Test find for auth method with email
     */
    public function test_find_for_auth_with_email(): void
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'username' => 'testuser',
            'is_active' => true,
        ]);

        $found = User::findForAuth('user@example.com');

        $this->assertNotNull($found);
        $this->assertEquals($user->id, $found->id);
    }

    /**
     * Test find for auth method with username
     */
    public function test_find_for_auth_with_username(): void
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'username' => 'testuser',
            'is_active' => true,
        ]);

        $found = User::findForAuth('testuser');

        $this->assertNotNull($found);
        $this->assertEquals($user->id, $found->id);
    }

    /**
     * Test find for auth returns null for inactive user
     */
    public function test_find_for_auth_returns_null_for_inactive_user(): void
    {
        User::factory()->inactive()->create([
            'email' => 'inactive@example.com',
            'username' => 'inactiveuser',
        ]);

        $found = User::findForAuth('inactive@example.com');

        $this->assertNull($found);
    }

    /**
     * Test user has all required fillable fields
     */
    public function test_user_has_fillable_fields(): void
    {
        $fillable = (new User())->getFillable();

        $expectedFields = [
            'name',
            'username',
            'email',
            'password',
            'phone',
            'role',
            'is_active',
        ];

        foreach ($expectedFields as $field) {
            $this->assertContains($field, $fillable);
        }
    }

    /**
     * Test user hides sensitive fields
     */
    public function test_user_hides_sensitive_fields(): void
    {
        $user = User::factory()->create();
        $array = $user->toArray();

        $this->assertArrayNotHasKey('password', $array);
        $this->assertArrayNotHasKey('remember_token', $array);
    }

    /**
     * Test user can be soft deleted
     */
    public function test_user_can_be_soft_deleted(): void
    {
        $user = User::factory()->create();
        $userId = $user->id;

        $user->delete();

        $this->assertSoftDeleted('users', ['id' => $userId]);
        $this->assertNotNull($user->deleted_at);
    }

    /**
     * Test all roles are valid
     */
    public function test_all_roles_are_valid(): void
    {
        $roles = ['Admin', 'Sales', 'Inventory', 'Purchase', 'Accountant', 'Marketing'];

        foreach ($roles as $role) {
            $user = User::factory()->create(['role' => $role]);
            $this->assertEquals($role, $user->role);
        }
    }

    /**
     * Test email must be unique
     */
    public function test_email_must_be_unique(): void
    {
        User::factory()->create(['email' => 'unique@example.com']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        User::factory()->create(['email' => 'unique@example.com']);
    }

    /**
     * Test username must be unique
     */
    public function test_username_must_be_unique(): void
    {
        User::factory()->create(['username' => 'uniqueuser']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        User::factory()->create(['username' => 'uniqueuser']);
    }
}
