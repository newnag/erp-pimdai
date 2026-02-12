# ERP PIMDAI - Header & Sidebar Components

## ภาพรวม

Components สำหรับ Header และ Sidebar ที่สร้างด้วย Bootstrap และใช้ธีมสีขาว สำหรับระบบ ERP PIMDAI

## โครงสร้างไฟล์

```
resources/
├── css/
│   ├── app.css (เก่า - Tailwind)
│   └── app.scss (ใหม่ - Bootstrap + Custom styles)
├── js/
│   └── app.js (รวม Bootstrap JavaScript + Sidebar toggle)
└── views/
    ├── layouts/
    │   └── app.blade.php (Main layout)
    ├── components/
    │   ├── header.blade.php
    │   └── sidebar.blade.php
    └── dashboard.blade.php (หน้าตัวอย่าง)
```

## การติดตั้ง

1. ติดตั้ง dependencies ที่จำเป็น (เสร็จแล้ว):
```bash
npm install bootstrap @popperjs/core sass
```

2. Build assets:
```bash
npm run dev
# หรือสำหรับ production
npm run build
```

3. เริ่ม Laravel development server:
```bash
php artisan serve
```

4. เปิดเบราว์เซอร์และไปที่:
```
http://localhost:8000/dashboard
```

## การใช้งาน

### 1. สร้างหน้าใหม่

สร้างไฟล์ blade ใหม่ที่ extends จาก layout:

```blade
@extends('layouts.app')

@section('title', 'ชื่อหน้า')
@section('page-title', 'หัวข้อหน้า')
@section('page-subtitle', 'คำอธิบายหน้า')

@section('content')
    <!-- เนื้อหาของคุณที่นี่ -->
@endsection
```

### 2. ปรับแต่ง Sidebar

แก้ไขไฟล์ `resources/views/components/sidebar.blade.php`:

- เพิ่ม/ลบเมนู
- เปลี่ยนไอคอน (ใช้ Font Awesome)
- เปลี่ยน route
- เปลี่ยนข้อมูลผู้ใช้

ตัวอย่างการเพิ่มเมนูใหม่:

```blade
<a href="{{ route('your-route') }}" class="nav-item d-flex align-items-center text-decoration-none text-dark p-2 rounded mb-1">
    <i class="fas fa-icon-name me-2"></i>
    <span>ชื่อเมนู</span>
</a>
```

### 3. ปรับแต่ง Header

แก้ไขไฟล์ `resources/views/components/header.blade.php`:

- เปลี่ยนชื่อผู้ใช้
- เพิ่มปุ่มหรือเมนูเพิ่มเติม
- ปรับแต่ง badge หรือ notifications

### 4. Customize สี

แก้ไขไฟล์ `resources/css/app.scss`:

```scss
// เปลี่ยนสีหลัก
$primary: #0d6efd;  // สีน้ำเงิน
$sidebar-width: 280px;

// หรือ override Bootstrap variables
$theme-colors: (
  "primary": #your-color,
  "secondary": #your-color,
  // ...
);
```

## Features

### Desktop
- ✅ Sidebar แบบ fixed ด้านซ้าย
- ✅ Header แบบ sticky ด้านบน
- ✅ Navigation menu แบบแยกหมวดหมู่
- ✅ Active state สำหรับเมนูที่เลือก
- ✅ Hover effects
- ✅ Custom scrollbar
- ✅ User profile section ใน sidebar footer

### Mobile (Responsive)
- ✅ Sidebar แบบ collapsible
- ✅ Toggle button ใน header
- ✅ Close sidebar เมื่อคลิกข้างนอก
- ✅ Responsive grid layout

## Bootstrap Components ที่ใช้

- Card
- Badge
- Button
- Table
- Grid System
- Utilities (spacing, colors, shadows, etc.)

## Routes

```php
GET  /              -> หน้า welcome (default Laravel)
GET  /dashboard     -> หน้า dashboard (ตัวอย่าง)
POST /logout        -> Logout (สำหรับทดสอบ)
```

## การแก้ไข Logo

แก้ไขใน `resources/views/components/sidebar.blade.php`:

```blade
<div class="logo-icon bg-primary text-white rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
    <!-- ใส่รูปภาพ หรือข้อความ -->
    <img src="/path/to/logo.png" alt="Logo">
    <!-- หรือ -->
    ERP
</div>
```

## การเพิ่ม Authentication

ปัจจุบัน components รองรับการแสดงข้อมูล user จาก Laravel Auth:

```blade
{{ Auth::user()->name ?? 'Default Name' }}
{{ Auth::user()->email ?? 'default@email.com' }}
```

หากต้องการเพิ่ม authentication ให้ใช้:

```bash
composer require laravel/breeze --dev
php artisan breeze:install
npm install && npm run dev
php artisan migrate
```

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## License

MIT License
