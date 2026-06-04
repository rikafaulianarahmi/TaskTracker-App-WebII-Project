<h1>Create Project</h1>

<a href="/projects">Back to Projects</a>

<?php if (session()->getFlashdata('errors')): ?>
    <ul>
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="/projects/store" method="post">
    <?= csrf_field() ?>

    <div>
        <label>Project Title</label>
        <br>
        <input 
            type="text" 
            name="title" 
            value="<?= old('title') ?>"
            placeholder="Example: Task Tracker App"
        >
    </div>

    <br>

    <div>
        <label>Description</label>
        <br>
        <textarea 
            name="description" 
            placeholder="Project description"
        ><?= old('description') ?></textarea>
    </div>

    <br>

    <button type="submit">Create Project</button>
</form>