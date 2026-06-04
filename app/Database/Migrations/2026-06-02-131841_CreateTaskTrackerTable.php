<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTaskTrackerTable extends Migration
{
    public function up()
    {
        // users 
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => false,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'member', 'klien'],
                'default'    => 'member',
                'null'       => false,
            ],
            'avatar' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'default'    => null,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('users', true);

        // projects 
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => false,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
                'default' => null,
            ],
            'admin_id' => [
                'type'     => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null'     => false,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'completed'],
                'default'    => 'active',
                'null'       => false,
            ],
            'archived_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('admin_id', 'users', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('projects', true);

        // tasks
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'project_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => false,
            ],
            'description' => [
                'type'    => 'TEXT',
                'null'    => true,
                'default' => null,
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'assignee_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['todo', 'in_progress', 'done'],
                'default'    => 'todo',
                'null'       => false,
            ],
            'priority' => [
                'type'       => 'ENUM',
                'constraint' => ['low', 'medium', 'high'],
                'default'    => 'medium',
                'null'       => false,
            ],
            'deadline' => [
                'type'    => 'DATE',
                'null'    => true,
                'default' => null,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('project_id',   'projects', 'id', 'CASCADE',  'CASCADE');
        $this->forge->addForeignKey('created_by',   'users',    'id', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('assignee_id',  'users',    'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('tasks', true);

        // project_members 
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'project_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['member', 'klien'],
                'default'    => 'member',
                'null'       => false,
            ],
            'joined_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey(['project_id', 'user_id']);
        $this->forge->addForeignKey('project_id', 'projects', 'id', 'CASCADE',  'CASCADE');
        $this->forge->addForeignKey('user_id',    'users',    'id', 'CASCADE',  'CASCADE');
        $this->forge->createTable('project_members', true);

        // comments
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'task_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'body' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('task_id', 'tasks', 'id', 'CASCADE',  'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('comments', true);

        // activity_logs
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'project_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
            ],
            'entity_type' => [
                'type'       => 'ENUM',
                'constraint' => ['project', 'task', 'comment', 'member'],
                'null'       => false,
            ],
            'entity_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'action' => [
                'type'       => 'ENUM',
                'constraint' => ['created', 'updated', 'deleted', 'status_changed', 'archived'],
                'null'       => false,
            ],
            'detail' => [
                'type'    => 'TEXT',
                'null'    => true,
                'default' => null,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id',    'users',    'id', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('project_id', 'projects', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('activity_logs', true);
    }

    public function down()
    {
        $this->forge->dropTable('activity_logs',    true);
        $this->forge->dropTable('comments',         true);
        $this->forge->dropTable('project_members',  true);
        $this->forge->dropTable('tasks',            true);
        $this->forge->dropTable('projects',         true);
        $this->forge->dropTable('users',            true);
    }
}