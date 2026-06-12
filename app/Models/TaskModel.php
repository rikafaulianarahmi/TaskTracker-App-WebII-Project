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
        'archived_at',
    ];
    protected $useTimestamps = true;

    public function getActiveTasksCount(array $projectIds)
    {
        return $this->whereIn('project_id', $projectIds)
            ->where('archived_at', null)
            ->where('status !=', 'done')
            ->countAllResults();
    }

    public function getDueTodayCount(array $projectIds)
    {
        return $this->whereIn('project_id', $projectIds)
            ->where('archived_at', null)
            ->where('deadline', date('Y-m-d'))
            ->where('status !=', 'done')
            ->countAllResults();
    }

    public function getOverdueCount(array $projectIds)
    {
        return $this->whereIn('project_id', $projectIds)
            ->where('archived_at', null)
            ->where('deadline <', date('Y-m-d'))
            ->where('status !=', 'done')
            ->countAllResults();
    }

    public function getMyTasks($userId)
    {
        return $this->select('tasks.*, projects.title as project_title')
            ->join('projects', 'projects.id = tasks.project_id')
            ->where('tasks.assignee_id', $userId)
            ->where('tasks.archived_at', null)
            ->where('tasks.status !=', 'done')
            ->where('projects.archived_at', null)
            ->orderBy('tasks.deadline', 'ASC')
            ->findAll();
    }

    public function getUpcomingDeadlines(array $projectIds, int $limit = 5)
    {
        if (empty($projectIds)) {
            return [];
        }

        return $this->select('tasks.*, projects.title as project_title')
            ->join('projects', 'projects.id = tasks.project_id')
            ->whereIn('tasks.project_id', $projectIds)
            ->where('tasks.archived_at', null)
            ->where('tasks.deadline IS NOT NULL', null, false)
            ->where('tasks.status !=', 'done')
            ->where('projects.archived_at', null)
            ->orderBy('tasks.deadline', 'ASC')
            ->limit($limit)
            ->findAll();
    }
}