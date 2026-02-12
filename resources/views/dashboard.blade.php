@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'ร้านค้า-ของ • ของรับเข้าขาย/เบิกออก')

@section('content')
<div class="container-fluid">
    <!-- Welcome Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 fade-in">
                <div class="card-body p-4">
                    <h2 class="mb-3">ยินดีต้อนรับสู่ระบบ ERP Stock</h2>
                    <p class="text-muted">ระบบจัดการสต็อก การขาย และการจัดซื้อแบบครบวงจร</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Sales -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm hover-shadow fade-in">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">ยอดขายวันนี้</p>
                            <h4 class="mb-0 fw-bold text-primary">฿ 125,500</h4>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-shopping-cart text-primary fs-3"></i>
                        </div>
                    </div>
                    <small class="text-success mt-2 d-block">
                        <i class="fas fa-arrow-up me-1"></i> +12.5% จากเมื่อวาน
                    </small>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm hover-shadow fade-in" style="animation-delay: 0.1s">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">คำสั่งซื้อวันนี้</p>
                            <h4 class="mb-0 fw-bold text-success">28</h4>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-file-invoice text-success fs-3"></i>
                        </div>
                    </div>
                    <small class="text-success mt-2 d-block">
                        <i class="fas fa-arrow-up me-1"></i> +8% จากเมื่อวาน
                    </small>
                </div>
            </div>
        </div>

        <!-- Low Stock -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm hover-shadow fade-in" style="animation-delay: 0.2s">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">สินค้าใกล้หมด</p>
                            <h4 class="mb-0 fw-bold text-warning">15</h4>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="fas fa-box text-warning fs-3"></i>
                        </div>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        ต้องการสั่งซื้อเพิ่ม
                    </small>
                </div>
            </div>
        </div>

        <!-- Pending Tasks -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm hover-shadow fade-in" style="animation-delay: 0.3s">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">งานค้าง</p>
                            <h4 class="mb-0 fw-bold text-danger">7</h4>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-3 rounded">
                            <i class="fas fa-tasks text-danger fs-3"></i>
                        </div>
                    </div>
                    <small class="text-danger mt-2 d-block">
                        <i class="fas fa-exclamation-circle me-1"></i> ต้องการดำเนินการ
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm fade-in" style="animation-delay: 0.4s">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">คำสั่งซื้อล่าสุด</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 px-4 py-3">เลขที่ใบสั่งซื้อ</th>
                                    <th class="border-0 py-3">ลูกค้า</th>
                                    <th class="border-0 py-3">วันที่</th>
                                    <th class="border-0 py-3">จำนวนเงิน</th>
                                    <th class="border-0 py-3">สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="px-4 py-3"><strong>#INV2026010047</strong></td>
                                    <td class="py-3">บริษัท ออโตคลิกบายเอซีจี จำกัด</td>
                                    <td class="py-3">12 ก.พ. 2026</td>
                                    <td class="py-3"><strong>฿ 25,680.00</strong></td>
                                    <td class="py-3"><span class="badge bg-success">ชำระแล้ว</span></td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3"><strong>#INV2026010046</strong></td>
                                    <td class="py-3">บริษัท เอ็นชัวร์คอมม์ กรุ๊ป จำกัด</td>
                                    <td class="py-3">11 ก.พ. 2026</td>
                                    <td class="py-3"><strong>฿ 18,450.00</strong></td>
                                    <td class="py-3"><span class="badge bg-warning text-dark">รอชำระ</span></td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3"><strong>#INV2026010045</strong></td>
                                    <td class="py-3">บริษัท ทีวีที เมทัลเวิร์คส จำกัด</td>
                                    <td class="py-3">10 ก.พ. 2026</td>
                                    <td class="py-3"><strong>฿ 32,150.00</strong></td>
                                    <td class="py-3"><span class="badge bg-info">กำลังดำเนินการ</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
