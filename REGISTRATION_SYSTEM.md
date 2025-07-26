# Registration System Documentation

## Overview
Sistem registrasi SATUPANGAN mendukung tiga jenis registrasi pengguna dengan validasi yang terpisah menggunakan Form Request classes:

1. **Registrasi Pengunjung Biasa** (`/register`) - `RegisterUserAddRequest`
2. **Registrasi Pengusaha** (`/register-business`) - `RegisterBusinessAddRequest`
3. **Registrasi Petugas** (`/register-petugas`) - `RegisterPetugasAddRequest`

## Routes yang Tersedia

### 1. Registrasi Pengunjung Biasa
- **GET** `/register` - Menampilkan form registrasi pengunjung
- **POST** `/register` - Memproses registrasi pengunjung
- **Role yang diberikan**: `ROLE_USER`
- **Form Request**: `RegisterUserAddRequest`

### 2. Registrasi Pengusaha
- **GET** `/register-business` - Menampilkan form registrasi pengusaha
- **POST** `/register-business` - Memproses registrasi pengusaha
- **Role yang diberikan**: `ROLE_USER_BUSINESS`
- **Form Request**: `RegisterBusinessAddRequest`

### 3. Registrasi Petugas
- **GET** `/register-petugas` - Menampilkan form registrasi petugas
- **POST** `/register-petugas` - Memproses registrasi petugas
- **Role yang diberikan**: `ROLE_OPERATOR`
- **Form Request**: `RegisterPetugasAddRequest`

### 4. Halaman Pilihan Registrasi
- **GET** `/register-list` - Menampilkan pilihan jenis registrasi

## Form Request Classes

### RegisterUserAddRequest
**Location**: `app/Http/Requests/RegisterUserAddRequest.php`

**Validation Rules**:
- `name`: required, string, max:255
- `email`: required, email, unique:users, max:255
- `jenis_kelamin`: required, in:male,female
- `no_hp`: required, string, max:20
- `pekerjaan`: required, string, max:100
- `alamat_domisili`: required, string, max:255
- `provinsi_id`: required, exists:master_provinsis,id
- `kota_id`: required, exists:master_kotas,id
- `password`: required, Laravel Password rules
- `agree`: accepted

### RegisterBusinessAddRequest
**Location**: `app/Http/Requests/RegisterBusinessAddRequest.php`

**Validation Rules** (includes all from RegisterUserAddRequest plus):
- `nama_perusahaan`: required, string, max:255
- `alamat_perusahaan`: nullable, string, max:255
- `jabatan_perusahaan`: nullable, string, max:100
- `nib`: nullable, string, max:100
- `jenispsat_id`: required, array
- `jenispsat_id.*`: exists:master_jenis_pangan_segars,id

**Note**: Tidak memerlukan field `pekerjaan` karena digantikan dengan data perusahaan.

### RegisterPetugasAddRequest
**Location**: `app/Http/Requests/RegisterPetugasAddRequest.php`

**Validation Rules** (includes all from RegisterUserAddRequest plus):
- `unit_kerja`: required, string, max:255
- `jabatan`: required, string, max:100
- `is_kantor_pusat`: required, in:0,1
- `penempatan`: nullable, exists:master_provinsis,id

**Custom Validation**: 
- Menggunakan `withValidator()` method untuk validasi conditional
- Field `penempatan` wajib diisi jika `is_kantor_pusat` = 0 (petugas daerah)

## Struktur Data

### Tabel Users
Semua jenis registrasi akan membuat record di tabel `users` dengan data:
- `name`: Nama lengkap
- `email`: Email (unique)
- `password`: Password (hashed)
- `phone_number`: Nomor HP
- `is_active`: Status aktif user

### Tabel User Profiles
Semua registrasi juga membuat record di `user_profiles`:
- `user_id`: ID user
- `gender`: Jenis kelamin (male/female)
- `address`: Alamat domisili
- `provinsi_id`: ID provinsi
- `kota_id`: ID kota/kabupaten
- `pekerjaan`: Pekerjaan (untuk user biasa dan petugas)

### Tabel Business (khusus pengusaha)
Registrasi pengusaha membuat record tambahan di `business`:
- `user_id`: ID user
- `nama_perusahaan`: Nama perusahaan
- `alamat_perusahaan`: Alamat perusahaan
- `jabatan_perusahaan`: Jabatan di perusahaan
- `nib`: Nomor Induk Berusaha

### Tabel Business_Jenispsat (khusus pengusaha)
Menyimpan jenis pangan segar yang ditangani:
- `business_id`: ID business
- `jenispsat_id`: ID jenis pangan segar

