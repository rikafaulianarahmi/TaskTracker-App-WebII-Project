<?php

namespace App\Controllers;

use App\Models\TaskModel;
use App\Models\CommentModel;

class CommentController extends BaseController
{
    public function store($taskId)
    {
        $taskModel = new TaskModel();
        $task = $taskModel->find($taskId);

        if (! $task) {
            return redirect()
                ->to('/projects')
                ->with('error', 'Task tidak ditemukan.');
        }

        $access = $this->getProjectAccess($task['project_id']);

        $rules = [
            'body' => 'required|min_length[1]|max_length[1000]',
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->to('/projects/' . $task['project_id'])
                ->with('errors', $this->validator->getErrors());
        }

        $commentModel = new CommentModel();

        $commentBody = $this->request->getPost('body');

        $commentId = $commentModel->insert([
            'task_id' => $taskId,
            'user_id' => session()->get('user_id'),
            'body' => $commentBody,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $this->logActivity(
            $task['project_id'],
            'comment',
            $commentId,
            'created',
            'Comment added: ' . $commentBody
        );
        return redirect()
            ->to('/projects/' . $task['project_id'])
            ->with('success', 'Komentar berhasil ditambahkan.');
    }
}