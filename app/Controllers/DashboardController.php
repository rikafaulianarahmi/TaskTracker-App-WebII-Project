<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\TaskModel;
use App\Models\ActivityLogModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');

        $projectModel = new ProjectModel();
        $taskModel    = new TaskModel();
        $logModel     = new ActivityLogModel();

        // Get user's projects
        $projects = $projectModel->getActiveProjectsForUser($userId);

        $activeProjectIds = array_column($projects, 'id');
        $accessibleProjectIds = $projectModel->getAccessibleProjectIdsForUser($userId);

        if (empty($activeProjectIds)) {
            $activeProjectIds = [0];
        }

        if (empty($accessibleProjectIds)) {
            $accessibleProjectIds = [0];
        }

        $projectIds = array_column($projects, 'id');
        if (empty($projectIds)) {
            $projectIds = [0];
        }

        // Statistics
        $totalProjects = count($projects);
        $activeTasks   = $taskModel->getActiveTasksCount($projectIds);
        $dueToday      = $taskModel->getDueTodayCount($projectIds);
        $overdue       = $taskModel->getOverdueCount($projectIds);

        // Recent Projects 
        $recentProjectsRaw = array_slice($projects, 0, 3);
        $recentProjects = [];
        foreach ($recentProjectsRaw as $p) {
            $tTasks = $taskModel->where('project_id', $p['id'])->countAllResults();
            $cTasks = $taskModel->where('project_id', $p['id'])->where('status', 'done')->countAllResults();
            $percent = $tTasks > 0 ? round(($cTasks / $tTasks) * 100) : 0;
            
            if ($percent >= 70) {
                $statusLabel = 'ON TRACK';
                $barColor = 'bg-emerald-500';
                $tagColor = 'text-emerald-700 bg-emerald-50 border-emerald-100';
            } elseif ($percent >= 30) {
                $statusLabel = 'MODERATE';
                $barColor = 'bg-amber-500';
                $tagColor = 'text-amber-700 bg-amber-50 border-amber-200';
            } else {
                $statusLabel = 'AT RISK';
                $barColor = 'bg-rose-500';
                $tagColor = 'text-rose-700 bg-rose-50 border-rose-200';
            }
            
            $p['percent']     = $percent;
            $p['statusLabel'] = $statusLabel;
            $p['barColor']    = $barColor;
            $p['tagColor']    = $tagColor;
            $recentProjects[] = $p;
        }

        // My Tasks 
        $myTasks = $taskModel->getMyTasks($userId);

        // Upcoming Deadlines
        $upcomingDeadlines = $taskModel->getUpcomingDeadlines($projectIds);

        // Recent logs
        $recentLogsRaw = $logModel->getRecentActivity($accessibleProjectIds, 4);
        
        $recentLogs = array_map(function ($log) {
            return [
                ...$log,
                'message' => $this->formatActivityMessage($log),
                'formatted_time' => $this->formatDateTime($log['created_at'] ?? null),
            ];
        }, $recentLogsRaw);

        return view('dashboard/index', [
            'name'              => session()->get('user_name'),
            'role'              => session()->get('role'),
            'totalProjects'     => $totalProjects,
            'activeTasks'       => $activeTasks,
            'dueToday'          => $dueToday,
            'overdue'           => $overdue,
            'recentProjects'    => $recentProjects,
            'myTasks'           => $myTasks,
            'upcomingDeadlines' => $upcomingDeadlines,
            'recentLogs'        => $recentLogs,
        ]);
    }

    private function formatDateTime($dateTime)
    {
        if (empty($dateTime)) {
            return '-';
        }

        $timestamp = strtotime($dateTime);

        if (! $timestamp) {
            return '-';
        }

        return date('H:i, d M Y', $timestamp);
    }

    private function formatActivityMessage(array $log)
    {
        $user = $log['user_name'] ?? 'User';
        $entity = $log['entity_type'] ?? '';
        $action = $log['action'] ?? '';
        $detail = $log['detail'] ?? '';

        if ($entity === 'task' && $action === 'created') {
            return "{$user} membuat task baru. {$detail}";
        }

        if ($entity === 'task' && ($action === 'status_updated' || $action === 'status_changed')) {
            return "{$user} mengubah status task. {$detail}";
        }

        if ($entity === 'comment' && $action === 'created') {
            return "{$user} menambahkan komentar. {$detail}";
        }

        if ($entity === 'project' && $action === 'created') {
            return "{$user} membuat project baru.";
        }

        if ($entity === 'project' && $action === 'archived') {
            return "{$user} mengarsipkan project.";
        }

        if ($entity === 'member' && $action === 'created') {
            return "{$user} menambahkan member. {$detail}";
        }

        if ($entity === 'member' && $action === 'deleted') {
            return "{$user} menghapus member. {$detail}";
        }

        return "{$user} melakukan aktivitas. {$detail}";
    }
}