### Tabel Petugas (khusus petugas)
Registrasi petugas membuat record tambahan di `petugas`:
- `user_id`: ID user
- `unit_kerja`: Unit kerja petugas
- `jabatan`: Jabatan petugas
- `is_kantor_pusat`: Boolean (1=pusat, 0=daerah)
- `penempatan`: ID provinsi penempatan (untuk petugas daerah)

## Roles System

### Available Roles
1. `ROLE_USER` - Pengguna biasa
2. `ROLE_USER_BUSINESS` - Pelaku usaha
3. `ROLE_OPERATOR` - Petugas Badan Pangan
4. `ROLE_SUPERVISOR` - Supervisor Badan Pangan
5. `ROLE_ADMIN` - Administrator

### Role Assignment
- **Pengunjung Biasa**: `ROLE_USER`
- **Pengusaha**: `ROLE_USER_BUSINESS`
- **Petugas**: `ROLE_OPERATOR` (default, bisa disesuaikan)

## Controller Implementation

### RegisteredUserController Methods

#### store(RegisterUserAddRequest $request)
- Menggunakan `RegisterUserAddRequest` untuk validasi
- Membuat user dengan role `ROLE_USER`
- Membuat user profile dengan data personal

#### storeBusiness(RegisterBusinessAddRequest $request)
- Menggunakan `RegisterBusinessAddRequest` untuk validasi
- Membuat user dengan role `ROLE_USER_BUSINESS`
- Membuat user profile (tanpa pekerjaan)
- Membuat record business
- Membuat relasi business_jenispsat

#### storePetugas(RegisterPetugasAddRequest $request)
- Menggunakan `RegisterPetugasAddRequest` untuk validasi
- Membuat user dengan role `ROLE_OPERATOR`
- Membuat user profile dengan data personal
- Membuat record petugas dengan data jabatan dan penempatan

## Error Handling

### Form Request Validation
- Validasi dilakukan secara otomatis oleh Laravel sebelum masuk ke controller
- Custom error messages dalam Bahasa Indonesia
- Automatic redirect back dengan error messages dan old input

### Database Transaction
- Semua operasi database dibungkus dalam transaction
- Rollback otomatis jika terjadi error
- Error logging untuk debugging

## Advanced Features

### Conditional Validation
**RegisterPetugasAddRequest** menggunakan `withValidator()` untuk:
- Memvalidasi field `penempatan` hanya jika `is_kantor_pusat` = 0
- Custom error message untuk validasi conditional

### Custom Error Messages
Setiap Form Request memiliki method `messages()` yang mengembalikan:
- Error messages dalam Bahasa Indonesia
- Specific messages untuk setiap field dan rule
- User-friendly error descriptions

## Flow Registrasi

1. User mengakses `/register-list` untuk memilih jenis registrasi
2. User diarahkan ke form registrasi sesuai pilihan
3. User mengisi form dan submit
4. **Form Request melakukan validasi otomatis**
5. Jika validasi gagal: redirect back dengan errors dan old input
6. Jika validasi berhasil: masuk ke controller method
7. Controller melakukan:
   - Database transaction
   - Create user record
   - Create user profile
   - Create additional records (business/petugas)
   - Assign appropriate role
   - Trigger Registered event
   - Redirect sesuai konfigurasi

## Best Practices Implemented

### Separation of Concerns
- Validasi logic terpisah dari controller
- Setiap jenis registrasi memiliki Form Request sendiri
- Controller fokus pada business logic

### Type Hinting
- Controller methods menggunakan type-hinted Form Request parameters
- IDE support dan better error detection
- Automatic validation execution

### Reusability
- Form Request classes dapat digunakan kembali
- Validation rules terpusat dan mudah dimodifikasi
- Custom validation methods dapat ditambahkan

## Testing

Untuk testing registrasi:
1. Pastikan database ter-seed dengan roles: `php artisan db:seed --class=RoleMasterSeeder`
2. Pastikan master data provinsi dan kota tersedia
3. Test validation dengan data invalid untuk memastikan Form Request bekerja
4. Test dengan data valid untuk memastikan proses registrasi berhasil

## Dependencies

- Laravel Form Requests
- Laravel Validation
- Laravel Authentication
- UUID untuk primary keys
- Soft Deletes untuk model Business dan Petugas
- Foreign key constraints

