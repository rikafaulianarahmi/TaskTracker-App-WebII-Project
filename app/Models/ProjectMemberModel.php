<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectMemberModel extends Model
{
    protected $table = 'project_members';
    protected $primaryKey = 'id';
    protected $allowedFields = ['project_id', 'user_id', 'role', 'joined_at'];
    protected $useTimestamps = false;
}