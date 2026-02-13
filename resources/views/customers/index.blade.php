@extends('layouts.app')

@section('title', 'สมุดรายชื่อ')

@section('page-title', 'สมุดรายชื่อ')
@section('page-subtitle', 'สมุดรวมชื่อ')

@push('styles')
<style>
    /* ===== Header Actions ===== */
    .page-header-actions {
        display: flex;
        gap: 10px;
        margin-bottom: 0;
    }

    /* ===== Filter Bar ===== */
    .filter-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .filter-tabs {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .filter-tab {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #fff;
        color: #64748b;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }

    .filter-tab:hover {
        background: #f1f5f9;
        color: #334155;
    }

    .filter-tab.active {
        background: #1e293b;
        color: #fff;
        border-color: #1e293b;
    }

    .filter-tab i {
        font-size: 0.6rem;
    }

    /* ===== Search Bar ===== */
    .search-bar {
        margin-bottom: 16px;
    }

    .search-input-wrapper {
        position: relative;
        width: 100%;
    }

    .search-input-wrapper .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 0.9rem;
    }

    .search-input-wrapper .form-control {
        padding-left: 42px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        font-size: 0.9rem;
        height: 44px;
    }

    .search-input-wrapper .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* ===== Data Table ===== */
    .data-table-container {
        background: #fff;
        border-radius: 12px;
        overflow: visible;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    }

    .data-table thead {
        border-radius: 12px 12px 0 0;
        overflow: hidden;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    }

    .data-table thead th {
        color: #fff;
        padding: 14px 16px;
        font-weight: 500;
        font-size: 0.85rem;
        border: none;
        white-space: nowrap;
    }

    .data-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.2s;
        cursor: pointer;
    }

    .data-table tbody tr:hover {
        background: #f8fafc;
    }

    .data-table tbody td {
        padding: 12px 16px;
        font-size: 0.88rem;
        color: #334155;
        vertical-align: middle;
    }

    /* ===== Customer Name Cell ===== */
    .customer-name {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .customer-name .status-indicator {
        font-size: 0.5rem;
    }

    .customer-note {
        display: block;
        font-size: 0.75rem;
        color: #94a3b8;
        margin-left: 18px;
    }

    /* ===== Type Badge ===== */
    .type-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 500;
    }

    .customer-badge {
        background: #dbeafe;
        color: #2563eb;
    }

    .vendor-badge {
        background: #fef3c7;
        color: #d97706;
    }

    .both-badge {
        background: #d1fae5;
        color: #059669;
    }

    /* ===== Action Button ===== */
    .btn-menu {
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        padding: 6px 10px;
        border-radius: 6px;
        transition: all 0.2s;
    }

    .btn-menu:hover {
        background: #f1f5f9;
        color: #334155;
    }

    /* ===== Dropdown Menu ===== */
    .dropdown-menu {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        padding: 6px 0;
        min-width: 180px;
        z-index: 1050;
    }

    .dropdown-menu .dropdown-item {
        font-size: 0.85rem;
        padding: 8px 16px;
        color: #334155;
        transition: all 0.15s;
    }

    .dropdown-menu .dropdown-item:hover {
        background: #f1f5f9;
        color: #1e293b;
    }

    .dropdown-menu .dropdown-item.text-danger:hover {
        background: #fef2f2;
        color: #dc2626;
    }

    .dropdown-menu .dropdown-item i {
        width: 18px;
        text-align: center;
    }

    .dropdown-divider {
        margin: 4px 0;
        border-color: #e2e8f0;
    }

    /* ===== Pagination ===== */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        padding: 20px 0;
    }

    .pagination-wrapper .pagination {
        gap: 4px;
    }

    .pagination-wrapper .page-link {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        color: #64748b;
        padding: 8px 14px;
        font-size: 0.85rem;
        transition: all 0.2s;
    }

    .pagination-wrapper .page-link:hover {
        background: #f1f5f9;
        color: #1e293b;
    }

    .pagination-wrapper .page-item.active .page-link {
        background: #1e293b;
        border-color: #1e293b;
        color: #fff;
    }

    .pagination-wrapper .page-item.disabled .page-link {
        color: #cbd5e1;
    }

    /* ===== Empty State ===== */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 16px;
        color: #cbd5e1;
    }

    .empty-state p {
        font-size: 0.95rem;
    }

    /* ===== Responsive ===== */
    @media (max-width: 768px) {
        .filter-tabs {
            flex-wrap: wrap;
        }

        .page-header-actions {
            flex-wrap: wrap;
        }

        .data-table-container {
            overflow-x: auto;
        }

        .data-table {
            min-width: 700px;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Header Actions --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div></div>
        <div class="page-header-actions">
            <a href="{{ route('customers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> สร้างใหม่
            </a>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="filter-bar">
        <div class="filter-tabs">
            <a href="{{ route('customers.index', array_merge(request()->except('filter', 'page'), ['filter' => 'all'])) }}"
               class="filter-tab {{ (!request('filter') || request('filter') == 'all') ? 'active' : '' }}">
                <i class="fas fa-layer-group"></i> แสดงทั้งหมด
            </a>
            <a href="{{ route('customers.index', array_merge(request()->except('filter', 'page'), ['filter' => 'customer'])) }}"
               class="filter-tab {{ request('filter') == 'customer' ? 'active' : '' }}">
                <i class="fas fa-circle" style="color: #3b82f6;"></i> ลูกค้า
            </a>
            <a href="{{ route('customers.index', array_merge(request()->except('filter', 'page'), ['filter' => 'vendor'])) }}"
               class="filter-tab {{ request('filter') == 'vendor' ? 'active' : '' }}">
                <i class="fas fa-circle" style="color: #f59e0b;"></i> ผู้จำหน่าย
            </a>
        </div>
    </div>

    {{-- Search Bar --}}
    <div class="search-bar">
        <form method="GET" action="{{ route('customers.index') }}">
            @if(request('filter'))
                <input type="hidden" name="filter" value="{{ request('filter') }}">
            @endif
            <div class="search-input-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" class="form-control"
                       placeholder="ค้นหารายชื่อ หรือระบุหมู่ผู้ติดต่อ"
                       value="{{ request('search') }}">
            </div>
        </form>
    </div>

    {{-- Data Table --}}
    <div class="data-table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>รายชื่อ</th>
                    <th>ชื่อผู้ติดต่อ</th>
                    <th>เบอร์ติดต่อ</th>
                    <th>อีเมล</th>
                    <th>ประเภท</th>
                    <th style="width: 50px;"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td>
                            <div class="customer-name">
                                @if($customer->customer_type === 'Customer')
                                    <i class="fas fa-circle status-indicator" style="color: #3b82f6;"></i>
                                @else
                                    <i class="fas fa-circle status-indicator" style="color: #f59e0b;"></i>
                                @endif
                                <span>{{ $customer->company_name ?: $customer->contact_name ?: '-' }}</span>
                            </div>
                            @if($customer->com_branch === 'Head')
                                <small class="customer-note">สำนักงานใหญ่</small>
                            @elseif($customer->com_branch === 'Branch')
                                <small class="customer-note">สาขา</small>
                            @endif
                        </td>
                        <td>{{ $customer->contact_name ?: '-' }}</td>
                        <td>{{ $customer->contact_phone ?: $customer->phone ?: '-' }}</td>
                        <td>{{ $customer->contact_email ?: $customer->email ?: '-' }}</td>
                        <td>
                            @if($customer->customer_type === 'Customer')
                                <span class="type-badge customer-badge">ลูกค้า</span>
                            @else
                                <span class="type-badge vendor-badge">ผู้จำหน่าย</span>
                            @endif
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn-menu" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('customers.show', $customer) }}">
                                            <i class="fas fa-eye me-2"></i> ดูรายละเอียด
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('customers.edit', $customer) }}">
                                            <i class="fas fa-edit me-2"></i> แก้ไข
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('customers.destroy', $customer) }}" method="POST"
                                              onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบรายชื่อนี้?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-trash-alt me-2"></i> ลบ
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-users"></i>
                                <p>ยังไม่มีรายชื่อผู้ติดต่อ</p>
                                <a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm mt-2">
                                    <i class="fas fa-plus me-1"></i> สร้างรายชื่อใหม่
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($customers->hasPages())
        <div class="pagination-wrapper">
            {{ $customers->links() }}
        </div>
    @endif
</div>
@endsection
