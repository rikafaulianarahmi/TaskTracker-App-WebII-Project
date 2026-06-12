<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Edit Project - <?= esc($project['title']) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Back Link -->
<div class="flex justify-start mb-6">
    <a href="<?= site_url('projects/' . esc($project['id'])) ?>" class="inline-flex items-center gap-2 py-2.5 px-4 bg-white border border-slate-300 hover:border-indigo-400 hover:bg-indigo-50/30 text-slate-800 hover:text-[#4F46E5] rounded-xl text-sm font-extrabold transition-all duration-200 shadow-sm group">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
        Back to Project
    </a>
</div>

<!-- Header -->
<div class="mb-8">
    <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Edit Project</h2>
    <p class="text-slate-700 mt-1 font-medium">Update the details of this project below.</p>
</div>

<!-- Centered Card Wrapper -->
<div class="flex justify-center w-full py-4">
    <div class="w-full max-w-2xl bg-white border-t-4 border-t-[#4F46E5] border-x border-b border-slate-200 rounded-[24px] shadow-[0_8px_30px_rgb(0,0,0,0.015)] overflow-hidden">
        
        <!-- Error Feedback -->
        <?php if (session()->getFlashdata('errors') || session()->getFlashdata('error')): ?>
            <div class="p-6 bg-rose-50 border-b border-rose-100 text-rose-800 flex flex-col gap-2">
                <div class="flex items-center gap-2 font-bold text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                    Ada beberapa kesalahan input:
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 font-medium pl-6">
                    <?php if (session()->getFlashdata('error')): ?>
                        <li><?= esc(session()->getFlashdata('error')) ?></li>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('errors')): ?>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('projects/' . esc($project['id']) . '/update') ?>" method="post" class="p-8 space-y-6">
            <?= csrf_field() ?>

            <!-- Project Title -->
            <div class="space-y-2">
                <label for="title" class="block text-[11px] font-extrabold text-slate-600 uppercase tracking-widest">Project Name</label>
                <div class="relative rounded-xl shadow-sm">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-4.5 h-4.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v13.5A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V9.75m-6-6 6 6m-6-6v6a.75.75 0 0 0 .75.75h6" />
                        </svg>
                    </span>
                    <input 
                        type="text" 
                        id="title"
                        name="title" 
                        value="<?= old('title', $project['title']) ?>"
                        placeholder="e.g. Redesign Website Company Profile"
                        required
                        class="w-full bg-[#F8FAFF] border border-slate-200 rounded-xl pl-11 pr-4 py-3.5 text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-200"
                    >
                </div>
                <span class="text-xs text-slate-600 block pl-1">Minimum 3 characters, maximum 200 characters.</span>
            </div>

            <!-- Project Description -->
            <div class="space-y-2">
                <label for="description" class="block text-[11px] font-extrabold text-slate-600 uppercase tracking-widest">Project Description</label>
                <textarea 
                    id="description"
                    name="description" 
                    rows="4"
                    placeholder="Briefly describe the goal of this project, milestones, or other important information..."
                    class="w-full bg-[#F8FAFF] border border-slate-200 rounded-xl px-4 py-3.5 text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-200"
                ><?= old('description', $project['description']) ?></textarea>
                <span class="text-xs text-slate-600 block pl-1">Maximum 1000 characters. Optional.</span>
            </div>

            <!-- Form Actions -->
            <div class="border-t border-slate-100 pt-6 flex items-center justify-end gap-4">
                <a href="<?= site_url('projects/' . esc($project['id'])) ?>" 
                   class="px-6 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-500 active:bg-rose-700 text-white text-sm font-bold transition-all duration-200 flex items-center gap-1.5 focus:outline-none focus:ring-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 active:scale-95 text-white text-sm font-bold transition-all duration-200 shadow-md shadow-indigo-500/25 flex items-center gap-1.5">
                    Update Project
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>