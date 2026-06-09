<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table = 'activity_logs';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id',
        'project_id',
        'entity_type',
        'entity_id',
        'action',
        'detail',
    ];
    protected $useTimestamps = false;

    public function getRecentActivity(array $projectIds, $limit = 4)
    {
        return $this->select('activity_logs.*, users.name as user_name, projects.title as project_title')
            ->join('users', 'users.id = activity_logs.user_id')
            ->join('projects', 'projects.id = activity_logs.project_id', 'left')
            ->whereIn('activity_logs.project_id', $projectIds)
            ->orderBy('activity_logs.created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }
}