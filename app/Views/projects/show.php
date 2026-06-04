<h1><?= esc($project['title']) ?></h1>

<p><?= esc($project['description']) ?></p>
<p>Status: <?= esc($project['status']) ?></p>

<form action="/projects/<?= esc($project['id']) ?>/archive" method="post" onsubmit="return confirm('Archive this project?')">
    <?= csrf_field() ?>
    <button type="submit">Archive Project</button>
</form>

<br>

<a href="/projects">Back to Projects</a>