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
