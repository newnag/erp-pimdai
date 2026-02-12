<aside class="sidebar bg-white border-end shadow-sm">
    <!-- Logo -->
    <div class="logo p-3 border-bottom">
        <div class="d-flex align-items-center">
            <div class="logo-icon bg-primary text-white rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-weight: 600;">
                ERP
            </div>
            <div class="logo-text ms-3">
                <div class="logo-title fw-bold text-dark" style="font-size: 1.1rem;">ERP Stock</div>
                <div class="logo-subtitle text-muted" style="font-size: 0.75rem;">Stock • Sales • Purchase</div>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="nav-menu overflow-auto" style="height: calc(100vh - 250px);">
        <!-- DASHBOARD -->
        <div class="nav-section p-3">
            <div class="nav-section-title text-secondary text-uppercase fw-semibold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">DASHBOARD</div>
            <a href="{{ route('dashboard') }}" class="nav-item d-flex align-items-center text-decoration-none p-2 rounded mb-1 {{ request()->routeIs('dashboard') ? 'active bg-primary text-white' : 'text-dark' }}">
                <i class="fas fa-th-large me-2"></i>
                <span>ภาพรวม</span>
            </a>
        </div>

        <!-- งานขาย (SALES) -->
        <div class="nav-section p-3 pt-0">
            <div class="nav-section-title text-secondary text-uppercase fw-semibold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">งานขาย (SALES)</div>
            <a href="#" class="nav-item d-flex align-items-center text-decoration-none text-dark p-2 rounded mb-1">
                <i class="fas fa-file-invoice me-2"></i>
                <span>ใบเสนอราคา</span>
            </a>
            <a href="#" class="nav-item d-flex align-items-center text-decoration-none text-dark p-2 rounded mb-1">
                <i class="fas fa-file-alt me-2"></i>
                <span>ใบส่งสินค้า/ใบวางบิล</span>
            </a>
            <a href="#" class="nav-item d-flex align-items-center text-decoration-none text-dark p-2 rounded mb-1">
                <i class="fas fa-receipt me-2"></i>
                <span>ใบกำกับภาษี/ใบเสร็จรับเงิน</span>
            </a>
            <a href="#" class="nav-item d-flex align-items-center text-decoration-none text-dark p-2 rounded mb-1">
                <i class="fas fa-users me-2"></i>
                <span>ลูกค้า</span>
            </a>
            <a href="#" class="nav-item d-flex align-items-center text-decoration-none text-dark p-2 rounded mb-1">
                <i class="fas fa-phone-alt me-2"></i>
                <span>Survey Call</span>
            </a>
            <a href="#" class="nav-item d-flex align-items-center text-decoration-none text-dark p-2 rounded mb-1">
                <i class="fas fa-tools me-2"></i>
                <span>Claim & Fix</span>
            </a>
            <a href="#" class="nav-item d-flex align-items-center text-decoration-none text-dark p-2 rounded mb-1">
                <i class="fas fa-tasks me-2"></i>
                <span>Extra Duty</span>
            </a>
        </div>

        <!-- การตลาด (MARKETING) -->
        <div class="nav-section p-3 pt-0">
            <div class="nav-section-title text-secondary text-uppercase fw-semibold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">การตลาด (MARKETING)</div>
            <a href="#" class="nav-item d-flex align-items-center text-decoration-none text-dark p-2 rounded mb-1">
                <i class="fas fa-chart-line me-2"></i>
                <span>บันทึกข้อมูลการตลาด</span>
            </a>
        </div>

        <!-- บุคคล (HR) -->
        <div class="nav-section p-3 pt-0">
            <div class="nav-section-title text-secondary text-uppercase fw-semibold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">บุคคล (HR)</div>
            <a href="#" class="nav-item d-flex align-items-center text-decoration-none text-dark p-2 rounded mb-1">
                <i class="fas fa-calendar-check me-2"></i>
                <span>บันทึกเวลาเข้า-ออก</span>
            </a>
        </div>

        <!-- จัดซื้อ (PURCHASES) -->
        <div class="nav-section p-3 pt-0">
            <div class="nav-section-title text-secondary text-uppercase fw-semibold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">จัดซื้อ (PURCHASES)</div>
            <a href="#" class="nav-item d-flex align-items-center text-decoration-none text-dark p-2 rounded mb-1">
                <i class="fas fa-clipboard-list me-2"></i>
                <span>รอสินค้าเข้า</span>
            </a>
            <a href="#" class="nav-item d-flex align-items-center text-decoration-none text-dark p-2 rounded mb-1">
                <i class="fas fa-building me-2"></i>
                <span>ซัพพลายเออร์</span>
            </a>
        </div>

        <!-- สินค้า (INVENTORY) -->
        <div class="nav-section p-3 pt-0">
            <div class="nav-section-title text-secondary text-uppercase fw-semibold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">สินค้า (INVENTORY)</div>
            <a href="#" class="nav-item d-flex align-items-center text-decoration-none text-dark p-2 rounded mb-1">
                <i class="fas fa-boxes me-2"></i>
                <span>สินค้า</span>
            </a>
            <a href="#" class="nav-item d-flex align-items-center text-decoration-none text-dark p-2 rounded mb-1">
                <i class="fas fa-sign-in-alt me-2"></i>
                <span>รับวัตถุดิบเข้า</span>
            </a>
            <a href="#" class="nav-item d-flex align-items-center text-decoration-none text-dark p-2 rounded mb-1">
                <i class="fas fa-sign-out-alt me-2"></i>
                <span>เบิกวัตถุดิบออก</span>
            </a>
            <a href="#" class="nav-item d-flex align-items-center text-decoration-none text-dark p-2 rounded mb-1">
                <i class="fas fa-exchange-alt me-2"></i>
                <span>ปรับปรุงสต็อก</span>
            </a>
        </div>

        <!-- การขนส่ง (LOGISTIC) -->
        <div class="nav-section p-3 pt-0">
            <div class="nav-section-title text-secondary text-uppercase fw-semibold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">การขนส่ง (LOGISTIC)</div>
            <a href="#" class="nav-item d-flex align-items-center text-decoration-none text-dark p-2 rounded mb-1">
                <i class="fas fa-truck me-2"></i>
                <span>บันทึกข้อมูลขนส่ง</span>
            </a>
        </div>

        <!-- การเงิน (FINANCE) -->
        <div class="nav-section p-3 pt-0">
            <div class="nav-section-title text-secondary text-uppercase fw-semibold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">การเงิน (FINANCE)</div>
            <a href="#" class="nav-item d-flex align-items-center text-decoration-none text-dark p-2 rounded mb-1">
                <i class="fas fa-receipt me-2"></i>
                <span>ค่าใช้จ่าย</span>
            </a>
            <a href="#" class="nav-item d-flex align-items-center text-decoration-none text-dark p-2 rounded mb-1">
                <i class="fas fa-money-check-alt me-2"></i>
                <span>เตรียมจ่าย</span>
            </a>
            <a href="#" class="nav-item d-flex align-items-center text-decoration-none text-dark p-2 rounded mb-1">
                <i class="fas fa-file-invoice-dollar me-2"></i>
                <span>หัก ณ ที่จ่าย</span>
            </a>
        </div>

        <!-- ทรัพย์สิน (ASSETS) -->
        <div class="nav-section p-3 pt-0">
            <div class="nav-section-title text-secondary text-uppercase fw-semibold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">ทรัพย์สิน (ASSETS)</div>
            <a href="#" class="nav-item d-flex align-items-center text-decoration-none text-dark p-2 rounded mb-1">
                <i class="fas fa-laptop me-2"></i>
                <span>จัดการสินทรัพย์</span>
            </a>
            <a href="#" class="nav-item d-flex align-items-center text-decoration-none text-dark p-2 rounded mb-1">
                <i class="fas fa-chart-line me-2"></i>
                <span>บันทึกค่าเสื่อมราคา</span>
            </a>
        </div>

        <!-- ตั้งค่า (SETTINGS) -->
        <div class="nav-section p-3 pt-0">
            <div class="nav-section-title text-secondary text-uppercase fw-semibold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">ตั้งค่า (SETTINGS)</div>
            <a href="#" class="nav-item d-flex align-items-center text-decoration-none text-dark p-2 rounded mb-1">
                <i class="fas fa-warehouse me-2"></i>
                <span>คลังสินค้า</span>
            </a>
            <a href="#" class="nav-item d-flex align-items-center text-decoration-none text-dark p-2 rounded mb-1">
                <i class="fas fa-tags me-2"></i>
                <span>หมวดหมู่ทรัพย์สิน</span>
            </a>
            <a href="#" class="nav-item d-flex align-items-center text-decoration-none text-dark p-2 rounded mb-1">
                <i class="fas fa-user-cog me-2"></i>
                <span>จัดการสมาชิก</span>
            </a>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer border-top p-3 bg-light">
        <div class="user-info mb-2">
            <div class="user-label text-muted" style="font-size: 0.7rem;">เข้าสู่ระบบเป็น</div>
            <div class="user-name fw-bold text-dark">{{ Auth::user()->name ?? 'Pzo' }}</div>
            <div class="user-email text-muted" style="font-size: 0.75rem;">{{ Auth::user()->email ?? 'pongkit@misuexemm.com' }} • admin</div>
            <a href="#" class="btn btn-sm btn-outline-primary w-100 mt-2">
                <i class="fas fa-user-circle"></i> โปรไฟล์ของฉัน
            </a>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger w-100 btn-sm">
                <i class="fas fa-sign-out-alt"></i>
                ออกจากระบบ
            </button>
        </form>
    </div>
</aside>
