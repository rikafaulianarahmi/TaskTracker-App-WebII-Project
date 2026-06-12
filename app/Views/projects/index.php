<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Projects<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Projects</h2>
        <p class="text-slate-700 mt-1">List of all active projects you are participating in.</p>
    </div>
    <?php if (session()->get('role') === 'admin'): ?>
        <a href="<?= site_url('projects/create') ?>" class="inline-flex items-center gap-2 py-2.5 px-5 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white rounded-xl text-sm font-bold transition-all duration-200 shadow-md shadow-indigo-100">
            Create New Project
        </a>
    <?php endif; ?>
</div>

<!-- Alert Feedback -->
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

<!-- Projects Grid -->
<?php if (empty($projects)): ?>
    <!-- Empty State -->
    <div class="bg-white border border-slate-200 rounded-3xl p-12 text-center max-w-lg mx-auto mt-12 shadow-[0_8px_30px_rgb(0,0,0,0.015)]">
        <div class="h-16 w-16 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center text-slate-600 mx-auto mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-19.5 0A2.25 2.25 0 0 0 4.5 15h15a2.25 2.25 0 0 0 2.25-2.25m-19.5 0v.25A2.25 2.25 0 0 0 4.5 17.5h15a2.25 2.25 0 0 0 2.25-2.25m-19.5 0v.25a2.25 2.25 0 0 0 2.25 2.25h15a2.25 2.25 0 0 0 2.25-2.25m-19.5 0v-4.5A2.25 2.25 0 0 1 4.5 6h4.5a2.25 2.25 0 0 1 1.62.69l1.01 1.01a2.25 2.25 0 0 0 1.62.69h6A2.25 2.25 0 0 1 21.75 9.75v3.25" />
            </svg>
        </div>
        <h3 class="text-lg font-bold text-slate-900">No projects yet</h3>
        <p class="text-slate-700 text-sm mt-2">You are not registered in any project yet. Contact an administrator or create a new project to get started.</p>
        <?php if (session()->get('role') === 'admin'): ?>
            <a href="<?= site_url('projects/create') ?>" class="inline-flex items-center gap-2 mt-6 py-2.5 px-5 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white rounded-xl text-sm font-bold transition-all duration-200 shadow-md shadow-indigo-100">
                Create First Project
            </a>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($projects as $project): ?>
            <?php 
                $total_tasks = (int)$project['total_tasks'];
                $completed_tasks = (int)$project['completed_tasks'];
                $progress_percentage = $total_tasks > 0 ? round(($completed_tasks / $total_tasks) * 100) : 0;
            ?>
            <!-- Project Card -->
            <div class="bg-white rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.015)] border border-slate-100/50 hover:shadow-md transition-all duration-300 relative group overflow-hidden flex flex-col justify-between">
                <!-- Status Badge -->
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-extrabold uppercase tracking-wider px-2.5 py-1 rounded-full border 
                        <?= $project['status'] === 'active' 
                            ? 'bg-emerald-50 text-emerald-700 border-emerald-150' 
                            : ($project['status'] === 'completed' 
                                ? 'bg-indigo-50 text-[#4F46E5] border-indigo-150' 
                                : 'bg-slate-50 text-slate-600 border-slate-200') ?>">
                        <?= esc($project['status']) ?>
                    </span>
                    
                    <a href="<?= site_url('projects/' . esc($project['id'])) ?>" class="text-slate-600 hover:text-indigo-650 p-1.5 rounded-lg hover:bg-slate-50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                    </a>
                </div>

                <!-- Title & Desc -->
                <div class="mb-5 flex-1">
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition-colors duration-200">
                        <a href="<?= site_url('projects/' . esc($project['id'])) ?>">
                            <?= esc($project['title']) ?>
                        </a>
                    </h3>
                    <p class="text-slate-700 text-sm mt-2 line-clamp-2 leading-relaxed font-medium">
                        <?= esc($project['description'] ?: 'Tidak ada deskripsi untuk proyek ini.') ?>
                    </p>
                </div>

                <!-- Progress Bar -->
                <div class="border-t border-slate-50 pt-4 mb-4">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-700 mb-1.5">
                        <span>Progress</span>
                        <span class="text-indigo-650"><?= $progress_percentage ?>%</span>
                    </div>
                    <div class="w-full bg-[#E0E7FF] h-2 rounded-full overflow-hidden">
                        <div class="bg-[#6366F1] h-2 rounded-full transition-all duration-500 ease-out" style="width: <?= $progress_percentage ?>%"></div>
                    </div>
                    <div class="flex items-center justify-between text-[11px] text-slate-600 mt-1.5 font-semibold">
                        <span><?= $completed_tasks ?> of <?= $total_tasks ?> tasks completed</span>
                    </div>
                </div>

                <!-- Members  -->
                <div class="border-t border-slate-50 pt-4 flex items-center justify-between mt-1">
                    <span class="text-xs font-bold text-slate-700">Project Team</span>
                    
                    <div class="flex -space-x-1.5 overflow-hidden">
                        <?php 
                            $members = $membersByProject[$project['id']] ?? [];
                            $max_avatars = 4;
                            $count = 0;
                        ?>
                        <?php foreach ($members as $member): ?>
                            <?php if ($count < $max_avatars): ?>
                                <?php 
                                    $m_name = $member['name'];
                                    $initials = '';
                                    $words = explode(' ', $m_name);
                                    for ($i = 0; $i < min(2, count($words)); $i++) {
                                        $initials .= strtoupper(substr($words[$i], 0, 1));
                                    }
                                ?>
                                <div class="inline-block h-6.5 w-6.5 rounded-full bg-slate-100 ring-2 ring-white text-[9px] font-bold text-slate-600 flex items-center justify-center border border-slate-200 select-none cursor-default" 
                                    title="<?= esc($member['name']) ?> (<?= esc($member['role']) ?>)">
                                    <?= $initials ?>
                                </div>
                                <?php $count++; ?>
                            <?php else: break; endif; ?>
                        <?php endforeach; ?>

                        <?php if (count($members) > $max_avatars): ?>
                            <div class="inline-block h-6.5 w-6.5 rounded-full bg-indigo-50 ring-2 ring-white text-[9px] font-extrabold text-[#4F46E5] flex items-center justify-center border border-indigo-100 select-none cursor-default">
                                +<?= count($members) - $max_avatars ?>
                            </div>
                        <?php endif; ?>

                        <?php if (empty($members)): ?>
                            <span class="text-xs text-slate-600 font-semibold italic">No members yet</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>