<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        // users 
        // Password semua akun: "password"
        $hashedPassword = password_hash('password', PASSWORD_BCRYPT);

        $users = [
            // Admin
            [
                'id'         => 1,
                'name'       => 'Arif Wicaksono',
                'email'      => 'admin@example.com',
                'password'   => $hashedPassword,
                'role'       => 'admin',
                'avatar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Members
            [
                'id'         => 2,
                'name'       => 'Budi Santoso',
                'email'      => 'budi@example.com',
                'password'   => $hashedPassword,
                'role'       => 'member',
                'avatar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'         => 3,
                'name'       => 'Citra Dewi',
                'email'      => 'citra@example.com',
                'password'   => $hashedPassword,
                'role'       => 'member',
                'avatar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'         => 4,
                'name'       => 'Dimas Prasetyo',
                'email'      => 'dimas@example.com',
                'password'   => $hashedPassword,
                'role'       => 'member',
                'avatar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Klien
            [
                'id'         => 5,
                'name'       => 'PT Maju Bersama',
                'email'      => 'klien@example.com',
                'password'   => $hashedPassword,
                'role'       => 'klien',
                'avatar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        $this->db->table('users')->insertBatch($users);

        // projects 
        $projects = [
            [
                'id'          => 1,
                'title'       => 'Redesign Website Company Profile',
                'description' => 'Pembaruan tampilan website perusahaan dengan desain modern dan responsif menggunakan Tailwind CSS.',
                'admin_id'    => 1,
                'status'      => 'active',
                'archived_at' => null,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 2,
                'title'       => 'Aplikasi Kasir Toko',
                'description' => 'Sistem point-of-sale sederhana untuk toko retail dengan fitur inventaris dan laporan penjualan harian.',
                'admin_id'    => 1,
                'status'      => 'active',
                'archived_at' => null,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 3,
                'title'       => 'Migrasi Server Lama',
                'description' => 'Pemindahan semua layanan dari server lama ke VPS baru dengan konfigurasi Nginx + Docker.',
                'admin_id'    => 1,
                'status'      => 'completed',
                'archived_at' => date('Y-m-d H:i:s', strtotime('-7 days')),
                'created_at'  => date('Y-m-d H:i:s', strtotime('-30 days')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-7 days')),
            ],
        ];

        $this->db->table('projects')->insertBatch($projects);

        // project_members
        $members = [
            // Proyek 1: Redesign Website
            ['project_id' => 1, 'user_id' => 2, 'role' => 'member', 'joined_at' => $now], // Budi
            ['project_id' => 1, 'user_id' => 3, 'role' => 'member', 'joined_at' => $now], // Citra
            ['project_id' => 1, 'user_id' => 5, 'role' => 'klien',  'joined_at' => $now], // PT Maju Bersama

            // Proyek 2: Aplikasi Kasir
            ['project_id' => 2, 'user_id' => 2, 'role' => 'member', 'joined_at' => $now], // Budi
            ['project_id' => 2, 'user_id' => 4, 'role' => 'member', 'joined_at' => $now], // Dimas
            ['project_id' => 2, 'user_id' => 5, 'role' => 'klien',  'joined_at' => $now], // PT Maju Bersama

            // Proyek 3: Migrasi Server (sudah archived)
            ['project_id' => 3, 'user_id' => 3, 'role' => 'member', 'joined_at' => date('Y-m-d H:i:s', strtotime('-30 days'))],
            ['project_id' => 3, 'user_id' => 4, 'role' => 'member', 'joined_at' => date('Y-m-d H:i:s', strtotime('-30 days'))],
        ];

        $this->db->table('project_members')->insertBatch($members);

        // tasks
        $tasks = [
            //  Proyek 1: Redesign Website 
            [
                'id'          => 1,
                'project_id'  => 1,
                'title'       => 'Buat wireframe halaman utama',
                'description' => 'Desain wireframe low-fidelity untuk halaman landing page dan about us.',
                'created_by'  => 1, // Admin
                'assignee_id' => 3, // Citra
                'status'      => 'done',
                'priority'    => 'high',
                'deadline'    => date('Y-m-d', strtotime('-5 days')),
                'created_at'  => date('Y-m-d H:i:s', strtotime('-14 days')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-6 days')),
                'archived_at' => null,
            ],
            [
                'id'          => 2,
                'project_id'  => 1,
                'title'       => 'Implementasi halaman Hero & Navbar',
                'description' => 'Coding section hero dengan animasi dan navbar responsif menggunakan Tailwind CSS.',
                'created_by'  => 1,
                'assignee_id' => 2, // Budi
                'status'      => 'in_progress',
                'priority'    => 'high',
                'deadline'    => date('Y-m-d', strtotime('+3 days')),
                'created_at'  => date('Y-m-d H:i:s', strtotime('-7 days')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-1 days')),
                'archived_at' => null,
            ],
            [
                'id'          => 3,
                'project_id'  => 1,
                'title'       => 'Integrasi form kontak ke backend',
                'description' => 'Sambungkan form kontak di frontend ke endpoint CI4 dan kirim notifikasi email.',
                'created_by'  => 1,
                'assignee_id' => 2, // Budi
                'status'      => 'todo',
                'priority'    => 'medium',
                'deadline'    => date('Y-m-d', strtotime('+10 days')),
                'created_at'  => date('Y-m-d H:i:s', strtotime('-3 days')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-3 days')),
                'archived_at' => null,
            ],
            [
                'id'          => 4,
                'project_id'  => 1,
                'title'       => 'Testing cross-browser & responsivitas',
                'description' => 'Uji tampilan di Chrome, Firefox, Safari, dan perangkat mobile.',
                'created_by'  => 1,
                'assignee_id' => null, // Belum di-assign
                'status'      => 'todo',
                'priority'    => 'low',
                'deadline'    => date('Y-m-d', strtotime('+14 days')),
                'created_at'  => date('Y-m-d H:i:s', strtotime('-2 days')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-2 days')),
                'archived_at' => null,
            ],

            //  Proyek 2: Aplikasi Kasir 
            [
                'id'          => 5,
                'project_id'  => 2,
                'title'       => 'Setup database produk & kategori',
                'description' => 'Buat migrasi dan seeder untuk tabel produk, kategori, dan satuan.',
                'created_by'  => 1,
                'assignee_id' => 4, // Dimas
                'status'      => 'done',
                'priority'    => 'high',
                'deadline'    => date('Y-m-d', strtotime('-10 days')),
                'created_at'  => date('Y-m-d H:i:s', strtotime('-20 days')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-11 days')),
                'archived_at' => null,
            ],
            [
                'id'          => 6,
                'project_id'  => 2,
                'title'       => 'Halaman transaksi penjualan',
                'description' => 'UI input transaksi: scan barcode, pilih produk, hitung kembalian.',
                'created_by'  => 1,
                'assignee_id' => 2, // Budi
                'status'      => 'in_progress',
                'priority'    => 'high',
                'deadline'    => date('Y-m-d', strtotime('+5 days')),
                'created_at'  => date('Y-m-d H:i:s', strtotime('-10 days')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-2 days')),
                'archived_at' => null,
            ],
            [
                'id'          => 7,
                'project_id'  => 2,
                'title'       => 'Laporan penjualan harian & bulanan',
                'description' => 'Generate laporan dengan filter tanggal dan export ke PDF.',
                'created_by'  => 1,
                'assignee_id' => 4, // Dimas
                'status'      => 'todo',
                'priority'    => 'medium',
                'deadline'    => date('Y-m-d', strtotime('+20 days')),
                'created_at'  => date('Y-m-d H:i:s', strtotime('-5 days')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-5 days')),
                'archived_at' => null,
            ],

            //  Proyek 3: Migrasi Server (archived, semua done) 
            [
                'id'          => 8,
                'project_id'  => 3,
                'title'       => 'Setup VPS dan konfigurasi Nginx',
                'description' => 'Provisioning VPS baru, install Nginx, dan konfigurasi virtual host.',
                'created_by'  => 1,
                'assignee_id' => 4, // Dimas
                'status'      => 'done',
                'priority'    => 'high',
                'deadline'    => date('Y-m-d', strtotime('-20 days')),
                'created_at'  => date('Y-m-d H:i:s', strtotime('-30 days')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-20 days')),
                'archived_at' => date('Y-m-d H:i:s', strtotime('-10 days')),
            ],
            [
                'id'          => 9,
                'project_id'  => 3,
                'title'       => 'Migrasi database dan backup',
                'description' => 'Dump database lama, import ke server baru, verifikasi integritas data.',
                'created_by'  => 1,
                'assignee_id' => 3, // Citra
                'status'      => 'done',
                'priority'    => 'high',
                'deadline'    => date('Y-m-d', strtotime('-15 days')),
                'created_at'  => date('Y-m-d H:i:s', strtotime('-28 days')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-15 days')),
                'archived_at' => date('Y-m-d H:i:s', strtotime('-10 days')),
            ],
        ];

        $this->db->table('tasks')->insertBatch($tasks);

        //  5. comments 
        $comments = [
            // Task 1: Wireframe (done)
            [
                'task_id'    => 1,
                'user_id'    => 3, // Citra
                'body'       => 'Wireframe sudah selesai, silakan direview pak. Ada 5 versi alternatif layout.',
                'created_at' => date('Y-m-d H:i:s', strtotime('-8 days')),
            ],
            [
                'task_id'    => 1,
                'user_id'    => 1, // Admin
                'body'       => 'Bagus, pakai versi ke-3. Warna header disesuaikan dengan brand guideline ya.',
                'created_at' => date('Y-m-d H:i:s', strtotime('-7 days')),
            ],
            [
                'task_id'    => 1,
                'user_id'    => 3,
                'body'       => 'Siap, sudah disesuaikan. Task ini bisa ditandai selesai.',
                'created_at' => date('Y-m-d H:i:s', strtotime('-6 days')),
            ],

            // Task 2: Hero & Navbar (in_progress)
            [
                'task_id'    => 2,
                'user_id'    => 2, // Budi
                'body'       => 'Navbar sudah responsif. Sekarang lagi ngerjain animasi hero section.',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
            ],
            [
                'task_id'    => 2,
                'user_id'    => 1,
                'body'       => 'Oke, jangan lupa tambahkan smooth scroll ke setiap anchor link.',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 days')),
            ],

            // Task 6: Halaman transaksi (in_progress)
            [
                'task_id'    => 6,
                'user_id'    => 2, // Budi
                'body'       => 'Fitur pilih produk sudah jalan. Sekarang lagi integrasi logika kembalian.',
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
            ],
            [
                'task_id'    => 6,
                'user_id'    => 4, // Dimas
                'body'       => 'Kalau butuh referensi struktur datanya bisa lihat di tabel transactions yang aku buat kemarin.',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
            ],

            // Task 8: Setup VPS (done, proyek archived)
            [
                'task_id'    => 8,
                'user_id'    => 4,
                'body'       => 'VPS sudah up, Nginx sudah dikonfigurasi dengan SSL dari Let\'s Encrypt.',
                'created_at' => date('Y-m-d H:i:s', strtotime('-21 days')),
            ],
        ];

        $this->db->table('comments')->insertBatch($comments);

        //  6. activity_logs 
        $logs = [
            // Proyek dibuat
            [
                'user_id'     => 1,
                'project_id'  => 1,
                'entity_type' => 'project',
                'entity_id'   => 1,
                'action'      => 'created',
                'detail'      => null,
                'created_at'  => date('Y-m-d H:i:s', strtotime('-14 days')),
            ],
            [
                'user_id'     => 1,
                'project_id'  => 2,
                'entity_type' => 'project',
                'entity_id'   => 2,
                'action'      => 'created',
                'detail'      => null,
                'created_at'  => date('Y-m-d H:i:s', strtotime('-20 days')),
            ],

            // Task dibuat
            [
                'user_id'     => 1,
                'project_id'  => 1,
                'entity_type' => 'task',
                'entity_id'   => 1,
                'action'      => 'created',
                'detail'      => 'Buat wireframe halaman utama',
                'created_at'  => date('Y-m-d H:i:s', strtotime('-14 days')),
            ],
            [
                'user_id'     => 1,
                'project_id'  => 1,
                'entity_type' => 'task',
                'entity_id'   => 2,
                'action'      => 'created',
                'detail'      => 'Implementasi halaman Hero & Navbar',
                'created_at'  => date('Y-m-d H:i:s', strtotime('-7 days')),
            ],
            [
                'user_id'     => 1,
                'project_id'  => 2,
                'entity_type' => 'task',
                'entity_id'   => 5,
                'action'      => 'created',
                'detail'      => 'Setup database produk & kategori',
                'created_at'  => date('Y-m-d H:i:s', strtotime('-20 days')),
            ],

            // Update status task
            [
                'user_id'     => 3, // Citra
                'project_id'  => 1,
                'entity_type' => 'task',
                'entity_id'   => 1,
                'action'      => 'status_changed',
                'detail'      => 'status: todo -> in_progress',
                'created_at'  => date('Y-m-d H:i:s', strtotime('-10 days')),
            ],
            [
                'user_id'     => 3,
                'project_id'  => 1,
                'entity_type' => 'task',
                'entity_id'   => 1,
                'action'      => 'status_changed',
                'detail'      => 'status: in_progress -> done',
                'created_at'  => date('Y-m-d H:i:s', strtotime('-6 days')),
            ],
            [
                'user_id'     => 2, // Budi
                'project_id'  => 1,
                'entity_type' => 'task',
                'entity_id'   => 2,
                'action'      => 'status_changed',
                'detail'      => 'status: todo -> in_progress',
                'created_at'  => date('Y-m-d H:i:s', strtotime('-4 days')),
            ],
            [
                'user_id'     => 4, // Dimas
                'project_id'  => 2,
                'entity_type' => 'task',
                'entity_id'   => 5,
                'action'      => 'status_changed',
                'detail'      => 'status: todo -> in_progress',
                'created_at'  => date('Y-m-d H:i:s', strtotime('-15 days')),
            ],
            [
                'user_id'     => 4,
                'project_id'  => 2,
                'entity_type' => 'task',
                'entity_id'   => 5,
                'action'      => 'status_changed',
                'detail'      => 'status: in_progress -> done',
                'created_at'  => date('Y-m-d H:i:s', strtotime('-11 days')),
            ],

            // Anggota ditambahkan
            [
                'user_id'     => 1,
                'project_id'  => 1,
                'entity_type' => 'member',
                'entity_id'   => 2, // user_id Budi
                'action'      => 'created',
                'detail'      => 'Budi Santoso ditambahkan sebagai member',
                'created_at'  => date('Y-m-d H:i:s', strtotime('-14 days')),
            ],
            [
                'user_id'     => 1,
                'project_id'  => 1,
                'entity_type' => 'member',
                'entity_id'   => 5, // user_id Klien
                'action'      => 'created',
                'detail'      => 'PT Maju Bersama ditambahkan sebagai klien',
                'created_at'  => date('Y-m-d H:i:s', strtotime('-13 days')),
            ],

            // Proyek diarsip
            [
                'user_id'     => 1,
                'project_id'  => 3,
                'entity_type' => 'project',
                'entity_id'   => 3,
                'action'      => 'archived',
                'detail'      => 'Proyek selesai dan diarsipkan',
                'created_at'  => date('Y-m-d H:i:s', strtotime('-7 days')),
            ],

            // Komentar ditambahkan
            [
                'user_id'     => 3,
                'project_id'  => 1,
                'entity_type' => 'comment',
                'entity_id'   => 1,
                'action'      => 'created',
                'detail'      => 'Komentar pada task: Buat wireframe halaman utama',
                'created_at'  => date('Y-m-d H:i:s', strtotime('-8 days')),
            ],
            [
                'user_id'     => 2,
                'project_id'  => 1,
                'entity_type' => 'comment',
                'entity_id'   => 4,
                'action'      => 'created',
                'detail'      => 'Komentar pada task: Implementasi halaman Hero & Navbar',
                'created_at'  => date('Y-m-d H:i:s', strtotime('-2 days')),
            ],
        ];

        $this->db->table('activity_logs')->insertBatch($logs);
    }
}