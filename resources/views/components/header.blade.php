<header class="header bg-white border-bottom shadow-sm py-3 px-4">
    <div class="d-flex justify-content-between align-items-center">
        <!-- Header Left -->
        <div class="header-left d-flex align-items-center">
            <button class="btn btn-link text-dark menu-toggle me-3 p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas">
                <i class="fas fa-bars fs-5"></i>
            </button>
            <div class="page-title">
                <h1 class="mb-0 fs-4 fw-bold text-dark">@yield('page-title', 'Dashboard')</h1>
                <span class="page-subtitle text-muted" style="font-size: 0.8rem;">@yield('page-subtitle', 'ร้านค้า-ของ • ของรับเข้าขาย/เบิกออก')</span>
            </div>
        </div>

        <!-- Header Right -->
        <div class="header-right">
            <div class="user-badge d-flex align-items-center bg-light rounded px-3 py-2">
                <i class="fas fa-user-circle text-primary fs-5 me-2"></i>
                <span class="text-dark">สวัสดี, <strong>{{ Auth::user()->name ?? 'Pzo' }}</strong></span>
            </div>
        </div>
    </div>
</header>
