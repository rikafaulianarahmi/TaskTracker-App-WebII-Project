<?php

namespace App\Controllers;

use App\Models\ProjectMemberModel;

class ProjectMemberController extends BaseController
{
    public function store($projectId)
    {
        $access = $this->getProjectAccess($projectId);

        if (! $access['is_admin']) {
            return redirect()
                ->to('/projects/' . $projectId)
                ->with('error', 'Kamu tidak punya akses untuk mengelola member project ini.');
        }

        $rules = [
            'user_id' => 'required|integer',
            'role' => 'required|in_list[member,klien]',
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $memberModel = new ProjectMemberModel();

        $exists = $memberModel
            ->where('project_id', $projectId)
            ->where('user_id', $this->request->getPost('user_id'))
            ->first();

        if ($exists) {
            return redirect()
                ->back()
                ->with('error', 'User sudah menjadi member project ini.');
        }

        $userId = $this->request->getPost('user_id');
        $role = $this->request->getPost('role');

        $memberId = $memberModel->insert([
            'project_id' => $projectId,
            'user_id' => $userId,
            'role' => $role,
            'joined_at' => date('Y-m-d H:i:s'),
        ]);

        $userModel = new \App\Models\UserModel();
        $addedUser = $userModel->find($userId);

        $this->logActivity(
            $projectId,
            'member',
            $memberId,
            'created',
            'Member added: ' . ($addedUser['name'] ?? 'Unknown User') . ' as ' . $role
        );

        return redirect()
            ->to('/projects/' . $projectId)
            ->with('success', 'Member berhasil ditambahkan.');
    }

    public function remove($projectId, $memberId)
    {
        $access = $this->getProjectAccess($projectId);

        if (! $access['is_admin']) {
            return redirect()
                ->to('/projects/' . $projectId)
                ->with('error', 'Kamu tidak punya akses untuk mengelola member project ini.');
        }

        $memberModel = new ProjectMemberModel();

        $member = $memberModel
            ->where('project_id', $projectId)
            ->where('id', $memberId)
            ->first();

        if (! $member) {
            return redirect()
                ->to('/projects/' . $projectId)
                ->with('error', 'Member tidak ditemukan.');
        }

        $userModel = new \App\Models\UserModel();
        $removedUser = $userModel->find($member['user_id']);

        $memberModel->delete($memberId);

        $this->logActivity(
            $projectId,
            'member',
            $memberId,
            'deleted',
            'Member removed: ' . ($removedUser['name'] ?? 'Unknown User')
        );

        return redirect()
            ->to('/projects/' . $projectId)
            ->with('success', 'Member berhasil dihapus dari project.');
    }
}