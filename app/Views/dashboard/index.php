<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 relative z-10">
    <div>
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Welcome back, <?= esc($name) ?>.</h2>
        <p class="text-slate-700 mt-1 font-medium">Here's an overview of your productivity today.</p>
    </div>
</div>


<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- Total Projects -->
    <div class="bg-gradient-to-br from-white to-[#EFF6FF] border border-[#BFDBFE] border-l-4 border-l-[#2563EB] p-6 rounded-2xl flex flex-col justify-between shadow-[0_8px_30px_rgb(37,99,235,0.04)] hover:-translate-y-0.5 transition-all duration-300 relative overflow-hidden">
        <div class="flex items-start justify-between">
            <div class="h-10 w-10 bg-[#EFF6FF] text-[#2563EB] rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-19.5 0A2.25 2.25 0 0 0 4.5 15h15a2.25 2.25 0 0 0 2.25-2.25m-19.5 0v.25A2.25 2.25 0 0 0 4.5 17.5h15a2.25 2.25 0 0 0 2.25-2.25m-19.5 0v.25a2.25 2.25 0 0 0 2.25 2.25h15a2.25 2.25 0 0 0 2.25-2.25m-19.5 0v-4.5A2.25 2.25 0 0 1 4.5 6h4.5a2.25 2.25 0 0 1 1.62.69l1.01 1.01a2.25 2.25 0 0 0 1.62.69h6A2.25 2.25 0 0 1 21.75 9.75v3.25" />
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-xs font-bold text-slate-750 uppercase tracking-wider block">Total Projects</span>
            <h3 class="text-4xl font-extrabold text-[#2563EB] mt-1"><?= $totalProjects ?></h3>
        </div>
    </div>

    <!-- Active Tasks -->
    <div class="bg-gradient-to-br from-white to-[#EEF2FF] border border-[#C7D2FE] border-l-4 border-l-[#6366F1] p-6 rounded-2xl flex flex-col justify-between shadow-[0_8px_30px_rgb(99,102,241,0.04)] hover:-translate-y-0.5 transition-all duration-300 relative overflow-hidden">
        <div class="flex items-start justify-between">
            <div class="h-10 w-10 bg-[#EEF2FF] text-[#6366F1] rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-xs font-bold text-slate-750 uppercase tracking-wider block">Active Tasks</span>
            <h3 class="text-4xl font-extrabold text-[#6366F1] mt-1"><?= $activeTasks ?></h3>
        </div>
    </div>

    <!-- Due Today -->
    <div class="bg-gradient-to-br from-white to-[#FEF3C7]/50 border border-[#FDE68A] border-l-4 border-l-[#D97706] p-6 rounded-2xl flex flex-col justify-between shadow-[0_8px_30px_rgb(217,119,6,0.04)] hover:-translate-y-0.5 transition-all duration-300 relative overflow-hidden">
        <div class="flex items-start justify-between">
            <div class="h-10 w-10 bg-[#FEF3C7] text-[#D97706] rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <span class="text-[9px] font-extrabold text-amber-700 bg-amber-100 px-2 py-0.5 rounded tracking-wider leading-none">URGENT</span>
        </div>
        <div class="mt-4">
            <span class="text-xs font-bold text-slate-750 uppercase tracking-wider block">Due Today</span>
            <h3 class="text-4xl font-extrabold text-[#D97706] mt-1"><?= $dueToday ?></h3>
        </div>
    </div>

    <!-- Overdue -->
    <div class="bg-gradient-to-br from-white to-[#FEE2E2]/50 border border-[#FCA5A5] border-l-4 border-l-[#DC2626] p-6 rounded-2xl flex flex-col justify-between shadow-[0_8px_30px_rgb(220,38,38,0.04)] hover:-translate-y-0.5 transition-all duration-300 relative overflow-hidden">
        <div class="flex items-start justify-between">
            <div class="h-10 w-10 bg-[#FEE2E2] text-[#DC2626] rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-xs font-bold text-slate-750 uppercase tracking-wider block">Overdue</span>
            <h3 class="text-4xl font-extrabold text-[#DC2626] mt-1"><?= $overdue ?></h3>
        </div>
    </div>

</div>

