# Role & Permission Guide - Sistem STK

## Daftar Role & Permission

### 1. **Super Admin** 
**Email:** `superadmin@gmail.com`  
**Password:** `password123`  
**Total Permissions:** 28 (ALL)

**Akses Penuh:**
- ✅ Manage Users (view, create, edit, delete)
- ✅ Manage Roles & Permissions (view, create, edit, delete, assign)
- ✅ Manage Kendaraan (view, create, edit, delete)
- ✅ Manage Audit Logs (view, export, delete)
- ✅ System Settings
- ✅ All Reports & Exports
- ✅ Dashboard Admin & User
- ✅ Profile Management

---

### 2. **Admin Transport** 
**Email:** `transport@gmail.com`  
**Password:** `password123`  
**Total Permissions:** 10

**Akses:**
- ✅ Full Manage Kendaraan (view, create, edit, delete)
- ✅ View Users (tidak bisa create/edit/delete)
- ✅ View & Export Reports
- ✅ Dashboard User
- ✅ Edit Profile

**Use Case:** 
Mengelola data kendaraan operasional, melihat laporan penggunaan kendaraan, monitoring status kendaraan.

---

### 3. **Admin Departemen** 
**Email:** `departemen@gmail.com`  
**Password:** `password123`  
**Total Permissions:** 6

**Akses:**
- ✅ View Kendaraan (hanya lihat)
- ✅ View Users (hanya lihat)
- ✅ View Reports (hanya lihat)
- ✅ Dashboard User
- ✅ Edit Profile

**Use Case:** 
Monitoring ketersediaan kendaraan untuk kebutuhan departemen, melihat siapa yang menggunakan kendaraan.

---

### 4. **Driver** 
**Email:** `driver@gmail.com`  
**Password:** `password123`  
**Total Permissions:** 4

**Akses:**
- ✅ View Kendaraan (lihat data kendaraan yang dikemudikan)
- ✅ Dashboard User
- ✅ View & Edit Profile

**Use Case:** 
Driver dapat melihat informasi kendaraan yang akan/sedang dikemudikan, status pajak, dll.

---

### 5. **Security** 
**Email:** `security@gmail.com`  
**Password:** `password123`  
**Total Permissions:** 4

**Akses:**
- ✅ View Kendaraan (monitoring keluar/masuk kendaraan)
- ✅ Dashboard User
- ✅ View & Edit Profile

**Use Case:** 
Memeriksa data kendaraan yang keluar/masuk area, verifikasi plat nomor dan data kendaraan.

---

## Permission Matrix

| Permission | Super Admin | Admin Transport | Admin Departemen | Driver | Security |
|------------|-------------|-----------------|------------------|--------|----------|
| **Users Management** |
| view users | ✅ | ✅ | ✅ | ❌ | ❌ |
| create users | ✅ | ❌ | ❌ | ❌ | ❌ |
| edit users | ✅ | ❌ | ❌ | ❌ | ❌ |
| delete users | ✅ | ❌ | ❌ | ❌ | ❌ |
| **Kendaraan Management** |
| view kendaraan | ✅ | ✅ | ✅ | ✅ | ✅ |
| create kendaraan | ✅ | ✅ | ❌ | ❌ | ❌ |
| edit kendaraan | ✅ | ✅ | ❌ | ❌ | ❌ |
| delete kendaraan | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Reports** |
| view reports | ✅ | ✅ | ✅ | ❌ | ❌ |
| export reports | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Audit Logs** |
| view audit logs | ✅ | ❌ | ❌ | ❌ | ❌ |
| export audit logs | ✅ | ❌ | ❌ | ❌ | ❌ |
| delete audit logs | ✅ | ❌ | ❌ | ❌ | ❌ |
| **Roles & Permissions** |
| view roles | ✅ | ❌ | ❌ | ❌ | ❌ |
| manage roles | ✅ | ❌ | ❌ | ❌ | ❌ |
| view permissions | ✅ | ❌ | ❌ | ❌ | ❌ |
| manage permissions | ✅ | ❌ | ❌ | ❌ | ❌ |
| **Dashboard** |
| access admin dashboard | ✅ | ❌ | ❌ | ❌ | ❌ |
| access user dashboard | ✅ | ✅ | ✅ | ✅ | ✅ |
| **Profile** |
| view profile | ✅ | ✅ | ✅ | ✅ | ✅ |
| edit profile | ✅ | ✅ | ✅ | ✅ | ✅ |
| **System** |
| manage settings | ✅ | ❌ | ❌ | ❌ | ❌ |

---

## Cara Menambah Role ke User

### Via Seeder
```php
$user = User::find(1);
$user->assignRole('admin_transport');
```

### Via Tinker
```bash
php artisan tinker
$user = User::where('email', 'user@example.com')->first();
$user->assignRole('driver');
```

### Via Controller
```php
$user->assignRole($request->role);
$user->syncRoles([$request->role]);
```

---

## Notes

- Semua user dapat edit profile mereka sendiri
- Permission berbasis middleware `can:` atau `@can` directive
- Cache permission otomatis di-clear setelah perubahan
- Super Admin memiliki akses ke semua fitur sistem

---

**Last Updated:** November 6, 2025
