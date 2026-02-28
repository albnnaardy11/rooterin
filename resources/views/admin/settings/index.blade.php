@extends('admin.layout')

@section('content')
<div class="max-w-6xl mx-auto space-y-10">
    <!-- Header: Compact & Elegant -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center gap-5">
            <div class="w-14 h-14 bg-primary/10 border border-primary/20 rounded-2xl flex items-center justify-center text-primary shadow-inner">
                <i class="ri-settings-5-line text-3xl"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-heading font-black text-white tracking-tight">Site <span class="text-primary italic">Control.</span></h1>
                <p class="text-slate-500 font-bold uppercase text-[9px] tracking-[0.3em]">Master System Configuration</p>
            </div>
        </div>
        
        <div class="hidden sm:flex items-center gap-3 px-5 py-3 bg-slate-900/40 rounded-2xl border border-white/5 backdrop-blur-md">
            <div class="w-2 h-2 bg-primary rounded-full animate-pulse"></div>
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">System Online : v2.4.0</span>
        </div>
    </div>

    @if(session('success'))
    <div class="p-5 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-emerald-500 text-xs font-bold animate-in slide-in-from-right duration-500">
        <i class="ri-checkbox-circle-fill mr-2"></i> {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('admin.settings.bulk') }}" method="POST" class="space-y-10">
        @csrf
        
        <!-- Grid System: Optimized for Balance -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Column: Primary Settings -->
            <div class="lg:col-span-12 xl:col-span-8 space-y-8">
                @foreach($settings as $group => $items)
                <div class="bg-slate-900/40 rounded-[2rem] border border-white/5 overflow-hidden backdrop-blur-3xl shadow-2xl transition-all duration-500 hover:border-white/10">
                    <div class="px-8 py-5 border-b border-white/5 bg-gradient-to-r from-primary/5 to-transparent flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-1.5 h-1.5 bg-primary rounded-full"></span>
                            <h3 class="text-[11px] font-black uppercase tracking-[0.2em] text-white">{{ $group }} Core</h3>
                        </div>
                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">{{ count($items) }} Parameters</span>
                    </div>

                    <div class="p-2 space-y-1">
                        @foreach($items as $setting)
                        <div class="group relative flex flex-col sm:flex-row sm:items-center gap-4 p-6 rounded-2xl hover:bg-white/[0.03] transition-all">
                            <div class="w-full sm:w-1/3">
                                <label class="text-[10px] font-black text-slate-500 group-hover:text-primary transition-colors uppercase tracking-widest">
                                    {{ str_replace(['site_', '_'], ['', ' '], $setting->key) }}
                                </label>
                            </div>
                            
                            <div class="w-full sm:w-2/3 relative">
                                <input 
                                    type="text" 
                                    name="settings[{{ $setting->id }}]" 
                                    value="{{ $setting->value }}"
                                    class="w-full bg-slate-950/60 border border-white/5 rounded-xl px-5 py-3.5 text-white font-bold text-sm focus:outline-none focus:border-primary/40 focus:bg-slate-950 transition-all shadow-inner"
                                >
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 opacity-0 group-focus-within:opacity-100 transition-opacity">
                                    <i class="ri-edit-circle-line text-primary/50 text-lg"></i>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Right Column: Info & Action Hub (Optional/Extra space filling) -->
            <div class="hidden xl:block xl:col-span-4 space-y-8">
                <div class="bg-primary shadow-2xl shadow-primary/20 rounded-[2rem] p-8 text-white relative overflow-hidden group">
                    <!-- Deco -->
                    <i class="ri-shield-flash-line absolute -bottom-8 -right-8 text-white/10 text-[120px] rotate-12 group-hover:rotate-0 transition-transform duration-1000"></i>
                    
                    <h4 class="text-lg font-black tracking-tight mb-2">Protocol Sync</h4>
                    <p class="text-white/70 text-xs font-medium leading-relaxed mb-8">Setiap perubahan pada parameter ini akan berdampak langsung pada operasional sistem global.</p>
                    
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3">
                            <i class="ri-checkbox-circle-fill text-white/50"></i>
                            <span class="text-[10px] font-black uppercase tracking-widest">Global Encryption</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="ri-checkbox-circle-fill text-white/50"></i>
                            <span class="text-[10px] font-black uppercase tracking-widest">Cloud Handshake</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="ri-checkbox-circle-fill text-white/50"></i>
                            <span class="text-[10px] font-black uppercase tracking-widest">SEO Redirection</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-slate-900/40 border border-white/5 rounded-[2rem] p-8 backdrop-blur-xl">
                    <h5 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6">Environment Stats</h5>
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-white/60">Server Time</span>
                            <span class="text-xs font-black text-white">{{ now()->format('H:i') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-white/60">DB Driver</span>
                            <span class="text-xs font-black text-emerald-500 uppercase">MySQL 8.0</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-white/60">PHP Engine</span>
                            <span class="text-xs font-black text-primary">v8.2.1</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Floating Console: Sleeker & Better Aligned -->
        <div class="sticky bottom-8 z-50">
            <div class="bg-slate-950/80 backdrop-blur-2xl border border-white/10 rounded-[2.5rem] p-4 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-[0_30px_60px_-15px_rgba(0,0,0,0.7)] border-b-primary/30">
                <div class="flex items-center gap-4 px-6">
                    <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center text-primary">
                        <i class="ri-server-fill"></i>
                    </div>
                    <div class="hidden sm:block">
                        <h4 class="text-white font-black text-[10px] uppercase tracking-widest leading-none mb-1">Deployment Ready</h4>
                        <p class="text-slate-500 font-bold text-[8px] uppercase tracking-[0.2em]">Ready for secure synchronization</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <button type="reset" class="flex-1 sm:flex-none px-6 py-4 text-slate-500 hover:text-white text-[9px] font-black uppercase tracking-widest transition-all">
                        Discard Changes
                    </button>
                    <button type="submit" class="flex-1 sm:flex-none px-10 py-4 bg-primary text-white rounded-[1.5rem] text-[10px] font-black uppercase tracking-[0.2em] hover:shadow-2xl hover:shadow-primary/30 active:scale-95 transition-all flex items-center justify-center gap-3">
                        <i class="ri-refresh-line text-lg animate-spin-slow"></i>
                        Sync System
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow {
        animation: spin-slow 10s linear infinite;
    }
    [x-cloak] { display: none !important; }
</style>
@endsection