## File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Auth/
│   │       └── RegisteredUserController.php
│   └── Requests/
│       ├── RegisterUserAddRequest.php
│       ├── RegisterBusinessAddRequest.php
│       └── RegisterPetugasAddRequest.php
├── Models/
│   ├── User.php
│   ├── UserProfile.php
│   ├── Business.php
│   ├── BusinessJenispsat.php
│   └── Petugas.php
└── ...
```

## Struktur Data

### Tabel Users
Semua jenis registrasi akan membuat record di tabel `users` dengan data:
- `name`: Nama lengkap
- `email`: Email (unique)
- `password`: Password (hashed)
- `phone_number`: Nomor HP
- `is_active`: Status aktif user

### Tabel User Profiles
Semua registrasi juga membuat record di `user_profiles`:
- `user_id`: ID user
- `gender`: Jenis kelamin (male/female)
- `address`: Alamat domisili
- `provinsi_id`: ID provinsi
- `kota_id`: ID kota/kabupaten
- `pekerjaan`: Pekerjaan (untuk user biasa dan petugas)

### Tabel Business (khusus pengusaha)
Registrasi pengusaha membuat record tambahan di `business`:
- `user_id`: ID user
- `nama_perusahaan`: Nama perusahaan
- `alamat_perusahaan`: Alamat perusahaan
- `jabatan_perusahaan`: Jabatan di perusahaan
- `nib`: Nomor Induk Berusaha

### Tabel Business_Jenispsat (khusus pengusaha)
Menyimpan jenis pangan segar yang ditangani:
- `business_id`: ID business
- `jenispsat_id`: ID jenis pangan segar

### Tabel Petugas (khusus petugas)
Registrasi petugas membuat record tambahan di `petugas`:
- `user_id`: ID user
- `unit_kerja`: Unit kerja petugas
- `jabatan`: Jabatan petugas
- `is_kantor_pusat`: Boolean (1=pusat, 0=daerah)
- `penempatan`: ID provinsi penempatan (untuk petugas daerah)

## Roles System

### Available Roles
1. `ROLE_USER` - Pengguna biasa
2. `ROLE_USER_BUSINESS` - Pelaku usaha
3. `ROLE_OPERATOR` - Petugas Badan Pangan
4. `ROLE_SUPERVISOR` - Supervisor Badan Pangan
5. `ROLE_ADMIN` - Administrator

### Role Assignment
- **Pengunjung Biasa**: `ROLE_USER`
- **Pengusaha**: `ROLE_USER_BUSINESS`
- **Petugas**: `ROLE_OPERATOR` (default, bisa disesuaikan)

## Validasi Form

### Registrasi Pengunjung Biasa
- Nama lengkap (required)
- Email (required, unique, valid email)
- Jenis kelamin (required, male/female)
- No HP (required)
- Pekerjaan (required)
- Alamat domisili (required)
- Provinsi (required, exists in master_provinsis)
- Kota (required, exists in master_kotas)
- Password (required, sesuai aturan Laravel)
- Persetujuan syarat & ketentuan (required)

### Registrasi Pengusaha
Semua field pengunjung biasa ditambah:
- Nama perusahaan (required)
- Alamat perusahaan (optional)
- Jabatan di perusahaan (optional)
- NIB (optional)
- Jenis pangan segar (required, array, exists in master_jenis_pangan_segars)

### Registrasi Petugas
Semua field pengunjung biasa ditambah:
- Unit kerja (required)
- Jabatan (required)
- Tipe petugas (required, 1=pusat/0=daerah)
- Penempatan provinsi (required untuk petugas daerah)

## Error Handling

Sistem menggunakan Laravel validation dengan custom error messages dalam Bahasa Indonesia. Jika terjadi error:
- Database transaction akan di-rollback
- User akan diarahkan kembali ke form dengan pesan error
- Input sebelumnya akan dipertahankan (old input)

## Flow Registrasi

1. User mengakses `/register-list` untuk memilih jenis registrasi
2. User diarahkan ke form registrasi sesuai pilihan
3. User mengisi form dan submit
4. Sistem validasi input
5. Jika valid:
   - Buat record di tabel `users`
   - Buat record di tabel `user_profiles`
   - Buat record tambahan sesuai jenis registrasi (business/petugas)
   - Assign role yang sesuai
   - Trigger event `Registered`
   - Redirect sesuai konfigurasi (login otomatis/aktivasi/verifikasi email)

## Konfigurasi

Perilaku setelah registrasi dikontrol oleh konstanta di `config/constant.php`:
- `NEW_USER_STATUS_ACTIVE`: Apakah user langsung aktif
- `NEW_USER_NEED_VERIFY_EMAIL`: Apakah perlu verifikasi email

## Testing

Untuk testing registrasi:
1. Pastikan database ter-seed dengan roles: `php artisan db:seed --class=RoleMasterSeeder`
2. Pastikan master data provinsi dan kota tersedia
3. Akses `/register-list` untuk memulai proses registrasi

## Dependencies

- Laravel Validation
- Laravel Authentication
- UUID untuk primary keys
- Soft Deletes untuk model Business dan Petugas
- Foreign key constraints