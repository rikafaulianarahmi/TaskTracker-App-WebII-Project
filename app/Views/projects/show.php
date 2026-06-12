<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?><?= esc($project['title']) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Back Link -->
<a href="<?= site_url('projects') ?>" class="inline-flex items-center gap-2 py-2 px-4 bg-white border border-slate-300 hover:border-indigo-400 hover:bg-indigo-50/30 text-slate-800 hover:text-[#4F46E5] rounded-xl text-sm font-extrabold transition-all duration-200 mb-6 shadow-sm group">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
    </svg>
    Back to Projects
</a>

<!-- Success/Error Feedback -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 flex items-start gap-3 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <span class="text-sm font-medium"><?= esc(session()->getFlashdata('success')) ?></span>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl mb-6 flex items-start gap-3 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-rose-600 mt-0.5 shrink-0">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
        </svg>
        <span class="text-sm font-medium"><?= esc(session()->getFlashdata('error')) ?></span>
    </div>
<?php endif; ?>

<!-- Project Overview Header Card -->
<div class="bg-white border border-slate-100 rounded-3xl p-6 md:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.015)] mb-8">
    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6">
        <div class="flex-1 space-y-3">
            <div class="flex flex-wrap items-center gap-3">
                <span class="text-[10px] font-extrabold uppercase tracking-wider px-2.5 py-1 rounded-full border 
                    <?= $project['status'] === 'active' 
                        ? 'bg-emerald-50 text-emerald-700 border-emerald-150' 
                        : ($project['status'] === 'completed' 
                            ? 'bg-indigo-50 text-[#4F46E5] border-indigo-150' 
                            : 'bg-slate-50 text-slate-655 border-slate-200') ?>">
                    <?= esc($project['status']) ?>
                </span>
                <span class="text-xs font-bold text-slate-600">Dibuat pada: <?= date('d M Y', strtotime($project['created_at'])) ?></span>
            </div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight leading-none"><?= esc($project['title']) ?></h1>
            <p class="text-slate-700 leading-relaxed text-sm md:text-base max-w-4xl font-medium">
                <?= esc($project['description'] ?: 'No description for this project.') ?>
            </p>
        </div>

        <?php if ($canManage): ?>
            <div class="shrink-0 self-start md:self-auto">
                <form action="<?= site_url('projects/' . esc($project['id']) . '/archive') ?>" method="post" 
                      onsubmit="return confirm('Are you sure you want to archive this project? Archived projects will not appear on the dashboard.');">
                    <?= csrf_field() ?>
                    <button type="submit" 
                            class="inline-flex items-center gap-2 border border-rose-250 hover:bg-rose-50 text-rose-700 py-2.5 px-4 rounded-xl text-sm font-semibold transition-all duration-200 active:scale-95 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                        </svg>
                        Archive Project
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <!-- Mini stats summary -->
    <?php 
        $total_tasks = count($tasks);
        $done_tasks = 0;
        $in_progress_tasks = 0;
        $todo_tasks = 0;
        foreach ($tasks as $task) {
            if ($task['status'] === 'done') $done_tasks++;
            elseif ($task['status'] === 'in_progress') $in_progress_tasks++;
            else $todo_tasks++;
        }
        $progress_pct = $total_tasks > 0 ? round(($done_tasks / $total_tasks) * 100) : 0;
    ?>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8 border-t border-slate-100 pt-6">
        <div class="bg-gradient-to-br from-white to-slate-50/50 p-4 rounded-xl border border-slate-200/60 shadow-sm">
            <span class="text-xs font-bold text-slate-600 uppercase tracking-wider block">Total Tasks</span>
            <span class="text-2xl font-black text-slate-800 mt-1 inline-block"><?= $total_tasks ?></span>
        </div>
        <div class="bg-gradient-to-br from-white to-emerald-50/20 p-4 rounded-xl border border-emerald-150 shadow-sm">
            <span class="text-xs font-bold text-slate-600 uppercase tracking-wider block">Tasks Completed</span>
            <span class="text-2xl font-black text-emerald-600 mt-1 inline-block"><?= $done_tasks ?></span>
        </div>
        <div class="bg-gradient-to-br from-white to-blue-50/20 p-4 rounded-xl border border-blue-150 shadow-sm">
            <span class="text-xs font-bold text-slate-600 uppercase tracking-wider block">In Progress</span>
            <span class="text-2xl font-black text-blue-600 mt-1 inline-block"><?= $in_progress_tasks ?></span>
        </div>
        <div class="bg-gradient-to-br from-white to-indigo-50/20 p-4 rounded-xl border border-indigo-150 shadow-sm">
            <span class="text-xs font-bold text-slate-600 uppercase tracking-wider block">Progress</span>
            <div class="flex items-center gap-2 mt-1">
                <span class="text-2xl font-black text-[#4F46E5]"><?= $progress_pct ?>%</span>
                <div class="flex-1 max-w-[80px] bg-slate-200 h-1.5 rounded-full overflow-hidden hidden sm:block">
                    <div class="bg-[#4F46E5] h-full rounded-full" style="width: <?= $progress_pct ?>%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Layout Columns -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Left Column: Tasks List -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.015)]">
            <div class="flex items-center justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Task List</h3>
                    <p class="text-xs text-slate-600 mt-0.5">All tasks for team members on this project.</p>
                </div>
                
                <?php if ($canManage): ?>
                    <a href="<?= site_url('projects/' . esc($project['id']) . '/tasks/create') ?>" 
                        class="inline-flex items-center gap-1.5 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 active:scale-95 text-white py-2 px-3.5 rounded-lg text-xs font-bold transition-all duration-200 shadow-sm shadow-indigo-100/80">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        New Task
                    </a>
                <?php endif; ?>
            </div>

            <!-- Task Cards -->
            <?php if (empty($tasks)): ?>
                <div class="text-center py-12 border border-dashed border-slate-200 rounded-2xl bg-slate-50/50">
                    <div class="h-12 w-12 bg-white border border-slate-100 rounded-xl flex items-center justify-center text-slate-600 mx-auto mb-4 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.03 0 1.9.693 2.166 1.638m-7.377 0A48.536 48.536 0 0 1 12 3m0 0c2.917 0 5.747.294 8.5.862m-21 10.398c0-.552.448-1 1-1h6.25a1 1 0 0 1 1 1v3.83a1 1 0 0 1-1 1H2.5a1 1 0 0 1-1-1v-3.83Z" />
                        </svg>
                    </div>
                    <h4 class="text-sm font-bold text-slate-800">No tasks yet</h4>
                    <p class="text-xs text-slate-600 max-w-sm mx-auto mt-1 leading-relaxed">Add a new task to start coordinating work with your team.</p>
                </div>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($tasks as $task): ?>
                        <?php
                            $card_bg = 'bg-[#F8FAFF] border-slate-100 hover:border-indigo-150';
                            if ($task['status'] === 'done') {
                                $card_bg = 'bg-emerald-55/20 hover:bg-emerald-50/45 border-emerald-150/70 border-l-4 border-l-emerald-500';
                            } elseif ($task['status'] === 'in_progress') {
                                $card_bg = 'bg-indigo-50/35 hover:bg-indigo-50/60 border-indigo-150/70 border-l-4 border-l-indigo-500';
                            } else {
                                $card_bg = 'bg-slate-50/50 hover:bg-slate-100/40 border-slate-200/70 border-l-4 border-l-slate-400';
                            }
                        ?>
                        <div class="<?= $card_bg ?> rounded-2xl p-5 hover:shadow-md transition-all duration-300 relative group/card">
                            
                            <!-- Task Badges Header -->
                            <div class="flex items-center justify-between gap-3 mb-3">
                                <div class="flex items-center gap-2">
                                    <!-- Priority Badge -->
                                    <span class="text-[10px] font-extrabold uppercase tracking-wider px-2 py-0.5 rounded border 
                                        <?= $task['priority'] === 'high' 
                                            ? 'bg-rose-50 text-rose-700 border-rose-200' 
                                            : ($task['priority'] === 'medium' 
                                                ? 'bg-amber-50 text-amber-700 border-amber-200' 
                                                : 'bg-slate-100 text-slate-650 border-slate-200') ?>">
                                        <?= esc($task['priority']) ?>
                                    </span>

                                    <!-- Status Badge -->
                                    <span class="text-[10px] font-extrabold uppercase tracking-wider px-2 py-0.5 rounded border 
                                        <?= $task['status'] === 'done' 
                                            ? 'bg-emerald-50 text-emerald-700 border-emerald-200' 
                                            : ($task['status'] === 'in_progress' 
                                                ? 'bg-blue-50 text-blue-700 border-blue-200' 
                                                : 'bg-slate-100 text-slate-705 border-slate-200') ?>">
                                        <?= esc($task['status']) ?>
                                    </span>
                                </div>
                                
                                <?php if ($task['deadline']): ?>
                                    <span class="text-xs text-slate-600 font-semibold flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-3.5 h-3.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75" />
                                        </svg>
                                        <?= date('d M Y', strtotime($task['deadline'])) ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Task Title & Description -->
                            <div class="mb-4">
                                <h4 class="text-base font-bold text-slate-900"><?= esc($task['title']) ?></h4>
                                <p class="text-slate-750 text-sm mt-1.5 leading-relaxed font-medium">
                                    <?= esc($task['description'] ?: 'Tidak ada deskripsi.') ?>
                                </p>
                            </div>

                            <!-- Assignee & Creator Info -->
                            <div class="flex flex-wrap items-center justify-between border-t border-slate-100 pt-4 gap-3 text-xs">
                                <div class="flex items-center gap-4">
                                    <div>
                                        <span class="text-slate-600 font-bold">Assignee:</span>
                                        <span class="text-slate-700 font-extrabold ml-1"><?= esc($task['assignee_name'] ?? 'Belum ditugaskan') ?></span>
                                    </div>
                                    <div class="h-3 w-px bg-slate-200 hidden sm:block"></div>
                                    <div class="hidden sm:block">
                                        <span class="text-slate-600 font-bold">Dibuat oleh:</span>
                                        <span class="text-slate-700 font-extrabold ml-1"><?= esc($task['creator_name'] ?? '-') ?></span>
                                    </div>
                                </div>

                                <!-- Status Update Form (Dropdown) -->
                                <?php
                                    $canUpdateTask = $canManage || ((int) session()->get('user_id') === (int) $task['assignee_id']);
                                ?>
                                <?php if ($canUpdateTask): ?>
                                    <form action="<?= site_url('tasks/' . esc($task['id']) . '/status') ?>" method="post" class="flex items-center gap-1.5 shrink-0">
                                        <?= csrf_field() ?>
                                        <select name="status" class="bg-white border border-slate-200 rounded-lg py-1.5 pl-2.5 pr-8 text-xs font-semibold text-slate-700 focus:outline-none focus:border-indigo-400 focus:ring-1 focus:ring-indigo-400">
                                            <option value="todo" <?= $task['status'] === 'todo' ? 'selected' : '' ?>>Todo</option>
                                            <option value="in_progress" <?= $task['status'] === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                                            <option value="done" <?= $task['status'] === 'done' ? 'selected' : '' ?>>Done</option>
                                        </select>
                                        <button type="submit" class="bg-[#4F46E5] hover:bg-[#4338CA] text-white text-xs font-bold py-1.5 px-3 rounded-lg transition-colors active:scale-95">
                                            Update
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>

                            <!-- Comment Accordion Section -->
                            <div class="border-t border-slate-100 mt-4 pt-4">
                                <h5 class="text-xs font-bold text-slate-700 mb-3 uppercase tracking-wider flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-3.5 h-3.5 text-slate-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.132.136.208.307.19.5l-.262 1.632a.75.75 0 0 0 .866.866l1.632-.262a.75.75 0 0 1 .5.19A8.932 8.932 0 0 0 12 20.25Z" />
                                    </svg>
                                    Comments 
                                    <span class="bg-indigo-50/50 text-[#4F46E5] font-bold px-1.5 py-0.5 rounded text-[10px] border border-indigo-100/50">
                                        <?= count($commentsByTask[$task['id']] ?? []) ?>
                                    </span>
                                </h5>

                                <!-- Comment Thread -->
                                <?php if (!empty($commentsByTask[$task['id']])): ?>
                                    <div class="space-y-3 mb-4 max-h-48 overflow-y-auto pr-1">
                                        <?php foreach ($commentsByTask[$task['id']] as $comment): ?>
                                            <div class="bg-white border border-slate-100/80 rounded-2xl p-3 text-xs leading-relaxed shadow-sm">
                                                <div class="flex items-center justify-between gap-3 mb-1">
                                                    <span class="font-bold text-slate-800"><?= esc($comment['user_name']) ?></span>
                                                    <span class="text-[10px] text-slate-600 font-semibold"><?= date('d M Y H:i', strtotime($comment['created_at'])) ?></span>
                                                </div>
                                                <p class="text-slate-600 font-medium"><?= esc($comment['body']) ?></p>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Post Comment Form -->
                                <form action="<?= site_url('tasks/' . esc($task['id']) . '/comments') ?>" method="post" class="flex gap-2">
                                    <?= csrf_field() ?>
                                    <input 
                                        type="text" 
                                        name="body" 
                                        placeholder="Write a reply or comment..."
                                        required
                                        class="flex-1 bg-white border border-slate-200/60 rounded-xl px-4 py-2.5 text-xs text-slate-800 placeholder-slate-500 focus:outline-none focus:border-indigo-400 focus:ring-1 focus:ring-indigo-400 transition-all shadow-sm"
                                    >
                                    <button type="submit" class="bg-[#E0E7FF] hover:bg-[#C7D2FE] text-[#4F46E5] font-bold text-xs py-2.5 px-4 rounded-xl border border-indigo-100 transition-colors shrink-0 flex items-center justify-center">
                                        Send
                                    </button>
                                </form>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- Right Column: Members Sidebar -->
    <div class="space-y-6">
        
        <!-- Members List Card -->
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.015)]">
            <div class="flex items-start justify-between gap-3 mb-5">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 mb-1">Team Members</h3>
                    <p class="text-xs text-slate-600">List of users participating in this project.</p>
                </div>

                <?php if ($canManage): ?>
                    <button type="button"
                            onclick="document.getElementById('add-member-form').classList.toggle('hidden')"
                            class="inline-flex items-center gap-1.5 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 active:scale-95 text-white py-2 px-3.5 rounded-lg text-xs font-bold transition-all duration-200 shadow-sm shadow-indigo-100/80">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Add
                    </button>
                <?php endif; ?>
            </div>

            <?php if ($canManage): ?>
                <form id="add-member-form"
                    action="<?= site_url('projects/' . esc($project['id']) . '/members') ?>"
                    method="post"
                    class="hidden mb-5 rounded-2xl border border-slate-100 bg-slate-50/60 p-3.5">
                    <?= csrf_field() ?>

                    <div class="space-y-2">
                        <select name="user_id"
                                required
                                class="w-full bg-white border border-slate-200 rounded-xl py-2.5 px-3 text-xs font-semibold text-slate-700 focus:outline-none focus:border-indigo-400 focus:ring-1 focus:ring-indigo-400">
                            <option value="">Select user</option>

                            <?php foreach (($availableUsers ?? $users ?? []) as $user): ?>
                                <option value="<?= esc($user['id']) ?>">
                                    <?= esc($user['name']) ?><?= !empty($user['email']) ? ' - ' . esc($user['email']) : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <div class="flex gap-2">
                            <select name="role"
                                    required
                                    class="flex-1 bg-white border border-slate-200 rounded-xl py-2.5 px-3 text-xs font-semibold text-slate-700 focus:outline-none focus:border-indigo-400 focus:ring-1 focus:ring-indigo-400">
                                <option value="member">Member</option>
                                <option value="klien">Klien</option>
                            </select>

                            <button type="submit"
                                    class="shrink-0 bg-[#4F46E5] hover:bg-[#4338CA] text-white text-xs font-bold py-2.5 px-4 rounded-xl transition-colors active:scale-95">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            <?php endif; ?>

            <div class="space-y-3.5">
                <div class="flex items-center justify-between p-3.5 rounded-2xl border border-indigo-100 bg-[#EEF2FF]/40">
                    <div class="flex items-center gap-3">
                        <?php 
                            $initials = '';
                            $words = explode(' ', $adminName);
                            for ($i = 0; $i < min(2, count($words)); $i++) {
                                $initials .= strtoupper(substr($words[$i], 0, 1));
                            }
                        ?>
                        <div class="h-9 w-9 bg-[#4F46E5] text-white rounded-xl flex items-center justify-center font-bold text-xs select-none shadow-sm">
                            <?= esc($initials) ?>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-slate-900 block leading-tight"><?= esc($adminName) ?></span>
                            <span class="text-[10px] text-slate-700 block mt-0.5"><?= esc($adminEmail) ?></span>
                        </div>
                    </div>
                    <span class="bg-indigo-50 text-[#4F46E5] text-[9px] font-extrabold uppercase px-2 py-0.5 rounded-full border border-indigo-100 tracking-wider">Owner</span>
                </div>

                <?php foreach ($members as $member): ?>
                    <?php
                        $projectMemberId = $member['id'];
                    ?>

                    <div class="flex items-center justify-between gap-3 p-3.5 rounded-2xl border border-slate-155 hover:bg-[#F5F8FF]/30 transition-all duration-200">
                        <div class="flex items-center gap-3 min-w-0">
                            <?php 
                                $initials = '';
                                $words = explode(' ', $member['name']);
                                for ($i = 0; $i < min(2, count($words)); $i++) {
                                    $initials .= strtoupper(substr($words[$i], 0, 1));
                                }
                            ?>
                            <div class="h-9 w-9 bg-slate-100 text-slate-700 border border-slate-200 rounded-xl flex items-center justify-center font-bold text-xs select-none shrink-0">
                                <?= esc($initials) ?>
                            </div>
                            <div class="min-w-0">
                                <span class="text-xs font-bold text-slate-800 block leading-tight truncate"><?= esc($member['name']) ?></span>
                                <span class="text-[10px] text-slate-700 block mt-0.5 truncate"><?= esc($member['email']) ?></span>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="text-[9px] font-extrabold uppercase px-2 py-0.5 rounded-full tracking-wider border 
                                <?= $member['role'] === 'member' 
                                    ? 'bg-blue-50 text-blue-700 border-blue-150' 
                                    : 'bg-amber-50 text-amber-700 border-amber-150' ?>">
                                <?= esc($member['role']) ?>
                            </span>

                            <?php if ($canManage): ?>
                                <form action="<?= site_url('projects/' . esc($project['id']) . '/members/' . esc($projectMemberId) . '/remove') ?>"
                                    method="post"
                                    onsubmit="return confirm('Remove <?= esc($member['name'], 'js') ?> from project?');">
                                    <?= csrf_field() ?>

                                    <button type="submit"
                                            class="inline-flex items-center justify-center text-rose-500 hover:text-rose-700 p-1.5 hover:bg-rose-50 rounded-lg transition-colors"
                                            title="Remove Member">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2.2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M22 10.5h-6m-2.25-4.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM4 19.25a7.25 7.25 0 0 1 14.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- Activity Logs Card -->
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.015)]">
            <h3 class="text-lg font-bold text-slate-900 mb-1">Activity Logs</h3>
            <p class="text-xs text-slate-600 mb-5">Recent activity in this project.</p>

            <?php if (empty($activityLogs)): ?>
                <p class="text-sm text-slate-500">No activity yet.</p>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($activityLogs as $log): ?>
                        <div class="border border-slate-100 rounded-2xl p-3 bg-slate-50/40">
                            <p class="text-sm text-slate-800">
                                <span class="font-bold text-slate-900"><?= esc($log['user_name']) ?></span>
                                <?= esc($log['action']) ?>
                                <?= esc($log['entity_type']) ?>

                                <?php if (! empty($log['detail'])): ?>
                                    <span class="text-slate-500">- <?= esc($log['detail']) ?></span>
                                <?php endif; ?>
                            </p>

                            <p class="text-[10px] text-slate-500 font-semibold mt-1">
                                <?= esc($log['created_at']) ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>

</div>

<?= $this->endSection() ?>
