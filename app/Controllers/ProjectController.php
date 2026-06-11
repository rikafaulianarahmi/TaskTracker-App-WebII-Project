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
        $userId = session()->get('user_id');

        $db = \Config\Database::connect();

        $projects = $db->table('projects')
            ->select('projects.*')
            ->select('(SELECT COUNT(*) FROM tasks WHERE tasks.project_id = projects.id) as total_tasks')
            ->select('(SELECT COUNT(*) FROM tasks WHERE tasks.project_id = projects.id AND tasks.status = "done") as completed_tasks')
            ->join(
                'project_members',
                'project_members.project_id = projects.id AND project_members.user_id = ' . $db->escape($userId),
                'left'
            )
            ->groupStart()
                ->where('projects.admin_id', $userId)
                ->orWhere('project_members.user_id', $userId)
            ->groupEnd()
            ->where('projects.archived_at', null)
            ->groupBy('projects.id')
            ->get()
            ->getResultArray();

        $projectIds = array_column($projects, 'id');
        $membersByProject = [];

        if (! empty($projectIds)) {
            $members = $db->table('project_members')
                ->select('project_members.project_id, users.name, users.role')
                ->join('users', 'users.id = project_members.user_id')
                ->whereIn('project_members.project_id', $projectIds)
                ->get()
                ->getResultArray();

            foreach ($members as $member) {
                $membersByProject[$member['project_id']][] = $member;
            }
        }

        return view('projects/index', [
            'projects' => $projects,
            'membersByProject' => $membersByProject,
        ]);
    }

    public function show($id)
    {
        $access = $this->getProjectAccess($id);
        $project = $access['project'];
        
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

        $adminUser = $userModel->find($project['admin_id']);
        $adminName = $adminUser ? $adminUser['name'] : 'Unknown Admin';
        $adminEmail = $adminUser ? $adminUser['email'] : '';

        $db = \Config\Database::connect();

        $tasks = $db->table('tasks')
            ->select('tasks.*, assignee.name as assignee_name, creator.name as creator_name')
            ->join('users as assignee', 'assignee.id = tasks.assignee_id', 'left')
            ->join('users as creator', 'creator.id = tasks.created_by', 'left')
            ->where('tasks.project_id', $id)
            ->orderBy('tasks.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $commentsByTask = [];

        if (! empty($tasks)) {
            $taskIds = array_column($tasks, 'id');

            $comments = $db->table('comments')
                ->select('comments.*, users.name as user_name')
                ->join('users', 'users.id = comments.user_id')
                ->whereIn('comments.task_id', $taskIds)
                ->orderBy('comments.created_at', 'ASC')
                ->get()
                ->getResultArray();

            foreach ($comments as $comment) {
                $commentsByTask[$comment['task_id']][] = $comment;
            }
        }

        $activityLogs = $db->table('activity_logs')
            ->select('activity_logs.*, users.name as user_name')
            ->join('users', 'users.id = activity_logs.user_id')
            ->where('activity_logs.project_id', $id)
            ->orderBy('activity_logs.created_at', 'DESC')
            ->get()
            ->getResultArray();

        return view('projects/show', [
            'project' => $project,
            'members' => $members,
            'users' => $users,
            'tasks' => $tasks,
            'commentsByTask' => $commentsByTask,
            'activityLogs' => $activityLogs,
            'canManage' => $access['is_admin'],
            'projectRole' => $access['role'],
            'adminName' => $adminName,
            'adminEmail' => $adminEmail,
        ]);
    }
    public function create()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()
                ->to('/projects')
                ->with('error', 'Kamu tidak punya akses untuk membuat project.');
        }

        return view('projects/create');
    }

    public function store()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()
                ->to('/projects')
                ->with('error', 'Kamu tidak punya akses untuk membuat project.');
        }

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

        $title = $this->request->getPost('title');

        $projectId = $projectModel->insert([
            'title' => $title,
            'description' => $this->request->getPost('description'),
            'admin_id' => session()->get('user_id'),
            'status' => 'active',
        ]);

        $this->logActivity(
            $projectId,
            'project',
            $projectId,
            'created',
            'Project created: ' . $title
        );

        return redirect()
            ->to('/projects')
            ->with('success', 'Project berhasil dibuat.');
    }

    public function archive($id)
    {
        $access = $this->getProjectAccess($id);

        if (! $access['is_admin']) {
            return redirect()
                ->to('/projects')
                ->with('error', 'Kamu tidak punya akses untuk mengarsipkan project ini.');
        }
        
        $projectModel = new ProjectModel();

        $project = $projectModel->find($id);

        if (! $project) {
            throw PageNotFoundException::forPageNotFound('Project not found');
        }

        $projectTitle = $project['title'];

        $projectModel->update($id, [
            'archived_at' => date('Y-m-d H:i:s'),
        ]);

        $this->logActivity(
            $id,
            'project',
            $id,
            'archived',
            'Project archived: ' . $projectTitle
        );

        return redirect()
            ->to('/projects')
            ->with('success', 'Project berhasil diarsipkan.');
    }
}