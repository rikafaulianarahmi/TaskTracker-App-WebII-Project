-- ============================================================
--  VERIFICATION SCRIPT
--  Manajemen Proyek Tim Kecil
--  Jalankan setelah: php spark migrate && php spark db:seed InitialSeeder
-- ============================================================

USE tasktracker;

-- ============================================================
--  1. VERIFY FOREIGN KEYS
--     Cek semua FK yang terdaftar di database
-- ============================================================

SELECT
    TABLE_NAME                AS `Tabel`,
    COLUMN_NAME               AS `Kolom FK`,
    CONSTRAINT_NAME           AS `Nama Constraint`,
    REFERENCED_TABLE_NAME     AS `Tabel Referensi`,
    REFERENCED_COLUMN_NAME    AS `Kolom Referensi`
FROM
    INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE
    TABLE_SCHEMA = DATABASE()
    AND REFERENCED_TABLE_NAME IS NOT NULL
ORDER BY
    TABLE_NAME, COLUMN_NAME;

-- ── Expected output: 9 FK ────────────────────────────────────
-- projects      | admin_id    | -> users.id
-- tasks         | project_id  | -> projects.id
-- tasks         | created_by  | -> users.id
-- tasks         | assignee_id | -> users.id
-- project_members | project_id | -> projects.id
-- project_members | user_id   | -> users.id
-- comments      | task_id     | -> tasks.id
-- comments      | user_id     | -> users.id
-- activity_logs | user_id     | -> users.id
-- activity_logs | project_id  | -> projects.id


-- ============================================================
--  2. VERIFY ON DELETE / ON UPDATE RULES
--     Pastikan CASCADE, SET NULL, RESTRICT sudah benar
-- ============================================================

SELECT
    kcu.TABLE_NAME      AS `Tabel`,
    kcu.COLUMN_NAME     AS `Kolom`,
    rc.CONSTRAINT_NAME  AS `Constraint`,
    rc.DELETE_RULE      AS `ON DELETE`,
    rc.UPDATE_RULE      AS `ON UPDATE`
FROM
    INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS rc
JOIN
    INFORMATION_SCHEMA.KEY_COLUMN_USAGE kcu
    ON rc.CONSTRAINT_NAME = kcu.CONSTRAINT_NAME
    AND rc.CONSTRAINT_SCHEMA = kcu.TABLE_SCHEMA
WHERE
    rc.CONSTRAINT_SCHEMA = DATABASE()
ORDER BY
    kcu.TABLE_NAME;

-- ── Expected rules ───────────────────────────────────────────
-- projects.admin_id    | ON DELETE RESTRICT  | ON UPDATE CASCADE
-- tasks.project_id     | ON DELETE CASCADE   | ON UPDATE CASCADE
-- tasks.created_by     | ON DELETE RESTRICT  | ON UPDATE CASCADE
-- tasks.assignee_id    | ON DELETE SET NULL  | ON UPDATE CASCADE
-- project_members.*    | ON DELETE CASCADE   | ON UPDATE CASCADE
-- comments.task_id     | ON DELETE CASCADE   | ON UPDATE CASCADE
-- comments.user_id     | ON DELETE RESTRICT  | ON UPDATE CASCADE
-- activity_logs.user_id    | ON DELETE RESTRICT | ON UPDATE CASCADE
-- activity_logs.project_id | ON DELETE SET NULL | ON UPDATE CASCADE


-- ============================================================
--  3. VERIFY INDEXES
--     Cek semua index: PRIMARY, UNIQUE, FK index
-- ============================================================

SELECT
    TABLE_NAME   AS `Tabel`,
    INDEX_NAME   AS `Nama Index`,
    COLUMN_NAME  AS `Kolom`,
    NON_UNIQUE   AS `Non-Unique (0=UNIQUE)`,
    INDEX_TYPE   AS `Tipe`
FROM
    INFORMATION_SCHEMA.STATISTICS
WHERE
    TABLE_SCHEMA = DATABASE()
ORDER BY
    TABLE_NAME, INDEX_NAME;

