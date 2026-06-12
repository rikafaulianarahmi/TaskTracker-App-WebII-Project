<h1>Edit Project</h1>

<a href="/projects/<?= esc($project['id']) ?>">Back to Project</a>

<?php if (session()->getFlashdata('errors')): ?>
    <ul>
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="/projects/<?= esc($project['id']) ?>/update" method="post">
    <?= csrf_field() ?>

    <div>
        <label>Project Title</label><br>
        <input 
            type="text" 
            name="title" 
            value="<?= old('title', $project['title']) ?>"
        >
    </div>

    <br>

    <div>
        <label>Description</label><br>
        <textarea name="description"><?= old('description', $project['description']) ?></textarea>
    </div>

    <br>

    <button type="submit">Update Project</button>
</form>