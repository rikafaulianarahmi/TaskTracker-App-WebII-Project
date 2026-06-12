<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Edit Task - <?= esc($task['title']) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Back to Project Button -->
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
    <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Edit Task</h2>
    <p class="text-slate-700 mt-1 font-medium"><?= esc($project['title']) ?> &bull; Status: <span class="<?= $project['status'] === 'active' ? 'text-emerald-600' : 'text-[#4F46E5]' ?> font-extrabold"><?= esc(ucfirst($project['status'])) ?></span></p>
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

        <form action="<?= site_url('tasks/' . esc($task['id']) . '/update') ?>" method="post" class="p-8 space-y-6">
            <?= csrf_field() ?>

            <!-- Task Name -->
            <div class="space-y-2">
                <label for="title" class="block text-[11px] font-extrabold text-slate-600 uppercase tracking-widest">Task Name</label>
                <div class="relative rounded-xl shadow-sm">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-4.5 h-4.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.03 0 1.9.693 2.166 1.638m-7.377 0A48.536 48.536 0 0 1 12 3m0 0c2.917 0 5.747.294 8.5.862m-21 10.398c0-.552.448-1 1-1h6.25a1 1 0 0 1 1 1v3.83a1 1 0 0 1-1 1H2.5a1 1 0 0 1-1-1v-3.83Z" />
                        </svg>
                    </span>
                    <input 
                        type="text" 
                        name="title" 
                        id="title"
                        value="<?= old('title', $task['title']) ?>"
                        placeholder="e.g. Implement hero section"
                        required
                        class="w-full bg-[#F8FAFF] border border-slate-200 rounded-xl pl-11 pr-4 py-3.5 text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-200"
                    >
                </div>
                <span class="text-xs text-slate-650 block pl-1">Focus on clear, actionable titles that describe the specific outcome.</span>
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label for="description" class="block text-[11px] font-extrabold text-slate-600 uppercase tracking-widest">Description</label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="4"
                    placeholder="Briefly describe the task requirements, acceptance criteria, or any helpful links..."
                    class="w-full bg-[#F8FAFF] border border-slate-200 rounded-xl px-4 py-3.5 text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-200"
                ><?= old('description', $task['description']) ?></textarea>
            </div>

            <!-- Grid for Assignee and Deadline -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Assignee -->
                <div class="space-y-2">
                    <label for="assignee_id" class="block text-[11px] font-extrabold text-slate-600 uppercase tracking-widest">Assignee</label>
                    <select 
                        name="assignee_id" 
                        id="assignee_id"
                        class="w-full bg-[#F8FAFF] border border-slate-200 rounded-xl px-4 py-3.5 text-sm text-slate-850 focus:bg-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-200"
                    >
                        <option value="">Select team member</option>
                        <?php foreach ($assignees as $user): ?>
                            <option value="<?= esc($user['id']) ?>" <?= old('assignee_id', $task['assignee_id']) == $user['id'] ? 'selected' : '' ?>>
                                <?= esc($user['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Deadline -->
                <div class="space-y-2">
                    <label for="deadline" class="block text-[11px] font-extrabold text-slate-600 uppercase tracking-widest">Deadline</label>
                    <input 
                        type="date" 
                        name="deadline" 
                        id="deadline"
                        value="<?= old('deadline', $task['deadline']) ?>"
                        class="w-full bg-[#F8FAFF] border border-slate-200 rounded-xl px-4 py-3.5 text-sm text-slate-855 focus:bg-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-200"
                    >
                </div>
            </div>

            <!-- Priority Level -->
            <div class="space-y-2">
                <label class="block text-[11px] font-extrabold text-slate-600 uppercase tracking-widest">Priority Level</label>
                <div class="grid grid-cols-3 gap-4">
                    <!-- Low -->
                    <div>
                        <input 
                            type="radio" 
                            name="priority" 
                            id="priority-low" 
                            value="low" 
                            class="sr-only peer" 
                            <?= old('priority', $task['priority']) === 'low' ? 'checked' : '' ?>
                        >
                        <label 
                            for="priority-low" 
                            class="flex items-center justify-center py-3 px-4 border border-slate-200 bg-[#F8FAFF] text-slate-700 rounded-xl font-bold text-sm cursor-pointer transition-all duration-200 select-none text-center peer-checked:bg-[#4F46E5] peer-checked:border-[#4F46E5] peer-checked:text-white hover:bg-[#EEF2FF]"
                        >
                            Low
                        </label>
                    </div>

                    <!-- Medium -->
                    <div>
                        <input 
                            type="radio" 
                            name="priority" 
                            id="priority-medium" 
                            value="medium" 
                            class="sr-only peer" 
                            <?= old('priority', $task['priority']) === 'medium' ? 'checked' : '' ?>
                        >
                        <label 
                            for="priority-medium" 
                            class="flex items-center justify-center py-3 px-4 border border-slate-200 bg-[#F8FAFF] text-slate-700 rounded-xl font-bold text-sm cursor-pointer transition-all duration-200 select-none text-center peer-checked:bg-[#4F46E5] peer-checked:border-[#4F46E5] peer-checked:text-white hover:bg-[#EEF2FF]"
                        >
                            Medium
                        </label>
                    </div>

                    <!-- High -->
                    <div>
                        <input 
                            type="radio" 
                            name="priority" 
                            id="priority-high" 
                            value="high" 
                            class="sr-only peer" 
                            <?= old('priority', $task['priority']) === 'high' ? 'checked' : '' ?>
                        >
                        <label 
                            for="priority-high" 
                            class="flex items-center justify-center py-3 px-4 border border-slate-200 bg-[#F8FAFF] text-slate-700 rounded-xl font-bold text-sm cursor-pointer transition-all duration-200 select-none text-center peer-checked:bg-[#4F46E5] peer-checked:border-[#4F46E5] peer-checked:text-white hover:bg-[#EEF2FF]"
                        >
                            High
                        </label>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="border-t border-slate-100 pt-6 flex items-center justify-end gap-4">
                <a href="<?= site_url('projects/' . esc($project['id'])) ?>" class="px-6 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-500 active:bg-rose-700 text-white text-sm font-bold transition-all duration-200 flex items-center gap-1.5 focus:outline-none focus:ring-0">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                    Cancel
                </a>
                <button 
                    type="submit" 
                    class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 active:scale-95 text-white text-sm font-bold transition-all duration-200 shadow-md shadow-indigo-500/25 flex items-center gap-1.5"
                >
                    Update Task
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>