-- ── Expected indexes ─────────────────────────────────────────
-- users             | PRIMARY          | id        | UNIQUE
-- users             | email            | email     | UNIQUE
-- projects          | PRIMARY          | id        | UNIQUE
-- projects          | admin_id         | admin_id  | (FK index)
-- tasks             | PRIMARY          | id        | UNIQUE
-- tasks             | project_id       | project_id
-- tasks             | created_by       | created_by
-- tasks             | assignee_id      | assignee_id
-- project_members   | PRIMARY          | id        | UNIQUE
-- project_members   | project_id_user_id | (composite UNIQUE)
-- comments          | PRIMARY          | id        | UNIQUE
-- activity_logs     | PRIMARY          | id        | UNIQUE


-- ============================================================
--  4. VERIFY UNIQUE CONSTRAINTS
--     Khusus cek UNIQUE keys saja
-- ============================================================

SELECT
    TABLE_NAME   AS `Tabel`,
    INDEX_NAME   AS `Nama Constraint`,
    COLUMN_NAME  AS `Kolom`
FROM
    INFORMATION_SCHEMA.STATISTICS
WHERE
    TABLE_SCHEMA = DATABASE()
    AND NON_UNIQUE = 0
    AND INDEX_NAME != 'PRIMARY'
ORDER BY
    TABLE_NAME;

-- ── Expected: 2 UNIQUE constraints ──────────────────────────
-- users           | email              | email
-- project_members | project_id_user_id | project_id + user_id


-- ============================================================
--  5. VERIFY TABLE STRUCTURE (COLUMNS & DATA TYPES)
--     Cek kolom, tipe, nullable, default per tabel
-- ============================================================

SELECT
    TABLE_NAME      AS `Tabel`,
    COLUMN_NAME     AS `Kolom`,
    COLUMN_TYPE     AS `Tipe`,
    IS_NULLABLE     AS `Nullable`,
    COLUMN_DEFAULT  AS `Default`,
    COLUMN_KEY      AS `Key (PRI/UNI/MUL)`
FROM
    INFORMATION_SCHEMA.COLUMNS
WHERE
    TABLE_SCHEMA = DATABASE()
ORDER BY
    TABLE_NAME, ORDINAL_POSITION;


-- ============================================================
--  6. VERIFY DATA INTEGRITY (setelah seeding)
--     Pastikan semua FK reference valid, tidak ada orphan data
-- ============================================================

-- 6a. Orphan tasks (project_id tidak ada di projects)
SELECT 'Orphan tasks (project_id)' AS `Check`, COUNT(*) AS `Jumlah`
FROM tasks t
LEFT JOIN projects p ON t.project_id = p.id
WHERE p.id IS NULL;

-- 6b. Orphan tasks (created_by tidak ada di users)
SELECT 'Orphan tasks (created_by)' AS `Check`, COUNT(*) AS `Jumlah`
FROM tasks t
LEFT JOIN users u ON t.created_by = u.id
WHERE u.id IS NULL;

-- 6c. Orphan tasks (assignee_id tidak ada di users, exclude NULL)
SELECT 'Orphan tasks (assignee_id)' AS `Check`, COUNT(*) AS `Jumlah`
FROM tasks t
LEFT JOIN users u ON t.assignee_id = u.id
WHERE t.assignee_id IS NOT NULL AND u.id IS NULL;

-- 6d. Orphan comments (task_id tidak ada di tasks)
SELECT 'Orphan comments (task_id)' AS `Check`, COUNT(*) AS `Jumlah`
FROM comments c
LEFT JOIN tasks t ON c.task_id = t.id
WHERE t.id IS NULL;

-- 6e. Orphan project_members (project_id tidak ada di projects)
SELECT 'Orphan members (project_id)' AS `Check`, COUNT(*) AS `Jumlah`
FROM project_members pm
LEFT JOIN projects p ON pm.project_id = p.id
WHERE p.id IS NULL;

-- 6f. Duplicate keanggotaan (harusnya 0 karena ada UNIQUE constraint)
SELECT 'Duplicate project_members' AS `Check`, COUNT(*) AS `Jumlah`
FROM (
    SELECT project_id, user_id, COUNT(*) AS cnt
    FROM project_members
    GROUP BY project_id, user_id
    HAVING cnt > 1
) AS dupes;

-- 6g. Orphan activity_logs (user_id tidak ada di users)
SELECT 'Orphan activity_logs (user_id)' AS `Check`, COUNT(*) AS `Jumlah`
FROM activity_logs al
LEFT JOIN users u ON al.user_id = u.id
WHERE u.id IS NULL;

-- ── Expected: semua hasil di atas = 0 ────────────────────────


-- ============================================================
--  7. VERIFY ENUM VALUES
--     Pastikan tidak ada nilai di luar enum yang didefinisikan
-- ============================================================

-- 7a. users.role
SELECT 'Invalid users.role' AS `Check`, COUNT(*) AS `Jumlah`
FROM users
WHERE role NOT IN ('admin', 'member', 'klien');

-- 7b. projects.status
SELECT 'Invalid projects.status' AS `Check`, COUNT(*) AS `Jumlah`
FROM projects
WHERE status NOT IN ('active', 'completed');

-- 7c. tasks.status
SELECT 'Invalid tasks.status' AS `Check`, COUNT(*) AS `Jumlah`
FROM tasks
WHERE status NOT IN ('todo', 'in_progress', 'done');

-- 7d. tasks.priority
SELECT 'Invalid tasks.priority' AS `Check`, COUNT(*) AS `Jumlah`
FROM tasks
WHERE priority NOT IN ('low', 'medium', 'high');

-- 7e. project_members.role
SELECT 'Invalid members.role' AS `Check`, COUNT(*) AS `Jumlah`
FROM project_members
WHERE role NOT IN ('member', 'klien');

-- 7f. activity_logs.action
SELECT 'Invalid logs.action' AS `Check`, COUNT(*) AS `Jumlah`
FROM activity_logs
WHERE action NOT IN ('created', 'updated', 'deleted', 'status_changed', 'archived');

-- 7g. activity_logs.entity_type
SELECT 'Invalid logs.entity_type' AS `Check`, COUNT(*) AS `Jumlah`
FROM activity_logs
WHERE entity_type NOT IN ('project', 'task', 'comment', 'member');

-- ── Expected: semua hasil di atas = 0 ────────────────────────


-- ============================================================
--  8. QUICK SANITY CHECK — ROW COUNTS
--     Verifikasi jumlah data setelah seeding
-- ============================================================

SELECT 'users'           AS `Tabel`, COUNT(*) AS `Jumlah Row` FROM users
UNION ALL
SELECT 'projects',        COUNT(*) FROM projects
UNION ALL
SELECT 'tasks',           COUNT(*) FROM tasks
UNION ALL
SELECT 'project_members', COUNT(*) FROM project_members
UNION ALL
SELECT 'comments',        COUNT(*) FROM comments
UNION ALL
SELECT 'activity_logs',   COUNT(*) FROM activity_logs;

-- ── Expected setelah InitialSeeder ──────────────────────────
-- users           | 5
-- projects        | 3
-- tasks           | 9
-- project_members | 8
-- comments        | 8
-- activity_logs   | 15


-- ============================================================
--  9. ADDITIONAL INDEXES (REKOMENDASI PERFORMA)
--     Jalankan jika belum ada, untuk query yang sering dipakai
-- ============================================================

-- Index untuk filter task by status (Kanban board)
CREATE INDEX IF NOT EXISTS idx_tasks_status
    ON tasks (status);

-- Index untuk filter task by deadline (deadline alert)
CREATE INDEX IF NOT EXISTS idx_tasks_deadline
    ON tasks (deadline);

-- Index untuk filter projects yang belum diarsip
CREATE INDEX IF NOT EXISTS idx_projects_archived_at
    ON projects (archived_at);

-- Index untuk query activity log per proyek (dashboard log)
CREATE INDEX IF NOT EXISTS idx_logs_project_id
    ON activity_logs (project_id);

-- Index untuk query activity log per entity (polimorfik lookup)
CREATE INDEX IF NOT EXISTS idx_logs_entity
    ON activity_logs (entity_type, entity_id);