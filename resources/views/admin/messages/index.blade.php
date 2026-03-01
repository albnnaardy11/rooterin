@extends('admin.layout')

@section('content')
<div class="space-y-12">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl sm:text-4xl font-heading font-black text-white tracking-tight">Customer <span class="text-primary italic">Messages.</span></h1>
            <p class="text-slate-500 font-medium mt-2 uppercase text-[10px] tracking-[0.3em]">Communication management</p>
        </div>
    </div>

    <!-- Messages Table -->
    <div class="bg-slate-900/50 rounded-[2rem] border border-white/5 overflow-hidden backdrop-blur-xl">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white/5 border-b border-white/5">
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-500 tracking-widest">Sender</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-500 tracking-widest">Subject</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-500 tracking-widest">Status</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-500 tracking-widest">Received</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-500 tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($messages as $msg)
                <tr class="hover:bg-white/[0.02] transition-colors group">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary font-bold">
                                {{ substr($msg->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-white">{{ $msg->name }}</p>
                                <p class="text-[10px] text-slate-500">{{ $msg->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <p class="text-sm text-slate-300 font-medium">{{ $msg->subject ?? 'General Inquiry' }}</p>
                        <p class="text-[10px] text-slate-500 line-clamp-1 italic">{{ $msg->message }}</p>
                    </td>
                    <td class="px-8 py-6">
                        <span class="px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest {{ $msg->status == 'new' ? 'bg-primary/20 text-primary' : ($msg->status == 'read' ? 'bg-blue-500/20 text-blue-400' : 'bg-slate-800 text-slate-400') }}">
                            {{ $msg->status }}
                        </span>
                    </td>
                    <td class="px-8 py-6 text-[10px] font-bold text-slate-500 uppercase">
                        {{ $msg->created_at->diffForHumans() }}
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.messages.show', $msg->id) }}" class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition-all">
                                <i class="ri-eye-line text-lg"></i>
                            </a>
                            <form id="deleteMsgForm_{{ $msg->id }}" action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="CMS.confirmAction('deleteMsgForm_{{ $msg->id }}', '{{ addslashes($msg->name) }}', 'Hapus Pesan?')" class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 hover:bg-red-500 hover:text-white transition-all">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($messages->isEmpty())
        <div class="py-24 text-center">
            <div class="w-20 h-20 bg-white/5 rounded-3xl flex items-center justify-center mx-auto mb-6">
                <i class="ri-mail-open-line text-4xl text-slate-700"></i>
            </div>
            <p class="text-sm text-slate-500 font-black uppercase tracking-widest">No messages found</p>
        </div>
        @endif

        <div class="p-8 border-t border-white/5">
            {{ $messages->links() }}
        </div>
    </div>
</div>
@endsection
