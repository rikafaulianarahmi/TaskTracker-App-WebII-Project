<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table = 'projects';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'admin_id', 'status', 'archived_at'];
    protected $useTimestamps = true;
}