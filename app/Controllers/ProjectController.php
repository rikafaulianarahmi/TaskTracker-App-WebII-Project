<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use CodeIgniter\Exceptions\PageNotFoundException;

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

        return view('projects/show', [
            'project' => $project
        ]);
    }
}