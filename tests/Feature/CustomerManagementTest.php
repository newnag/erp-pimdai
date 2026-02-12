<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['role' => 'Sales']);
    }

    /**
     * Test user can view customers list
     */
    public function test_user_can_view_customers_list(): void
    {
        $this->actingAs($this->user);

        Customer::factory()->count(5)->create();

        $response = $this->get('/customers');

        $response->assertStatus(200);
        $response->assertViewIs('customers.index');
        $response->assertViewHas('customers');
    }

    /**
     * Test user can create customer
     */
    public function test_user_can_create_customer(): void
    {
        $this->actingAs($this->user);

        $customerData = [
            'customer_code' => 'CUST001',
            'customer_name' => 'บริษัท ทดสอบ จำกัด',
            'customer_type' => 'Corporate',
            'email' => 'test@example.com',
            'phone' => '0812345678',
            'address' => '123 ถนนทดสอบ',
            'district' => 'บางกะปิ',
            'province' => 'กรุงเทพมหานคร',
            'postal_code' => '10240',
        ];

        $response = $this->post('/customers', $customerData);

        $response->assertRedirect('/customers');
        $this->assertDatabaseHas('customers', [
            'customer_code' => 'CUST001',
            'email' => 'test@example.com',
        ]);
    }

    /**
     * Test user can update customer
     */
    public function test_user_can_update_customer(): void
    {
        $this->actingAs($this->user);

        $customer = Customer::factory()->create();

        $updatedData = [
            'customer_name' => 'Updated Name',
            'email' => 'updated@example.com',
        ];

        $response = $this->put("/customers/{$customer->id}", array_merge(
            $customer->toArray(),
            $updatedData
        ));

        $response->assertRedirect('/customers');
        $this->assertDatabaseHas('customers', $updatedData);
    }

    /**
     * Test user can delete customer
     */
    public function test_user_can_delete_customer(): void
    {
        $this->actingAs($this->user);

        $customer = Customer::factory()->create();

        $response = $this->delete("/customers/{$customer->id}");

        $response->assertRedirect('/customers');
        $this->assertSoftDeleted('customers', ['id' => $customer->id]);
    }

    /**
     * Test guest cannot access customers
     */
    public function test_guest_cannot_access_customers(): void
    {
        $response = $this->get('/customers');

        $response->assertRedirect('/login');
    }

    /**
     * Test customer validation rules
     */
    public function test_customer_validation_rules(): void
    {
        $this->actingAs($this->user);

        $response = $this->post('/customers', []);

        $response->assertSessionHasErrors([
            'customer_code',
            'customer_name',
            'email',
        ]);
    }

    /**
     * Test user can search customers
     */
    public function test_user_can_search_customers(): void
    {
        $this->actingAs($this->user);

        Customer::factory()->create(['customer_name' => 'ABC Company']);
        Customer::factory()->create(['customer_name' => 'XYZ Corporation']);

        $response = $this->get('/customers?search=ABC');

        $response->assertStatus(200);
        $response->assertSee('ABC Company');
        $response->assertDontSee('XYZ Corporation');
    }
}
