# Laravel Authentication Setup Guide

## การปรับปรุง Migration สำหรับ Laravel Authentication

### การเปลี่ยนแปลง

#### 1. Users Table Migration
ปรับปรุงตาราง `users` ให้รองรับระบบ authentication ของ Laravel:

**ฟิลด์หลัก:**
- `id` - Primary key
- `name` - ชื่อผู้ใช้ (แทน full_name เดิม)
- `username` - Username สำหรับ login (optional, unique)
- `email` - Email address (unique, required)
- `email_verified_at` - เวลาที่ยืนยัน email (Laravel email verification)
- `password` - รหัสผ่านที่เข้ารหัสแล้ว
- `remember_token` - Token สำหรับ "Remember Me" feature
- `phone` - เบอร์โทรศัพท์
- `role` - บทบาท (Admin, Sales, Inventory, Purchase, Accountant, Marketing)
- `is_active` - สถานะการใช้งาน (boolean)
- `timestamps` - created_at, updated_at
- `softDeletes` - deleted_at (soft delete support)

#### 2. Password Reset Tokens Table
สร้างตาราง `password_reset_tokens` สำหรับ password reset functionality:
- `email` - Email address (primary key)
- `token` - Reset token
- `created_at` - เวลาที่สร้าง token

#### 3. Sessions Table
สร้างตาราง `sessions` สำหรับเก็บ session ใน database:
- `id` - Session ID (primary key)
- `user_id` - Foreign key ไปยัง users
- `ip_address` - IP address ของผู้ใช้
- `user_agent` - Browser agent string
- `payload` - Session data
- `last_activity` - เวลาที่ active ล่าสุด

### User Model

#### Traits
- `HasFactory` - สำหรับ Factory pattern
- `Notifiable` - สำหรับ notifications
- `SoftDeletes` - สำหรับ soft delete

#### Fillable Fields
```php
protected $fillable = [
    'name',
    'username',
    'email',
    'password',
    'phone',
    'role',
    'is_active',
];
```

#### Helper Methods
- `findForAuth($identity)` - ค้นหาผู้ใช้ด้วย email หรือ username
- `hasRole($role)` - ตรวจสอบ role ของผู้ใช้
- `isActive()` - ตรวจสอบสถานะ active

### การใช้งาน

#### 1. รัน Migration
```bash
php artisan migrate
```

#### 2. รัน Seeder
```bash
php artisan db:seed --class=UserSeeder
```

#### 3. ข้อมูล Login เริ่มต้น

| Role | Username | Email | Password |
|------|----------|-------|----------|
| Admin | admin | admin@pimdai.com | password |
| Sales | sales01 | sales01@pimdai.com | password |
| Inventory | inventory01 | inventory01@pimdai.com | password |
| Purchase | purchase01 | purchase01@pimdai.com | password |
| Accountant | accountant01 | accountant01@pimdai.com | password |
| Marketing | marketing01 | marketing01@pimdai.com | password |

#### 4. Login ด้วย Username หรือ Email

ผู้ใช้สามารถ login ด้วย email หรือ username ได้:

```php
use App\Models\User;

// ค้นหาผู้ใช้ด้วย username หรือ email
$user = User::findForAuth($credentials['identity']);

// ตรวจสอบรหัสผ่าน
if ($user && Hash::check($credentials['password'], $user->password)) {
    // Login สำเร็จ
    Auth::login($user, $remember);
}
```

#### 5. ตรวจสอบ Role

```php
// ตรวจสอบว่าผู้ใช้เป็น Admin หรือไม่
if (auth()->user()->hasRole('Admin')) {
    // ทำงานสำหรับ Admin
}

// ตรวจสอบว่าผู้ใช้ active หรือไม่
if (auth()->user()->isActive()) {
    // ผู้ใช้ active
}
```

### UserFactory

Factory รองรับการสร้าง test users:

```php
// สร้าง admin user
User::factory()->admin()->create();

// สร้าง sales user
User::factory()->sales()->create();

// สร้าง inactive user
User::factory()->inactive()->create();

// สร้าง unverified email user
User::factory()->unverified()->create();

// สร้าง random users
User::factory()->count(10)->create();
```

### Session Configuration

ในไฟล์ `.env` ตั้งค่า session driver เป็น database:
```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
```

### Email Verification (Optional)

หากต้องการเปิดใช้งาน email verification:

1. อัปเดต User model:
```php
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    // ...
}
```

2. เพิ่ม middleware `verified` ในroutes:
```php
Route::middleware(['auth', 'verified'])->group(function () {
    // Protected routes
});
```

### Security Best Practices

1. **แก้ไขรหัสผ่านเริ่มต้น:** เปลี่ยนรหัสผ่าน `password` ในทุก account ก่อนใช้งานจริง
2. **ใช้ HTTPS:** บังคับใช้ HTTPS ในโปรดักชัน
3. **Rate Limiting:** เพิ่ม rate limiting สำหรับ login attempts
4. **Two-Factor Authentication:** พิจารณาเพิ่ม 2FA สำหรับ admin accounts
5. **Session Security:** ตั้งค่า secure session cookies

### การ Troubleshooting

#### ปัญหา: Migration Error
```bash
# รีเซ็ต database (ข้อมูลจะหายหมด)
php artisan migrate:fresh --seed
```

#### ปัญหา: Session ไม่ทำงาน
```bash
# ลบ cache ทั้งหมด
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

#### ปัญหา: Can't login
1. ตรวจสอบว่า user is_active = true
2. ตรวจสอบว่า password ถูกต้อง
3. ตรวจสอบ session configuration

---

© 2026 ERP PIMDAI - Laravel Authentication System
