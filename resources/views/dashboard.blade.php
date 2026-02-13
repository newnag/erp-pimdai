@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'ร้านค้า-ของ • ของรับเข้าขาย/เบิกออก')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')
{{-- ===== Monthly Summary ===== --}}
<div class="monthly-summary fade-in">
    <div class="summary-header">
        <h2><i class="fas fa-calendar-alt"></i> สรุปประจำเดือน</h2>
        <span class="summary-period">กุมภาพันธ์ 2569</span>
    </div>
    <div class="summary-cards">
        <div class="summary-card income">
            <div class="summary-card-icon"><i class="fas fa-arrow-down"></i></div>
            <div class="summary-card-content">
                <span class="summary-label">รายรับทั้งหมด</span>
                <span class="summary-amount">฿ 2,450,000.00</span>
                <span class="summary-change positive"><i class="fas fa-caret-up"></i> +18.5% จากเดือนก่อน</span>
            </div>
        </div>
        <div class="summary-card expense">
            <div class="summary-card-icon"><i class="fas fa-arrow-up"></i></div>
            <div class="summary-card-content">
                <span class="summary-label">รายจ่ายทั้งหมด</span>
                <span class="summary-amount">฿ 1,200,000.00</span>
                <span class="summary-change negative"><i class="fas fa-caret-up"></i> +5.2% จากเดือนก่อน</span>
            </div>
        </div>
        <div class="summary-card net-balance">
            <div class="summary-card-icon"><i class="fas fa-chart-line"></i></div>
            <div class="summary-card-content">
                <span class="summary-label">ยอดสุทธิ</span>
                <span class="summary-amount">฿ 1,250,000.00</span>
                <span class="summary-change positive"><i class="fas fa-caret-up"></i> +32.8% จากเดือนก่อน</span>
            </div>
        </div>
    </div>
</div>

