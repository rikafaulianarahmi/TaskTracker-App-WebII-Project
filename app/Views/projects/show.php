<h2>Tasks</h2>

<?php if (empty($tasks)): ?>
    <p>No tasks yet.</p>
<?php else: ?>
    <?php foreach ($tasks as $task): ?>
        <div>
            <h3><?= esc($task['title']) ?></h3>
            <p><?= esc($task['description']) ?></p>
            <p>Status: <?= esc($task['status']) ?></p>
            <p>Priority: <?= esc($task['priority']) ?></p>
            <p>Deadline: <?= esc($task['deadline'] ?? '-') ?></p>
            <p>Assignee: <?= esc($task['assignee_name'] ?? 'Unassigned') ?></p>
            <p>Created by: <?= esc($task['creator_name'] ?? '-') ?></p>

            <?php
                $canUpdateTask = $canManage || ((int) session()->get('user_id') === (int) $task['assignee_id']);
            ?>

            <?php if ($canUpdateTask): ?>
                <form action="/tasks/<?= esc($task['id']) ?>/status" method="post">
                    <?= csrf_field() ?>

                    <select name="status">
                        <option value="todo" <?= $task['status'] === 'todo' ? 'selected' : '' ?>>Todo</option>
                        <option value="in_progress" <?= $task['status'] === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                        <option value="done" <?= $task['status'] === 'done' ? 'selected' : '' ?>>Done</option>
                    </select>

                    <button type="submit">Update Status</button>
                </form>
            <?php endif; ?>

            <h4>Comments</h4>

            <?php if (empty($commentsByTask[$task['id']])): ?>
                <p>No comments yet.</p>
            <?php else: ?>
                <?php foreach ($commentsByTask[$task['id']] as $comment): ?>
                    <div>
                        <strong><?= esc($comment['user_name']) ?></strong>
                        <small><?= esc($comment['created_at']) ?></small>
                        <p><?= esc($comment['body']) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <form action="/tasks/<?= esc($task['id']) ?>/comments" method="post">
                <?= csrf_field() ?>

                <textarea 
                    name="body" 
                    placeholder="Write a comment..."
                    required
                ></textarea>

                <br>

                <button type="submit">Add Comment</button>
            </form>
        </div>
        <hr>
    <?php endforeach; ?>
<?php endif; ?>

<hr>

<h2>Activity Logs</h2>

<?php if (empty($activityLogs)): ?>
    <p>No activity yet.</p>
<?php else: ?>
    <ul>
        <?php foreach ($activityLogs as $log): ?>
            <li>
                <strong><?= esc($log['user_name']) ?></strong>
                <?= esc($log['action']) ?>
                <?= esc($log['entity_type']) ?>

                <?php if (! empty($log['detail'])): ?>
                    - <?= esc($log['detail']) ?>
                <?php endif; ?>

                <br>
                <small><?= esc($log['created_at']) ?></small>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>