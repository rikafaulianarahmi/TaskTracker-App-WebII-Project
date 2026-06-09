<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table = 'projects';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'admin_id', 'status', 'archived_at'];
    protected $useTimestamps = true;

    public function getActiveProjectsForUser($userId)
    {
        return $this->select('projects.*')
            ->join('project_members', 'project_members.project_id = projects.id AND project_members.user_id = ' . $this->db->escape($userId), 'left')
            ->groupStart()
                ->where('projects.admin_id', $userId)
                ->orWhere('project_members.user_id', $userId)
            ->groupEnd()
            ->where('projects.archived_at', null)
            ->groupBy('projects.id')
            ->findAll();
    }
}