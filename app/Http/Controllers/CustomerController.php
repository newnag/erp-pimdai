<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        // Filter by customer_type
        if ($request->filled('filter') && $request->filter !== 'all') {
            $query->where('customer_type', ucfirst($request->filter));
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhere('contact_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('contact_id', 'like', "%{$search}%")
                  ->orWhere('tax_id', 'like', "%{$search}%");
            });
        }

        $customers = $query->orderBy('created_at', 'desc')->paginate(15);

        // Preserve query parameters in pagination
        $customers->appends($request->only(['filter', 'search']));

        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'contact_type'  => 'required|in:Individual,Corporate',
            'customer_type' => 'required|in:Customer,Vendor',
            'credit_limit'  => 'nullable|numeric|min:0',
            'contact_id'    => 'nullable|string|max:50',
            'company_name'  => 'nullable|string|max:255',
            'tax_id'        => 'nullable|string|max:50',
            'com_branch'    => 'nullable|in:Head,Branch',
            'phone'         => 'nullable|string|max:20',
            'email'         => 'nullable|email|max:255',
            'website'       => 'nullable|url|max:255',
            'address'       => 'nullable|string',
            'postal_code'   => 'nullable|string|max:10',
            'delivery_note' => 'nullable|string',
            'contact_name'  => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'bank'          => 'nullable|string|max:100',
            'bank_name'     => 'nullable|string|max:255',
            'bank_acc_no'   => 'nullable|string|max:50',
            'bank_branch'   => 'nullable|string|max:255',
            'link_file'     => 'nullable|file|max:10240',
            'note'          => 'nullable|string',
        ]);

        // Handle file upload
        if ($request->hasFile('link_file')) {
            $file = $request->file('link_file');
            $path = $file->store('customers/attachments', 'public');
            $validated['link_file'] = '/storage/' . $path;
        } else {
            unset($validated['link_file']);
        }

        Customer::create($validated);

        return redirect()->route('customers.index')
            ->with('success', 'สร้างรายชื่อผู้ติดต่อสำเร็จ');
    }

    /**
     * Display the specified customer.
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'ลบรายชื่อผู้ติดต่อสำเร็จ');
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'contact_type'  => 'required|in:Individual,Corporate',
            'customer_type' => 'required|in:Customer,Vendor',
            'credit_limit'  => 'nullable|numeric|min:0',
            'contact_id'    => 'nullable|string|max:50',
            'company_name'  => 'nullable|string|max:255',
            'tax_id'        => 'nullable|string|max:50',
            'com_branch'    => 'nullable|in:Head,Branch',
            'phone'         => 'nullable|string|max:20',
            'email'         => 'nullable|email|max:255',
            'website'       => 'nullable|url|max:255',
            'address'       => 'nullable|string',
            'postal_code'   => 'nullable|string|max:10',
            'delivery_note' => 'nullable|string',
            'contact_name'  => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'bank'          => 'nullable|string|max:100',
            'bank_name'     => 'nullable|string|max:255',
            'bank_acc_no'   => 'nullable|string|max:50',
            'bank_branch'   => 'nullable|string|max:255',
            'link_file'     => 'nullable|file|max:10240',
            'note'          => 'nullable|string',
        ]);

        // Handle file upload
        if ($request->hasFile('link_file')) {
            $file = $request->file('link_file');
            $path = $file->store('customers/attachments', 'public');
            $validated['link_file'] = '/storage/' . $path;
        } else {
            unset($validated['link_file']);
        }

        $customer->update($validated);

        return redirect()->route('customers.index')
            ->with('success', 'แก้ไขรายชื่อผู้ติดต่อสำเร็จ');
    }
}
