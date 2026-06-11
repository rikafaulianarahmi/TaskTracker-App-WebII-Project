<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Dashboard</h2>
        <p class="text-slate-500 mt-1">Selamat datang kembali, <span class="font-semibold text-slate-800"><?= esc($name) ?></span>. Berikut adalah rangkuman proyek Anda hari ini.</p>
    </div>
    
    <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm font-semibold text-slate-600 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-slate-400">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
        </svg>
        <?= date('d M Y') ?>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    
    <!-- Total Projects -->
    <div class="bg-white border-l-4 border-indigo-600 border-y border-r border-slate-200 p-6 rounded-2xl flex flex-col justify-between hover:shadow-xl hover:shadow-indigo-50/50 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
        <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-indigo-50/50 rounded-full blur-xl pointer-events-none"></div>
        <div class="flex items-start justify-between relative z-10">
            <div class="h-10 w-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-19.5 0A2.25 2.25 0 0 0 4.5 15h15a2.25 2.25 0 0 0 2.25-2.25m-19.5 0v.25A2.25 2.25 0 0 0 4.5 17.5h15a2.25 2.25 0 0 0 2.25-2.25m-19.5 0v.25a2.25 2.25 0 0 0 2.25 2.25h15a2.25 2.25 0 0 0 2.25-2.25m-19.5 0v-4.5A2.25 2.25 0 0 1 4.5 6h4.5a2.25 2.25 0 0 1 1.62.69l1.01 1.01a2.25 2.25 0 0 0 1.62.69h6A2.25 2.25 0 0 1 21.75 9.75v3.25" />
                </svg>
            </div>
        </div>
        <div class="mt-4 relative z-10">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Proyek</span>
            <h3 class="text-3xl font-black text-slate-800 mt-1"><?= $totalProjects ?></h3>
        </div>
    </div>

    <!-- Active Tasks -->
    <div class="bg-white border-l-4 border-sky-500 border-y border-r border-slate-200 p-6 rounded-2xl flex flex-col justify-between hover:shadow-xl hover:shadow-sky-50/50 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
        <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-sky-50/50 rounded-full blur-xl pointer-events-none"></div>
        <div class="flex items-start justify-between relative z-10">
            <div class="h-10 w-10 bg-sky-50 text-sky-600 rounded-xl flex items-center justify-center shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
        </div>
        <div class="mt-4 relative z-10">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tugas Aktif</span>
            <h3 class="text-3xl font-black text-slate-800 mt-1"><?= $activeTasks ?></h3>
        </div>
    </div>

    <!-- Due Today -->
    <div class="bg-white border-l-4 border-amber-500 border-y border-r border-slate-200 p-6 rounded-2xl flex flex-col justify-between hover:shadow-xl hover:shadow-amber-50/50 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
        <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-amber-50/50 rounded-full blur-xl pointer-events-none"></div>
        <div class="flex items-start justify-between relative z-10">
            <div class="h-10 w-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <?php if ($dueToday > 0): ?>
                <span class="text-[9px] font-extrabold text-amber-700 bg-amber-100 border border-amber-200 px-2 py-0.5 rounded tracking-wider">PENTING</span>
            <?php endif; ?>
        </div>
        <div class="mt-4 relative z-10">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tenggat Hari Ini</span>
            <h3 class="text-3xl font-black text-slate-800 mt-1"><?= $dueToday ?></h3>
        </div>
    </div>

    <!-- Overdue -->
    <div class="bg-white border-l-4 border-rose-500 border-y border-r border-slate-200 p-6 rounded-2xl flex flex-col justify-between hover:shadow-xl hover:shadow-rose-50/50 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
        <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-rose-50/50 rounded-full blur-xl pointer-events-none"></div>
        <div class="flex items-start justify-between relative z-10">
            <div class="h-10 w-10 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
            </div>
            <?php if ($overdue > 0): ?>
                <span class="text-[9px] font-extrabold text-rose-700 bg-rose-100 border border-rose-200 px-2 py-0.5 rounded tracking-wider">KRITIS</span>
            <?php endif; ?>
        </div>
        <div class="mt-4 relative z-10">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Terlambat (Overdue)</span>
            <h3 class="text-3xl font-black text-rose-600 mt-1"><?= $overdue ?></h3>
        </div>
    </div>

</div>

