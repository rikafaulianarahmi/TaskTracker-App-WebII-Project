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

    public function getActiveTasksCount(array $projectIds)
    {
        return $this->whereIn('project_id', $projectIds)
            ->where('status !=', 'done')
            ->countAllResults();
    }

    public function getDueTodayCount(array $projectIds)
    {
        return $this->whereIn('project_id', $projectIds)
            ->where('deadline', date('Y-m-d'))
            ->where('status !=', 'done')
            ->countAllResults();
    }

    public function getOverdueCount(array $projectIds)
    {
        return $this->whereIn('project_id', $projectIds)
            ->where('deadline <', date('Y-m-d'))
            ->where('status !=', 'done')
            ->countAllResults();
    }

    public function getMyTasks($userId)
    {
        return $this->select('tasks.*, projects.title as project_title')
            ->join('projects', 'projects.id = tasks.project_id')
            ->where('tasks.assignee_id', $userId)
            ->where('tasks.status !=', 'done')
            ->orderBy('tasks.deadline', 'ASC')
            ->limit(3)
            ->findAll();
    }

    public function getUpcomingDeadlines(array $projectIds)
    {
        return $this->select('tasks.*, projects.title as project_title')
            ->join('projects', 'projects.id = tasks.project_id')
            ->whereIn('tasks.project_id', $projectIds)
            ->where('tasks.deadline >=', date('Y-m-d'))
            ->where('tasks.status !=', 'done')
            ->orderBy('tasks.deadline', 'ASC')
            ->limit(3)
            ->findAll();
    }
}