<!-- Content Columns -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Left Area -->
    <div class="lg:col-span-2 space-y-8">
        
        <!-- Recent Projects Widget -->
        <div class="bg-white rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.015)] border border-slate-100/30">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Recent Projects</h3>
                    <p class="text-xs text-slate-600 mt-0.5">List of your active projects</p>
                </div>
                <a href="<?= site_url('projects') ?>" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                    View All
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
            </div>
            
            <div class="space-y-4">
                <?php if (empty($recentProjects)): ?>
                    <p class="text-sm text-slate-600 py-4 text-center">No active projects yet.</p>
                <?php else: ?>
                    <?php foreach ($recentProjects as $p): ?>
                        <div class="p-5 border border-slate-100 rounded-2xl hover:border-indigo-100 hover:bg-[#F5F8FF]/30 transition-all duration-300 relative group">
                            
                            <!-- Card Header -->
                            <div class="flex items-start justify-between gap-4 mb-3">
                                <div>
                                    <h4 class="font-bold text-slate-900 text-base group-hover:text-indigo-600 transition-colors">
                                        <a href="<?= site_url('projects/' . $p['id']) ?>">
                                            <?= esc($p['title']) ?>
                                        </a>
                                    </h4>
                                    <p class="text-xs text-slate-700 mt-1 line-clamp-1 leading-relaxed"><?= esc($p['description'] ?: 'No description.') ?></p>
                                </div>

                                <!-- Custom Status -->
                                <span class="text-[9px] font-extrabold uppercase px-2.5 py-1 rounded-full text-center shrink-0 tracking-wider leading-none 
                                    <?= ($p['percent'] < 50) 
                                        ? 'bg-red-700 text-white' 
                                        : 'bg-emerald-600 text-white' ?>">
                                    <?= ($p['percent'] < 50) ? 'At Risk' : 'On Track' ?>
                                </span>
                            </div>
                            
                            <!-- Progress Bar -->
                            <div class="mt-4 mb-4">
                                <div class="flex justify-between items-center mb-1.5 text-xs font-bold text-slate-700">
                                    <span>Progress</span>
                                    <span class="text-indigo-600"><?= $p['percent'] ?>%</span>
                                </div>
                                <div class="w-full bg-[#E0E7FF] h-2 rounded-full overflow-hidden shadow-inner">
                                    <div class="bg-[#6366F1] h-full rounded-full transition-all duration-500" style="width: <?= $p['percent'] ?>%"></div>
                                </div>
                            </div>

                            <!-- Card Footer -->
                            <div class="flex items-center justify-between border-t border-slate-50 pt-3 text-xs mt-3">
                                <!-- Placeholders for stacked team members -->
                                <div class="flex -space-x-1.5 overflow-hidden">
                                    <div class="inline-block h-6 w-6 rounded-full bg-slate-200 ring-2 ring-white text-[9px] font-bold text-slate-600 flex items-center justify-center">AW</div>
                                    <div class="inline-block h-6 w-6 rounded-full bg-indigo-50 ring-2 ring-white text-[9px] font-bold text-indigo-700 flex items-center justify-center">BS</div>
                                    <div class="inline-block h-6 w-6 rounded-full bg-emerald-50 ring-2 ring-white text-[8px] font-bold text-emerald-700 flex items-center justify-center">+3</div>
                                </div>

                                <span class="text-[11px] text-slate-600 font-semibold flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75" />
                                    </svg>
                                    12 Okt 2026
                                </span>
                            </div>

                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <?php if (session()->get('role') !== 'klien'): ?>
        <!-- My Tasks Widget -->
        <div class="bg-white rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.015)] border border-slate-100/30">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">My Tasks</h3>
                    <p class="text-xs text-slate-600 mt-0.5">List of tasks assigned to you</p>
                </div>
                <button class="text-slate-600 hover:text-slate-900 p-1 hover:bg-slate-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5-3h16.5m-16.5 6h16.5" />
                    </svg>
                </button>
            </div>
            
            <?php if (empty($myTasks)): ?>
                <div class="text-center py-16 flex flex-col items-center">
                    <div class="h-20 w-20 bg-[#F0F4FF] rounded-full flex items-center justify-center text-indigo-500 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-9 h-9">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.03 0 1.9.693 2.166 1.638m-7.377 0A48.536 48.536 0 0 1 12 3m0 0c2.917 0 5.747.294 8.5.862m-21 10.398c0-.552.448-1 1-1h6.25a1 1 0 0 1 1 1v3.83a1 1 0 0 1-1 1H2.5a1 1 0 0 1-1-1v-3.83Z" />
                        </svg>
                    </div>
                    <h4 class="text-sm font-bold text-slate-800">No tasks yet.</h4>
                    <p class="text-xs text-slate-600 max-w-xs mx-auto mt-2 leading-relaxed font-medium">All tasks assigned to you will appear here.</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-[11px] font-bold text-slate-600 uppercase tracking-wider text-left">
                                <th class="pb-3 w-8"></th>
                                <th class="pb-3 pl-2">Task Name</th>
                                <th class="pb-3">Project</th>
                                <th class="pb-3">Due Date</th>
                                <th class="pb-3 text-right">Priority</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?php foreach ($myTasks as $t): ?>
                                <tr class="group hover:bg-slate-50/50 transition-colors">
                                    <td class="py-4">
                                        <input type="checkbox" disabled class="h-4.5 w-4.5 rounded border-slate-350 bg-white text-indigo-600 focus:ring-indigo-500 cursor-not-allowed">
                                    </td>
                                    <td class="py-4 pl-2">
                                        <span class="font-bold text-slate-900 text-sm"><?= esc($t['title']) ?></span>
                                    </td>
                                    <td class="py-4">
                                        <span class="text-xs text-slate-700 font-semibold"><?= esc($t['project_title']) ?></span>
                                    </td>
                                    <td class="py-4">
                                        <span class="text-xs font-semibold <?= $t['deadlineClass'] ?>">
                                            <?= date('d M Y', strtotime($t['deadline'])) ?>
                                        </span>
                                    </td>
                                    <td class="py-4 text-right">
                                        <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full inline-block <?= $t['priorityClass'] ?>">
                                            <?= $t['priority'] ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

    </div>

    <!-- Right Area  -->
    <div class="space-y-8">
        
        <!-- Upcoming Deadlines -->
        <div class="bg-white rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.015)] border border-slate-100/30">
            <div class="flex items-center gap-2 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-indigo-650">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <h3 class="text-lg font-bold text-slate-900">Upcoming Deadlines</h3>
            </div>
            
            <div class="space-y-4">
                <?php if (empty($upcomingDeadlines)): ?>
                    <p class="text-sm text-slate-600 py-2">No upcoming deadlines.</p>
                <?php else: ?>
                    <?php foreach ($upcomingDeadlines as $u): ?>
                        <div class="flex items-center gap-4">
                            <!-- High Fidelity Calendar -->
                            <div class="w-10 rounded-xl overflow-hidden shrink-0 border border-slate-100 shadow-sm">
                                <span class="bg-rose-500 text-white text-[8px] font-extrabold py-0.5 px-1.5 uppercase rounded-t-xl text-center block tracking-wider leading-none">
                                    <?= date('M', strtotime($u['deadline'])) ?>
                                </span>
                                <span class="bg-[#FEF3C7] text-[#D97706] text-sm font-extrabold text-center block py-1 rounded-b-xl leading-none">
                                    <?= date('d', strtotime($u['deadline'])) ?>
                                </span>
                            </div>
                            
                            <span class="text-[10px] font-extrabold text-indigo-600 uppercase tracking-wider block">
                                <?= esc($u['daysLabel']) ?>
                            </span>
                            <h4 class="font-bold text-slate-900 text-sm mt-0.5"><?= esc($u['title']) ?></h4>
                            <p class="text-xs text-slate-500 mt-1"><?= esc($u['project_title']) ?> • <?= date('d M Y', strtotime($u['deadline'])) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Team Activity -->
        <div class="bg-white rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.015)] border border-slate-100/30">
            <div class="flex items-center gap-2 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-5 h-5 text-indigo-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
                <h3 class="text-lg font-bold text-slate-900">Team Activity</h3>
            </div>
            
            <div class="space-y-5">
                <?php if (empty($recentLogs)): ?>
                    <p class="text-sm text-slate-600 py-2">No activity recorded yet.</p>
                <?php else: ?>
                    <?php foreach ($recentLogs as $log): ?>
                        <div class="flex gap-3 text-sm">
                            <div class="h-8 w-8 bg-indigo-50 text-indigo-700 font-bold rounded-lg flex items-center justify-center text-xs shrink-0 border border-indigo-100">
                                <?= strtoupper(substr($log['user_name'], 0, 1)) ?>
                            </div>

                            <div>
                                <p class="text-slate-800 leading-normal">
                                    <?= esc($log['message']) ?>
                                </p>

                                <span class="text-[10px] text-slate-400 font-medium mt-1 inline-block">
                                    <?= esc($log['formatted_time']) ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>

</div>
<?= $this->endSection() ?>