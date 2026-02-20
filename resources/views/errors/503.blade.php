<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Unavailable | RooterIN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        body { background-color: #020617; }
        .grid-pattern {
            background-image: radial-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 30px 30px;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen text-slate-300 grid-pattern">
    <div class="max-w-md w-full p-8 text-center">
        <div class="mb-8 inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-red-500/10 border border-red-500/20">
            <i class="ri-shield-flash-line text-4xl text-red-500 animate-pulse"></i>
        </div>
        
        <h1 class="text-3xl font-black text-white mb-4 tracking-tight uppercase">Security Lockdown</h1>
        <p class="text-slate-500 mb-8 leading-relaxed">
            Sistem RooterIN sedang dalam mode perlindungan otonom. Akses dibatasi untuk menjaga integritas data. Silakan hubungi administrator SRE jika Anda merasa ini adalah kesalahan.
        </p>
        
        <div class="p-4 bg-white/5 rounded-2xl border border-white/5 mb-8">
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Status Code</p>
            <p class="text-xl font-mono text-white">503 | SERVICE_LOCKDOWN</p>
        </div>

        <a href="/" class="inline-flex items-center gap-2 text-xs font-black text-primary uppercase tracking-widest hover:text-white transition-colors">
            <i class="ri-arrow-left-line"></i> Kembali ke Beranda
        </a>
    </div>
</body>
</html>
