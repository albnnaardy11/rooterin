@extends('admin.layout')

@section('content')
<div class="max-w-7xl mx-auto space-y-10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center gap-5">
            <div class="w-14 h-14 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex items-center justify-center text-emerald-500 shadow-inner">
                <i class="ri-brain-line text-3xl"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-heading font-black text-white tracking-tight">AI Command <span class="text-emerald-500 italic">Center.</span></h1>
                <p class="text-slate-500 font-bold uppercase text-[9px] tracking-[0.3em]">Enterprise Intelligence Gateway</p>
            </div>
        </div>
        
        <div class="hidden sm:flex items-center gap-3 px-5 py-3 bg-slate-900/40 rounded-2xl border border-white/5 backdrop-blur-md">
            <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Gateway : ACTIVE</span>
        </div>
    </div>

    @if(session('success'))
    <div class="p-5 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-emerald-500 text-xs font-bold animate-in slide-in-from-right duration-500">
        <i class="ri-checkbox-circle-fill mr-2"></i> {{ session('success') }}
    </div>
    @endif

    <!-- 1. Telemetry Dashboard (Top Stats) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-slate-900/40 border border-white/5 rounded-[2rem] p-6 backdrop-blur-md relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 text-white/5 text-7xl group-hover:scale-110 transition-transform"><i class="ri-pulse-line"></i></div>
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Total Requests (Today)</p>
            <h2 class="text-4xl font-black text-white">{{ number_format($totalRequests) }}</h2>
        </div>
        
        <div class="bg-slate-900/40 border border-emerald-500/20 rounded-[2rem] p-6 backdrop-blur-md relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 text-emerald-500/5 text-7xl group-hover:scale-110 transition-transform"><i class="ri-check-double-line"></i></div>
            <p class="text-[10px] font-black text-emerald-500/70 uppercase tracking-widest mb-2">Success Rate</p>
            <h2 class="text-4xl font-black text-emerald-500">
                {{ $totalRequests > 0 ? round(($successRequests / $totalRequests) * 100) : 100 }}%
            </h2>
        </div>

        <div class="bg-slate-900/40 border {{ $failedRequests > 0 ? 'border-red-500/30' : 'border-white/5' }} rounded-[2rem] p-6 backdrop-blur-md relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 text-red-500/5 text-7xl group-hover:scale-110 transition-transform"><i class="ri-spam-line"></i></div>
            <p class="text-[10px] font-black text-red-500/70 uppercase tracking-widest mb-2">Failed / Rate Limit</p>
            <h2 class="text-4xl font-black {{ $failedRequests > 0 ? 'text-red-500' : 'text-white' }}">{{ number_format($failedRequests) }}</h2>
        </div>

        <div class="bg-slate-900/40 border border-primary/20 rounded-[2rem] p-6 backdrop-blur-md relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 text-primary/5 text-7xl group-hover:scale-110 transition-transform"><i class="ri-speed-up-line"></i></div>
            <p class="text-[10px] font-black text-primary/70 uppercase tracking-widest mb-2">Avg. Latency</p>
            <h2 class="text-4xl font-black text-primary">{{ $avgLatency }} <span class="text-lg">ms</span></h2>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- 2. Feature Quotas (Left) -->
        <div class="lg:col-span-8 space-y-6">
            <div class="flex items-center justify-between px-2">
                <h3 class="text-sm font-black text-white uppercase tracking-widest">Resource Allocation</h3>
                <span class="text-[10px] font-bold text-slate-500 uppercase">Token Bucket Strategy</span>
            </div>

            <div class="space-y-4">
                @foreach($quotas as $quota)
                <div class="bg-slate-900/40 border border-white/5 rounded-[2rem] p-6 backdrop-blur-md hover:border-white/10 transition-all">
                    <form action="{{ route('admin.ai-gateway.quota.update', $quota->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                            
                            <!-- Feature Info -->
                            <div class="w-full md:w-1/3">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-slate-300">
                                        <i class="ri-cpu-line"></i>
                                    </div>
                                    <h4 class="text-sm font-black text-white uppercase tracking-wider">{{ $quota->feature_name }}</h4>
                                </div>
                                @php
                                    $percentage = $quota->daily_limit > 0 ? ($quota->current_usage / $quota->daily_limit) * 100 : 0;
                                    $barColor = $percentage > 90 ? 'bg-red-500' : ($percentage > 70 ? 'bg-orange-500' : 'bg-emerald-500');
                                @endphp
                                <div class="w-full bg-slate-950 rounded-full h-1.5 mt-4">
                                    <div class="{{ $barColor }} h-1.5 rounded-full transition-all duration-1000" style="width: {{ min($percentage, 100) }}%"></div>
                                </div>
                                <div class="flex justify-between mt-2">
                                    <span class="text-[9px] text-slate-500 font-bold">Usage: {{ $quota->current_usage }}</span>
                                    <span class="text-[9px] text-slate-500 font-bold">{{ round($percentage) }}%</span>
                                </div>
                            </div>

                            <!-- Settings Controls -->
                            <div class="w-full md:w-2/3 flex flex-col sm:flex-row items-end sm:items-center gap-4">
                                <div class="flex-1 w-full">
                                    <label class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-2 block">Daily Limit</label>
                                    <input type="number" name="daily_limit" value="{{ $quota->daily_limit }}" 
                                        class="w-full bg-slate-950/60 border border-white/5 rounded-xl px-4 py-3 text-white font-bold text-xs focus:border-emerald-500/50 outline-none">
                                </div>
                                
                                <div class="flex-1 w-full">
                                    <label class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-2 block">Model Routing</label>
                                    <select name="assigned_model" class="w-full bg-slate-950/60 border border-white/5 rounded-xl px-4 py-3 text-white font-bold text-xs focus:border-emerald-500/50 outline-none appearance-none">
                                        <option value="gemini" {{ $quota->assigned_model === 'gemini' ? 'selected' : '' }}>Gemini (Fallback to Groq)</option>
                                        <option value="groq" {{ $quota->assigned_model === 'groq' ? 'selected' : '' }}>Groq Llama-3 (Strict)</option>
                                    </select>
                                </div>

                                <button type="submit" class="w-full sm:w-auto mt-4 sm:mt-0 px-6 py-3.5 bg-white/5 hover:bg-emerald-500/20 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                                    Save
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
                @endforeach
            </div>
        </div>

        <!-- 3. Usage Analytics (Right) -->
        <div class="lg:col-span-4 space-y-6">
            <div class="flex items-center justify-between px-2">
                <h3 class="text-sm font-black text-white uppercase tracking-widest">Today's Heatmap</h3>
            </div>

            <div class="bg-slate-900/40 border border-white/5 rounded-[2rem] p-6 backdrop-blur-md">
                @if($featureStats->isEmpty())
                <div class="text-center py-10">
                    <i class="ri-sleep-line text-4xl text-slate-600 mb-3 block"></i>
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">No AI Activity Today</p>
                </div>
                @else
                <div class="space-y-6">
                    @foreach($featureStats as $stat)
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-white uppercase">{{ $stat->feature_name }}</span>
                            <span class="text-xs font-black text-emerald-500">{{ $stat->total }} req</span>
                        </div>
                        <div class="w-full bg-slate-950 rounded-full h-1">
                            <div class="bg-white/20 h-1 rounded-full" style="width: {{ ($stat->total / max($totalRequests, 1)) * 100 }}%"></div>
                        </div>
                        <p class="text-[9px] text-slate-500 mt-1 font-bold tracking-wider">Avg Latency: {{ round($stat->avg_latency) }}ms</p>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="bg-gradient-to-br from-emerald-500/10 to-primary/10 border border-emerald-500/20 rounded-[2rem] p-6 backdrop-blur-md">
                <h4 class="text-xs font-black text-white uppercase tracking-widest mb-2 flex items-center gap-2">
                    <i class="ri-shield-check-fill text-emerald-500"></i> Circuit Breaker
                </h4>
                <p class="text-xs text-slate-400 font-medium leading-relaxed">
                    Sistem 40-Year Veteran ini menggunakan *Token Bucket* dan perlindungan lonjakan lalu lintas otomatis. Jika salah satu API Key Anda terblokir, trafik akan dialihkan dalam hitungan milidetik tanpa interupsi pada pengunjung website.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
