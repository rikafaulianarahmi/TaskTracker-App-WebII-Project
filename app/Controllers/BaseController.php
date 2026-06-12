<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\ProjectModel;
use App\Models\ProjectMemberModel;
use CodeIgniter\Exceptions\PageNotFoundException;

abstract class BaseController extends Controller
{
    protected function getProjectAccess($projectId)
    {
        $userId = session()->get('user_id');

        $projectModel = new ProjectModel();

        $project = $projectModel
            ->where('archived_at', null)
            ->find($projectId);

        if (! $project) {
            throw PageNotFoundException::forPageNotFound('Project not found');
        }

        if ((int) $project['admin_id'] === (int) $userId) {
            return [
                'project' => $project,
                'role' => 'admin',
                'is_admin' => true,
            ];
        }

        $memberModel = new ProjectMemberModel();

        $member = $memberModel
            ->where('project_id', $projectId)
            ->where('user_id', $userId)
            ->first();

        if ($member) {
            return [
                'project' => $project,
                'role' => $member['role'],
                'is_admin' => false,
            ];
        }

        throw PageNotFoundException::forPageNotFound('Project not found');
    }
    protected function formatDateTime($dateTime)
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

    protected function formatActivityMessage(array $log)
    {
        $user = $log['user_name'] ?? 'User';
        $entity = $log['entity_type'] ?? '';
        $action = $log['action'] ?? '';
        $detail = $log['detail'] ?? '';

        if ($entity === 'project' && $action === 'created') {
            $detail = trim(str_replace('Project created:', '', $detail));

            return $detail
                ? "{$user} created project: {$detail}"
                : "{$user} created a project.";
        }

        if ($entity === 'project' && $action === 'updated') {
            $detail = trim(str_replace('Project updated:', '', $detail));

            return $detail
                ? "{$user} updated project: {$detail}"
                : "{$user} updated a project.";
        }

        if ($entity === 'project' && $action === 'archived') {
            $detail = trim(str_replace('Project archived:', '', $detail));

            return $detail
                ? "{$user} archived project: {$detail}"
                : "{$user} archived a project.";
        }

        if ($entity === 'task' && $action === 'created') {
            $detail = trim(str_replace('Task created:', '', $detail));

            return $detail
                ? "{$user} created task: {$detail}"
                : "{$user} created a task.";
        }

        if ($entity === 'task' && ($action === 'status_updated' || $action === 'status_changed')) {
            $detail = trim(str_replace('Task status changed to', '', $detail));

            return $detail
                ? "{$user} changed task status to {$detail}"
                : "{$user} changed task status.";
        }

        if ($entity === 'task' && $action === 'updated') {
            $detail = trim(str_replace('Task updated:', '', $detail));

            return $detail
                ? "{$user} updated task: {$detail}"
                : "{$user} updated a task.";
        }

        if ($entity === 'task' && $action === 'archived') {
            $detail = trim(str_replace('Task archived:', '', $detail));

            return $detail
                ? "{$user} archived task: {$detail}"
                : "{$user} archived a task.";
        }


        if ($entity === 'comment' && ($action === 'created')) {
            $detail = trim(str_replace('Comment created:', '', $detail));

            return $detail
                ? "{$user} created comment: {$detail}"
                : "{$user} created a comment.";
        }

        if ($entity === 'member' && $action === 'created') {
            $detail = trim(str_replace('Member added:', '', $detail));

            return $detail
                ? "{$user} added member: {$detail}"
                : "{$user} added a member.";
        }

        if ($entity === 'member' && $action === 'deleted') {
            $detail = trim(str_replace('Member removed:', '', $detail));

            return $detail
                ? "{$user} removed member: {$detail}"
                : "{$user} removed a member.";
        }
        return "{$user} melakukan aktivitas. {$detail}";
    }

    protected function formatActivityLogs(array $logs)
    {
        return array_map(function ($log) {
            return [
                ...$log,
                'message' => $this->formatActivityMessage($log),
                'formatted_time' => $this->formatDateTime($log['created_at'] ?? null),
            ];
        }, $logs);
    }

    protected function logActivity($projectId, $entityType, $entityId, $action, $detail = null)
    {
        $logModel = new \App\Models\ActivityLogModel();

        $logModel->insert([
            'user_id' => session()->get('user_id'),
            'project_id' => $projectId,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'action' => $action,
            'detail' => $detail,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
    
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        // $this->helpers = ['form', 'url'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // $this->session = service('session');
    }
}