<!-- Content Columns -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Left Area (Proyek Baru & Tugas Saya) - Takes 2 cols on desktop -->
    <div class="lg:col-span-2 space-y-8">
        
        <!-- Recent Projects Widget -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Proyek Terbaru</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Daftar proyek aktif Anda</p>
                </div>
                <a href="<?= site_url('projects') ?>" class="text-xs font-bold bg-indigo-50 hover:bg-indigo-100 text-indigo-700 px-3 py-1.5 rounded-lg transition-colors">Lihat Semua</a>
            </div>
            
            <div class="space-y-4">
                <?php if (empty($recentProjects)): ?>
                    <p class="text-sm text-slate-400 py-4 text-center">Belum ada proyek yang aktif.</p>
                <?php else: ?>
                    <?php foreach ($recentProjects as $p): ?>
                        <div class="flex items-center justify-between p-4 border border-slate-100 rounded-xl hover:border-slate-200 hover:bg-slate-50/30 transition-all duration-200 gap-4">
                            <div class="flex items-center gap-4 min-w-0 flex-1">
                                <div class="h-11 w-11 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center font-bold border border-indigo-100 shadow-sm shrink-0">
                                    <?= strtoupper(substr($p['title'], 0, 1)) ?>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h4 class="font-bold text-slate-900 text-sm truncate">
                                        <a href="<?= site_url('projects/' . $p['id']) ?>" class="hover:text-indigo-600 transition-colors">
                                            <?= esc($p['title']) ?>
                                        </a>
                                    </h4>
                                    <p class="text-xs text-slate-500 mt-0.5 truncate"><?= esc($p['description'] ?: 'Tidak ada deskripsi.') ?></p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-6 shrink-0 w-44">
                                <div class="flex-1">
                                    <div class="flex justify-between items-center mb-1 text-[10px] font-bold text-slate-500">
                                        <span class="<?= $p['tagColor'] ?> border px-2 py-0.5 rounded text-[8px] font-extrabold tracking-wider leading-none uppercase"><?= $p['statusLabel'] ?></span>
                                        <span><?= $p['percent'] ?>%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden shadow-inner">
                                        <div class="<?= $p['barColor'] ?> h-full rounded-full transition-all duration-500" style="width: <?= $p['percent'] ?>%"></div>
                                    </div>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-slate-400 shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <?php if (session()->get('role') !== 'klien'): ?>
        <!-- My Tasks Widget -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Tugas Saya</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Daftar tugas yang di-assign untuk Anda</p>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-left">
                            <th class="pb-3 w-8"></th>
                            <th class="pb-3 pl-2">Nama Tugas</th>
                            <th class="pb-3">Proyek</th>
                            <th class="pb-3">Tenggat</th>
                            <th class="pb-3 text-right">Prioritas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php if (empty($myTasks)): ?>
                            <tr>
                                <td colspan="5" class="py-8 text-center text-sm text-slate-400">
                                    Tidak ada tugas tertunda untuk Anda.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($myTasks as $t): ?>
                                <tr class="group hover:bg-slate-50/50 transition-colors">
                                    <td class="py-4">
                                        <input type="checkbox" disabled class="h-4.5 w-4.5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-not-allowed">
                                    </td>
                                    <td class="py-4 pl-2">
                                        <span class="font-semibold text-slate-950 text-sm"><?= esc($t['title']) ?></span>
                                    </td>
                                    <td class="py-4">
                                        <span class="text-xs text-slate-500 font-medium"><?= esc($t['project_title']) ?></span>
                                    </td>
                                    <td class="py-4">
                                        <span class="text-xs font-semibold <?= strtotime($t['deadline']) <= strtotime(date('Y-m-d')) ? 'text-rose-600' : 'text-slate-500' ?>">
                                            <?= date('d M Y', strtotime($t['deadline'])) ?>
                                        </span>
                                    </td>
                                    <td class="py-4 text-right">
                                        <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full inline-block
                                            <?= $t['priority'] === 'high' ? 'bg-rose-50 text-rose-700' : ($t['priority'] === 'medium' ? 'bg-amber-50 text-amber-700' : 'bg-slate-100 text-slate-700') ?>">
                                            <?= $t['priority'] ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

    </div>

    <!-- Right Area  -->
    <div class="space-y-8">
        
        <!-- Upcoming Deadlines -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <div class="flex items-center gap-2 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-indigo-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <h3 class="text-lg font-bold text-slate-900">Deadline Terdekat</h3>
            </div>
            
            <div class="relative pl-4 border-l border-slate-100 space-y-6">
                <?php if (empty($upcomingDeadlines)): ?>
                    <p class="text-sm text-slate-400 py-2">Tidak ada deadline terdekat.</p>
                <?php else: ?>
                    <?php foreach ($upcomingDeadlines as $u): ?>
                        <div class="relative">
                            <!-- Bullet marker -->
                            <div class="absolute -left-[21px] top-1.5 w-2.5 h-2.5 rounded-full border-2 border-white bg-indigo-600"></div>
                            
                            <span class="text-[10px] font-extrabold text-indigo-600 uppercase tracking-wider block">
                                <?php 
                                    $diff = (strtotime($u['deadline']) - strtotime(date('Y-m-d'))) / 86400;
                                    if ($diff == 0) echo 'Hari Ini';
                                    elseif ($diff == 1) echo 'Besok';
                                    else echo floor($diff) . ' hari lagi';
                                ?>
                            </span>
                            <h4 class="font-bold text-slate-900 text-sm mt-0.5"><?= esc($u['title']) ?></h4>
                            <p class="text-xs text-slate-500 mt-1"><?= esc($u['project_title']) ?> • <?= date('d M Y', strtotime($u['deadline'])) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Team Pulse (Activity Logs) -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <div class="flex items-center gap-2 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-indigo-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
                <h3 class="text-lg font-bold text-slate-900">Aktivitas Tim</h3>
            </div>
            
            <div class="space-y-4">
                <?php if (empty($recentLogs)): ?>
                    <p class="text-sm text-slate-400 py-2">Belum ada aktivitas tercatat.</p>
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