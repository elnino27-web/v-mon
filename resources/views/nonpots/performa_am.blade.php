@extends('layouts.app')

@section('dashboard_title', 'PERFORMA AM - NONPOTS')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        /* Custom Styling Tabel Premium */
        table.dataTable thead th { background-color: #0f172a; color: #f8fafc; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; padding: 1rem; border-bottom: none; text-align: left !important;}
        table.dataTable tbody td { font-size: 0.875rem; padding: 1rem; border-bottom: 1px solid #f1f5f9; color: #334155; font-weight: 500; vertical-align: middle; text-align: left !important;}
        table.dataTable.stripe>tbody>tr.odd>td { box-shadow: inset 0 0 0 9999px rgba(248, 250, 252, 0.5); }

        /* Sembunyikan Search & Length bawaan DataTables karena kita pakai versi kustom */
        .dataTables_filter { display: none; }
        .dataTables_length { display: none; }

        /* Kustomisasi Paginasi */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: #ED1E28 !important; color: white !important; border: none; border-radius: 0.5rem; }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: #B6252A !important; color: white !important; border: none; }
    </style>
@endsection

@section('content')
    <div id="rawDataContainer" data-json="{{ json_encode($data) }}" class="hidden"></div>

    <div class="flex gap-2 mb-6 overflow-x-auto pb-2">
        <a href="{{ route('nonpots.dashboard') }}" class="px-4 py-2 shrink-0 bg-white text-slate-600 text-sm font-bold rounded-xl border border-slate-200 hover:bg-slate-50 transition-colors">Data Tabel</a>
        <a href="#" class="px-4 py-2 shrink-0 bg-t-red text-white text-sm font-bold rounded-xl shadow-md shadow-t-red/20 cursor-default">Performa AM</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 items-stretch">

        <div class="bg-blue-600 rounded-2xl p-6 text-white shadow-lg shadow-blue-500/20 transform transition-all duration-500 hover:-translate-y-1 hover:shadow-xl relative overflow-hidden group flex flex-col justify-center min-h-[140px]">
            <div class="relative z-10 flex justify-between items-center">
                <div>
                    <p class="text-xs font-bold tracking-widest uppercase text-white/80 mb-1">Total AM Aktif</p>
                    <div class="flex items-baseline gap-2">
                        <h3 class="font-display font-black text-4xl counter-animate" id="val_total_am">0</h3>
                        <span class="text-sm font-medium text-blue-200">Orang</span>
                    </div>
                </div>
                <div class="p-3 bg-white/10 rounded-xl backdrop-blur-sm">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
            <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition-all duration-500"></div>
        </div>

        <div class="bg-emerald-500 rounded-2xl p-6 text-white shadow-lg shadow-emerald-500/20 transform transition-all duration-500 hover:-translate-y-1 hover:shadow-xl relative overflow-hidden group flex flex-col justify-center min-h-[140px]">
            <div class="relative z-10 flex justify-between items-center">
                <div>
                    <p class="text-xs font-bold tracking-widest uppercase text-white/80 mb-1">Realisasi Keseluruhan</p>
                    <div class="flex items-baseline gap-1">
                        <h3 class="font-display font-black text-4xl counter-animate" id="val_realisasi">0</h3>
                        <span class="font-display font-black text-3xl">%</span>
                    </div>
                </div>
                <div class="p-3 bg-white/10 rounded-xl backdrop-blur-sm">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
            </div>
            <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition-all duration-500"></div>
        </div>

        <div class="bg-gradient-to-br from-amber-400 to-amber-600 rounded-2xl p-6 text-white shadow-lg shadow-amber-500/30 transform transition-all duration-500 hover:-translate-y-1 hover:shadow-xl relative overflow-hidden group flex flex-col justify-center min-h-[140px]">
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-2">
                    <p class="text-xs font-bold tracking-widest uppercase text-amber-100">🏆 Top AM Terbaik</p>
                    <span id="best_am_pct" class="px-2 py-0.5 bg-white/20 rounded text-xs font-bold backdrop-blur-sm border border-white/30">0%</span>
                </div>
                <h3 class="font-display font-black text-2xl truncate pr-4" id="val_best_am">Memuat...</h3>
                <p class="text-xs text-amber-100 font-medium mt-1"><span id="best_am_lunas">0</span> dari <span id="best_am_total">0</span> data Lunas</p>
            </div>
            <svg class="absolute -right-2 -bottom-2 w-24 h-24 text-white/10 transform group-hover:scale-110 group-hover:-rotate-12 transition-all duration-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-.966.744H8a1 1 0 01-.967-.744l-1.18-4.455-3.354-1.935a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 018 2h4zm-1.208 3.147L10 8.01 9.208 5.147 6.452 3.553l1.83 6.907L5.5 12l2.782 1.54 1.83 6.907 1.83-6.907L14.5 12l-2.782-1.54-1.83-6.907-2.754-1.593z" clip-rule="evenodd"/></svg>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-8">

        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">

                <div class="flex items-center gap-3">
                    <div class="p-2 bg-t-red/10 rounded-lg text-t-red shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <div class="flex flex-col justify-center">
                        <h2 class="font-display font-bold text-lg text-slate-800 leading-tight">Peringkat Kinerja Account Manager</h2>
                        <p class="text-xs font-medium text-slate-400 mt-0.5">Peringkat Berdasarkan Presentase Lunas</p>
                    </div>
                </div>

                <div class="w-full md:w-72">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Cari Kinerja AM</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" id="custom_search" placeholder="Ketik nama AM..." class="w-full pl-9 pr-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-t-red focus:ring-1 focus:ring-t-red transition-all">
                    </div>
                </div>

            </div>
        </div>

        <div class="p-0 overflow-x-auto">
            <table id="amTable" class="w-full whitespace-nowrap stripe hover">
                <thead>
                    <tr>
                        <th class="text-left w-16">Rank</th>
                        <th class="text-left">Nama AM</th>
                        <th class="text-left">Total Data</th>
                        <th class="text-left">Lunas</th>
                        <th class="text-left min-w-[200px]">Realisasi (%)</th>
                    </tr>
                </thead>
                <tbody id="amTableBody">
                    </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // 1. Ambil & Parsing Data
            const rawData = JSON.parse(document.getElementById('rawDataContainer').getAttribute('data-json'));
            const headers = rawData[0];
            const rows = rawData.slice(1);

            const getColExact = (name) => headers.findIndex(h => h && h.trim().toUpperCase() === name.toUpperCase());
            const idxAM = getColExact('NAMA AM');
            const idxStatusCR = getColExact('STATUS_CR');

            // 2. Agregasi Data per AM
            let amData = {};
            let globalTotalData = 0;
            let globalTotalLunas = 0;

            rows.forEach(row => {
                const r = row.map(cell => cell || '');
                let amName = r[idxAM] ? r[idxAM].trim() : '';
                const status = r[idxStatusCR] ? r[idxStatusCR].toUpperCase().trim() : '';

                // PERBAIKAN: Jika nama AM kosong, '-', atau '#N/A', ubah menjadi 'TIDAK TERDEFINISI'
                if (!amName || amName === '-' || amName.toLowerCase() === '#n/a') {
                    amName = 'TIDAK TERDEFINISI';
                }

                // Data langsung dimasukkan tanpa diabaikan
                if (!amData[amName]) {
                    amData[amName] = { name: amName, total: 0, lunas: 0 };
                }

                amData[amName].total++;
                globalTotalData++;

                if (status === 'LUNAS') {
                    amData[amName].lunas++;
                    globalTotalLunas++;
                }
            });

            // 3. Konversi ke Array dan Hitung Persentase
            let leaderboard = [];
            for (let key in amData) {
                let am = amData[key];
                am.pct = am.total > 0 ? (am.lunas / am.total) * 100 : 0;
                leaderboard.push(am);
            }

            // 4. Sortir Data
            leaderboard.sort((a, b) => {
                if (b.pct !== a.pct) return b.pct - a.pct;
                return b.total - a.total;
            });

            // 5. Update Kartu Ringkasan
            const globalPct = globalTotalData > 0 ? Math.round((globalTotalLunas / globalTotalData) * 100) : 0;

            const animateValue = (id, end, duration) => {
                let obj = document.getElementById(id);
                let startTimestamp = null;
                const step = (timestamp) => {
                    if (!startTimestamp) startTimestamp = timestamp;
                    const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                    obj.innerHTML = Math.floor(progress * end).toLocaleString('id-ID');
                    if (progress < 1) { window.requestAnimationFrame(step); }
                };
                window.requestAnimationFrame(step);
            }

            // Jumlah AM dikurangi 1 jika ada "TIDAK TERDEFINISI" agar tidak dihitung sebagai orang (AM sungguhan)
            let totalAmAktif = leaderboard.length;
            if (amData['TIDAK TERDEFINISI']) {
                totalAmAktif -= 1;
            }

            animateValue("val_total_am", totalAmAktif, 1000);
            animateValue("val_realisasi", globalPct, 1000);

            // Set Kartu Top AM (Pastikan yang "TIDAK TERDEFINISI" tidak bisa jadi Top AM)
            const validLeaderboard = leaderboard.filter(am => am.name !== 'TIDAK TERDEFINISI');
            if (validLeaderboard.length > 0) {
                const best = validLeaderboard[0];
                document.getElementById('val_best_am').innerText = best.name;
                document.getElementById('best_am_pct').innerText = Math.round(best.pct) + '%';
                document.getElementById('best_am_lunas').innerText = best.lunas;
                document.getElementById('best_am_total').innerText = best.total;
            } else {
                document.getElementById('val_best_am').innerText = "Tidak Ada Data";
            }

            // 6. Siapkan HTML untuk Tabel (Semua format Rata Kiri / text-left)
            let tbodyHtml = '';
            leaderboard.forEach((am, index) => {
                const rank = index + 1;
                const pctRound = Math.round(am.pct);

                let rankBadge = `<span class="text-slate-500 font-bold ml-2">${rank}</span>`;
                if (rank === 1) rankBadge = `<span class="inline-flex items-center justify-center w-7 h-7 bg-amber-100 text-amber-600 rounded-full font-black shadow-sm">1</span>`;
                else if (rank === 2) rankBadge = `<span class="inline-flex items-center justify-center w-7 h-7 bg-slate-200 text-slate-600 rounded-full font-black shadow-sm">2</span>`;
                else if (rank === 3) rankBadge = `<span class="inline-flex items-center justify-center w-7 h-7 bg-orange-100 text-orange-600 rounded-full font-black shadow-sm">3</span>`;

                let barColor = 'bg-t-red';
                if (pctRound >= 80) barColor = 'bg-[#10b981]';
                else if (pctRound >= 50) barColor = 'bg-amber-500';

                // Beri warna teks abu-abu pudar jika namanya TIDAK TERDEFINISI
                let nameClass = am.name === 'TIDAK TERDEFINISI' ? 'text-slate-400 italic' : 'text-slate-700';

                tbodyHtml += `
                    <tr>
                        <td class="text-left">${rankBadge}</td>
                        <td class="text-left font-bold ${nameClass}">${am.name}</td>
                        <td class="text-left font-medium text-slate-500">${am.total}</td>
                        <td class="text-left text-[#10b981] font-bold">${am.lunas}</td>
                        <td class="text-left">
                            <div class="flex items-center gap-3">
                                <span class="w-10 text-left font-bold text-slate-600">${pctRound}%</span>
                                <div class="w-full min-w-[150px] bg-slate-100 rounded-full h-2">
                                    <div class="${barColor} h-2 rounded-full" style="width: ${pctRound}%"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                `;
            });
            document.getElementById('amTableBody').innerHTML = tbodyHtml;

            // 7. Inisialisasi DataTables
            const table = $('#amTable').DataTable({
                "ordering": false,
                "autoWidth": true,
                "pageLength": 15,
                "dom": 'rt<"flex flex-col md:flex-row justify-between items-center p-4 gap-4"ip>',
                "language": {
                    info: "Menampilkan _START_ sampai _END_ dari total _TOTAL_ Baris",
                    paginate: { next: "Lanjut &raquo;", previous: "&laquo; Kembali" },
                    emptyTable: "Belum ada data kinerja AM"
                }
            });

            // 8. Hubungkan Search Box Kustom ke DataTables
            $('#custom_search').on('keyup', function () {
                table.search(this.value).draw();
            });

        });
    </script>
@endsection
