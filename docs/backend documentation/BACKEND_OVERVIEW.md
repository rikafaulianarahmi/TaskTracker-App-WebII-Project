# Backend Notes

## Routes yang sudah dibuat

```php
$routes->get('/', 'AuthController::login', ['filter' => 'guest']);
$routes->post('/login', 'AuthController::attemptLogin', ['filter' => 'guest']);
$routes->get('/logout', 'AuthController::logout', ['filter' => 'auth']);

$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'auth']);
$routes->get('/projects', 'ProjectController::index', ['filter' => 'auth']);

$routes->get('/projects/create', 'ProjectController::create', ['filter' => 'auth']);
$routes->post('/projects/store', 'ProjectController::store', ['filter' => 'auth']);

$routes->post('/projects/(:num)/archive', 'ProjectController::archive/$1', ['filter' => 'auth']);
$routes->get('/projects/(:num)/edit', 'ProjectController::edit/$1', ['filter' => 'auth']);
$routes->post('/projects/(:num)/update', 'ProjectController::update/$1', ['filter' => 'auth']);

$routes->get('/projects/(:num)', 'ProjectController::show/$1', ['filter' => 'auth']);
$routes->post('/projects/(:num)/members', 'ProjectMemberController::store/$1', ['filter' => 'auth']);
$routes->post('/projects/(:num)/members/(:num)/remove', 'ProjectMemberController::remove/$1/$2', ['filter' => 'auth']);

$routes->get('/projects/(:num)/tasks/create', 'TaskController::create/$1', ['filter' => 'auth']);
$routes->post('/projects/(:num)/tasks/store', 'TaskController::store/$1', ['filter' => 'auth']);
$routes->post('/tasks/(:num)/status', 'TaskController::updateStatus/$1', ['filter' => 'auth']);

$routes->post('/tasks/(:num)/comments', 'CommentController::store/$1', ['filter' => 'auth']);
```

* Route GET `/` digunakan untuk menampilkan halaman login, menggunakan GuestFilter agar user yang sudah login diarahkan ke dashboard.
* Route POST `/login` digunakan untuk memproses percobaan login, menggunakan GuestFilter agar user yang sudah login tidak memproses login ulang.
* Route GET `/logout` digunakan untuk keluar dari akun.
* Route GET `/dashboard` digunakan untuk menampilkan halaman dashboard.
* Route GET `/projects` digunakan untuk menampilkan daftar project.
* Route GET `/projects/create` digunakan untuk menampilkan form tambah project.
* Route POST `/projects/store` digunakan untuk menyimpan data project baru.
* Route POST `/projects/(:num)/archive` digunakan untuk mengarsipkan project berdasarkan ID.
* Route GET `/projects/(:num)/edit` digunakan untuk menampilkan form edit project berdasarkan ID project.
* Route POST `/projects/(:num)/update` digunakan untuk menyimpan perubahan data project berdasarkan ID project.
* Route GET `/projects/(:num)` digunakan untuk menampilkan detail project berdasarkan ID.
* Route POST `/projects/(:num)/members` digunakan untuk menambahkan member ke project berdasarkan ID project.
* Route POST `/projects/(:num)/members/(:num)/remove` digunakan untuk menghapus member dari project berdasarkan ID project dan ID member.
* Route GET `/projects/(:num)/tasks/create` digunakan untuk menampilkan form tambah task berdasarkan ID project.
* Route POST `/projects/(:num)/tasks/store` digunakan untuk menyimpan data task baru berdasarkan ID project.
* Route POST `/tasks/(:num)/status` digunakan untuk memperbarui status task berdasarkan ID task.
* Route POST `/tasks/(:num)/comments` digunakan untuk menyimpan komentar baru pada task berdasarkan ID task.

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
* Mencatat aktivitas user pada project melalui `logActivity()`.
* Menyimpan log aktivitas seperti aksi create, update, delete, atau aksi lainnya.
* Menyimpan informasi log berupa user, project, jenis entity, ID entity, aksi, detail, dan waktu aktivitas.

