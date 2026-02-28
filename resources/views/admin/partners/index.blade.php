@extends('admin.layout')

@section('content')
<div class="space-y-12">
    <!-- Header Strategy -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 animate-in fade-in slide-in-from-top duration-700">
        <div>
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-primary rounded-2xl flex items-center justify-center text-white shadow-2xl shadow-primary/40">
                    <i class="ri-building-2-line text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl sm:text-4xl font-heading font-black text-white tracking-tight">Alliance <span class="text-primary italic">Network.</span></h1>
                    <p class="text-slate-500 font-medium mt-1 uppercase text-[9px] tracking-[0.4em]">Industrial Partner Ecosystem</p>
                </div>
            </div>
        </div>
        
        <a href="{{ route('admin.partners.create') }}" class="group px-8 py-4 bg-primary text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:scale-105 active:scale-95 transition-all shadow-xl shadow-primary/20 flex items-center gap-3">
            <i class="ri-add-circle-line text-lg"></i>
            Ingest New Partner
        </a>
    </div>

    @if(session('success'))
    <div class="p-6 bg-emerald-500/10 border border-emerald-500/20 rounded-3xl text-emerald-500 text-sm font-bold animate-in zoom-in duration-300">
        <i class="ri-checkbox-circle-line mr-2"></i> {{ session('success') }}
    </div>
    @endif

    <!-- Partners Grid Matrix -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @forelse($partners as $partner)
        <div class="group relative bg-slate-900/40 rounded-[2.5rem] border border-white/5 overflow-hidden backdrop-blur-3xl transition-all duration-500 hover:border-primary/30">
            <!-- Action Overlay -->
            <div class="absolute top-6 right-6 flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity z-20">
                <a href="{{ route('admin.partners.edit', $partner->id) }}" class="w-10 h-10 bg-white/10 hover:bg-white/20 backdrop-blur-xl rounded-xl flex items-center justify-center text-white transition-all">
                    <i class="ri-edit-line"></i>
                </a>
                <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" onsubmit="return confirm('Disconnect this partner?')">
                    @csrf
                    @method('DELETE')
                    <button class="w-10 h-10 bg-red-500/10 hover:bg-red-500/20 backdrop-blur-xl rounded-xl flex items-center justify-center text-red-500 transition-all">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </form>
            </div>

            <div class="p-8 space-y-6">
                <!-- Logo Canvas -->
                <div class="aspect-square bg-slate-950/60 rounded-[2rem] flex items-center justify-center p-8 relative overflow-hidden group-hover:bg-slate-950 transition-colors border border-white/5">
                    <img src="{{ asset($partner->logo_path) }}" 
                         alt="{{ $partner->name }}" 
                         class="max-w-full max-h-full object-contain grayscale group-hover:grayscale-0 transition-all duration-700">
                    
                    @if(!$partner->is_active)
                    <div class="absolute inset-0 bg-slate-950/80 flex items-center justify-center">
                        <span class="px-4 py-1.5 bg-red-500 text-white text-[8px] font-black uppercase tracking-widest rounded-full">Inactive Connection</span>
                    </div>
                    @endif
                </div>

                <div class="space-y-2">
                    <h4 class="text-white font-black text-lg tracking-tight group-hover:text-primary transition-colors line-clamp-1">{{ $partner->name }}</h4>
                    <div class="flex items-center justify-between text-[8px] font-black uppercase tracking-[0.2em] text-slate-500">
                        <span>P-{{ str_pad($partner->id, 4, '0', STR_PAD_LEFT) }}</span>
                        <span class="flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 {{ $partner->is_active ? 'bg-emerald-500' : 'bg-red-500' }} rounded-full"></span>
                            {{ $partner->is_active ? 'Active Node' : 'Suspended' }}
                        </span>
                    </div>
                </div>

                @if($partner->website_url)
                <a href="{{ $partner->website_url }}" target="_blank" class="w-full py-3 bg-white/5 hover:bg-white/10 rounded-xl flex items-center justify-center text-[9px] font-black uppercase tracking-widest text-slate-400 group-hover:text-white transition-all border border-white/5">
                    Explore Node <i class="ri-external-link-line ml-2"></i>
                </a>
                @endif
            </div>

            <!-- Position Badge -->
            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-12 h-1.5 bg-primary/20 rounded-t-full group-hover:h-2 group-hover:bg-primary/50 transition-all"></div>
        </div>
        @empty
        <div class="col-span-full py-24 flex flex-col items-center justify-center text-center space-y-6 bg-slate-900/40 rounded-[3rem] border border-dashed border-white/10">
            <div class="w-20 h-20 bg-slate-800 rounded-3xl flex items-center justify-center text-slate-600">
                <i class="ri-building-fill text-4xl"></i>
            </div>
            <div class="space-y-2">
                <h3 class="text-white font-black text-xl uppercase tracking-widest">No Alliances Found</h3>
                <p class="text-slate-500 text-xs font-medium">Your network is currently isolated. Upload partner logos to build trust.</p>
            </div>
            <a href="{{ route('admin.partners.create') }}" class="px-8 py-3 bg-white/5 hover:bg-white/10 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                Initiate Connection
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection
