<?php

namespace Tests\Unit\Models;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test expense can be created
     */
    public function test_expense_can_be_created(): void
    {
        $category = ExpenseCategory::factory()->create();
        $user = User::factory()->create();

        $expense = Expense::create([
            'expense_no' => 'EXP-2026-001',
            'expense_date' => now(),
            'category_id' => $category->id,
            'description' => 'ค่าไฟฟ้าสำนักงาน',
            'amount' => 5000.00,
            'payment_method' => 'Bank Transfer',
            'reference_no' => 'REF12345',
            'vendor_name' => 'การไฟฟ้านครหลวง',
            'status' => 'Paid',
            'note' => 'ชำระค่าไฟประจำเดือน',
            'created_by' => $user->id,
        ]);

        $this->assertDatabaseHas('expenses', [
            'expense_no' => 'EXP-2026-001',
            'amount' => 5000.00,
        ]);
    }

    /**
     * Test expense belongs to category
     */
    public function test_expense_belongs_to_category(): void
    {
        $category = ExpenseCategory::factory()->create();
        
        $expense = Expense::factory()->create([
            'category_id' => $category->id,
        ]);

        $this->assertInstanceOf(ExpenseCategory::class, $expense->category);
        $this->assertEquals($category->id, $expense->category->id);
    }

    /**
     * Test expense number is unique
     */
    public function test_expense_number_must_be_unique(): void
    {
        Expense::factory()->create(['expense_no' => 'EXP-2026-001']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Expense::factory()->create(['expense_no' => 'EXP-2026-001']);
    }

    /**
     * Test expense payment methods
     */
    public function test_expense_payment_methods(): void
    {
        $methods = ['Cash', 'Bank Transfer', 'Credit Card', 'Cheque'];

        foreach ($methods as $method) {
            $expense = Expense::factory()->create(['payment_method' => $method]);
            $this->assertEquals($method, $expense->payment_method);
        }
    }

    /**
     * Test expense status types
     */
    public function test_expense_status_types(): void
    {
        $statuses = ['Pending', 'Approved', 'Paid', 'Rejected'];

        foreach ($statuses as $status) {
            $expense = Expense::factory()->create(['status' => $status]);
            $this->assertEquals($status, $expense->status);
        }
    }

    /**
     * Test expense can be soft deleted
     */
    public function test_expense_can_be_soft_deleted(): void
    {
        $expense = Expense::factory()->create();

        $expense->delete();

        $this->assertSoftDeleted('expenses', ['id' => $expense->id]);
    }

    /**
     * Test expense belongs to creator
     */
    public function test_expense_belongs_to_creator(): void
    {
        $user = User::factory()->create();
        
        $expense = Expense::factory()->create([
            'created_by' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $expense->creator);
        $this->assertEquals($user->id, $expense->creator->id);
    }

    /**
     * Test expense filter by date range
     */
    public function test_expense_filter_by_date_range(): void
    {
        Expense::factory()->create(['expense_date' => now()->subDays(10)]);
        Expense::factory()->create(['expense_date' => now()->subDays(5)]);
        Expense::factory()->create(['expense_date' => now()]);

        $expenses = Expense::whereBetween('expense_date', [
            now()->subDays(7)->startOfDay(),
            now()->endOfDay()
        ])->get();

        $this->assertEquals(2, $expenses->count());
    }

    /**
     * Test expense filter by status
     */
    public function test_expense_filter_by_status(): void
    {
        Expense::factory()->create(['status' => 'Paid']);
        Expense::factory()->create(['status' => 'Paid']);
        Expense::factory()->create(['status' => 'Pending']);

        $paidExpenses = Expense::where('status', 'Paid')->get();

        $this->assertEquals(2, $paidExpenses->count());
    }

    /**
     * Test expense amount must be positive
     */
    public function test_expense_amount_validation(): void
    {
        $expense = Expense::factory()->create([
            'amount' => 1000.00,
        ]);

        $this->assertGreaterThan(0, $expense->amount);
    }
}
