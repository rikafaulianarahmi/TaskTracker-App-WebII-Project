<h1>Edit Task</h1>

<p>Project: <?= esc($project['title']) ?></p>

<a href="/projects/<?= esc($project['id']) ?>">Back to Project</a>

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

<form action="/tasks/<?= esc($task['id']) ?>/update" method="post">
    <?= csrf_field() ?>

    <div>
        <label>Title</label><br>
        <input 
            type="text" 
            name="title" 
            value="<?= old('title', $task['title']) ?>"
        >
    </div>

    <br>

    <div>
        <label>Description</label><br>
        <textarea name="description"><?= old('description', $task['description']) ?></textarea>
    </div>

    <br>

    <div>
        <label>Assignee</label><br>
        <select name="assignee_id">
            <option value="">Unassigned</option>

            <?php foreach ($assignees as $user): ?>
                <option 
                    value="<?= esc($user['id']) ?>"
                    <?= old('assignee_id', $task['assignee_id']) == $user['id'] ? 'selected' : '' ?>
                >
                    <?= esc($user['name']) ?> - <?= esc($user['email']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <br>

    <div>
        <label>Priority</label><br>
        <select name="priority">
            <option value="low" <?= old('priority', $task['priority']) === 'low' ? 'selected' : '' ?>>Low</option>
            <option value="medium" <?= old('priority', $task['priority']) === 'medium' ? 'selected' : '' ?>>Medium</option>
            <option value="high" <?= old('priority', $task['priority']) === 'high' ? 'selected' : '' ?>>High</option>
        </select>
    </div>

    <br>

    <div>
        <label>Deadline</label><br>
        <input 
            type="date" 
            name="deadline" 
            value="<?= old('deadline', $task['deadline']) ?>"
        >
    </div>

    <br>

    <button type="submit">Update Task</button>
</form>