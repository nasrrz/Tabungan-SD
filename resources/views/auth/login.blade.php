<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tabungan SD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-[400px]">
            <div class="mb-10 text-center">
        <div class="bg-white w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-5 shadow-lg shadow-blue-900/10 p-2 overflow-hidden">
            <img src="{{ asset('images/icon.jpeg') }}" alt="Logo Tabungan SD Kedawung" class="w-full h-full object-contain">
        </div>

        <h1 class="text-3xl font-bold text-blue-950 tracking-tight">Tabungan <span class="text-blue-700">SD</span></h1>
        <p class="text-slate-500 mt-1.5 text-sm font-medium">Sistem Informasi Tabungan Sekolah Islami</p>
    </div>

        @if($errors->has('loginError'))
        <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm border border-red-100">
            {{ $errors->first('loginError') }}
        </div>
        @endif

        <form action="/login" method="POST" class="bg-white p-8 rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-100">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Username</label>
                <input type="text" name="username" required placeholder=""
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all text-slate-800">
            </div>

            <div class="mb-8">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                <input type="password" name="password" required placeholder=""
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all text-slate-800">
            </div>

            <button type="submit" class="w-full bg-sky-500 hover:bg-sky-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-sky-200 transition-all active:scale-[0.98]">
                Masuk Sekarang
            </button>
        </form>

        <p class="text-center text-slate-400 text-xs mt-10">
            &copy; 2026 SD - Tabungan SD System
        </p>
    </div>

</body>
</html>