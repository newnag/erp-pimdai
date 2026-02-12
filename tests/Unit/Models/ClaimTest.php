<?php

namespace Tests\Unit\Models;

use App\Models\Claim;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClaimTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test claim can be created
     */
    public function test_claim_can_be_created(): void
    {
        $customer = Customer::factory()->create();
        $product = Product::factory()->create();
        $user = User::factory()->create();

        $claim = Claim::create([
            'claim_no' => 'CLM-2026-001',
            'claim_date' => now(),
            'customer_id' => $customer->id,
            'customer_name' => $customer->customer_name,
            'product_id' => $product->id,
            'product_name' => $product->product_name,
            'quantity' => 2,
            'claim_type' => 'Defective',
            'description' => 'สินค้าชำรุดไม่สามารถใช้งานได้',
            'priority' => 'High',
            'status' => 'Pending',
            'resolution' => null,
            'assigned_to' => $user->id,
            'created_by' => $user->id,
        ]);

        $this->assertDatabaseHas('claims', [
            'claim_no' => 'CLM-2026-001',
            'customer_id' => $customer->id,
        ]);
    }

    /**
     * Test claim belongs to customer
     */
    public function test_claim_belongs_to_customer(): void
    {
        $customer = Customer::factory()->create();
        
        $claim = Claim::factory()->create([
            'customer_id' => $customer->id,
        ]);

        $this->assertInstanceOf(Customer::class, $claim->customer);
        $this->assertEquals($customer->id, $claim->customer->id);
    }

    /**
     * Test claim belongs to product
     */
    public function test_claim_belongs_to_product(): void
    {
        $product = Product::factory()->create();
        
        $claim = Claim::factory()->create([
            'product_id' => $product->id,
        ]);

        $this->assertInstanceOf(Product::class, $claim->product);
        $this->assertEquals($product->id, $claim->product->id);
    }

    /**
     * Test claim number is unique
     */
    public function test_claim_number_must_be_unique(): void
    {
        Claim::factory()->create(['claim_no' => 'CLM-2026-001']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Claim::factory()->create(['claim_no' => 'CLM-2026-001']);
    }

    /**
     * Test claim types
     */
    public function test_claim_types(): void
    {
        $types = ['Defective', 'Damaged', 'Wrong Item', 'Missing Parts', 'Other'];

        foreach ($types as $type) {
            $claim = Claim::factory()->create(['claim_type' => $type]);
            $this->assertEquals($type, $claim->claim_type);
        }
    }

    /**
     * Test claim priority levels
     */
    public function test_claim_priority_levels(): void
    {
        $priorities = ['Low', 'Medium', 'High', 'Urgent'];

        foreach ($priorities as $priority) {
            $claim = Claim::factory()->create(['priority' => $priority]);
            $this->assertEquals($priority, $claim->priority);
        }
    }

    /**
     * Test claim status types
     */
    public function test_claim_status_types(): void
    {
        $statuses = ['Pending', 'In Progress', 'Resolved', 'Rejected', 'Closed'];

        foreach ($statuses as $status) {
            $claim = Claim::factory()->create(['status' => $status]);
            $this->assertEquals($status, $claim->status);
        }
    }

    /**
     * Test claim assigned to user
     */
    public function test_claim_assigned_to_user(): void
    {
        $user = User::factory()->create();
        
        $claim = Claim::factory()->create([
            'assigned_to' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $claim->assignee);
        $this->assertEquals($user->id, $claim->assignee->id);
    }

    /**
     * Test claim can be soft deleted
     */
    public function test_claim_can_be_soft_deleted(): void
    {
        $claim = Claim::factory()->create();

        $claim->delete();

        $this->assertSoftDeleted('claims', ['id' => $claim->id]);
    }

    /**
     * Test urgent claims filter
     */
    public function test_urgent_claims_filter(): void
    {
        Claim::factory()->create(['priority' => 'Urgent']);
        Claim::factory()->create(['priority' => 'High']);
        Claim::factory()->create(['priority' => 'Low']);

        $urgentClaims = Claim::where('priority', 'Urgent')->get();

        $this->assertEquals(1, $urgentClaims->count());
    }

    /**
     * Test pending claims filter
     */
    public function test_pending_claims_filter(): void
    {
        Claim::factory()->create(['status' => 'Pending']);
        Claim::factory()->create(['status' => 'Pending']);
        Claim::factory()->create(['status' => 'Resolved']);

        $pendingClaims = Claim::where('status', 'Pending')->get();

        $this->assertEquals(2, $pendingClaims->count());
    }
}
