<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sentinel Adaptive Challenge</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        @keyframes scan {
            0% { transform: translateY(-100%); }
            100% { transform: translateY(100%); }
        }
        .scan-line {
            height: 2px;
            background: linear-gradient(to right, transparent, #ef4444, transparent);
            animation: scan 2s linear infinite;
        }
    </style>
</head>
<body class="bg-[#0a0a0c] text-slate-400 font-sans flex items-center justify-center min-h-screen p-4">
    <div class="max-w-md w-full bg-[#111114] border border-white/5 rounded-[32px] p-8 relative overflow-hidden shadow-2xl">
        <div class="scan-line absolute inset-0 pointer-events-none opacity-20"></div>
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-red-500/10 rounded-2xl mb-6">
                <i class="ri-shield-keyhole-line text-3xl text-red-500 animate-pulse"></i>
            </div>
            <h1 class="text-white text-xl font-black uppercase tracking-widest mb-2">Neural Throttling Active</h1>
            <p class="text-xs leading-relaxed italic">Sistem mendeteksi pola navigasi anomali. Selesaikan tantangan kriptografi di bawah untuk memulihkan reputasi sesi Anda.</p>
        </div>

        <div id="pow-container" class="space-y-6">
            <div class="p-4 bg-black/40 rounded-2xl border border-white/5 text-center">
                <span id="status-text" class="text-[10px] font-bold uppercase tracking-widest text-primary">Menyiapkan Computational Challenge...</span>
                <div class="mt-3 h-1 bg-white/5 rounded-full overflow-hidden">
                    <div id="progress-bar" class="h-full bg-red-500 transition-all duration-300" style="width: 0%"></div>
                </div>
            </div>

            <p class="text-[10px] text-center uppercase tracking-widest opacity-50">Estimated Time: ~5 Seconds (Human Factor)</p>

            <form id="pow-form" action="{{ route('sentinel.challenge.verify') }}" method="POST" class="hidden">
                @csrf
                <input type="hidden" name="pow_token" id="pow_token">
                <button type="submit" class="w-full py-4 bg-white text-black font-black uppercase tracking-widest rounded-xl hover:bg-white/90 transition-all">
                    Verification Complete
                </button>
            </form>
        </div>

        <div class="mt-8 pt-6 border-t border-white/5 text-center">
            <p class="text-[9px] uppercase tracking-[0.2em] font-bold opacity-30">RooterIN Sentinel ARR v2.0 - Lattice Guard</p>
        </div>
    </div>

    <script>
        // Simple client-side PoW (Finding a partial hash collision)
        async function solveChallenge() {
            const status = document.getElementById('status-text');
            const progress = document.getElementById('progress-bar');
            const form = document.getElementById('pow-form');
            const tokenInput = document.getElementById('pow_token');

            status.innerText = "Analyzing Neural Footprint...";
            
            // Artificial delay to simulate human focus + CPU work
            let nonce = 0;
            const targetPrefix = '0000'; // Difficulty
            const startTime = Date.now();

            while(true) {
                const hash = await crypto.subtle.digest('SHA-256', new TextEncoder().encode('sentinel-' + nonce));
                const hashArray = Array.from(new Uint8Array(hash));
                const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');

                if (hashHex.startsWith(targetPrefix)) {
                    tokenInput.value = hashHex + ':' + nonce;
                    break;
                }
                nonce++;

                if (nonce % 500 === 0) {
                    const elapsed = (Date.now() - startTime) / 1000;
                    const percent = Math.min(95, (nonce / 5000) * 100);
                    progress.style.width = percent + '%';
                    status.innerText = `Solving Lattice-Puzzle: ${nonce} attempts...`;
                    await new Promise(r => setTimeout(r, 10)); // Give main thread some air
                }
            }

            progress.style.width = '100%';
            status.innerText = "Challenge Solved: Human Identity Verified.";
            status.classList.replace('text-primary', 'text-emerald-500');
            form.classList.remove('hidden');
        }

        setTimeout(solveChallenge, 1000);
    </script>
</body>
</html>
