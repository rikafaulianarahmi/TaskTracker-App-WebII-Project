<h1>Projects</h1>

<a href="/dashboard">Back to Dashboard</a>

<?php if (session()->get('role') === 'admin'): ?>
<a href="/projects/create">Create New Project</a>
<?php endif; ?>
<?php if (empty($projects)): ?>
    <p>No projects yet.</p>
<?php endif; ?>

<?php foreach ($projects as $project): ?>
    <div>
        <h3>
            <a href="/projects/<?= esc($project['id']) ?>">
                <?= esc($project['title']) ?>
            </a>
        </h3>

        <p><?= esc($project['description']) ?></p>
        <p>Status: <?= esc($project['status']) ?></p>
    </div>
<?php endforeach; ?>