<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tabungan SD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            background-image:
                radial-gradient(ellipse at 0% 100%, #e2e8f0 0%, transparent 55%),
                radial-gradient(ellipse at 100% 0%, #f1f5f9 0%, transparent 55%);
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-fade-in {
            animation: fadeIn 0.45s ease-out forwards;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-[400px] animate-fade-in">

        <!-- Brand -->
        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white shadow-sm border border-slate-200 mb-5 overflow-hidden">
                <img src="{{ asset('images/icon.jpeg') }}" alt="Logo Tabungan SD Kedawung" class="w-full h-full object-cover">
            </div>
            <h1 class="text-[1.7rem] font-bold text-slate-800 tracking-tight leading-tight">
                Tabungan <span class="text-sky-600">SD</span>
            </h1>
            <p class="text-slate-500 mt-1.5 text-[0.9rem]">Sistem Informasi Tabungan Sekolah Islami</p>
        </div>

        <!-- Error Message -->
        @if($errors->has('loginError'))
        <div class="bg-red-50 text-red-700 p-3.5 rounded-lg mb-5 text-sm border border-red-200 flex items-start gap-2.5 leading-relaxed">
            <svg class="w-4 h-4 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
            </svg>
            <span>{{ $errors->first('loginError') }}</span>
        </div>
        @endif

        <!-- Login Card -->
        <form action="/login" method="POST" class="bg-white rounded-2xl shadow-sm border border-slate-200 p-7">
            @csrf

            <!-- Username -->
            <div class="mb-4">
                <label class="block text-[0.8rem] font-semibold text-slate-700 mb-1.5">Username</label>
                <input
                    type="text"
                    name="username"
                    required
                    placeholder="Masukkan username"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800 placeholder:text-slate-400
                           focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500
                           transition-colors text-[0.9rem]"
                >
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label class="block text-[0.8rem] font-semibold text-slate-700 mb-1.5">Password</label>
                <input
                    type="password"
                    name="password"
                    required
                    placeholder="Masukkan password"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-slate-800 placeholder:text-slate-400
                           focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500
                           transition-colors text-[0.9rem]"
                >
            </div>

            <!-- Submit -->
            <button
                type="submit"
                class="w-full bg-sky-600 hover:bg-sky-700 text-white font-semibold py-2.5 rounded-lg
                       transition-colors duration-150 text-[0.9rem] tracking-wide"
            >
                Masuk
            </button>
        </form>

        <!-- Footer -->
        <p class="text-center text-slate-400 text-[0.75rem] mt-6">
            &copy; 2026 SD &mdash; Tabungan SD System
        </p>
    </div>

</body>
</html>