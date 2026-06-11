<?php helper('url'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> — TaskTracker</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #F5F8FF;
        }
        ::-webkit-scrollbar-thumb {
            background: #D9E2FC;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #C3D0FA;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-[#F5F8FF] via-[#EEF2FF] to-[#E5EDFF] text-slate-800 antialiased min-h-screen flex flex-col">

    <div id="sidebar-backdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 hidden transition-opacity duration-300 opacity-0"></div>

    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-[#EEF2FF] border-r border-indigo-100 flex flex-col justify-between h-screen transition-transform duration-300 ease-in-out -translate-x-full shadow-xl">
        <div>
            <!-- Header Logo -->
            <div class="px-6 py-6 flex items-center justify-between border-b border-indigo-50/50">
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 bg-[#4F46E5] rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-md shadow-indigo-200">
                        T
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900 tracking-tight leading-none">TaskTracker</h1>
                        <span class="text-[10px] text-indigo-600 font-bold tracking-wide mt-1 block">Vibrant Productivity</span>
                    </div>
                </div>

                <!-- Sidebar Close Button -->
                <button id="sidebar-close" class="text-slate-600 hover:text-slate-900 p-1.5 rounded-lg hover:bg-indigo-50/50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="mt-6 px-3 space-y-1">
                <?php 
                    $current_uri = current_url(true)->getPath(); 
                ?>
                <!-- Dashboard Link -->
                <a href="<?= site_url('dashboard') ?>" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all duration-200 <?= (strpos($current_uri, 'dashboard') !== false) ? 'bg-[#E0E7FF] text-[#4F46E5]' : 'text-slate-600 hover:bg-[#E0E7FF]/40 hover:text-slate-900' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25A2.25 2.25 0 0 1 13.5 8.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                    Dashboard
                </a>

                <!-- Projects Link -->
                <a href="<?= site_url('projects') ?>" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all duration-200 <?= (strpos($current_uri, 'projects') !== false) ? 'bg-[#E0E7FF] text-[#4F46E5]' : 'text-slate-600 hover:bg-[#E0E7FF]/40 hover:text-slate-900' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-19.5 0A2.25 2.25 0 0 0 4.5 15h15a2.25 2.25 0 0 0 2.25-2.25m-19.5 0v.25A2.25 2.25 0 0 0 4.5 17.5h15a2.25 2.25 0 0 0 2.25-2.25m-19.5 0v.25a2.25 2.25 0 0 0 2.25 2.25h15a2.25 2.25 0 0 0 2.25-2.25m-19.5 0v-4.5A2.25 2.25 0 0 1 4.5 6h4.5a2.25 2.25 0 0 1 1.62.69l1.01 1.01a2.25 2.25 0 0 0 1.62.69h6A2.25 2.25 0 0 1 21.75 9.75v3.25" />
                    </svg>
                    Projects
                </a>

                <!-- Kanban Board -->
                <a href="#" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold text-slate-600 hover:bg-[#E0E7FF]/40 hover:text-slate-900 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.03 0 1.9.693 2.166 1.638m-7.377 0A48.536 48.536 0 0 1 12 3m0 0c2.917 0 5.747.294 8.5.862m-21 10.398c0-.552.448-1 1-1h6.25a1 1 0 0 1 1 1v3.83a1 1 0 0 1-1 1H2.5a1 1 0 0 1-1-1v-3.83Z" />
                    </svg>
                    Kanban Board
                </a>

                <!-- Timeline -->
                <a href="#" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold text-slate-600 hover:bg-[#E0E7FF]/40 hover:text-slate-900 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                    </svg>
                    Timeline
                </a>
            </nav>
        </div>

        <!-- Sidebar Bottom (Action & Logout) -->
        <div class="p-4 border-t border-indigo-100/30">
            <?php if (session()->get('role') === 'admin'): ?>
                <a href="<?= site_url('projects/create') ?>" 
                   class="flex items-center justify-center gap-2 w-full py-3 px-4 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 active:scale-95 text-white rounded-xl text-sm font-bold transition-all duration-200 shadow-md shadow-indigo-100 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    New Project
                </a>
            <?php endif; ?>

            <a href="<?= site_url('logout') ?>" 
               class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-700 hover:text-slate-950 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-slate-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                </svg>
                Logout
            </a>
        </div>
    </aside>

    <!-- MAIN CONTAINER -->
    <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden relative">
        <!-- Top Gradient Background Accent -->
        <div class="absolute top-0 left-0 right-0 h-[380px] bg-gradient-to-b from-[#4F46E5]/25 via-[#8B5CF6]/10 to-transparent pointer-events-none z-0"></div>
        
        <!-- TOP NAVBAR -->
        <header class="h-20 bg-transparent flex items-center justify-between px-8 sticky top-0 z-30 shrink-0">
            <!-- Sidebar Toggle & Search bar -->
            <div class="flex items-center w-96 relative">
                <button id="sidebar-toggle" class="text-slate-600 hover:text-slate-900 p-2.5 hover:bg-white/60 rounded-full mr-3 shrink-0 shadow-sm border border-slate-200/50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.602 10.602Z" />
                        </svg>
                    </span>
                    <input type="text" 
                           placeholder="Search tasks or projects..." 
                           class="w-full bg-white border border-slate-200/60 rounded-full pl-12 pr-4 py-2.5 text-sm text-slate-800 placeholder-slate-500 focus:outline-none focus:border-indigo-400 focus:ring-1 focus:ring-indigo-400 transition-all duration-200 shadow-sm">
                </div>
            </div>

            <!-- Profile and Icons -->
            <div class="flex items-center gap-6">
                <!-- Notifications button -->
                <button class="text-slate-600 hover:text-slate-900 transition-colors duration-200 relative p-1.5 hover:bg-white/50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                    </svg>
                    <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-rose-500 border-2 border-[#F5F8FF] rounded-full"></span>
                </button>

                <!-- Settings button -->
                <button class="text-slate-600 hover:text-slate-900 transition-colors duration-200 p-1.5 hover:bg-white/50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.43l-1.003.828c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.43l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </button>

                <!-- Vertical Divider -->
                <div class="h-6 w-px bg-slate-200"></div>

                <!-- Profile Info -->
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="text-sm font-bold text-slate-900 leading-none"><?= esc(session()->get('user_name') ?? 'Admin User') ?></p>
                        <span class="text-[10px] font-bold text-slate-700 mt-1 inline-block"><?= esc(session()->get('role') === 'admin' ? 'Lead Designer' : (session()->get('role') === 'member' ? 'Member' : 'Client')) ?></span>
                    </div>
                    <!-- Initials Avatar -->
                    <?php 
                        $name = session()->get('user_name') ?? 'Admin User';
                        $initials = '';
                        $words = explode(' ', $name);
                        for ($i = 0; $i < min(2, count($words)); $i++) {
                            $initials .= strtoupper(substr($words[$i], 0, 1));
                        }
                    ?>
                    <div class="h-10 w-10 bg-indigo-100 text-indigo-700 font-bold rounded-xl flex items-center justify-center border border-indigo-200 text-sm">
                        <?= $initials ?>
                    </div>
                </div>
            </div>
        </header>

        <!-- CONTENT SECTION -->
        <main class="flex-1 p-8">
            <?= $this->renderSection('content') ?>
        </main>
        
    </div>

    <!-- Collapsible Sidebar Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            const toggleBtns = document.querySelectorAll('#sidebar-toggle');
            const closeBtn = document.getElementById('sidebar-close');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                backdrop.classList.remove('hidden');
                setTimeout(() => {
                    backdrop.classList.remove('opacity-0');
                    backdrop.classList.add('opacity-100');
                }, 10);
            }

            function closeSidebar() {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.remove('opacity-100');
                backdrop.classList.add('opacity-0');
                setTimeout(() => {
                    backdrop.classList.add('hidden');
                }, 300);
            }

            toggleBtns.forEach(btn => btn.addEventListener('click', openSidebar));
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            backdrop.addEventListener('click', closeSidebar);
        });
    </script>

</body>
</html>
