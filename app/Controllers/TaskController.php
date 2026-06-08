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

        $taskModel->insert([
            'project_id' => $projectId,
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'created_by' => session()->get('user_id'),
            'assignee_id' => $assigneeId ?: null,
            'status' => 'todo',
            'priority' => $this->request->getPost('priority'),
            'deadline' => $this->request->getPost('deadline') ?: null,
        ]);

        return redirect()
            ->to('/projects/' . $projectId)
            ->with('success', 'Task berhasil dibuat.');
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