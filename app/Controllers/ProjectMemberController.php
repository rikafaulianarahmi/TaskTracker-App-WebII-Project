<?php

namespace App\Controllers;

use App\Models\ProjectMemberModel;
use App\Models\ProjectModel;

class ProjectMemberController extends BaseController
{
    public function store($projectId)
    {
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

        $projectModel = new ProjectModel();
        $project = $projectModel->find($projectId);

        if (! $project) {
            return redirect()
                ->to('/projects')
                ->with('error', 'Project tidak ditemukan.');
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

        $memberModel->insert([
            'project_id' => $projectId,
            'user_id' => $this->request->getPost('user_id'),
            'role' => $this->request->getPost('role'),
            'joined_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()
            ->to('/projects/' . $projectId)
            ->with('success', 'Member berhasil ditambahkan.');
    }

    public function remove($projectId, $memberId)
    {
    $memberModel = new \App\Models\ProjectMemberModel();

    $member = $memberModel
        ->where('project_id', $projectId)
        ->where('id', $memberId)
        ->first();

    if (! $member) {
        return redirect()
            ->to('/projects/' . $projectId)
            ->with('error', 'Member tidak ditemukan.');
    }

    $memberModel->delete($memberId);

    return redirect()
        ->to('/projects/' . $projectId)
        ->with('success', 'Member berhasil dihapus dari project.');
    }
}