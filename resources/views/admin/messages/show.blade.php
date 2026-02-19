@extends('admin.layout')

@section('content')
<div class="space-y-12">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-6">
            <a href="{{ route('admin.messages.index') }}" class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/10 transition-all border border-white/5">
                <i class="ri-arrow-left-line text-2xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-heading font-black text-white tracking-tight">Message <span class="text-primary italic">Detail.</span></h1>
                <p class="text-slate-500 font-medium uppercase text-[10px] tracking-[0.3em]">Communication preview</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Message Content -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-slate-900/50 p-12 rounded-[3rem] border border-white/5 backdrop-blur-xl">
                <div class="flex items-center justify-between mb-10 pb-10 border-b border-white/5">
                    <div>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Subject</p>
                        <h2 class="text-2xl font-bold text-white">{{ $message->subject ?? 'General Inquiry' }}</h2>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Received</p>
                        <p class="text-sm font-bold text-slate-300">{{ $message->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                <div class="prose prose-invert max-w-none">
                    <p class="text-lg text-slate-300 leading-relaxed font-medium italic">
                        "{{ $message->message }}"
                    </p>
                </div>

                <div class="mt-16 pt-10 border-t border-white/5 flex items-center justify-between">
                    <div class="flex items-center gap-4 text-[10px] font-black uppercase tracking-widest text-slate-500">
                        <i class="ri-history-line text-primary text-base"></i>
                        Last Updated: {{ $message->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Sender Info -->
        <div class="space-y-8">
            <div class="bg-slate-900/50 p-10 rounded-[3rem] border border-white/5">
                <h3 class="text-lg font-black text-white mb-8 flex items-center gap-3">
                    <span class="w-1.5 h-6 bg-primary rounded-full"></span>
                    Sender Profile
                </h3>
                
                <div class="space-y-6">
                    <div class="p-6 bg-white/5 rounded-2xl border border-white/5">
                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Full Name</p>
                        <p class="text-sm font-bold text-white">{{ $message->name }}</p>
                    </div>
                    <div class="p-6 bg-white/5 rounded-2xl border border-white/5">
                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Email Address</p>
                        <p class="text-sm font-bold text-white">{{ $message->email }}</p>
                    </div>
                    <div class="p-6 bg-white/5 rounded-2xl border border-white/5">
                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Phone Number</p>
                        <p class="text-sm font-bold text-white">{{ $message->phone ?? 'Not provided' }}</p>
                    </div>
                </div>

                <div class="mt-10">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $message->phone) }}" target="_blank" class="flex items-center justify-center gap-3 w-full py-4 bg-primary text-white rounded-2xl font-black uppercase text-[10px] tracking-widest hover:scale-105 active:scale-95 transition-all shadow-xl shadow-primary/20">
                        <i class="ri-whatsapp-line text-xl"></i>
                        Reply via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
