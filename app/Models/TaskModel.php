<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'project_id',
        'title',
        'description',
        'created_by',
        'assignee_id',
        'status',
        'priority',
        'deadline',
    ];
    protected $useTimestamps = true;
}