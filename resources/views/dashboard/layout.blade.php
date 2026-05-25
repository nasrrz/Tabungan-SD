<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>@yield('title') - Tabungan SD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100/80 font-sans antialiased text-slate-800">

    <div class="md:hidden bg-white border-b border-slate-200 p-4 flex justify-between items-center sticky top-0 z-50 shadow-sm">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/icon.jpeg') }}" alt="Logo" class="w-7 h-7 object-contain">
            <h2 class="text-lg font-bold text-blue-950 tracking-tight">Tabungan <span class="text-blue-700">SD</span></h2>
        </div>
        <button id="mobile-toggle" class="text-slate-700 focus:outline-none p-1 flex items-center justify-center cursor-pointer">
            <i class="bi bi-list text-2xl"></i>
        </button>
    </div>

    <div class="flex min-h-screen relative overflow-x-hidden">
        
        <div id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-white p-6 space-y-6 flex-shrink-0 border-r border-slate-200 shadow-sm transition-all duration-300 transform -translate-x-full md:translate-x-0 md:relative">
            
            <div class="flex items-center justify-between mb-2 pb-4 border-b border-slate-100">
                <div class="flex items-center space-x-3">
                    <div class="bg-white w-9 h-9 rounded-xl p-1 flex items-center justify-center border border-slate-200 shadow-sm">
                        <img src="{{ asset('images/icon.jpeg') }}" alt="Logo" class="w-full h-full object-contain">
                    </div>
                    <h2 class="text-xl font-bold text-blue-950 tracking-tight">
                        Tabungan <span class="text-blue-700">SD</span>
                    </h2>
                </div>
                <button id="desktop-collapse" class="hidden md:flex text-slate-400 hover:text-slate-600 focus:outline-none text-xs items-center justify-center cursor-pointer bg-slate-50 hover:bg-slate-100 w-7 h-7 rounded-xl border border-slate-200 transition">
                    <i class="bi bi-chevron-left font-bold"></i>
                </button>
            </div>

            <nav class="space-y-1.5">
                
                @if(Auth::user()->role == 'admin')
                    
                    <a href="/admin/dashboard" class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('admin/dashboard') ? 'bg-sky-500 text-white font-semibold shadow-md shadow-sky-500/10' : 'text-slate-600 hover:text-sky-600 hover:bg-sky-50 font-medium' }} rounded-xl transition-all">
                        <i class="bi bi-speedometer2 text-lg"></i> <span>Dashboard Admin</span>
                    </a>

                    <a href="/admin/guru" class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('admin/guru*') ? 'bg-sky-500 text-white font-semibold shadow-md shadow-sky-500/10' : 'text-slate-600 hover:text-sky-600 hover:bg-sky-50 font-medium' }} rounded-xl transition-all">
                        <i class="bi bi-person-badge{{ Request::is('admin/guru*') ? '-fill' : '' }} text-lg"></i> <span>Data Guru</span>
                    </a>

                    <a href="/admin/siswa" class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('admin/siswa*') ? 'bg-sky-500 text-white font-semibold shadow-md shadow-sky-500/10' : 'text-slate-600 hover:text-sky-600 hover:bg-sky-50 font-medium' }} rounded-xl transition-all">
                        <i class="bi bi-people{{ Request::is('admin/siswa*') ? '-fill' : '' }} text-lg"></i> <span>Data Siswa</span>
                    </a>

                    <a href="/admin/ortu" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->is('admin/ortu*') ? 'bg-sky-500 text-white shadow-lg shadow-sky-200' : 'text-slate-500 hover:bg-slate-50' }}">
                            <i class="bi bi-person-badge-fill"></i>
                            <span class="text-sm font-bold">Data Orang Tua</span>
                    </a>
                    
                    <a href="/admin/kelas" class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('admin/kelas*') ? 'bg-sky-500 text-white font-semibold shadow-md shadow-sky-500/10' : 'text-slate-600 hover:text-sky-600 hover:bg-sky-50 font-medium' }} rounded-xl transition-all">
                        <i class="bi bi-columns-gap text-lg"></i> <span>Data Kelas</span>
                    </a>
    
                @elseif(Auth::user()->role == 'guru')
                        
                    <a href="/guru/dashboard" class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('guru/dashboard') ? 'bg-sky-500 text-white font-semibold shadow-md shadow-sky-500/10' : 'text-slate-600 hover:text-sky-600 hover:bg-slate-50 font-medium' }} rounded-xl transition-all">
                        <i class="bi bi-house-door{{ Request::is('guru/dashboard') ? '-fill' : '' }} text-lg"></i> <span>Dashboard</span>
                    </a>

                    <a href="/guru/transaksi" class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('guru/transaksi*') ? 'bg-sky-500 text-white font-semibold shadow-md shadow-sky-500/10' : 'text-slate-600 hover:text-sky-600 hover:bg-sky-50 font-medium' }} rounded-xl transition-all">
                        <i class="bi bi-wallet2 text-lg"></i> <span>Form Transaksi</span>
                    </a>

                    <a href="/guru/siswa" class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('guru/siswa*') ? 'bg-sky-500 text-white font-semibold shadow-md shadow-sky-500/10' : 'text-slate-600 hover:text-sky-600 hover:bg-sky-50 font-medium' }} rounded-xl transition-all">
                        <i class="bi bi-eye{{ Request::is('guru/siswa*') ? '-fill' : '' }} text-lg"></i> <span>Detail Tabungan</span>
                    </a>

                @elseif(Auth::user()->role == 'orang_tua')
                    <a href="/orang-tua/dashboard" class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('orang-tua/dashboard') ? 'bg-sky-500 text-white font-semibold shadow-md shadow-sky-500/10' : 'text-slate-600 hover:text-sky-600 hover:bg-sky-50 font-medium' }} rounded-xl transition-all">
                        <i class="bi bi-wallet2 text-lg"></i> <span>Tabungan Anak</span>
                    </a>
                @endif

            </nav>

            <form action="/logout" method="POST" class="pt-6">
                @csrf
                <button type="submit" class="w-full flex items-center space-x-3 px-4 py-2.5 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-xl font-semibold transition-all cursor-pointer">
                    <i class="bi bi-door-open-fill text-lg"></i> <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>

        <div id="sidebar-overlay" class="hidden fixed inset-0 bg-slate-900/40 z-30 transition-opacity md:hidden"></div>

        <div id="main-content" class="flex-1 p-4 md:p-10 overflow-y-auto transition-all duration-300 w-full">
            <div class="hidden md:flex items-center mb-6">
                <button id="desktop-expand" class="hidden text-slate-600 hover:text-blue-700 font-bold bg-white w-10 h-10 rounded-xl flex items-center justify-center border border-slate-200 shadow-sm cursor-pointer transition hover:scale-105">
                    <i class="bi bi-list text-xl"></i>
                </button>
            </div>

            @yield('content')
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const desktopCollapseBtn = document.getElementById('desktop-collapse');
        const desktopExpandBtn = document.getElementById('desktop-expand');
        const mobileToggleBtn = document.getElementById('mobile-toggle');

        desktopCollapseBtn.addEventListener('click', () => { sidebar.classList.add('md:hidden'); desktopExpandBtn.classList.remove('hidden'); });
        desktopExpandBtn.addEventListener('click', () => { sidebar.classList.remove('md:hidden'); desktopExpandBtn.classList.add('hidden'); });
        mobileToggleBtn.addEventListener('click', () => { sidebar.classList.remove('-translate-x-full'); overlay.classList.remove('hidden'); });
        overlay.addEventListener('click', () => { sidebar.classList.add('-translate-x-full'); overlay.classList.add('hidden'); });
    </script>
</body>
</html>