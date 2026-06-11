<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixForeignKeysAndAddIndexes extends Migration
{
        private array $restrictFKs = [
        [
            'table'      => 'projects',
            'column'     => 'admin_id',
            'constraint' => 'projects_admin_id_foreign',
            'ref_table'  => 'users',
            'ref_column' => 'id',
            'on_delete'  => 'RESTRICT',
            'on_update'  => 'CASCADE',
        ],
        [
            'table'      => 'tasks',
            'column'     => 'created_by',
            'constraint' => 'tasks_created_by_foreign',
            'ref_table'  => 'users',
            'ref_column' => 'id',
            'on_delete'  => 'RESTRICT',
            'on_update'  => 'CASCADE',
        ],
        [
            'table'      => 'comments',
            'column'     => 'user_id',
            'constraint' => 'comments_user_id_foreign',
            'ref_table'  => 'users',
            'ref_column' => 'id',
            'on_delete'  => 'RESTRICT',
            'on_update'  => 'CASCADE',
        ],
        [
            'table'      => 'activity_logs',
            'column'     => 'user_id',
            'constraint' => 'activity_logs_user_id_foreign',
            'ref_table'  => 'users',
            'ref_column' => 'id',
            'on_delete'  => 'RESTRICT',
            'on_update'  => 'CASCADE',
        ],
    ];

    private array $indexes = [
        [
            'name'   => 'idx_tasks_status',
            'table'  => 'tasks',
            'column' => 'status',
        ],
        [
            'name'   => 'idx_tasks_deadline',
            'table'  => 'tasks',
            'column' => 'deadline',
        ],
        [
            'name'   => 'idx_projects_archived_at',
            'table'  => 'projects',
            'column' => 'archived_at',
        ],
        [
            'name'   => 'idx_logs_project_id',
            'table'  => 'activity_logs',
            'column' => 'project_id',
        ],
    ];
 
    private array $compositeIndexes = [
        [
            'name'    => 'idx_logs_entity',
            'table'   => 'activity_logs',
            'columns' => ['entity_type', 'entity_id'],
        ],
    ];
 
    public function up()
    {
        // Fix ON DELETE Rules (CASCADE -> RESTRICT) 
        foreach ($this->restrictFKs as $fk) {
            $this->db->query("
                ALTER TABLE `{$fk['table']}`
                DROP FOREIGN KEY `{$fk['constraint']}`
            ");
 
            $this->db->query("
                ALTER TABLE `{$fk['table']}`
                ADD CONSTRAINT `{$fk['constraint']}`
                FOREIGN KEY (`{$fk['column']}`)
                REFERENCES `{$fk['ref_table']}` (`{$fk['ref_column']}`)
                ON DELETE {$fk['on_delete']}
                ON UPDATE {$fk['on_update']}
            ");
        }
 
        //  Add Performance Indexes (single column) 
        foreach ($this->indexes as $index) {
            $exists = $this->db->query("
                SELECT COUNT(*) AS cnt
                FROM INFORMATION_SCHEMA.STATISTICS
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME   = '{$index['table']}'
                  AND INDEX_NAME   = '{$index['name']}'
            ")->getRow()->cnt;
 
            if (! $exists) {
                $this->db->query("
                    CREATE INDEX `{$index['name']}`
                    ON `{$index['table']}` (`{$index['column']}`)
                ");
            }
        }
 
        //  Add Composite Index (multi-column) 
        foreach ($this->compositeIndexes as $index) {
            $exists = $this->db->query("
                SELECT COUNT(*) AS cnt
                FROM INFORMATION_SCHEMA.STATISTICS
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME   = '{$index['table']}'
                  AND INDEX_NAME   = '{$index['name']}'
            ")->getRow()->cnt;
 
            if (! $exists) {
                $cols = implode('`, `', $index['columns']);
                $this->db->query("
                    CREATE INDEX `{$index['name']}`
                    ON `{$index['table']}` (`{$cols}`)
                ");
            }
        }
    }
 
    // 
    public function down()
    {
        // Disable foreign key checks to allow index dropping
        $this->db->query("SET FOREIGN_KEY_CHECKS=0");
        //  Drop performance indexes (single column) 
        foreach ($this->indexes as $index) {
            $exists = $this->db->query("
                SELECT COUNT(*) AS cnt
                FROM INFORMATION_SCHEMA.STATISTICS
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME   = '{$index['table']}'
                  AND INDEX_NAME   = '{$index['name']}'
            ")->getRow()->cnt;
 
            if ($exists) {
                $this->db->query("
                    DROP INDEX `{$index['name']}`
                    ON `{$index['table']}`
                ");
            }
        }
 
        //  Drop composite indexes 
        foreach ($this->compositeIndexes as $index) {
            $exists = $this->db->query("
                SELECT COUNT(*) AS cnt
                FROM INFORMATION_SCHEMA.STATISTICS
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME   = '{$index['table']}'
                  AND INDEX_NAME   = '{$index['name']}'
            ")->getRow()->cnt;
 
            if ($exists) {
                $this->db->query("
                    DROP INDEX `{$index['name']}`
                    ON `{$index['table']}`
                ");
            }
        }

        //  Revert foreign key constraints to CASCADE (original state) 
        foreach ($this->restrictFKs as $fk) {
            $this->db->query("
                ALTER TABLE `{$fk['table']}`
                DROP FOREIGN KEY IF EXISTS `{$fk['constraint']}`
            ");
 
            $this->db->query("
                ALTER TABLE `{$fk['table']}`
                ADD CONSTRAINT `{$fk['constraint']}`
                FOREIGN KEY (`{$fk['column']}`)
                REFERENCES `{$fk['ref_table']}` (`{$fk['ref_column']}`)
                ON DELETE CASCADE
                ON UPDATE CASCADE
            ");
        }

        // Re-enable foreign key checks
        $this->db->query("SET FOREIGN_KEY_CHECKS=1");
    }
}
