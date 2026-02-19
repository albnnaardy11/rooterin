<div x-data="seoChecker()" class="bg-slate-900/50 p-8 sm:p-12 rounded-[3rem] border border-white/5 backdrop-blur-xl mt-12">
    <div class="flex items-center gap-4 mb-10">
        <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary border border-primary/20">
            <i class="ri-pulse-line text-xl"></i>
        </div>
        <div>
            <h3 class="text-xl font-heading font-black text-white tracking-tight">Real-time <span class="text-primary italic">SEO Score.</span></h3>
            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Live Content Optimization</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <div class="space-y-6">
            <div class="flex items-center justify-between p-4 rounded-2xl bg-white/5 border border-white/5">
                <span class="text-xs font-bold text-slate-300">Title Keywords</span>
                <span :class="score.title ? 'text-emerald-500' : 'text-slate-600'">
                    <i :class="score.title ? 'ri-checkbox-circle-fill' : 'ri-close-circle-line'" class="text-lg"></i>
                </span>
            </div>
            <div class="flex items-center justify-between p-4 rounded-2xl bg-white/5 border border-white/5">
                <span class="text-xs font-bold text-slate-300">Meta Description Length</span>
                <div class="flex items-center gap-3">
                    <span class="text-[10px] font-mono text-slate-500" x-text="metaLength + '/160'"></span>
                    <span :class="score.meta ? 'text-emerald-500' : 'text-slate-600'">
                        <i :class="score.meta ? 'ri-checkbox-circle-fill' : 'ri-close-circle-line'" class="text-lg"></i>
                    </span>
                </div>
            </div>
        </div>
        
        <div class="flex flex-col items-center justify-center space-y-4">
            <div class="relative w-32 h-32 flex items-center justify-center">
                <svg class="w-full h-full -rotate-90">
                    <circle cx="64" cy="64" r="58" stroke="currentColor" stroke-width="8" fill="transparent" class="text-white/5" />
                    <circle cx="64" cy="64" r="58" stroke="currentColor" stroke-width="8" fill="transparent" 
                            class="text-primary transition-all duration-1000"
                            :style="'stroke-dasharray: 364.4; stroke-dashoffset: ' + (364.4 - (364.4 * totalScore / 100))" />
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-3xl font-black text-white" x-text="totalScore + '%'"></span>
                    <span class="text-[8px] font-black text-slate-500 uppercase tracking-widest">SEO Rating</span>
                </div>
            </div>
            <p class="text-[10px] font-black uppercase tracking-[0.2em]" :class="totalScore > 70 ? 'text-emerald-500' : 'text-amber-500'" x-text="statusText"></p>
        </div>
    </div>
</div>

@once
    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('seoChecker', () => ({
                score: { title: false, meta: false, headings: false },
                totalScore: 0,
                metaLength: 0,
                statusText: 'Needs Optimization',

                init() {
                    const titleInput = document.querySelector('input[name="title"]');
                    const seoDescInput = document.querySelector('textarea[name="seo[description]"]');
                    const seoTitleInput = document.querySelector('input[name="seo[title]"]');
                    
                    const update = () => {
                        const title = titleInput.value.toLowerCase();
                        const seoTitle = seoTitleInput.value.toLowerCase();
                        const desc = seoDescInput.value;
                        
                        this.metaLength = desc.length;
                        
                        // Check if keywords from main title are in SEO title
                        this.score.title = seoTitle.length > 5 && title.split(' ').some(word => word.length > 3 && seoTitle.includes(word));
                        
                        // Check meta description length (120-160)
                        this.score.meta = desc.length >= 120 && desc.length <= 160;
                        
                        // Calculate
                        let current = 0;
                        if (this.score.title) current += 50;
                        if (this.score.meta) current += 50;
                        
                        this.totalScore = current;
                        this.statusText = current >= 100 ? 'SEO Optimized' : (current >= 50 ? 'Good' : 'Weak');
                    };

                    [titleInput, seoDescInput, seoTitleInput].forEach(el => {
                        if (el) el.addEventListener('input', update);
                    });
                    
                    setTimeout(update, 500);
                }
            }));
        });
    </script>
    @endpush
@endonce
