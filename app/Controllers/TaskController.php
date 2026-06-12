<?php

namespace App\Controllers;

use App\Models\TaskModel;

class TaskController extends BaseController
{
    public function create($projectId)
    {
        $access = $this->getProjectAccess($projectId);

        if (! $access['is_admin']) {
            return redirect()
                ->to('/projects/' . $projectId)
                ->with('error', 'Kamu tidak punya akses untuk membuat task.');
        }

        $assignees = $this->getAssignableUsers($projectId, $access['project']['admin_id']);

        return view('tasks/create', [
            'project' => $access['project'],
            'assignees' => $assignees,
        ]);
    }

    public function store($projectId)
    {
        $access = $this->getProjectAccess($projectId);

        if (! $access['is_admin']) {
            return redirect()
                ->to('/projects/' . $projectId)
                ->with('error', 'Kamu tidak punya akses untuk membuat task.');
        }

        $rules = [
            'title' => 'required|min_length[3]|max_length[200]',
            'description' => 'permit_empty|max_length[1000]',
            'assignee_id' => 'permit_empty|integer',
            'priority' => 'required|in_list[low,medium,high]',
            'deadline' => 'permit_empty|valid_date[Y-m-d]',
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $assigneeId = $this->request->getPost('assignee_id');

        if ($assigneeId && ! $this->isAssignableUser($projectId, $access['project']['admin_id'], $assigneeId)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Assignee tidak valid untuk project ini.');
        }

        $taskModel = new TaskModel();

        $taskId = $taskModel->insert([
            'project_id' => $projectId,
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'created_by' => session()->get('user_id'),
            'assignee_id' => $assigneeId ?: null,
            'status' => 'todo',
            'priority' => $this->request->getPost('priority'),
            'deadline' => $this->request->getPost('deadline') ?: null,
        ]);

        $this->logActivity(
            $projectId,
            'task',
            $taskId,
            'created',
            'Task created: ' . $this->request->getPost('title')
        );

        return redirect()
            ->to('/projects/' . $projectId)
            ->with('success', 'Task berhasil dibuat.');
    }

    public function updateStatus($taskId)
    {
        $taskModel = new TaskModel();

        $task = $taskModel->find($taskId);

        if (! $task) {
            return redirect()
                ->to('/projects')
                ->with('error', 'Task tidak ditemukan.');
        }

        $access = $this->getProjectAccess($task['project_id']);

        $isAssignee = (int) $task['assignee_id'] === (int) session()->get('user_id');
        $isAssignedMember = $access['role'] === 'member' && $isAssignee;

        if (! $access['is_admin'] && ! $isAssignedMember) {
            return redirect()
                ->to('/projects/' . $task['project_id'])
                ->with('error', 'Kamu tidak punya akses untuk mengubah status task ini.');
        }

        $rules = [
            'status' => 'required|in_list[todo,in_progress,done]',
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->to('/projects/' . $task['project_id'])
                ->with('errors', $this->validator->getErrors());
        }

        $newStatus = $this->request->getPost('status');

        $taskModel->update($taskId, [
            'status' => $newStatus,
        ]);

        $this->logActivity(
            $task['project_id'],
            'task',
            $taskId,
            'status_updated',
            'Task status changed to ' . $newStatus
        );

        return redirect()
            ->to('/projects/' . $task['project_id'])
            ->with('success', 'Status task berhasil diperbarui.');
    }

    public function edit($taskId)
    {
        $taskModel = new TaskModel();

        $task = $taskModel->find($taskId);

        if (! $task) {
            return redirect()
                ->to('/projects')
                ->with('error', 'Task tidak ditemukan.');
        }

        $access = $this->getProjectAccess($task['project_id']);

        if (! $access['is_admin']) {
            return redirect()
                ->to('/projects/' . $task['project_id'])
                ->with('error', 'Kamu tidak punya akses untuk mengedit task ini.');
        }

        $assignees = $this->getAssignableUsers(
            $task['project_id'],
            $access['project']['admin_id']
        );

        return view('tasks/edit', [
            'project' => $access['project'],
            'task' => $task,
            'assignees' => $assignees,
        ]);
    }

    public function update($taskId)
    {
        $taskModel = new TaskModel();

        $task = $taskModel->find($taskId);

        if (! $task) {
            return redirect()
                ->to('/projects')
                ->with('error', 'Task tidak ditemukan.');
        }

        $access = $this->getProjectAccess($task['project_id']);

        if (! $access['is_admin']) {
            return redirect()
                ->to('/projects/' . $task['project_id'])
                ->with('error', 'Kamu tidak punya akses untuk mengedit task ini.');
        }

        $rules = [
            'title' => 'required|min_length[3]|max_length[200]',
            'description' => 'permit_empty|max_length[1000]',
            'assignee_id' => 'permit_empty|integer',
            'priority' => 'required|in_list[low,medium,high]',
            'deadline' => 'permit_empty|valid_date[Y-m-d]',
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $assigneeId = $this->request->getPost('assignee_id');

        if ($assigneeId && ! $this->isAssignableUser($task['project_id'], $access['project']['admin_id'], $assigneeId)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Assignee tidak valid untuk project ini.');
        }

        $title = $this->request->getPost('title');

        $taskModel->update($taskId, [
            'title' => $title,
            'description' => $this->request->getPost('description'),
            'assignee_id' => $assigneeId ?: null,
            'priority' => $this->request->getPost('priority'),
            'deadline' => $this->request->getPost('deadline') ?: null,
        ]);

        $this->logActivity(
            $task['project_id'],
            'task',
            $taskId,
            'updated',
            'Task updated: ' . $title
        );

        return redirect()
            ->to('/projects/' . $task['project_id'])
            ->with('success', 'Task berhasil diperbarui.');
    }

    private function getAssignableUsers($projectId, $adminId)
    {
        $db = \Config\Database::connect();

        return $db->table('users')
            ->select('users.id, users.name, users.email')
            ->join('project_members', 'project_members.user_id = users.id', 'left')
            ->groupStart()
                ->where('users.id', $adminId)
                ->orGroupStart()
                    ->where('project_members.project_id', $projectId)
                    ->where('project_members.role', 'member')
                ->groupEnd()
            ->groupEnd()
            ->groupBy('users.id')
            ->get()
            ->getResultArray();
    }

    private function isAssignableUser($projectId, $adminId, $userId)
    {
        $assignees = $this->getAssignableUsers($projectId, $adminId);

        foreach ($assignees as $assignee) {
            if ((int) $assignee['id'] === (int) $userId) {
                return true;
            }
        }

        return false;
    }
}