Method:

```text
getProjectAccess($projectId)
logActivity($projectId, $entityType, $entityId, $action, $detail = null)
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
* Mengirim data activity log ke view melalui variabel activityLogs.
* Mencatat activity log saat project dibuat.
* Mencatat activity log saat project diarsipkan.
* Mengirim role user dalam project ke view melalui variabel projectRole.
* Menggunakan projectRole untuk membatasi tampilan form komentar bagi user dengan role klien.

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
* Mencatat activity log saat task dibuat.
* Mencatat activity log saat status task diperbarui.

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
* Menghapus member dari project.
* Mencatat activity log saat member ditambahkan.
* Mencatat activity log saat member dihapus.
* Memastikan hanya admin project yang dapat mengelola member.
* Melakukan validasi input `user_id` dan `role`.
* Mengecek akses project melalui `getProjectAccess($projectId)`.
* Mencegah user yang sama ditambahkan dua kali ke project yang sama.
* Menyimpan role member sebagai `member` atau `klien`.
* Menyimpan waktu bergabung member melalui `joined_at`.
* Memastikan member yang akan dihapus benar-benar berada pada project tersebut.
* Menampilkan pesan error jika user tidak memiliki akses atau member tidak ditemukan.

Method:

```text
store($projectId)
remove($projectId, $memberId)
```

### CommentController

Fungsi:

* Menambahkan komentar pada task berdasarkan ID task.
* Komentar hanya dapat ditambahkan oleh admin project atau member project.
* User dengan role klien hanya dapat melihat komentar dan tidak dapat menambahkan komentar.
* Mengecek apakah task yang akan dikomentari tersedia di database.
* Menampilkan pesan error jika task tidak ditemukan.
* Mengecek akses user ke project melalui `getProjectAccess($projectId)`.
* Melakukan validasi input komentar melalui field `body`.
* Membatasi isi komentar maksimal 1000 karakter.
* Menampilkan pesan error jika validasi komentar gagal.
* Menyimpan komentar ke database.
* Menyimpan ID task melalui `task_id`.
* Menyimpan ID user yang membuat komentar melalui `user_id`.
* Menyimpan isi komentar melalui `body`.
* Menyimpan waktu komentar dibuat melalui `created_at`.
* Mengarahkan kembali ke halaman detail project setelah komentar berhasil ditambahkan.
* Mencatat activity log saat komentar ditambahkan.

Method:

```text
store($taskId)
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

* Mengecek apakah user sudah login melalui session.
* Melindungi route yang hanya boleh diakses oleh user yang sudah login.
* Jika user belum login, user diarahkan kembali ke halaman login.
* Jika user sudah login, request boleh dilanjutkan ke controller tujuan.
* Digunakan untuk mencegah akses langsung ke dashboard, project, task, member, komentar, dan logout tanpa proses login.

Route yang sudah memakai AuthFilter:

```text
/logout
/dashboard
/projects
/projects/create
/projects/store
/projects/{id}
/projects/{id}/archive
/projects/{id}/edit
/projects/{id}/update
/projects/{id}/members
/projects/{projectId}/members/{memberId}/remove
/projects/{id}/tasks/create
/projects/{id}/tasks/store
/tasks/{id}/status
/tasks/{id}/comments
```

### GuestFilter

Fungsi:

* Mengecek apakah user sudah login.
* Jika user sudah login, user diarahkan ke halaman dashboard.
* Jika user belum login, user boleh mengakses halaman login.
* Mencegah user yang sudah login membuka halaman login kembali.
* Digunakan untuk route login dan proses login.

Route yang sudah memakai GuestFilter:

```text
/
/login
```

## View yang sudah dibuat   

```text
auth/login.php
dashboard/index.php
projects/index.php
projects/show.php
projects/create.php
projects/edit.php
tasks/create.php
```

Fungsi view:

* auth/login.php digunakan untuk menampilkan halaman login.
* dashboard/index.php digunakan untuk menampilkan halaman dashboard setelah user berhasil login, termasuk ringkasan project, task, dan aktivitas terbaru.
* projects/index.php digunakan untuk menampilkan daftar project yang dapat diakses oleh user berdasarkan role sebagai admin atau member.
* projects/show.php digunakan untuk menampilkan detail project, daftar task, komentar, team members, form tambah member, tombol edit/archive project, dan activity log.
* projects/create.php digunakan untuk menampilkan form pembuatan project baru.
* projects/edit.php digunakan untuk menampilkan form edit project yang sudah ada.
* tasks/create.php digunakan untuk menampilkan form pembuatan task baru pada project tertentu.

## Fitur yang sudah berjalan

```text
Login, logout, session login, dan protected route Dashboard setelah login 
Menampilkan daftar project berdasarkan akses user sebagai admin atau member 
Menampilkan detail project beserta member, task, komentar, dan activity log 
Membuat project, mengedit, mengarsip dengan batasan hanya untuk user role admin 
Mencatat activity log saat project dibuat 
Mencatat activity log saat project diarsipkan 
Menambah dan menghapus member dengan batasan hanya untuk admin project 
Membuat task baru berdasarkan project dengan batasan hanya untuk admin project 
Mencatat activity log saat task dibuat 
Menambahkan assignee ke task dari admin atau member project 
Memvalidasi input project, member, task, status task, dan komentar 
Menampilkan task beserta status, priority, deadline, assignee, dan pembuat task 
Mengubah status task dengan batasan hanya untuk admin project atau assignee 
Mencatat activity log saat status task diperbarui 
Menampilkan komentar pada setiap task
Menambahkan komentar hanya untuk admin project dan member project
Menyembunyikan form komentar untuk user dengan role klien
Mencatat activity log saat komentar ditambahkan 
Menampilkan riwayat activity log berdasarkan aktivitas terbaru 
Menyembunyikan tombol aksi berdasarkan hak akses user Koneksi database melalui model dan query builder
Mencegah user yang sudah login mengakses halaman login kembali menggunakan GuestFilter.
User yang sudah login otomatis diarahkan ke dashboard jika membuka halaman login.
```

### Activity Log

Fungsi:

* Mencatat aktivitas user yang terjadi di dalam project.
* Menyimpan riwayat aktivitas agar perubahan pada project dapat dilihat kembali.
* Menampilkan daftar aktivitas pada halaman detail project.
* Mengambil data activity log berdasarkan project_id.
* Menghubungkan activity log dengan tabel users untuk menampilkan nama user yang melakukan aktivitas.
* Mengurutkan activity log berdasarkan waktu terbaru menggunakan created_at DESC.

#### Data yang dicatat:

```text
user_id yaitu ID user yang melakukan aktivitas.
project_id yaitu ID project tempat aktivitas terjadi.
entity_type yaitu jenis data yang terkena aktivitas, seperti project, member, task, atau comment.
entity_id yaitu ID dari data yang terkena aktivitas.
action yaitu aksi yang dilakukan, seperti created, archived, atau status_updated.
detail yaitu keterangan tambahan dari aktivitas.
created_at yaitu waktu aktivitas dilakukan.
```

#### Aktivitas yang dicatat:

```text
Project dibuat.
Project diarsipkan.
Member ditambahkan ke project.
Member dihapus dari project.
Task dibuat.
Status task diperbarui.
Komentar ditambahkan pada task.
```

#### Controller yang menggunakan Activity Log:

```text
BaseController menyediakan method logActivity() untuk menyimpan activity log.
ProjectController mencatat aktivitas saat project dibuat dan diarsipkan.
TaskController mencatat aktivitas saat task dibuat dan status task diperbarui.
CommentController mencatat aktivitas saat komentar ditambahkan.
```

Method:

```text
logActivity($projectId, $entityType, $entityId, $action, $detail = null)
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