{{-- ===== Financial Overview ===== --}}
<div class="financial-overview">
    {{-- Row 1: Sales & Collection --}}
    <div class="fin-row">
        <div class="fin-card fade-in">
            <div class="fin-card-header">
                <div class="fin-card-title"><span>ยอดขายตามสินค้า</span> <span class="dropdown-arrow">▼</span> <i class="fas fa-info-circle info-icon"></i></div>
                <div class="fin-card-actions"><a href="#" class="fin-link">ดูยอดขายตามโปรเจ็ค</a> <button class="fin-menu-btn"><i class="fas fa-ellipsis-h"></i></button></div>
            </div>
            <div class="fin-card-content">
                <div class="fin-filter">
                    <select class="fin-select"><option>3 เดือน</option><option>6 เดือน</option><option>1 ปี</option></select>
                </div>
                <div class="fin-total-row">
                    <span class="fin-dot blue"></span>
                    <span class="fin-label">รายได้รวม:</span>
                    <span class="fin-value blue">2,119,328.01</span>
                </div>
                <div class="fin-donut-section">
                    <div class="fin-donut-chart"><canvas id="salesByProductChart"></canvas></div>
                    <div class="fin-legend-list">
                        <div class="fin-legend-item"><span class="fin-legend-dot" style="background:#0ea5e9;"></span><span class="fin-legend-text">หมวกพร้อมปักและสกรีน...</span><span class="fin-legend-value">167,722.50</span></div>
                        <div class="fin-legend-item"><span class="fin-legend-dot" style="background:#38bdf8;"></span><span class="fin-legend-text">กลอนประตูดิจิตอล : Mo...</span><span class="fin-legend-value">121,713.00</span></div>
                        <div class="fin-legend-item"><span class="fin-legend-dot" style="background:#7dd3fc;"></span><span class="fin-legend-text">กลอนประตูดิจิตอล : Ens...</span><span class="fin-legend-value">106,273.98</span></div>
                        <div class="fin-legend-item"><span class="fin-legend-dot" style="background:#a5d8ff;"></span><span class="fin-legend-text">ของขวัญพรีเมี่ยม</span><span class="fin-legend-value">97,766.97</span></div>
                        <div class="fin-legend-item"><span class="fin-legend-dot" style="background:#bae6fd;"></span><span class="fin-legend-text">กลอนประตูดิจิตอล Lock...</span><span class="fin-legend-value">91,508.21</span></div>
                        <div class="fin-legend-item"><span class="fin-legend-dot" style="background:#7dd3fc;"></span><span class="fin-legend-text">กลอนประตูดิจิตอล Ensu...</span><span class="fin-legend-value">84,647.38</span></div>
                        <div class="fin-legend-item"><span class="fin-legend-dot" style="background:#38bdf8;"></span><span class="fin-legend-text">ป้ายสแตนดี้ Standee P...</span><span class="fin-legend-value">75,588.01</span></div>
                        <div class="fin-legend-item"><span class="fin-legend-dot" style="background:#0284c7;"></span><span class="fin-legend-text">กลอนประตูดิจิตอล : Ins...</span><span class="fin-legend-value">72,190.71</span></div>
                        <div class="fin-legend-item"><span class="fin-legend-dot" style="background:#6b7280;"></span><span class="fin-legend-text">ค่าปักหมวก</span><span class="fin-legend-value">60,990.00</span></div>
                        <div class="fin-legend-item"><span class="fin-legend-dot" style="background:#d1d5db;"></span><span class="fin-legend-text">อื่นๆ</span><span class="fin-legend-value">1,240,927.24</span></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="fin-card fade-in">
            <div class="fin-card-header">
                <div class="fin-card-title"><span>สรุปยอดเก็บเงิน</span> <i class="fas fa-info-circle info-icon"></i></div>
                <div class="fin-card-actions"><button class="fin-menu-btn"><i class="fas fa-ellipsis-h"></i></button></div>
            </div>
            <div class="fin-card-content">
                <div class="fin-filter">
                    <select class="fin-select"><option>3 เดือน</option><option>6 เดือน</option><option>1 ปี</option></select>
                </div>
                <div class="fin-totals-row">
                    <div class="fin-total-item"><span class="fin-dot blue"></span><span class="fin-label">เก็บเงินแล้ว:</span><span class="fin-value blue">1,916,811.26</span></div>
                    <div class="fin-total-item"><span class="fin-dot gray"></span><span class="fin-label">รายได้รวม:</span><span class="fin-value gray">2,119,328.02</span></div>
                </div>
                <div class="fin-bar-chart-container"><canvas id="collectionChart"></canvas></div>
            </div>
        </div>
    </div>

    {{-- Row 2: Expense & Payment --}}
    <div class="fin-row">
        <div class="fin-card fade-in">
            <div class="fin-card-header">
                <div class="fin-card-title"><span>ค่าใช้จ่ายตามหมวดหมู่</span> <i class="fas fa-info-circle info-icon"></i></div>
                <div class="fin-card-actions"><a href="#" class="fin-link">ดูค่าใช้จ่ายตามโปรเจ็ค</a> <button class="fin-menu-btn"><i class="fas fa-ellipsis-h"></i></button></div>
            </div>
            <div class="fin-card-content">
                <div class="fin-filter">
                    <select class="fin-select"><option>3 เดือน</option><option>6 เดือน</option><option>1 ปี</option></select>
                </div>
                <div class="fin-total-row">
                    <span class="fin-dot pink"></span>
                    <span class="fin-label">ค่าใช้จ่ายรวม:</span>
                    <span class="fin-value pink">2,412,014.74</span>
                </div>
                <div class="fin-donut-section">
                    <div class="fin-donut-chart"><canvas id="expenseByCategoryChart"></canvas></div>
                    <div class="fin-legend-list">
                        <div class="fin-legend-item"><span class="fin-legend-dot" style="background:#ec4899;"></span><span class="fin-legend-text">สินค้า/วัตถุดิบ/แพคเกจจิ้ง</span><span class="fin-legend-value pink">933,014.68</span></div>
                        <div class="fin-legend-item"><span class="fin-legend-dot" style="background:#f472b6;"></span><span class="fin-legend-text">เงินเดือน/สวัสดิการ</span><span class="fin-legend-value pink">605,647.39</span></div>
                        <div class="fin-legend-item"><span class="fin-legend-dot" style="background:#a855f7;"></span><span class="fin-legend-text">การตลาดและโฆษณา</span><span class="fin-legend-value pink">288,006.75</span></div>
                        <div class="fin-legend-item"><span class="fin-legend-dot" style="background:#818cf8;"></span><span class="fin-legend-text">เบ็ดเตล็ด</span><span class="fin-legend-value pink">163,835.73</span></div>
                        <div class="fin-legend-item"><span class="fin-legend-dot" style="background:#1f2937;"></span><span class="fin-legend-text">ค่าเช่า</span><span class="fin-legend-value pink">138,726.66</span></div>
                        <div class="fin-legend-item"><span class="fin-legend-dot" style="background:#d1d5db;"></span><span class="fin-legend-text">อื่นๆ</span><span class="fin-legend-value pink">282,783.53</span></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="fin-card fade-in">
            <div class="fin-card-header">
                <div class="fin-card-title"><span>สรุปยอดชำระเงิน</span> <i class="fas fa-info-circle info-icon"></i></div>
                <div class="fin-card-actions"><button class="fin-menu-btn"><i class="fas fa-ellipsis-h"></i></button></div>
            </div>
            <div class="fin-card-content">
                <div class="fin-filter">
                    <select class="fin-select"><option>3 เดือน</option><option>6 เดือน</option><option>1 ปี</option></select>
                </div>
                <div class="fin-totals-row">
                    <div class="fin-total-item"><span class="fin-dot pink"></span><span class="fin-label">ชำระเงินแล้ว:</span><span class="fin-value pink">2,102,508.53</span></div>
                    <div class="fin-total-item"><span class="fin-dot gray"></span><span class="fin-label">ค่าใช้จ่ายรวม:</span><span class="fin-value gray">2,412,014.74</span></div>
                </div>
                <div class="fin-bar-chart-container"><canvas id="paymentChart"></canvas></div>
            </div>
        </div>
    </div>

    {{-- Row 3: Income vs Expense --}}
    <div class="fin-row full-width">
        <div class="fin-card fade-in">
            <div class="fin-card-header">
                <div class="fin-card-title"><span>รายได้และค่าใช้จ่ายตามเอกสาร</span> <span class="dropdown-arrow">▼</span> <i class="fas fa-info-circle info-icon"></i></div>
                <div class="fin-card-actions"><a href="#" class="fin-link">ดูรายได้และค่าใช้จ่ายตามโปรเจ็ค</a> <button class="fin-menu-btn"><i class="fas fa-ellipsis-h"></i></button></div>
            </div>
            <div class="fin-card-content">
                <div class="fin-filter">
                    <select class="fin-select"><option>ปีปัจจุบัน</option><option>ปีที่แล้ว</option></select>
                </div>
                <div class="fin-totals-row center">
                    <div class="fin-total-item"><span class="fin-dot blue"></span><span class="fin-label">รายได้รวม:</span><span class="fin-value blue">981,934.91</span></div>
                    <div class="fin-total-item"><span class="fin-dot pink"></span><span class="fin-label">ค่าใช้จ่ายรวม:</span><span class="fin-value pink">879,381.18</span></div>
                </div>
                <div class="fin-line-chart-container"><canvas id="incomeExpenseChart"></canvas></div>
            </div>
        </div>
    </div>

    {{-- Row 4: Outstanding Receivables & Payables --}}
    <div class="fin-row">
        <div class="fin-card fade-in">
            <div class="fin-card-header">
                <div class="fin-card-title"><span>ยอดค้างรับ</span> <i class="fas fa-info-circle info-icon"></i></div>
                <div class="fin-card-actions"><button class="fin-menu-btn"><i class="fas fa-ellipsis-h"></i></button></div>
            </div>
            <div class="fin-card-content">
                <div class="fin-filter">
                    <select class="fin-select"><option>1 ปี</option><option>6 เดือน</option><option>3 เดือน</option></select>
                </div>
                <div class="fin-total-row">
                    <span class="fin-dot blue"></span>
                    <span class="fin-label">ยอดค้างรับ:</span>
                    <span class="fin-value blue">202,516.76</span>
                </div>
                <div class="fin-list">
                    <div class="fin-list-header"><span>เอกสาร</span><span>สถานะ</span></div>
                    <div class="fin-list-item">
                        <div class="fin-list-info">
                            <div class="fin-list-title">บริษัท ออโตคลิกบายเอซีจี จำกัด สาขาปั๊มบางจาก วิภาว...</div>
                            <div class="fin-list-meta">INV2026010047 &nbsp; ครบกำหนด 12-01-2026</div>
                        </div>
                        <div class="fin-list-right">
                            <span class="fin-list-amount">1,926.00</span>
                            <span class="fin-status pending">รอเก็บเงิน</span>
                        </div>
                    </div>
                    <div class="fin-list-item">
                        <div class="fin-list-info">
                            <div class="fin-list-title">บริษัท ออโตคลิกบายเอซีจี จำกัด สาขาปั๊มซัสโก้ เพชรเกษ...</div>
                            <div class="fin-list-meta">INV2026010046 &nbsp; ครบกำหนด 12-01-2026</div>
                        </div>
                        <div class="fin-list-right">
                            <span class="fin-list-amount">1,926.00</span>
                            <span class="fin-status pending">รอเก็บเงิน</span>
                        </div>
                    </div>
                    <div class="fin-list-item">
                        <div class="fin-list-info">
                            <div class="fin-list-title">บริษัท ออโตคลิกบายเอซีจี จำกัด สาขาบิ๊กซี รามอินทรา</div>
                            <div class="fin-list-meta">INV2026010045 &nbsp; ครบกำหนด 12-01-2026</div>
                        </div>
                        <div class="fin-list-right">
                            <span class="fin-list-amount">2,678.21</span>
                            <span class="fin-status pending">รอเก็บเงิน</span>
                        </div>
                    </div>
                    <div class="fin-list-item">
                        <div class="fin-list-info">
                            <div class="fin-list-title">บริษัท ออโตคลิกบายเอซีจี จำกัด สาขาบิ๊กซี ติวานนท์</div>
                            <div class="fin-list-meta">INV2026010044 &nbsp; ครบกำหนด 12-01-2026</div>
                        </div>
                        <div class="fin-list-right">
                            <span class="fin-list-amount">2,678.21</span>
                            <span class="fin-status pending">รอเก็บเงิน</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="fin-card fade-in">
            <div class="fin-card-header">
                <div class="fin-card-title"><span>ยอดค้างจ่าย</span> <i class="fas fa-info-circle info-icon"></i></div>
                <div class="fin-card-actions"><button class="fin-menu-btn"><i class="fas fa-ellipsis-h"></i></button></div>
            </div>
            <div class="fin-card-content">
                <div class="fin-filter">
                    <select class="fin-select"><option>1 ปี</option><option>6 เดือน</option><option>3 เดือน</option></select>
                </div>
                <div class="fin-total-row">
                    <span class="fin-dot pink"></span>
                    <span class="fin-label">ยอดค้างจ่าย:</span>
                    <span class="fin-value pink">421,660.50</span>
                </div>
                <div class="fin-list">
                    <div class="fin-list-header"><span>เอกสาร</span><span>สถานะ</span></div>
                    <div class="fin-list-item">
                        <div class="fin-list-info">
                            <div class="fin-list-title">บริษัท เอ็นชัวร์คอมม์ กรุ๊ป จำกัด</div>
                            <div class="fin-list-meta">RI2025110040 &nbsp; ครบกำหนด 28-11-2025</div>
                        </div>
                        <div class="fin-list-right">
                            <span class="fin-list-amount">112,154.29</span>
                            <span class="fin-status approval">รออนุมัติ</span>
                        </div>
                    </div>
                    <div class="fin-list-item">
                        <div class="fin-list-info">
                            <div class="fin-list-title">นาย พงศ์ศิริ จงปติยัตต์</div>
                            <div class="fin-list-meta">EXP2025120009 &nbsp; ครบกำหนด 04-12-2025</div>
                        </div>
                        <div class="fin-list-right">
                            <span class="fin-list-amount">78,954.84</span>
                            <span class="fin-status processing">รอดำเนินการ</span>
                        </div>
                    </div>
                    <div class="fin-list-item">
                        <div class="fin-list-info">
                            <div class="fin-list-title">putinkjet</div>
                            <div class="fin-list-meta">EXP2026010054 &nbsp; ครบกำหนด 30-01-2026</div>
                        </div>
                        <div class="fin-list-right">
                            <span class="fin-list-amount">21,000.00</span>
                            <span class="fin-status processing">รอดำเนินการ</span>
                        </div>
                    </div>
                    <div class="fin-list-item">
                        <div class="fin-list-info">
                            <div class="fin-list-title">บริษัท ทีวีที เมทัลเวิร์คส จำกัด</div>
                            <div class="fin-list-meta">RI2025120015 &nbsp; ครบกำหนด 15-12-2025</div>
                        </div>
                        <div class="fin-list-right">
                            <span class="fin-list-amount">2,568.00</span>
                            <span class="fin-status approval">รออนุมัติ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== Dashboard Grid ===== --}}
