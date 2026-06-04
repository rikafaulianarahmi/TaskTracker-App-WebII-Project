<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\ProjectMemberModel;
use App\Models\UserModel;

class ProjectController extends BaseController
{
    public function index()
    {
        $projectModel = new ProjectModel();

        $projects = $projectModel
            ->where('archived_at', null)
            ->findAll();

        return view('projects/index', [
            'projects' => $projects
        ]);
    }

    public function show($id)
    {
        $projectModel = new ProjectModel();

        $project = $projectModel
            ->where('archived_at', null)
            ->find($id);

        if (! $project) {
            throw PageNotFoundException::forPageNotFound('Project not found');
        }

        $memberModel = new ProjectMemberModel();
        $userModel = new UserModel();

        $members = $memberModel
            ->select('project_members.*, users.name, users.email, users.role as user_role')
            ->join('users', 'users.id = project_members.user_id')
            ->where('project_members.project_id', $id)
            ->findAll();

        $users = $userModel
            ->where('id !=', $project['admin_id'])
            ->findAll();

        return view('projects/show', [
            'project' => $project,
            'members' => $members,
            'users' => $users,
        ]);
    }

    public function create()
    {
        return view('projects/create');
    }

    public function store()
    {
        $rules = [
            'title' => 'required|min_length[3]|max_length[200]',
            'description' => 'permit_empty|max_length[1000]',
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $projectModel = new ProjectModel();

        $projectModel->insert([
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'admin_id' => session()->get('user_id'),
            'status' => 'active',
        ]);

        return redirect()
            ->to('/projects')
            ->with('success', 'Project berhasil dibuat.');
    }

    public function archive($id)
    {
    $projectModel = new \App\Models\ProjectModel();

    $project = $projectModel->find($id);

    if (! $project) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Project not found');
    }

    $projectModel->update($id, [
        'archived_at' => date('Y-m-d H:i:s'),
    ]);

    return redirect()
        ->to('/projects')
        ->with('success', 'Project berhasil diarsipkan.');
    }
}