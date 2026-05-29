<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>@yield('title') - Tabungan SD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800">

    {{-- Mobile Header --}}
    <div class="md:hidden bg-white border-b border-slate-200 p-4 flex justify-between items-center sticky top-0 z-50 shadow-sm">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/icon.jpeg') }}" alt="Logo" class="w-7 h-7 object-cover rounded">
            <h2 class="text-lg font-bold text-slate-800 tracking-tight">Tabungan <span class="text-sky-600">SD</span></h2>
        </div>
        <button id="mobile-toggle" class="text-slate-700 focus:outline-none p-1 flex items-center justify-center">
            <i class="bi bi-list text-2xl"></i>
        </button>
    </div>

    <div class="flex min-h-screen relative overflow-x-hidden">
        
        {{-- Sidebar --}}
        <div id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-white p-6 space-y-6 flex-shrink-0 border-r border-slate-200 shadow-sm transition-transform duration-300 transform -translate-x-full md:translate-x-0 md:relative">
            
            {{-- Logo dan Brand --}}
            <div class="flex items-center justify-between mb-2 pb-4 border-b border-slate-100">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center overflow-hidden shadow-sm">
                        <img src="{{ asset('images/icon.jpeg') }}" alt="Logo" class="w-full h-full object-cover">
                    </div>
                    <h2 class="text-xl font-bold text-slate-800 tracking-tight">
                        Tabungan <span class="text-sky-600">SD</span>
                    </h2>
                </div>
                <button id="desktop-collapse" class="hidden md:flex text-slate-400 hover:text-slate-600 bg-slate-50 hover:bg-slate-100 w-7 h-7 rounded-lg border border-slate-200 items-center justify-center transition-colors">
                    <i class="bi bi-chevron-left text-xs"></i>
                </button>
            </div>

            {{-- Navigasi --}}
            <nav class="space-y-1">
                
                @if(Auth::user()->role == 'admin')
                    
                    <a href="/admin/dashboard" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors {{ Request::is('admin/dashboard') ? 'bg-sky-500 text-white font-semibold' : 'text-slate-600 hover:text-sky-600 hover:bg-sky-50 font-medium' }}">
                        <i class="bi bi-speedometer2 text-lg"></i> <span>Dashboard Admin</span>
                    </a>

                    <a href="/admin/guru" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors {{ Request::is('admin/guru*') ? 'bg-sky-500 text-white font-semibold' : 'text-slate-600 hover:text-sky-600 hover:bg-sky-50 font-medium' }}">
                        <i class="bi bi-person-badge text-lg"></i> <span>Data Guru</span>
                    </a>

                    <a href="/admin/siswa" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors {{ Request::is('admin/siswa*') ? 'bg-sky-500 text-white font-semibold' : 'text-slate-600 hover:text-sky-600 hover:bg-sky-50 font-medium' }}">
                        <i class="bi bi-people text-lg"></i> <span>Data Siswa</span>
                    </a>

                    <a href="/admin/ortu" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors {{ Request::is('admin/ortu*') ? 'bg-sky-500 text-white font-semibold' : 'text-slate-600 hover:text-sky-600 hover:bg-sky-50 font-medium' }}">
                        <i class="bi bi-person-badge-fill text-lg"></i> <span>Data Orang Tua</span>
                    </a>
                    
                    <a href="/admin/kelas" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors {{ Request::is('admin/kelas*') ? 'bg-sky-500 text-white font-semibold' : 'text-slate-600 hover:text-sky-600 hover:bg-sky-50 font-medium' }}">
                        <i class="bi bi-columns-gap text-lg"></i> <span>Data Kelas</span>
                    </a>
    
                @elseif(Auth::user()->role == 'guru')
                        
                    <a href="/guru/dashboard" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors {{ Request::is('guru/dashboard') ? 'bg-sky-500 text-white font-semibold' : 'text-slate-600 hover:text-sky-600 hover:bg-sky-50 font-medium' }}">
                        <i class="bi bi-house-door text-lg"></i> <span>Dashboard</span>
                    </a>

                    <a href="/guru/transaksi" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors {{ Request::is('guru/transaksi*') ? 'bg-sky-500 text-white font-semibold' : 'text-slate-600 hover:text-sky-600 hover:bg-sky-50 font-medium' }}">
                        <i class="bi bi-wallet2 text-lg"></i> <span>Form Transaksi</span>
                    </a>

                    <a href="/guru/siswa" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors {{ Request::is('guru/siswa*') ? 'bg-sky-500 text-white font-semibold' : 'text-slate-600 hover:text-sky-600 hover:bg-sky-50 font-medium' }}">
                        <i class="bi bi-eye text-lg"></i> <span>Detail Tabungan</span>
                    </a>

                @elseif(Auth::user()->role == 'orang_tua')
                    <a href="/orang-tua/dashboard" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors {{ Request::is('orang-tua/dashboard') ? 'bg-sky-500 text-white font-semibold' : 'text-slate-600 hover:text-sky-600 hover:bg-sky-50 font-medium' }}">
                        <i class="bi bi-wallet2 text-lg"></i> <span>Tabungan Anak</span>
                    </a>
                @endif

            </nav>

            {{-- Logout --}}
            <form action="/logout" method="POST" class="pt-6">
                @csrf
                <button type="submit" class="w-full flex items-center space-x-3 px-3 py-2.5 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg font-medium transition-colors">
                    <i class="bi bi-door-open-fill text-lg"></i> <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>

        {{-- Overlay Mobile --}}
        <div id="sidebar-overlay" class="hidden fixed inset-0 bg-slate-900/40 z-30 transition-opacity md:hidden"></div>

        {{-- Main Content --}}
        <div id="main-content" class="flex-1 p-4 md:p-8 overflow-y-auto transition-all duration-300 w-full">
            <div class="hidden md:flex items-center mb-6">
                <button id="desktop-expand" class="hidden text-slate-500 hover:text-sky-600 bg-white w-9 h-9 rounded-lg flex items-center justify-center border border-slate-200 shadow-sm transition-colors">
                    <i class="bi bi-list text-xl"></i>
                </button>
            </div>

            @yield('content')
        </div>
    </div>

    {{-- JavaScript --}}
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