<div class="dashboard-grid">

    {{-- Account Section --}}
    <div class="dashboard-section account-section full-width fade-in">
        <div class="section-header">
            <div class="section-icon account"><i class="fas fa-wallet"></i></div>
            <h2>Account</h2>
        </div>
        <div class="section-content">
            <div class="account-layout-simple">
                <div class="cash-balance-card">
                    <div class="cash-icon"><i class="fas fa-coins"></i></div>
                    <div class="cash-label">Cash Balance</div>
                    <div class="cash-symbol">฿</div>
                    <div class="cash-amount">1,250,000.00</div>
                    <div class="cash-trend"><i class="fas fa-arrow-up"></i><span>+12.5% จากเดือนก่อน</span></div>
                </div>
                <div class="account-chart-area-full">
                    <div class="chart-title">INBOUND VS OUTBOUND</div>
                    <div class="account-chart-wrapper-large"><canvas id="accountChart"></canvas></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sales Section --}}
    <div class="dashboard-section sales-section full-width fade-in">
        <div class="section-header">
            <div class="section-icon sales"><i class="fas fa-shopping-cart"></i></div>
            <h2>Sales</h2>
        </div>
        <div class="section-content">
            <div class="sales-overview">
                <div class="sales-total-card">
                    <div class="total-header"><h4><i class="fas fa-chart-bar"></i> ยอดขายรวม (ทุกคน)</h4></div>
                    <div class="total-charts-grid">
                        <div class="total-chart-item">
                            <h5>จำนวนใบเสนอราคา</h5>
                            <div class="chart-wrapper"><canvas id="totalQuotationCountChart"></canvas></div>
                        </div>
                        <div class="total-chart-item">
                            <h5>มูลค่าใบเสนอราคา</h5>
                            <div class="chart-wrapper"><canvas id="totalQuotationValueChart"></canvas></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sales-by-person">
                <div class="sales-person-header"><h4><i class="fas fa-users"></i> ยอดขายแยกตามเซลล์</h4></div>
                <div class="sales-comparison-charts">
                    <div class="comparison-chart-item">
                        <h5><i class="fas fa-file-invoice"></i> จำนวนใบเสนอราคา</h5>
                        <div class="chart-wrapper-large"><canvas id="salesPersonCountChart"></canvas></div>
                    </div>
                    <div class="comparison-chart-item">
                        <h5><i class="fas fa-dollar-sign"></i> มูลค่า (ล้านบาท)</h5>
                        <div class="chart-wrapper-large"><canvas id="salesPersonValueChart"></canvas></div>
                    </div>
                </div>

                <div class="sales-person-stats">
                    <div class="person-stat-card" style="border-left: 4px solid #667eea;">
                        <div class="person-header">
                            <div class="person-avatar-small" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"><i class="fas fa-user"></i></div>
                            <div class="person-info-compact">
                                <span class="person-name-small">สมชาย ใจดี</span>
                                <span class="person-role-small">Senior Sales</span>
                            </div>
                        </div>
                        <div class="stats-grid">
                            <div class="stat-box"><span class="stat-label">ใบเสนอราคา</span><span class="stat-value">18 ใบ</span></div>
                            <div class="stat-box"><span class="stat-label">ปิดการขาย</span><span class="stat-value success">14 ใบ (77.8%)</span></div>
                            <div class="stat-box"><span class="stat-label">มูลค่ารวม</span><span class="stat-value">฿1.2M</span></div>
                        </div>
                    </div>
                    <div class="person-stat-card" style="border-left: 4px solid #f093fb;">
                        <div class="person-header">
                            <div class="person-avatar-small" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);"><i class="fas fa-user"></i></div>
                            <div class="person-info-compact">
                                <span class="person-name-small">สมหญิง รักงาน</span>
                                <span class="person-role-small">Sales Executive</span>
                            </div>
                        </div>
                        <div class="stats-grid">
                            <div class="stat-box"><span class="stat-label">ใบเสนอราคา</span><span class="stat-value">15 ใบ</span></div>
                            <div class="stat-box"><span class="stat-label">ปิดการขาย</span><span class="stat-value success">11 ใบ (73.3%)</span></div>
                            <div class="stat-box"><span class="stat-label">มูลค่ารวม</span><span class="stat-value">฿0.8M</span></div>
                        </div>
                    </div>
                    <div class="person-stat-card" style="border-left: 4px solid #4facfe;">
                        <div class="person-header">
                            <div class="person-avatar-small" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);"><i class="fas fa-user"></i></div>
                            <div class="person-info-compact">
                                <span class="person-name-small">สมศักดิ์ ขยัน</span>
                                <span class="person-role-small">Junior Sales</span>
                            </div>
                        </div>
                        <div class="stats-grid">
                            <div class="stat-box"><span class="stat-label">ใบเสนอราคา</span><span class="stat-value">12 ใบ</span></div>
                            <div class="stat-box"><span class="stat-label">ปิดการขาย</span><span class="stat-value warning">7 ใบ (58.3%)</span></div>
                            <div class="stat-box"><span class="stat-label">มูลค่ารวม</span><span class="stat-value">฿0.5M</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="subsection recall-section">
                <h4><i class="fas fa-bell"></i> Recall consideration</h4>
                <div class="metrics-row">
                    <div class="metric-mini warning"><span class="metric-num">8</span><span class="metric-text">ใบเสนอราคาค้างตาม (รออนุมัติ)</span></div>
                    <div class="metric-mini danger"><span class="metric-num">3</span><span class="metric-text">เกินกำหนด (1 อาทิตย์/ 1 Follow)</span></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Survey Call Section --}}
    <div class="dashboard-section survey-section fade-in">
        <div class="section-header">
            <div class="section-icon survey"><i class="fas fa-phone-alt"></i></div>
            <h2>Survey Call</h2>
        </div>
        <div class="section-content">
            <div class="metrics-grid-4">
                <div class="metric-box">
                    <div class="metric-icon success"><i class="fas fa-check-circle"></i></div>
                    <div class="metric-data"><span class="value">12</span><span class="label">จำนวนใบเสนอราคาปิดจบใหม่</span></div>
                </div>
                <div class="metric-box">
                    <div class="metric-icon info"><i class="fas fa-phone"></i></div>
                    <div class="metric-data"><span class="value">48</span><span class="label">สายที่โทรได้ประจำวัน</span></div>
                </div>
                <div class="metric-box">
                    <div class="metric-icon warning"><i class="fas fa-clock"></i></div>
                    <div class="metric-data"><span class="value">15</span><span class="label">จำนวนใบเสนอราคาที่ค้างโทร</span></div>
                </div>
                <div class="metric-box">
                    <div class="metric-icon danger"><i class="fas fa-thumbs-down"></i></div>
                    <div class="metric-data"><span class="value">2</span><span class="label">Bad Feedback Count</span></div>
                </div>
            </div>
        </div>
    </div>

    {{-- HR Section --}}
    <div class="dashboard-section hr-section fade-in">
        <div class="section-header">
            <div class="section-icon hr"><i class="fas fa-users"></i></div>
            <h2>HR</h2>
        </div>
        <div class="section-content">
            <div class="hr-grid">
                <div class="hr-chart-container"><canvas id="hrDonutChart"></canvas></div>
                <div class="hr-legend">
                    <div class="legend-item"><span class="dot present"></span><span class="label">มาทำงาน</span><span class="value">9 คน</span></div>
                    <div class="legend-item"><span class="dot absent"></span><span class="label">ขาด/ลา งาน</span><span class="value">1 คน</span></div>
                    <div class="legend-item"><span class="dot late"></span><span class="label">มาสาย (≤10 นาที)</span><span class="value">2 คน</span></div>
                </div>
            </div>
            <div class="lms-progress">
                <div class="lms-header"><i class="fas fa-book-reader"></i><span>LMS Knowledge | Tech</span><span class="lms-value">85%</span></div>
                <div class="lms-bar"><div class="lms-fill" style="width: 85%"></div></div>
            </div>
        </div>
    </div>

    {{-- Marketing Section --}}
    <div class="dashboard-section marketing-section full-width fade-in">
        <div class="section-header">
            <div class="section-icon marketing"><i class="fas fa-bullhorn"></i></div>
            <h2>Marketing</h2>
        </div>
        <div class="section-content marketing-grid">
            <div class="marketing-subsection">
                <h4><i class="fas fa-chart-pie"></i> Ads Budget Distribution</h4>
                <div class="ads-budget-chart">
                    <div class="donut-chart-container"><canvas id="adsBudgetChart"></canvas></div>
                    <div class="budget-total-center"><span class="total-label">Total</span><span class="total-value">125K/50K</span></div>
                </div>
                <div class="budget-legend">
                    <div class="legend-row"><span class="dot facebook"></span><span class="label">Facebook</span><span class="value">฿65,000</span></div>
                    <div class="legend-row"><span class="dot google"></span><span class="label">Google</span><span class="value">฿35,000</span></div>
                    <div class="legend-row"><span class="dot line"></span><span class="label">Line</span><span class="value">฿25,000</span></div>
                </div>
            </div>
            <div class="marketing-subsection">
                <h4><i class="fas fa-chart-bar"></i> Conversion Metrics</h4>
                <div class="engagement-metrics">
                    <div class="engagement-item"><div class="engagement-icon"><i class="fas fa-volume-up"></i></div><div class="engagement-data"><span class="value">2,450</span><span class="label">Line Volumn</span></div></div>
                    <div class="engagement-item"><div class="engagement-icon"><i class="fas fa-sync-alt"></i></div><div class="engagement-data"><span class="value">35</span><span class="label">Line Conversion Update</span></div></div>
                    <div class="engagement-item"><div class="engagement-icon"><i class="fab fa-google"></i></div><div class="engagement-data"><span class="value">180</span><span class="label">Line GG Ads Conversion Click</span></div></div>
                    <div class="engagement-item"><div class="engagement-icon"><i class="fas fa-mouse-pointer"></i></div><div class="engagement-data"><span class="value">85</span><span class="label">Line Ads Conversion Click/Add</span></div></div>
                </div>
            </div>
            <div class="marketing-subsection">
                <h4><i class="fas fa-comments"></i> Engagement</h4>
                <div class="engagement-metrics">
                    <div class="engagement-item"><div class="engagement-icon"><i class="fab fa-facebook-messenger"></i></div><div class="engagement-data"><span class="value">1,248</span><span class="label">FB Inbox Total Message</span></div></div>
                    <div class="engagement-item"><div class="engagement-icon"><i class="fas fa-user-plus"></i></div><div class="engagement-data"><span class="value">156</span><span class="label">Actual C/Addline | Sum</span></div></div>
                    <div class="engagement-item"><div class="engagement-icon"><i class="fas fa-hand-holding-usd"></i></div><div class="engagement-data"><span class="value">฿ 45.50</span><span class="label">Cost Per Real Add Line</span></div></div>
                </div>
            </div>
            <div class="marketing-subsection">
                <h4><i class="fas fa-photo-video"></i> Performance</h4>
                <div class="media-metrics">
                    <div class="media-item highlight"><span class="label">Pimdai - Performance (Reach)</span><span class="value">458K</span></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Logistic Section --}}
    <div class="dashboard-section logistic-section full-width fade-in">
        <div class="section-header">
            <div class="section-icon logistic"><i class="fas fa-truck"></i></div>
            <h2>Logistic</h2>
        </div>
        <div class="section-content">
            <div class="logistic-stats">
                <div class="stat-row">
                    <div class="stat-item success"><i class="fas fa-file-invoice"></i><span class="value">28</span><span class="label">จำนวนใบเสนอราคาที่ส่งได้</span></div>
                    <div class="stat-item info"><i class="fas fa-box-open"></i><span class="value">156</span><span class="label">จำนวนชิ้นงานที่จัดส่งจริง</span></div>
                    <div class="stat-item warning"><i class="fas fa-calendar-times"></i><span class="value">5</span><span class="label">จำนวนเลื่อนส่งจากส่งไม่ทัน</span></div>
                </div>
            </div>
            <div class="logistic-details-grid">
                <div class="delivery-costs">
                    <h4>ขนส่งไปษณีย์ (ลูกค้าไม่ได้จ่าย)</h4>
                    <div class="cost-row">
                        <div class="cost-item"><span class="label">จำนวน</span><span class="value">12 รายการ</span></div>
                        <div class="cost-item"><span class="label">มูลค่าที่ใช้</span><span class="value danger">฿ 4,850</span></div>
                    </div>
                </div>
                <div class="delivery-others">
                    <h4>Lalamove & Flash</h4>
                    <div class="others-row">
                        <div class="other-item"><span class="label">จำนวนต่องาน</span><span class="value">8</span></div>
                        <div class="other-item"><span class="label">AVG ค่าต่องาน</span><span class="value">฿ 285</span></div>
                    </div>
                </div>
                <div class="customer-shipping">
                    <div class="shipping-total">
                        <i class="fas fa-hand-holding-usd"></i>
                        <span class="label">มูลค่าค่าขนส่งจากลูกค้า</span>
                        <span class="value success">฿ 18,500</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Warehouse Section --}}
    <div class="dashboard-section warehouse-section fade-in">
        <div class="section-header">
            <div class="section-icon warehouse"><i class="fas fa-warehouse"></i></div>
            <h2>Warehouse</h2>
        </div>
        <div class="section-content">
            <div class="warehouse-grid">
                <div class="warehouse-chart-area">
                    <div class="warehouse-donut"><canvas id="warehouseDonutChart"></canvas></div>
                    <div class="stock-total"><span class="total-label">Stock Value</span><span class="total-value">฿4.58M</span></div>
                </div>
                <div class="warehouse-legend">
                    <div class="legend-item"><span class="dot supplies"></span><span class="label">วัสดุสิ้นเปลือง</span><span class="value">฿125K</span></div>
                    <div class="legend-item"><span class="dot materials"></span><span class="label">วัตถุดิบหลัก</span><span class="value">฿890K</span></div>
                    <div class="legend-item"><span class="dot finished"></span><span class="label">สินค้าสำเร็จรูป</span><span class="value">฿2.45M</span></div>
                    <div class="legend-item"><span class="dot tools"></span><span class="label">เครื่องมือช่าง&อะไหล่</span><span class="value">฿315K</span></div>
                    <div class="legend-item"><span class="dot cogs"></span><span class="label">Cost of goods</span><span class="value">฿800K</span></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Claim & Fix Section --}}
    <div class="dashboard-section claim-section fade-in">
        <div class="section-header">
            <div class="section-icon claim"><i class="fas fa-tools"></i></div>
            <h2>PIMDAI Claim & Fix</h2>
        </div>
        <div class="section-content">
            <div class="claim-grid">
                <div class="claim-chart-area">
                    <canvas id="claimDonutChart"></canvas>
                    <div class="claim-center"><span class="total-num">16</span><span class="total-text">รายการ</span></div>
                </div>
                <div class="claim-legend">
                    <div class="legend-item inkjet"><span class="dot"></span><div class="legend-info"><span class="type">Inkjet</span><span class="count">5 รายการ</span></div><i class="fas fa-print"></i></div>
                    <div class="legend-item digital"><span class="dot"></span><div class="legend-info"><span class="type">Digital</span><span class="count">3 รายการ</span></div><i class="fas fa-tv"></i></div>
                    <div class="legend-item accessory"><span class="dot"></span><div class="legend-info"><span class="type">Accessory</span><span class="count">8 รายการ</span></div><i class="fas fa-plug"></i></div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/dashboard-charts.js') }}"></script>
@endpush
