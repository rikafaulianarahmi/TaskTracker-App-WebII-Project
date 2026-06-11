# Backend Notes

## Routes yang sudah dibuat

```php
$routes->get('/', 'AuthController::login');

$routes->post('/login', 'AuthController::attemptLogin');
$routes->get('/logout', 'AuthController::logout', ['filter' => 'auth']);

$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'auth']);
$routes->get('/projects', 'ProjectController::index', ['filter' => 'auth']);

$routes->get('/projects/create', 'ProjectController::create', ['filter' => 'auth']);
$routes->post('/projects/store', 'ProjectController::store', ['filter' => 'auth']);
$routes->post('/projects/(:num)/archive', 'ProjectController::archive/$1', ['filter' => 'auth']);

$routes->get('/projects/(:num)', 'ProjectController::show/$1', ['filter' => 'auth']);
$routes->post('/projects/(:num)/members', 'ProjectMemberController::store/$1', ['filter' => 'auth']);
$routes->post('/projects/(:num)/members/(:num)/remove', 'ProjectMemberController::remove/$1/$2', ['filter' => 'auth']);

$routes->get('/projects/(:num)/tasks/create', 'TaskController::create/$1', ['filter' => 'auth']);
$routes->post('/projects/(:num)/tasks/store', 'TaskController::store/$1', ['filter' => 'auth']);
$routes->post('/tasks/(:num)/status', 'TaskController::updateStatus/$1', ['filter' => 'auth']);
```

* Route GET `/` digunakan untuk menampilkan halaman login.
* Route POST `/login` digunakan untuk memproses percobaan login.
* Route GET `/logout` digunakan untuk keluar dari akun.
* Route GET `/dashboard` digunakan untuk menampilkan halaman dashboard.
* Route GET `/projects` digunakan untuk menampilkan daftar project.
* Route GET `/projects/create` digunakan untuk menampilkan form tambah project.
* Route POST `/projects/store` digunakan untuk menyimpan data project baru.
* Route GET `/projects/(:num)` digunakan untuk menampilkan detail project berdasarkan ID.
* Route GET `/projects/(:num)/tasks/create` digunakan untuk menampilkan form tambah task berdasarkan ID project.
* Route POST `/projects/(:num)/tasks/store` digunakan untuk menyimpan data task baru berdasarkan ID project.
* Route POST `/tasks/(:num)/status` digunakan untuk memperbarui status task berdasarkan ID task.
* Route POST `/projects/(:num)/archive` digunakan untuk mengarsipkan project berdasarkan ID.
* Route POST `/projects/(:num)/members` digunakan untuk menambahkan member ke project berdasarkan ID project.
* Route POST `/projects/(:num)/members/(:num)/remove` digunakan untuk menghapus member dari project berdasarkan ID project dan ID member.

## Controller yang sudah dibuat

### BaseController

Fungsi:

* Menyediakan fungsi dasar yang dapat digunakan oleh controller lain.
* Mengecek akses user terhadap project melalui `getProjectAccess($projectId)`.
* Mengambil data project berdasarkan ID project.
* Memastikan project belum diarsipkan melalui pengecekan `archived_at`.
* Menampilkan halaman 404 jika project tidak ditemukan.
* Mengecek apakah user yang sedang login adalah admin project.
* Memberikan akses admin jika `admin_id` project sama dengan `user_id` session.
* Mengecek apakah user yang sedang login terdaftar sebagai member project.
* Memberikan akses view kepada user yang terdaftar sebagai member project.
* Mengembalikan data project, role user, dan status admin.
* Menolak akses jika user bukan admin dan bukan member project.

Method:

```text
getProjectAccess($projectId)
```

### AuthController

Fungsi:

* Menampilkan halaman login
* Memproses login
* Mengecek email dan password
* Menyimpan data user ke session
* Logout dan menghapus session

Method:

```text
login()
attemptLogin()
logout()
```

### DashboardController

Fungsi:

* Menampilkan halaman dashboard setelah login
* Mengambil nama dan role user dari session

Method:

```text
index()
```

### ProjectController

Fungsi:

* Menampilkan daftar project yang belum diarsipkan.
* Hanya menampilkan project yang dimiliki user sebagai admin atau member.
* Menampilkan detail satu project berdasarkan ID.
* Mengecek akses user ke project melalui `getProjectAccess($id)`.
* Hanya menampilkan detail project yang belum diarsipkan.
* Mengambil daftar member project.
* Mengambil data user yang dapat ditambahkan sebagai member project.
* Menentukan apakah user dapat mengelola project melalui `canManage`.
* Menampilkan form tambah project hanya untuk user dengan role `admin`.
* Menyimpan data project baru hanya untuk user dengan role `admin`.
* Melakukan validasi input saat membuat project.
* Menampilkan error jika validasi gagal.
* Menampilkan halaman 404 jika project tidak ditemukan.
* Mengarsipkan project hanya jika user adalah admin project.
* Mengarsipkan project dengan mengisi nilai `archived_at`.
* Setelah project diarsipkan, user diarahkan kembali ke halaman daftar project.
* Mengambil daftar task berdasarkan project ID.
* Mengambil data task beserta nama assignee dan nama creator.
* Menampilkan task pada halaman detail project.
* Menampilkan informasi task seperti title, description, status, priority, deadline, assignee, dan creator.
* Mengirim data task ke view melalui variabel tasks.
Method:

```text
index()
show($id)
create()
store()
archive($id)
```

### TaskController

Fungsi:

* Menampilkan form tambah task berdasarkan ID project
* Mengecek apakah user memiliki akses sebagai admin project
* Mengambil daftar user yang dapat dijadikan assignee
* Memvalidasi input task seperti title, priority, deadline, dan assignee
* Mengecek apakah assignee valid untuk project tersebut
* Menyimpan task baru ke database
* Mengarahkan kembali ke detail project setelah task berhasil dibuat
* Mengubah status task melalui form update status.
* Mengizinkan admin project untuk mengubah status semua task.
* Mengizinkan assignee untuk mengubah status task miliknya sendiri.
* Memvalidasi status task agar hanya bernilai `todo`, `in_progress`, atau `done`.
* Mengarahkan kembali ke halaman detail project setelah status task berhasil diubah.

Method:

```text
create($projectId)
store($projectId)
getAssignableUsers($projectId, $adminId)
isAssignableUser($projectId, $adminId, $userId)
updateStatus($taskId)
```

### ProjectMemberController

Fungsi:

* Menambahkan user sebagai member project.
* Memastikan hanya admin project yang dapat mengelola member.
* Melakukan validasi input `user_id` dan `role`.
* Mengecek akses project melalui `getProjectAccess($projectId)`.
* Mencegah user yang sama ditambahkan dua kali ke project yang sama.
* Menyimpan role member sebagai `member` atau `klien`.
* Menyimpan waktu bergabung member melalui `joined_at`.
* Menghapus member dari project.
* Memastikan member yang akan dihapus benar-benar berada pada project tersebut.
* Menampilkan pesan error jika user tidak memiliki akses atau member tidak ditemukan.

Method:

```text
store($projectId)
remove($projectId, $memberId)
```

## Model yang sudah dibuat

```text
UserModel
ProjectModel
ProjectMemberModel
TaskModel
CommentModel
ActivityLogModel
```

Fungsi model:

* Menghubungkan controller dengan tabel database
* Menentukan nama tabel
* Menentukan kolom yang boleh diisi
* Mempermudah query database lewat CI4 Model

## Filter yang sudah dibuat

### AuthFilter

Fungsi:

* Mengecek apakah user sudah login
* Jika belum login, user diarahkan kembali ke halaman login
* Jika sudah login, user boleh mengakses route yang dilindungi

Route yang sudah memakai AuthFilter:

```text
/logout
/dashboard
/projects/create
/projects/store
/projects
/projects/{id}/archive
/projects/{id}/members
/projects/{projectId}/members/{memberId}/remove
/projects/{id}
```

## View yang sudah dibuat   

```text
auth/login.php
dashboard/index.php
projects/index.php
projects/show.php
projects/create.php
tasks/create.php
```

Fungsi view:

* login.php untuk tampilan login
* dashboard/index.php untuk halaman dashboard
* projects/index.php untuk daftar project
* projects/show.php untuk detail project
* projects/show.php untuk membuat project

## Fitur yang sudah berjalan

```text
Login
Logout
Session login
Protected route
Dashboard setelah login
Menampilkan daftar project
Menampilkan daftar project berdasarkan akses user
Menampilkan detail project
Membuat project
Membatasi pembuatan project hanya untuk admin
Koneksi database melalui model
Menambah member ke project
Membatasi pengelolaan member hanya untuk admin project
Delete member dari project
Mengarsipkan project
Membatasi archive project hanya untuk admin project
Menyembunyikan tombol aksi berdasarkan hak akses user
Menampilkan form tambah task 
Membuat task baru berdasarkan project 
Membatasi pembuatan task hanya untuk admin project 
Memvalidasi input task 
Menambahkan assignee ke task 
Membatasi assignee hanya admin project atau member project 
```

## Catatan sementara

Akun dummy (Admin):

```text
Email: admin@example.com
Password: password
```

Akun dummy (member):

```text
Email: budi@example.com
Password: password
```

Akun dummy (klien):

```text
Email: klien@example.com
Password: password
```

Project yang sudah diarsipkan tidak ditampilkan karena query memakai:

```php
where('archived_at', null)
```
