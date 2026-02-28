@extends('admin.layout')

@section('content')
<div class="max-w-4xl mx-auto space-y-12">
    <!-- Header Strategy -->
    <div class="flex items-center justify-between gap-8 animate-in fade-in slide-in-from-top duration-700">
        <div>
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('admin.partners.index') }}" class="w-10 h-10 bg-white/5 hover:bg-white/10 rounded-xl flex items-center justify-center text-white transition-all">
                    <i class="ri-arrow-left-line"></i>
                </a>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-heading font-black text-white tracking-tight">Ingest <span class="text-primary italic">Partner.</span></h1>
                    <p class="text-slate-500 font-medium mt-1 uppercase text-[8px] tracking-[0.4em]">Integrated Connection Protocol</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Interface -->
    <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        @csrf
        
        <!-- Left: Intelligence Info -->
        <div class="lg:col-span-8 space-y-8">
            <div class="bg-slate-900/40 rounded-[2.5rem] border border-white/5 p-8 sm:p-12 space-y-10 backdrop-blur-3xl shadow-2xl transition-all duration-500 hover:border-primary/20">
                
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <span class="w-1.5 h-6 bg-primary rounded-full"></span>
                        <h3 class="text-sm font-black uppercase tracking-[0.2em] text-white">Partner Identity</h3>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest pl-4">Company Name</label>
                        <input type="text" name="name" required value="{{ old('name') }}" 
                               class="w-full bg-slate-950/50 border border-white/5 rounded-2xl px-6 py-4 text-white font-bold text-sm focus:outline-none focus:border-primary/50 transition-all placeholder-slate-800 shadow-inner"
                               placeholder="Enter the official company name...">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest pl-4">Logo Branding (Transparent PNG Recommended)</label>
                        <div x-data="{ fileName: '', preview: '' }" class="relative">
                            <input type="file" name="logo" required accept="image/*"
                                   @change="fileName = $event.target.files[0].name; preview = URL.createObjectURL($event.target.files[0])"
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="w-full bg-slate-950/50 border border-dashed border-white/10 rounded-2xl px-6 py-10 text-center flex flex-col items-center justify-center gap-4 transition-all group hover:border-primary/40">
                                <template x-if="!preview">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center text-slate-600 group-hover:text-primary group-hover:bg-primary/10 transition-all">
                                            <i class="ri-upload-cloud-2-line text-3xl"></i>
                                        </div>
                                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Drop or select industrial logo</p>
                                    </div>
                                </template>
                                <template x-if="preview">
                                    <div class="flex flex-col items-center gap-4">
                                        <img :src="preview" class="h-24 object-contain">
                                        <p class="text-[10px] font-black text-primary uppercase tracking-widest" x-text="fileName"></p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest pl-4">Official Node (URL)</label>
                        <div class="relative">
                            <i class="ri-global-line absolute left-6 top-1/2 -translate-y-1/2 text-slate-700"></i>
                            <input type="url" name="website_url" value="{{ old('website_url') }}" 
                                   class="w-full bg-slate-950/50 border border-white/5 rounded-2xl pl-14 pr-6 py-4 text-white font-bold text-sm focus:outline-none focus:border-primary/50 transition-all placeholder-slate-800 shadow-inner"
                                   placeholder="https://company-official.com">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Control Center -->
        <div class="lg:col-span-4 space-y-8">
            <div class="bg-slate-900/40 rounded-[2.5rem] border border-white/5 p-8 space-y-8 backdrop-blur-3xl">
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <span class="w-1.5 h-6 bg-accent rounded-full"></span>
                        <h3 class="text-sm font-black uppercase tracking-[0.2em] text-white">Engagement Stats</h3>
                    </div>

                    <div class="p-6 bg-slate-950/60 rounded-3xl border border-white/5 space-y-6">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Connection Order</span>
                            <input type="number" name="order" value="0" 
                                   class="w-16 bg-white/5 border border-white/10 rounded-xl px-3 py-2 text-white font-black text-center focus:outline-none focus:border-primary transition-all">
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Active Node</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full px-8 py-5 bg-primary text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:scale-105 active:scale-95 transition-all shadow-xl shadow-primary/20 flex items-center justify-center gap-3">
                        <i class="ri-save-line text-lg"></i>
                        Confirm Integration
                    </button>
                    <p class="text-center text-[8px] text-slate-600 font-black uppercase tracking-widest mt-6">Secure System Entry v1.2</p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
