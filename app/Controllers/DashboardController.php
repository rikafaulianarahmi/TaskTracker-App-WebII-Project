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

            $tTasks = $taskModel
                ->where('tasks.project_id', $p['id'])
                ->where('tasks.archived_at', null)
                ->countAllResults();

            $cTasks = $taskModel
                ->where('tasks.project_id', $p['id'])
                ->where('tasks.status', 'done')
                ->where('tasks.archived_at', null)
                ->countAllResults();            
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
        $myTasksRaw = $taskModel->getMyTasks($userId);
        $myTasks = array_map(function ($task) {
            $isOverdue = strtotime($task['deadline']) <= strtotime(date('Y-m-d'));
            $task['deadlineClass'] = $isOverdue ? 'text-rose-600' : 'text-slate-500';
            $task['priorityClass'] = match($task['priority']) {
                'high' => 'bg-rose-50 text-rose-700',
                'medium' => 'bg-amber-50 text-amber-700',
                default => 'bg-slate-100 text-slate-700'
            };
            return $task;
        }, $myTasksRaw);

        // Upcoming Deadlines
        $upcomingDeadlines = $taskModel->getUpcomingDeadlines($activeProjectIds);
        $upcomingDeadlines = array_map(function ($deadline) {
            $diff = (strtotime($deadline['deadline']) - strtotime(date('Y-m-d'))) / 86400;
            $deadline['daysLabel'] = match(true) {
                $diff == 0 => 'Hari Ini',
                $diff == 1 => 'Besok',
                $diff > 1 => "{$diff} hari lagi",
                default => 'Lewat',
            };
            return $deadline;
        }, $upcomingDeadlines);

        // Recent logs
        $recentLogsRaw = $logModel->getRecentActivity($accessibleProjectIds, 4);
        $recentLogs = $this->formatActivityLogs($recentLogsRaw);

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

}