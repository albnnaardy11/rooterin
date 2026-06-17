@props(['name', 'value' => 'ri-drop-line'])

@php
    $pickerId = 'icon_picker_' . uniqid();
@endphp

<div id="{{ $pickerId }}" class="w-full">
    <div class="flex items-center gap-4">
        <!-- Preview Box -->
        <div class="w-16 h-16 shrink-0 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-3xl text-primary transition-all" id="{{ $pickerId }}_preview">
            <i class="{{ $value }}"></i>
        </div>
        
        <!-- Input & Button -->
        <div class="flex-1 flex gap-2">
            <input type="text" name="{{ $name }}" id="{{ $pickerId }}_input" value="{{ $value }}" readonly
                   class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-white focus:outline-none focus:border-primary/50 transition-all font-bold cursor-not-allowed text-sm">
            
            <button type="button" id="{{ $pickerId }}_btn" class="px-6 py-4 bg-primary text-white rounded-xl font-black uppercase text-[10px] tracking-widest hover:scale-105 active:scale-95 transition-all shadow-xl shadow-primary/20 whitespace-nowrap">
                <i class="ri-search-eye-line mr-2"></i> Browse
            </button>
        </div>
    </div>

    <!-- Modal Overlay -->
    <div id="{{ $pickerId }}_modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4 sm:p-8 opacity-0 transition-opacity duration-300">
        <div class="bg-slate-900 border border-white/10 w-full max-w-4xl rounded-[2rem] shadow-2xl flex flex-col h-[85vh] transform scale-95 transition-transform duration-300" id="{{ $pickerId }}_modal_content">
            
            <!-- Modal Header -->
            <div class="p-6 sm:p-8 border-b border-white/5 flex items-center justify-between shrink-0">
                <div>
                    <h3 class="text-xl sm:text-2xl font-heading font-black text-white">Remix Icon <span class="text-primary italic">Library.</span></h3>
                    <p class="text-slate-500 text-[10px] uppercase tracking-widest mt-1">Select from thousands of icons</p>
                </div>
                <button type="button" id="{{ $pickerId }}_close" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-slate-400 hover:text-white hover:bg-red-500/20 transition-all">
                    <i class="ri-close-line text-xl"></i>
                </button>
            </div>

            <!-- Search Bar -->
            <div class="p-6 border-b border-white/5 bg-black/20 shrink-0">
                <div class="relative">
                    <i class="ri-search-line absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-lg"></i>
                    <input type="text" id="{{ $pickerId }}_search" placeholder="Search icons (e.g. water, home, user)..." 
                           class="w-full bg-white/5 border border-white/10 rounded-xl pl-12 pr-4 py-4 text-white focus:outline-none focus:border-primary/50 transition-all font-medium placeholder-slate-600">
                </div>
            </div>

            <!-- Icons Grid -->
            <div class="flex-1 overflow-y-auto p-6 custom-scrollbar">
                <div id="{{ $pickerId }}_loading" class="flex flex-col items-center justify-center h-full text-slate-500">
                    <i class="ri-loader-4-line text-4xl animate-spin text-primary mb-4"></i>
                    <p class="text-xs uppercase tracking-widest font-black">Fetching library...</p>
                </div>
                
                <div id="{{ $pickerId }}_grid" class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 lg:grid-cols-10 gap-4 hidden">
                    <!-- Icons will be injected here -->
                </div>
                
                <div id="{{ $pickerId }}_empty" class="hidden flex-col items-center justify-center h-full text-slate-500">
                    <i class="ri-ghost-line text-4xl mb-4"></i>
                    <p class="text-xs uppercase tracking-widest font-black">No icons found</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pickerId = '{{ $pickerId }}';
    const btn = document.getElementById(pickerId + '_btn');
    const closeBtn = document.getElementById(pickerId + '_close');
    const modal = document.getElementById(pickerId + '_modal');
    const modalContent = document.getElementById(pickerId + '_modal_content');
    const searchInput = document.getElementById(pickerId + '_search');
    const grid = document.getElementById(pickerId + '_grid');
    const loading = document.getElementById(pickerId + '_loading');
    const empty = document.getElementById(pickerId + '_empty');
    const hiddenInput = document.getElementById(pickerId + '_input');
    const preview = document.getElementById(pickerId + '_preview');

    let allIcons = [];
    let isLoaded = false;

    // Open Modal
    btn.addEventListener('click', () => {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        // Trigger reflow
        void modal.offsetWidth;
        modal.classList.remove('opacity-0');
        modalContent.classList.remove('scale-95');
        modalContent.classList.add('scale-100');
        
        searchInput.focus();

        if (!isLoaded) {
            fetchIcons();
        }
    });

    // Close Modal
    function closeModal() {
        modal.classList.add('opacity-0');
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            searchInput.value = '';
            if(isLoaded) renderIcons(allIcons); // reset filter
        }, 300);
    }

    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', (e) => {
        if(e.target === modal) closeModal();
    });

    // Fetch Icons
    async function fetchIcons() {
        try {
            const response = await fetch('/js/remix-tags.json');
            const data = await response.json();
            
            allIcons = [];
            
            // Parse tags.json: it's grouped by category
            // { "arrows": { "arrow-left": ["arrow", "left", ...], ... } }
            for (const category in data) {
                if(category === '_comment') continue;
                
                const iconsInCategory = data[category];
                for (const baseName in iconsInCategory) {
                    const tagsInfo = iconsInCategory[baseName];
                    const tags = (Array.isArray(tagsInfo) ? tagsInfo.join(' ') : String(tagsInfo)).toLowerCase();
                    const searchString = `${baseName} ${tags} ${category}`.toLowerCase();
                    
                    // Add Line version
                    allIcons.push({
                        class: `ri-${baseName}-line`,
                        search: searchString
                    });
                    
                    // Add Fill version
                    allIcons.push({
                        class: `ri-${baseName}-fill`,
                        search: searchString
                    });
                }
            }
            
            isLoaded = true;
            loading.classList.add('hidden');
            grid.classList.remove('hidden');
            renderIcons(allIcons);
            
        } catch (error) {
            console.error('Error fetching icons:', error);
            loading.innerHTML = `<i class="ri-error-warning-line text-4xl text-red-500 mb-4"></i><p class="text-xs uppercase tracking-widest font-black">Failed to load library</p>`;
        }
    }

    // Render Icons
    function renderIcons(iconsToRender) {
        grid.innerHTML = '';
        
        if (iconsToRender.length === 0) {
            grid.classList.add('hidden');
            empty.classList.remove('hidden');
            empty.classList.add('flex');
            return;
        }
        
        empty.classList.add('hidden');
        empty.classList.remove('flex');
        grid.classList.remove('hidden');

        // Render in chunks if too many, to prevent browser freeze.
        // For simple search, building a docfrag is usually fast enough for 2000 elements.
        const fragment = document.createDocumentFragment();
        
        // Limit to 300 to keep DOM light, or render all if filtered
        const limit = iconsToRender.length > 500 ? 500 : iconsToRender.length;
        
        for (let i = 0; i < limit; i++) {
            const icon = iconsToRender[i];
            
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'flex flex-col items-center justify-center p-4 bg-white/5 rounded-xl border border-transparent hover:border-primary/50 hover:bg-primary/10 hover:text-primary text-slate-400 transition-all group';
            btn.title = icon.class;
            
            const iElem = document.createElement('i');
            iElem.className = `${icon.class} text-2xl mb-2 group-hover:scale-125 transition-transform`;
            
            const span = document.createElement('span');
            span.className = 'text-[8px] uppercase tracking-wider font-bold truncate w-full text-center opacity-50 group-hover:opacity-100';
            
            // Clean up name for display: ri-home-line -> home-line
            span.textContent = icon.class.replace('ri-', '');
            
            btn.appendChild(iElem);
            btn.appendChild(span);
            
            btn.addEventListener('click', () => {
                selectIcon(icon.class);
            });
            
            fragment.appendChild(btn);
        }
        
        grid.appendChild(fragment);
    }

    // Search
    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase().trim();
        if (!query) {
            renderIcons(allIcons);
            return;
        }
        
        const filtered = allIcons.filter(icon => icon.search.includes(query) || icon.class.includes(query));
        renderIcons(filtered);
    });

    // Select Icon
    function selectIcon(iconClass) {
        hiddenInput.value = iconClass;
        preview.innerHTML = `<i class="${iconClass}"></i>`;
        closeModal();
    }
});
</script>
<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: var(--color-primary);
}
</style>
