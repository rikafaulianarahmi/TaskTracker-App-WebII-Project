<h1><?= esc($project['title']) ?></h1>

<?php if ($canManage): ?>
    <a href="/projects/<?= esc($project['id']) ?>/tasks/create">Create Task</a>
<?php endif; ?>

<p><?= esc($project['description']) ?></p>
<p>Status: <?= esc($project['status']) ?></p>

<hr>

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
        </div>
        <hr>
    <?php endforeach; ?>
<?php endif; ?>

<h2>Project Members</h2>

<?php if (session()->getFlashdata('success')): ?>
    <p><?= esc(session()->getFlashdata('success')) ?></p>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <p><?= esc(session()->getFlashdata('error')) ?></p>
<?php endif; ?>

<?php if (session()->getFlashdata('errors')): ?>
    <ul>
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if (empty($members)): ?>
    <p>No members yet.</p>
<?php else: ?>
    <ul>
        <?php foreach ($members as $member): ?>
            <li>
                <?= esc($member['name']) ?>
                (<?= esc($member['email']) ?>)
                - Project Role: <?= esc($member['role']) ?>

                <?php if ($canManage): ?>
                    <form 
                        action="/projects/<?= esc($project['id']) ?>/members/<?= esc($member['id']) ?>/remove" 
                        method="post"
                        onsubmit="return confirm('Remove this member from project?')"
                    >
                        <?= csrf_field() ?>
                        <button type="submit">Remove</button>
                    </form>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if ($canManage): ?>

    <h3>Add Member</h3>

    <form action="/projects/<?= esc($project['id']) ?>/members" method="post">
        <?= csrf_field() ?>

        <select name="user_id">
            <option value="">-- Select User --</option>
            <?php foreach ($users as $user): ?>
                <option value="<?= esc($user['id']) ?>">
                    <?= esc($user['name']) ?> - <?= esc($user['email']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="role">
            <option value="member">Member</option>
            <option value="klien">Klien</option>
        </select>

        <button type="submit">Add Member</button>
    </form>

    <form action="/projects/<?= esc($project['id']) ?>/archive" method="post" onsubmit="return confirm('Archive this project?')">
        <?= csrf_field() ?>
        <button type="submit">Archive Project</button>
    </form>

<?php endif; ?>

<br>

<a href="/projects">Back to Projects</a>