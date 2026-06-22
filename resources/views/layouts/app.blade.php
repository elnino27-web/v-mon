<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('dashboard_title') | C-MON Telkom</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800;900&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { 't-red-dark': '#B6252A', 't-red': '#ED1E28', 't-gray-dark': '#55565B', 't-gray': '#959597' },
                    fontFamily: { sans: ['Inter', 'sans-serif'], display: ['Poppins', 'sans-serif'] }
                }
            }
        }
    </script>
    @yield('styles')
</head>
<body class="bg-slate-50 min-h-screen font-sans antialiased text-slate-800">

    <div class="sticky top-4 z-50 max-w-[100rem] mx-auto px-4 sm:px-6 lg:px-8 mb-6 transition-all">
        <nav class="bg-white/95 backdrop-blur-xl rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-slate-100 p-3 md:p-4 flex justify-between items-center">

            <div class="flex items-center gap-3 md:gap-5">
                <a href="{{ route('welcome') }}" class="shrink-0 hover:scale-105 transition-transform duration-300">
                    <img src="{{ asset('img/logo.png') }}" alt="Telkom" class="h-8 md:h-11 object-contain">
                </a>
                <div class="hidden sm:block w-px h-10 bg-slate-200"></div>
                <div class="flex flex-col justify-center">
                    <h1 class="font-display font-black text-slate-800 text-sm sm:text-lg md:text-2xl tracking-tight uppercase leading-none mt-1">
                        @yield('dashboard_title')
                    </h1>
                    @if(session('periode_bulan'))
                    <div class="flex items-center mt-1.5 md:mt-2">
                        <span class="px-2.5 py-0.5 rounded-md bg-red-50 text-t-red font-bold text-[10px] md:text-xs tracking-widest uppercase border border-red-100">
                            PERIODE: {{ session('periode_bulan') }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-4 shrink-0">
                <div class="hidden md:flex flex-col items-end justify-center">
                    <span class="text-[10px] font-bold text-slate-400 tracking-widest uppercase mb-0.5">Terakhir Update</span>
                    <span id="local_clock" class="text-sm font-semibold text-slate-600">Memuat waktu...</span>
                </div>

                <button onclick="window.location.reload()" class="bg-t-red hover:bg-t-red-dark text-white p-2.5 md:p-3 rounded-xl shadow-lg shadow-t-red/30 transition-all duration-300 active:scale-95 group focus:outline-none">
                    <svg class="w-5 h-5 md:w-6 md:h-6 transform group-hover:rotate-180 transition-transform duration-500 ease-in-out" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </button>
            </div>
        </nav>
    </div>

    <main class="max-w-[100rem] mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        @yield('content')
    </main>

    <script>
        function updateLocalClock() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            // Format format to: "Jumat, 19 Juni 2026, 11.25"
            let timeString = now.toLocaleDateString('id-ID', options).replace('pukul', ',').replace(/\./g, ':');
            document.getElementById('local_clock').innerText = timeString;
        }
        setInterval(updateLocalClock, 1000); // Perbarui setiap detik
        updateLocalClock();
    </script>
    @yield('scripts')
</body>
</html>
