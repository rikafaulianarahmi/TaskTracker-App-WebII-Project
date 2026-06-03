# Backend Notes

## Routes yang sudah dibuat

```php
$routes->get('/', 'AuthController::login');
$routes->post('/login', 'AuthController::attemptLogin');

$routes->get('/logout', 'AuthController::logout', ['filter' => 'auth']);
$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'auth']);

$routes->get('/projects', 'ProjectController::index', ['filter' => 'auth']);
$routes->get('/projects/(:num)', 'ProjectController::show/$1', ['filter' => 'auth']);
```

## Controller yang sudah dibuat

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

* Menampilkan daftar project
* Menampilkan detail satu project berdasarkan id
* Hanya menampilkan project yang belum diarsipkan

Method:

```text
index()
show($id)
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
/projects
/projects/{id}
```

## View yang sudah dibuat

```text
auth/login.php
dashboard/index.php
projects/index.php
projects/show.php
```

Fungsi view:

* login.php untuk tampilan login
* dashboard/index.php untuk halaman dashboard
* projects/index.php untuk daftar project
* projects/show.php untuk detail project

## Fitur yang sudah berjalan

```text
Login
Logout
Session login
Protected route
Dashboard setelah login
Menampilkan daftar project
Menampilkan detail project
Koneksi database melalui model
```

## Catatan sementara

Akun dummy:

```text
Email: admin@test.com
Password: password
```

Project yang sudah diarsipkan tidak ditampilkan karena query memakai:

```php
where('archived_at', null)
```
