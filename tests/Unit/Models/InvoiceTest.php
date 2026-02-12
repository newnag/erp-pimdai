<?php

namespace Tests\Unit\Models;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test invoice can be created
     */
    public function test_invoice_can_be_created(): void
    {
        $customer = Customer::factory()->create();
        $user = User::factory()->create();

        $invoice = Invoice::create([
            'invoice_no' => 'INV-2026-001',
            'invoice_date' => now(),
            'customer_id' => $customer->id,
            'customer_name' => $customer->customer_name,
            'customer_tax_id' => $customer->tax_id,
            'total_amount' => 20000.00,
            'discount_amount' => 500.00,
            'vat_amount' => 1365.00,
            'grand_total' => 20865.00,
            'payment_status' => 'Unpaid',
            'payment_due_date' => now()->addDays(30),
            'note' => 'กำหนดชำระภายใน 30 วัน',
            'created_by' => $user->id,
        ]);

        $this->assertDatabaseHas('invoices', [
            'invoice_no' => 'INV-2026-001',
            'customer_id' => $customer->id,
        ]);
    }

    /**
     * Test invoice belongs to customer
     */
    public function test_invoice_belongs_to_customer(): void
    {
        $customer = Customer::factory()->create();
        
        $invoice = Invoice::factory()->create([
            'customer_id' => $customer->id,
        ]);

        $this->assertInstanceOf(Customer::class, $invoice->customer);
        $this->assertEquals($customer->id, $invoice->customer->id);
    }

    /**
     * Test invoice has many items
     */
    public function test_invoice_has_many_items(): void
    {
        $invoice = Invoice::factory()->create();

        InvoiceItem::factory()->count(4)->create([
            'invoice_id' => $invoice->id,
        ]);

        $this->assertCount(4, $invoice->items);
        $this->assertInstanceOf(InvoiceItem::class, $invoice->items->first());
    }

    /**
     * Test invoice payment status types
     */
    public function test_invoice_payment_status_types(): void
    {
        $statuses = ['Unpaid', 'Partial', 'Paid', 'Overdue', 'Cancelled'];

        foreach ($statuses as $status) {
            $invoice = Invoice::factory()->create(['payment_status' => $status]);
            $this->assertEquals($status, $invoice->payment_status);
        }
    }

    /**
     * Test invoice number is unique
     */
    public function test_invoice_number_must_be_unique(): void
    {
        Invoice::factory()->create(['invoice_no' => 'INV-2026-001']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Invoice::factory()->create(['invoice_no' => 'INV-2026-001']);
    }

    /**
     * Test invoice can be soft deleted
     */
    public function test_invoice_can_be_soft_deleted(): void
    {
        $invoice = Invoice::factory()->create();

        $invoice->delete();

        $this->assertSoftDeleted('invoices', ['id' => $invoice->id]);
    }

    /**
     * Test invoice payment due date
     */
    public function test_invoice_payment_due_date(): void
    {
        $dueDate = now()->addDays(30);
        
        $invoice = Invoice::factory()->create([
            'payment_due_date' => $dueDate,
        ]);

        $this->assertEquals($dueDate->format('Y-m-d'), $invoice->payment_due_date->format('Y-m-d'));
    }

    /**
     * Test invoice is overdue check
     */
    public function test_invoice_is_overdue_check(): void
    {
        $overdueInvoice = Invoice::factory()->create([
            'payment_due_date' => now()->subDays(5),
            'payment_status' => 'Unpaid',
        ]);

        $notOverdueInvoice = Invoice::factory()->create([
            'payment_due_date' => now()->addDays(5),
            'payment_status' => 'Unpaid',
        ]);

        $this->assertTrue($overdueInvoice->payment_due_date->isPast());
        $this->assertFalse($notOverdueInvoice->payment_due_date->isPast());
    }

    /**
     * Test invoice calculates remaining amount
     */
    public function test_invoice_calculates_remaining_amount(): void
    {
        $invoice = Invoice::factory()->create([
            'grand_total' => 10000.00,
            'paid_amount' => 3000.00,
        ]);

        $remainingAmount = $invoice->grand_total - $invoice->paid_amount;

        $this->assertEquals(7000.00, $remainingAmount);
    }
}
