<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C-MON | Telkom Witel Sulbagsel</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800;900&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        't-red-dark': '#B6252A',
                        't-red': '#ED1E28',
                        't-gray-dark': '#55565B',
                        't-gray': '#959597',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        /* Animasi Ulat Gelombang (Caterpillar) */
        @keyframes wave {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        .animate-caterpillar { animation: wave 1.2s infinite ease-in-out; }

        /* Animasi Sorot Judul (Hover Effect) */
        .hover-title-animated {
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        @media (min-width: 1024px) {
            .hover-title-animated:hover {
                letter-spacing: 0.03em;
                transform: scale(1.02);
                text-shadow: 0 0 30px rgba(255, 255, 255, 0.4);
            }
        }

        /* Animasi Slide (Move Right/Left) */
        .slide-hidden {
            opacity: 0;
            transform: translateX(-20px) translateY(-10px);
            pointer-events: none;
            visibility: hidden;
            position: absolute;
            transition: all 0.5s ease;
        }
        .slide-visible {
            opacity: 1;
            transform: translateX(0) translateY(0);
            pointer-events: auto;
            visibility: visible;
            position: relative;
            transition: all 0.5s ease;
        }

        /* Modal Transisi */
        .modal-hidden {
            opacity: 0;
            pointer-events: none;
            backdrop-filter: blur(0px);
            -webkit-backdrop-filter: blur(0px);
        }
        .modal-visible {
            opacity: 1;
            pointer-events: auto;
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
        }
        .modal-card-hidden { transform: scale(0.95) translateY(10px); }
        .modal-card-visible { transform: scale(1) translateY(0); }

        /* Kustomisasi Tanda Panah Dropdown */
        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1.2em;
        }
        select option { color: #55565B; background: white; font-family: 'Inter', sans-serif; font-weight: 600;}
    </style>
</head>
<body class="bg-t-red min-h-screen font-sans antialiased relative overflow-x-hidden selection:bg-t-gray-dark selection:text-white flex flex-col">

    <svg class="fixed right-0 bottom-0 w-full h-full object-cover z-0 pointer-events-none drop-shadow-2xl opacity-90 md:opacity-100" preserveAspectRatio="none" viewBox="0 0 1440 900" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <filter id="shadow1" x="-20%" y="-20%" width="140%" height="140%">
                <feDropShadow dx="-10" dy="10" stdDeviation="15" flood-color="#000" flood-opacity="0.25"/>
            </filter>
            <filter id="shadow2" x="-20%" y="-20%" width="140%" height="140%">
                <feDropShadow dx="-8" dy="8" stdDeviation="12" flood-color="#000" flood-opacity="0.3"/>
            </filter>
            <filter id="shadow3" x="-20%" y="-20%" width="140%" height="140%">
                <feDropShadow dx="-5" dy="5" stdDeviation="8" flood-color="#000" flood-opacity="0.2"/>
            </filter>
        </defs>

        <path fill="#B6252A" filter="url(#shadow1)" d="M1440 0 L1440 900 L0 900 C300 650 350 350 750 250 C1000 180 1200 100 1440 0 Z"></path>
        <path fill="#55565B" filter="url(#shadow2)" d="M1440 180 L1440 900 L250 900 C500 700 700 550 950 400 C1150 280 1300 200 1440 180 Z"></path>
        <path fill="#959597" filter="url(#shadow3)" d="M1440 450 L1440 900 L600 900 C800 800 1000 700 1150 550 C1280 400 1380 450 1440 450 Z"></path>
    </svg>

    <header class="absolute top-0 w-full px-5 md:px-10 lg:px-16 py-6 flex items-center justify-between z-20">

        <div class="flex items-center gap-3 relative z-10">
            <div class="bg-white p-1.5 md:p-2 rounded-xl shadow-lg hover:scale-105 transition-transform duration-300 shrink-0">
                <img src="{{ asset('img/logo.png') }}" alt="Telkom Indonesia" class="h-8 md:h-10 lg:h-12 object-contain">
            </div>
            <div class="hidden sm:flex flex-col justify-center">
                <span class="font-display font-black tracking-widest text-white text-[11px] md:text-sm">C-MON SYSTEM</span>
                <span class="font-sans font-medium text-white/80 text-[9px] md:text-xs tracking-wider">WITEL SULBAGSEL</span>
            </div>
        </div>

        <div class="absolute right-5 md:right-10 lg:right-16 left-1/2 flex justify-end gap-1.5 md:gap-2.5 lg:gap-3 items-center pointer-events-none">
            <div class="hidden lg:block w-2 h-2 rounded-full bg-white/40 shadow-lg animate-caterpillar [animation-delay:0.9s]"></div>
            <div class="hidden md:block w-2.5 h-2.5 rounded-full bg-white/50 shadow-lg animate-caterpillar [animation-delay:0.8s]"></div>
            <div class="hidden sm:block w-2.5 h-2.5 md:w-3 md:h-3 rounded-full bg-white/60 shadow-lg animate-caterpillar [animation-delay:0.7s]"></div>
            <div class="w-2.5 h-2.5 md:w-3.5 md:h-3.5 rounded-full bg-white/70 shadow-lg animate-caterpillar [animation-delay:0.6s]"></div>
            <div class="w-3 h-3 md:w-3.5 md:h-3.5 rounded-full bg-white/80 shadow-lg animate-caterpillar [animation-delay:0.5s]"></div>
            <div class="w-3 h-3 md:w-4 md:h-4 rounded-full bg-white/90 shadow-lg animate-caterpillar [animation-delay:0.4s]"></div>
            <div class="w-3.5 h-3.5 md:w-4 md:h-4 rounded-full bg-white shadow-lg animate-caterpillar [animation-delay:0.3s]"></div>
            <div class="w-3.5 h-3.5 md:w-4 md:h-4 rounded-full bg-white shadow-lg animate-caterpillar [animation-delay:0.2s]"></div>
            <div class="w-4 h-4 md:w-5 md:h-5 rounded-full bg-white shadow-lg animate-caterpillar [animation-delay:0.1s]"></div>
            <div class="w-4 h-4 md:w-5 md:h-5 rounded-full bg-white shadow-lg animate-caterpillar [animation-delay:0s]"></div>
        </div>

    </header>

    <main class="relative z-10 w-full flex-grow flex flex-col justify-center px-5 md:px-10 lg:px-16 pt-24 md:pt-32 pb-16">

        <div class="max-w-5xl mt-8 md:mt-0">
            <h1 class="font-display text-4xl sm:text-5xl md:text-6xl lg:text-[5.5rem] font-black text-white uppercase leading-tight lg:leading-[1.05] drop-shadow-lg hover-title-animated cursor-default origin-left">
                INTEGRATED<br>
                <span class="text-t-gray-dark">DASHBOARD</span>
            </h1>

            <p class="text-white/90 font-sans text-sm md:text-base lg:text-lg font-medium mt-4 md:mt-6 max-w-2xl leading-relaxed drop-shadow-sm">
                Platform monitoring performa berbasis cloud. Kelola pelaporan dengan lebih cepat dan visualisasi data yang interaktif.
            </p>

            @if ($errors->any())
                <div class="mt-5 md:mt-6 p-3 md:p-4 bg-white/20 backdrop-blur-md border border-white/40 rounded-xl text-white font-medium inline-block shadow-lg text-sm md:text-base">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="vmon_form" action="{{ route('report.process') }}" method="POST" class="mt-8 md:mt-10 lg:mt-14">
                @csrf

                <div class="flex flex-col lg:flex-row gap-4 md:gap-5 items-start">

                    <div class="relative z-20 w-full lg:w-auto shrink-0">
                        <label class="block text-white/90 text-xs md:text-sm font-bold mb-2 uppercase tracking-widest font-sans">Sumber Data</label>
                        <select id="kategori_dropdown" name="kategori" class="w-full lg:w-64 bg-t-gray-dark/40 hover:bg-t-gray-dark/60 backdrop-blur-md border border-white/20 text-white font-display font-bold text-base md:text-lg px-4 md:px-6 py-3.5 md:py-4 rounded-xl shadow-xl outline-none focus:border-white focus:bg-t-gray-dark/80 transition-all duration-300 cursor-pointer">
                            <option value="">-- PILIH DATA --</option>
                            <option value="visit">Visit Collection</option>
                            <option value="non_pots">NON POTS</option>
                        </select>
                    </div>

                    <div id="dynamic_panel" class="slide-hidden flex flex-col md:flex-row gap-3 md:gap-4 w-full max-w-4xl lg:mt-7">

                        <div class="w-full md:w-56 shrink-0">
                            <input type="text" name="periode_bulan" value="{{ old('periode_bulan') }}" placeholder="Periode (Cth: Mei 2026)"
                                class="w-full bg-white/10 backdrop-blur-md border border-white/20 text-white placeholder-white/70 font-sans font-medium text-sm md:text-base px-4 md:px-5 py-3.5 md:py-4 rounded-xl shadow-xl outline-none focus:bg-white/20 focus:border-white transition-all duration-300" required>
                        </div>

                        <div class="flex flex-col md:flex-row w-full bg-white/10 backdrop-blur-md border border-white/20 rounded-xl shadow-xl overflow-hidden focus-within:bg-white/20 focus-within:border-white transition-all duration-300">

                            <input type="url" name="spreadsheet_url" value="{{ old('spreadsheet_url') }}" placeholder="Tempelkan link spreadsheet....."
                                class="w-full bg-transparent text-white placeholder-white/70 font-sans font-medium text-sm md:text-base px-4 md:px-5 py-3.5 md:py-4 outline-none border-b md:border-b-0 md:border-r border-white/10" required>

                            <button type="button" id="btn_trigger_modal" class="bg-t-red-dark hover:bg-t-gray-dark text-white font-display font-black tracking-widest text-sm md:text-base px-6 py-4 md:py-0 transition-colors duration-300 flex items-center justify-center gap-2 shrink-0">
                                SUBMIT
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </main>

    <div id="confirmation_modal" class="fixed inset-0 z-50 flex items-center justify-center bg-t-gray-dark/80 modal-hidden transition-all duration-300 ease-out px-4 py-8">

        <div id="modal_card" class="bg-white rounded-3xl p-6 md:p-8 max-w-md w-full shadow-2xl modal-card-hidden transition-transform duration-300 ease-out border-t-[8px] md:border-t-[10px] border-t-red max-h-full overflow-y-auto">

            <div class="w-16 h-16 md:w-20 md:h-20 bg-red-50 rounded-full flex items-center justify-center mb-4 md:mb-6 mx-auto shadow-inner">
                <svg class="w-8 h-8 md:w-10 md:h-10 text-t-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <h3 class="text-xl md:text-2xl font-display font-black text-center text-t-gray-dark mb-2">Konfirmasi Akses</h3>
            <p class="text-center text-t-gray font-sans font-medium mb-6 md:mb-8 leading-relaxed text-sm md:text-base">
                Apakah kamu yakin link data <br>
                <strong id="modal_data_name" class="text-t-red-dark font-display text-sm md:text-lg px-3 py-1.5 bg-red-50 rounded-lg inline-block mt-2 border border-red-100"></strong><br>
                <span class="block mt-2">sudah sesuai?</span>
            </p>

            <div class="flex flex-col sm:flex-row gap-2.5 md:gap-3">
                <button type="button" id="btn_batal" class="flex-1 py-3 md:py-4 px-4 bg-slate-100 hover:bg-slate-200 text-t-gray-dark font-display font-bold tracking-wide rounded-xl transition-colors text-sm md:text-base">
                    Batal
                </button>
                <button type="button" id="btn_yakin" class="flex-1 py-3 md:py-4 px-4 bg-t-red hover:bg-t-red-dark text-white font-display font-bold tracking-wide rounded-xl shadow-lg shadow-t-red/30 transition-colors text-sm md:text-base">
                    Yakin
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dropdown = document.getElementById('kategori_dropdown');
            const panel = document.getElementById('dynamic_panel');
            const modal = document.getElementById('confirmation_modal');
            const modalCard = document.getElementById('modal_card');
            const btnTrigger = document.getElementById('btn_trigger_modal');
            const btnBatal = document.getElementById('btn_batal');
            const btnYakin = document.getElementById('btn_yakin');
            const modalDataName = document.getElementById('modal_data_name');
            const form = document.getElementById('vmon_form');

            // Logika Panel Slide
            function checkDropdown() {
                if (dropdown.value !== "") {
                    panel.classList.remove('slide-hidden');
                    panel.classList.add('slide-visible');
                } else {
                    panel.classList.add('slide-hidden');
                    panel.classList.remove('slide-visible');
                }
            }

            dropdown.addEventListener('change', checkDropdown);
            checkDropdown();

            // Logika Pop Up Konfirmasi
            btnTrigger.addEventListener('click', () => {
                const urlInput = document.querySelector('input[name="spreadsheet_url"]').value;
                const periodeInput = document.querySelector('input[name="periode_bulan"]').value;

                if(!urlInput || !periodeInput) {
                    form.reportValidity();
                    return;
                }

                const selectedText = dropdown.options[dropdown.selectedIndex].text;
                modalDataName.innerText = `"${selectedText}"`;

                modal.classList.remove('modal-hidden');
                modal.classList.add('modal-visible');
                modalCard.classList.remove('modal-card-hidden');
                modalCard.classList.add('modal-card-visible');
            });

            btnBatal.addEventListener('click', () => {
                modal.classList.add('modal-hidden');
                modal.classList.remove('modal-visible');
                modalCard.classList.add('modal-card-hidden');
                modalCard.classList.remove('modal-card-visible');
            });

            btnYakin.addEventListener('click', () => {
                btnYakin.innerHTML = 'Memproses...';
                btnYakin.classList.add('opacity-75', 'cursor-not-allowed');
                form.submit();
            });
        });
    </script>
</body>
</html>
