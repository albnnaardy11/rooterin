<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RooterIn Admin - Dashboard Hub</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-heading { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-slate-950 text-slate-300">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-68 bg-[#0B1120] border-r border-white/5 flex flex-col h-screen sticky top-0 shadow-2xl">
            <!-- Header Section: Premium Branding -->
            <div class="px-7 py-8">
                <div class="flex items-center gap-3 group cursor-default">
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white shadow-[0_0_20px_rgba(16,185,129,0.3)] group-hover:shadow-primary/50 transition-all duration-500">
                        <i class="ri-flashlight-fill text-2xl"></i>
                    </div>
                    <div>
                        <span class="font-heading font-black text-xl text-white tracking-[0.1em] block leading-none">ROOTER<span class="text-primary italic">IN</span></span>
                        <div class="flex items-center gap-1.5 mt-1.5 opacity-50">
                            <span class="w-10 h-[2px] bg-primary/30 rounded-full"></span>
                            <p class="text-[7px] text-slate-400 font-black tracking-[0.4em] uppercase">Tech Core</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Area: Airy & Focused -->
            <nav class="flex-grow px-4 pb-4 space-y-1 overflow-y-auto no-scrollbar scroll-smooth" x-data="{ 
                activeGroup: '{{ (request()->routeIs('admin.posts.*') || request()->routeIs('admin.services.*') || request()->routeIs('admin.projects.*') || request()->routeIs('admin.wiki.*')) ? 'content' : ((request()->routeIs('admin.ai.intelligence.*') || request()->routeIs('admin.media.*') || request()->routeIs('admin.messages.*')) ? 'systems' : ((request()->routeIs('admin.vault.*') || request()->routeIs('admin.activity-logs.*') || request()->routeIs('admin.users.*')) ? 'security' : ((request()->routeIs('admin.settings.*') || request()->routeIs('admin.seo.*')) ? 'config' : ''))) }}' 
            }">
                
                <!-- Group: CORE -->
                <div class="mb-8">
                    <div class="px-4 py-2 text-[10px] font-black text-slate-500 uppercase tracking-[0.25em] mb-3 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary/40 animate-pulse"></span>
                        Management
                    </div>
                    <div class="space-y-1.5">
                        <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'bg-white/[0.04] text-white shadow-sm border border-white/5' : 'text-slate-400 hover:bg-white/[0.02] hover:text-white' }}">
                            <div class="w-8 h-8 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-slate-800/40' }} flex items-center justify-center transition-all">
                                <i class="ri-dashboard-fill text-lg"></i>
                            </div>
                            <span class="font-bold text-xs uppercase tracking-wider">Dashboard</span>
                            @if(request()->routeIs('admin.dashboard'))
                                <div class="ml-auto w-1 h-4 bg-primary rounded-full"></div>
                            @endif
                        </a>
                        <a href="{{ route('admin.sentinel.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.sentinel.*') ? 'bg-white/[0.04] text-white shadow-sm border border-white/5' : 'text-slate-400 hover:bg-white/[0.02] hover:text-white' }}">
                            <div class="w-8 h-8 rounded-xl {{ request()->routeIs('admin.sentinel.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'bg-slate-800/40' }} flex items-center justify-center transition-all">
                                <i class="ri-shield-flash-fill text-lg"></i>
                            </div>
                            <span class="font-bold text-xs uppercase tracking-wider">Sentinel</span>
                            @if(request()->routeIs('admin.sentinel.*'))
                                <div class="ml-auto w-1 h-4 bg-indigo-500 rounded-full"></div>
                            @endif
                        </a>
                    </div>
                </div>

                <!-- Grouped Navigation with Submenus -->
                <div class="space-y-2">
                    <!-- CONTENT -->
                    <div x-data="{ open: activeGroup === 'content' }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-[10px] font-black text-slate-400 hover:bg-white/[0.02] hover:text-white transition-all rounded-2xl group">
                            <div class="flex items-center gap-3">
                                <i class="ri-instance-line text-lg text-primary opacity-60"></i>
                                <span class="uppercase tracking-[0.2em]">Factory</span>
                            </div>
                            <i class="ri-arrow-right-s-line transition-transform duration-500 text-slate-600" :class="open ? 'rotate-90 text-primary' : ''"></i>
                        </button>
                        <div x-show="open" x-collapse class="mt-1 ml-4 border-l border-white/5 space-y-1">
                            <a href="{{ route('admin.posts.index') }}" class="flex items-center gap-3 pl-8 pr-4 py-2.5 transition-all {{ request()->routeIs('admin.posts.*') ? 'text-primary font-bold' : 'text-slate-500 hover:text-white' }}">
                                <span class="text-[11px] uppercase tracking-widest italic">Tips & Trik</span>
                            </a>
                            <a href="{{ route('admin.services.index') }}" class="flex items-center gap-3 pl-8 pr-4 py-2.5 transition-all {{ request()->routeIs('admin.services.*') ? 'text-primary font-bold' : 'text-slate-500 hover:text-white' }}">
                                <span class="text-[11px] uppercase tracking-widest italic">Layanan</span>
                            </a>
                            <a href="{{ route('admin.projects.index') }}" class="flex items-center gap-3 pl-8 pr-4 py-2.5 transition-all {{ request()->routeIs('admin.projects.*') ? 'text-primary font-bold' : 'text-slate-500 hover:text-white' }}">
                                <span class="text-[11px] uppercase tracking-widest italic">Portfolio</span>
                            </a>
                        </div>
                    </div>

                    <!-- SYSTEMS -->
                    <div x-data="{ open: activeGroup === 'systems' }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-[10px] font-black text-slate-400 hover:bg-white/[0.02] hover:text-white transition-all rounded-2xl group">
                            <div class="flex items-center gap-3">
                                <i class="ri-rocket-2-line text-lg text-orange-500 opacity-60"></i>
                                <span class="uppercase tracking-[0.2em]">Systems</span>
                            </div>
                            <i class="ri-arrow-right-s-line transition-transform duration-500 text-slate-600" :class="open ? 'rotate-90 text-orange-500' : ''"></i>
                        </button>
                        <div x-show="open" x-collapse class="mt-1 ml-4 border-l border-white/5 space-y-1">
                            <a href="{{ route('admin.media.index') }}" class="flex items-center gap-3 pl-8 pr-4 py-2.5 transition-all {{ request()->routeIs('admin.media.*') ? 'text-orange-500 font-bold' : 'text-slate-500 hover:text-white' }}">
                                <span class="text-[11px] uppercase tracking-widest italic">Media Hub</span>
                            </a>
                            <a href="{{ route('admin.ai.intelligence.index') }}" class="flex items-center gap-3 pl-8 pr-4 py-2.5 transition-all {{ request()->routeIs('admin.ai.intelligence.*') ? 'text-orange-500 font-bold' : 'text-slate-500 hover:text-white' }}">
                                <span class="text-[11px] uppercase tracking-widest italic">AI Core</span>
                            </a>
                        </div>
                    </div>

                    <!-- SECURITY -->
                    <div x-data="{ open: activeGroup === 'security' }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-[10px] font-black text-slate-400 hover:bg-white/[0.02] hover:text-white transition-all rounded-2xl group">
                            <div class="flex items-center gap-3">
                                <i class="ri-shield-user-line text-lg text-indigo-400 opacity-60"></i>
                                <span class="uppercase tracking-[0.2em]">Security</span>
                            </div>
                            <i class="ri-arrow-right-s-line transition-transform duration-500 text-slate-600" :class="open ? 'rotate-90 text-indigo-400' : ''"></i>
                        </button>
                        <div x-show="open" x-collapse class="mt-1 ml-4 border-l border-white/5 space-y-1">
                            <a href="{{ route('admin.vault.index') }}" class="flex items-center gap-3 pl-8 pr-4 py-2.5 transition-all {{ request()->routeIs('admin.vault.*') ? 'text-indigo-400 font-bold' : 'text-slate-500 hover:text-white' }}">
                                <span class="text-[11px] uppercase tracking-widest italic">Vault</span>
                            </a>
                            <a href="{{ route('admin.activity-logs.index') }}" class="flex items-center gap-3 pl-8 pr-4 py-2.5 transition-all {{ request()->routeIs('admin.activity-logs.*') ? 'text-indigo-400 font-bold' : 'text-slate-500 hover:text-white' }}">
                                <span class="text-[11px] uppercase tracking-widest italic">Audits</span>
                            </a>
                        </div>
                    </div>

                    <!-- CONFIG -->
                    <div x-data="{ open: activeGroup === 'config' }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-[10px] font-black text-slate-400 hover:bg-white/[0.02] hover:text-white transition-all rounded-2xl group">
                            <div class="flex items-center gap-3">
                                <i class="ri-equalizer-line text-lg text-emerald-400 opacity-60"></i>
                                <span class="uppercase tracking-[0.2em]">Config</span>
                            </div>
                            <i class="ri-arrow-right-s-line transition-transform duration-500 text-slate-600" :class="open ? 'rotate-90 text-emerald-400' : ''"></i>
                        </button>
                        <div x-show="open" x-collapse class="mt-1 ml-4 border-l border-white/5 space-y-1">
                            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 pl-8 pr-4 py-2.5 transition-all {{ request()->routeIs('admin.settings.*') ? 'text-emerald-400 font-bold' : 'text-slate-500 hover:text-white' }}">
                                <span class="text-[11px] uppercase tracking-widest italic">Settings</span>
                            </a>
                            <a href="{{ route('admin.seo.index') }}" class="flex items-center gap-3 pl-8 pr-4 py-2.5 transition-all {{ request()->routeIs('admin.seo.*') ? 'text-emerald-400 font-bold' : 'text-slate-500 hover:text-white' }}">
                                <span class="text-[11px] uppercase tracking-widest italic">SEO Hub</span>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Bottom Profile Footer: High-End Glassmorphism -->
            <div class="mt-auto p-4 border-t border-white/5 bg-slate-900/40 backdrop-blur-xl">
                <div class="flex items-center gap-3 p-3 rounded-2xl bg-white/[0.03] border border-white/5 group transition-all duration-500 hover:bg-white/5 hover:border-white/10">
                    <div class="relative flex-shrink-0">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary via-emerald-500 to-indigo-600 flex items-center justify-center border border-white/20 shadow-lg group-hover:scale-105 transition-transform duration-500">
                            <i class="ri-user-star-fill text-white text-lg"></i>
                        </div>
                        <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-green-500 border-2 border-[#0B1120] rounded-full shadow-sm animate-pulse"></span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-black text-white truncate tracking-wider uppercase">Super Admin</p>
                        <div class="flex items-center gap-1.5 mt-0.5">
                            <i class="ri-shield-check-fill text-[9px] text-primary"></i>
                            <p class="text-[8px] text-slate-500 truncate font-bold uppercase tracking-tight">System Identity Verified</p>
                        </div>
                    </div>
                </div>
                <a href="/" target="_blank" class="mt-4 flex items-center justify-center gap-2 w-full py-3.5 rounded-2xl bg-primary text-white text-[10px] font-black uppercase tracking-[0.25em] hover:shadow-[0_0_20px_rgba(16,185,129,0.4)] hover:-translate-y-0.5 transition-all duration-500 group">
                    <i class="ri-external-link-line group-hover:rotate-45 transition-transform duration-500"></i>
                    Visit Website
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow bg-slate-950 p-8 sm:p-12">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
