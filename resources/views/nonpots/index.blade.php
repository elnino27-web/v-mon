@extends('layouts.app')

@section('dashboard_title', 'NONPOTS MONITORING')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <style>
        .dt-buttons .dt-button {
            background: #fff !important; border: 1px solid #e2e8f0 !important; border-radius: 0.5rem !important;
            color: #475569 !important; font-weight: 600 !important; padding: 0.5rem 1rem !important; transition: all 0.3s;
        }
        .dt-buttons .dt-button:hover { background: #f8fafc !important; color: #ED1E28 !important; border-color: #ED1E28 !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: #ED1E28 !important; color: white !important; border: none; border-radius: 0.5rem; }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: #B6252A !important; color: white !important; border: none; }

        /* PERBAIKAN LEBAR & RATA KIRI TABEL */
        /* width: auto membatalkan paksaan tabel melar 100%, sehingga merapat ke konten */
        table.dataTable { width: auto !important; min-width: 100%; border-collapse: collapse; }
        table.dataTable thead th { background-color: #0f172a; color: #f8fafc; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; padding: 1rem; border-bottom: none; text-align: left !important; white-space: nowrap;}
        table.dataTable tbody td { font-size: 0.875rem; padding: 1rem; border-bottom: 1px solid #f1f5f9; color: #334155; font-weight: 500; text-align: left !important; white-space: nowrap;}

        table.dataTable.stripe>tbody>tr.odd>td { box-shadow: inset 0 0 0 9999px rgba(248, 250, 252, 0.5); }
        .dataTables_filter { display: none; }
        .dataTables_length { display: none; }
    </style>
@endsection

@section('content')
    <div id="rawDataContainer" data-json="{{ json_encode($data) }}" class="hidden"></div>

    <div class="flex gap-2 mb-6">
        <a href="#" class="px-4 py-2 bg-t-red text-white text-sm font-bold rounded-xl shadow-md shadow-t-red/20 cursor-default">Data Tabel</a>
        <a href="{{ route('nonpots.performa_am') }}" class="px-4 py-2 bg-white text-slate-600 text-sm font-bold rounded-xl border border-slate-200 hover:bg-slate-50 transition-colors">Performa AM</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6 items-stretch">

        <div class="col-span-1 flex flex-col gap-4 h-full">
            <div class="flex-1 bg-[#d97706] rounded-2xl p-5 text-white shadow-lg shadow-orange-500/20 transform transition-all duration-500 hover:-translate-y-1 hover:shadow-xl relative overflow-hidden group flex flex-col justify-center">
                <div class="relative z-10">
                    <p class="text-xs font-bold tracking-widest uppercase text-white/80 mb-1">Total Data</p>
                    <h3 class="font-display font-black text-4xl counter-animate" id="val_total">0</h3>
                </div>
                <svg class="absolute -right-4 -bottom-4 w-24 h-24 text-white/20 transform group-hover:scale-110 transition-transform duration-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
            </div>

            <div class="flex-1 bg-[#10b981] rounded-2xl p-5 text-white shadow-lg shadow-emerald-500/20 transform transition-all duration-500 hover:-translate-y-1 hover:shadow-xl relative overflow-hidden group flex flex-col justify-center">
                <div class="relative z-10">
                    <p class="text-xs font-bold tracking-widest uppercase text-white/80 mb-1">Total Lunas</p>
                    <h3 class="font-display font-black text-4xl counter-animate" id="val_lunas">0</h3>
                </div>
                <svg class="absolute -right-4 -bottom-4 w-24 h-24 text-white/20 transform group-hover:scale-110 transition-transform duration-500" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
            </div>

            <div class="flex-1 bg-t-red rounded-2xl p-5 text-white shadow-lg shadow-t-red/20 transform transition-all duration-500 hover:-translate-y-1 hover:shadow-xl relative overflow-hidden group flex flex-col justify-center">
                <div class="relative z-10">
                    <p class="text-xs font-bold tracking-widest uppercase text-white/80 mb-1">Belum Lunas</p>
                    <h3 class="font-display font-black text-4xl counter-animate" id="val_belum_lunas">0</h3>
                </div>
                <svg class="absolute -right-4 -bottom-4 w-24 h-24 text-white/20 transform group-hover:scale-110 transition-transform duration-500" fill="currentColor" viewBox="0 0 24 24"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
            </div>
        </div>

        <div class="col-span-1 lg:col-span-3 bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 flex flex-col justify-center relative h-full" id="capture_area">
            <div class="flex justify-between items-start border-b border-slate-100 pb-4 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-red-50 flex items-center justify-center text-t-red">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    </div>
                    <h2 class="font-display font-bold text-xl text-slate-800">Rasio Realisasi Pelunasan</h2>
                </div>
                <button id="btn_download" class="p-2 border border-slate-200 rounded-lg text-slate-500 hover:text-t-red hover:bg-red-50 transition-colors tooltip" title="Download Image">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                </button>
            </div>

            <div class="mb-6">
                <div class="flex justify-between text-sm font-bold text-slate-500 mb-2 uppercase tracking-wide">
                    <span>Realisasi Lunas (Paid)</span>
                    <span class="text-[#10b981] text-lg"><span id="pct_lunas">0</span>% (<span id="txt_lunas">0</span>)</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-3.5 overflow-hidden">
                    <div id="bar_lunas" class="bg-[#10b981] h-3.5 rounded-full transition-all duration-1000 ease-out" style="width: 0%"></div>
                </div>
            </div>

            <div class="mb-8 flex-grow">
                <div class="flex justify-between text-sm font-bold text-slate-500 mb-2 uppercase tracking-wide">
                    <span>Sisa Belum Lunas (Unpaid)</span>
                    <span class="text-t-red text-lg"><span id="pct_belum_lunas">0</span>% (<span id="txt_belum_lunas">0</span>)</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-3.5 overflow-hidden">
                    <div id="bar_belum_lunas" class="bg-t-red h-3.5 rounded-full transition-all duration-1000 ease-out" style="width: 0%"></div>
                </div>
            </div>

            <div class="flex justify-center gap-16 border-t border-slate-100 pt-6">
                <div class="text-center">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Target</p>
                    <p class="font-display font-black text-2xl text-slate-800">100%</p>
                </div>
                <div class="text-center">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Sisa Gap</p>
                    <p class="font-display font-black text-2xl text-t-red"><span id="txt_gap">0</span>%</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

        <div class="col-span-1 lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/></svg>
                    <h3 class="font-display font-bold text-lg text-slate-800">Diagram Sebaran Data (Top 5)</h3>
                </div>
                <select id="chartColumnSelector" class="w-full md:w-auto px-3 py-1.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 font-semibold text-slate-600 bg-slate-50 cursor-pointer">
                    </select>
            </div>
            <div class="relative h-64 w-full">
                <canvas id="dynamicBarChart"></canvas>
            </div>
        </div>

        <div class="col-span-1 bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-5 h-5 text-indigo-500" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"/><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"/></svg>
                <h3 class="font-display font-bold text-lg text-slate-800">Rasio Data Segmen</h3>
            </div>
            <div class="relative flex-grow flex items-center justify-center min-h-[250px]">
                <canvas id="segmenChart"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-8">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <div class="flex items-center gap-2 mb-5">
                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                <h2 class="font-display font-bold text-lg text-slate-800">Detail Transaksi Pelanggan</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Cari Data</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" id="filter_id" placeholder="Cari ID Number / Nama..." class="w-full pl-9 pr-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-t-red focus:ring-1 focus:ring-t-red transition-all">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Nama AM</label>
                    <select id="filter_am" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-t-red transition-all appearance-none bg-white">
                        <option value="">Semua AM</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Datel</label>
                    <select id="filter_datel" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-t-red transition-all appearance-none bg-white">
                        <option value="">Semua Datel</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Status CR</label>
                    <select id="filter_status" class="w-full px-3 py-2 border border-red-200 bg-red-50 text-t-red font-semibold rounded-xl text-sm focus:outline-none focus:border-t-red transition-all appearance-none">
                        <option value="">Semua Status</option>
                        <option value="LUNAS">Lunas</option>
                        <option value="BELUM LUNAS">Belum Lunas</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="p-0 overflow-x-auto">
            <table id="mainTable" class="whitespace-nowrap stripe hover">
                <thead id="tableHead"></thead>
                <tbody id="tableBody"></tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const rawData = JSON.parse(document.getElementById('rawDataContainer').getAttribute('data-json'));
            const headers = rawData[0];
            const rows = rawData.slice(1);

            // PERBAIKAN: Fungsi Regex ini akan menoleransi "Spasi Ganda" pada nama Header Excel
            const getColExact = (name) => headers.findIndex(h => h && h.trim().replace(/\s+/g, ' ').toUpperCase() === name.replace(/\s+/g, ' ').toUpperCase());

            const idxID = getColExact('ID NUMBER');
            const idxNama = getColExact('NAMA');
            const idxAM = getColExact('NAMA AM');
            const idxSegmen = getColExact('SEGMEN');
            const idxDatel = getColExact('DATEL');
            // Mencari kolom VOC dengan mengabaikan jika ada salah ketik spasi dobel di Excel
            const idxVocDefault = getColExact('UPDATE VOC JUNI 2026');
            const idxBayarCR = getColExact('CEK_BAYAR CR');
            const idxStatusCR = getColExact('STATUS_CR');
            const idxL11CR = getColExact('L11 SALDO CR');
            const idxL11CYC = getColExact('L11 SALDO CYC');

            let totalData = rows.length;
            let totalLunas = 0;
            let totalBelumLunas = 0;
            let amSet = new Set();
            let datelSet = new Set();
            let segmenCounts = {};

            rows.forEach(row => {
                const r = row.map(cell => cell || '');

                const status = r[idxStatusCR] ? r[idxStatusCR].toUpperCase().trim() : '';
                if(status === 'LUNAS') totalLunas++;
                else if (status === 'BELUM LUNAS') totalBelumLunas++;

                if(r[idxAM] && r[idxAM].trim() !== '-') amSet.add(r[idxAM].trim());
                if(r[idxDatel] && r[idxDatel].trim() !== '-') datelSet.add(r[idxDatel].trim());

                const segmen = r[idxSegmen] ? r[idxSegmen].trim() : 'UNKNOWN';
                if(segmen && segmen !== '-' && segmen !== '') {
                    segmenCounts[segmen] = (segmenCounts[segmen] || 0) + 1;
                }
            });

            if((totalLunas + totalBelumLunas) === 0) totalBelumLunas = totalData;

            // Animasi Angka
            const animateValue = (id, start, end, duration) => {
                let obj = document.getElementById(id);
                let startTimestamp = null;
                const step = (timestamp) => {
                    if (!startTimestamp) startTimestamp = timestamp;
                    const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                    obj.innerHTML = Math.floor(progress * (end - start) + start).toLocaleString('id-ID');
                    if (progress < 1) { window.requestAnimationFrame(step); }
                };
                window.requestAnimationFrame(step);
            }
            animateValue("val_total", 0, totalData, 1000);
            animateValue("val_lunas", 0, totalLunas, 1000);
            animateValue("val_belum_lunas", 0, totalBelumLunas, 1000);

            // Progress Bar
            const pctLunas = totalData > 0 ? Math.round((totalLunas / totalData) * 100) : 0;
            const pctBelumLunas = totalData > 0 ? (100 - pctLunas) : 0;
            document.getElementById('txt_lunas').innerText = totalLunas.toLocaleString('id-ID');
            document.getElementById('pct_lunas').innerText = pctLunas;
            document.getElementById('txt_belum_lunas').innerText = totalBelumLunas.toLocaleString('id-ID');
            document.getElementById('pct_belum_lunas').innerText = pctBelumLunas;
            document.getElementById('txt_gap').innerText = pctBelumLunas;
            setTimeout(() => {
                document.getElementById('bar_lunas').style.width = pctLunas + '%';
                document.getElementById('bar_belum_lunas').style.width = pctBelumLunas + '%';
            }, 300);

            // ================= DIAGRAM BAR DINAMIS =================
            const chartSelector = document.getElementById('chartColumnSelector');

            headers.forEach((h, i) => {
                if(h && h.trim() !== '') {
                    let opt = new Option(h, i);
                    chartSelector.add(opt);
                }
            });

            // PERBAIKAN: Mengunci diagram bawaan secara kuat ke VOC JUNI 2026
            // (Atau ke kolom yang mengandung kata 'VOC' jika terjadi kesalahan ketik ekstrim)
            let defaultChartIndex = idxVocDefault;
            if (defaultChartIndex === -1) {
                // Jika "UPDATE VOC JUNI 2026" tidak ditemukan sama sekali, cari yang paling mirip
                defaultChartIndex = headers.findIndex(h => h && h.toUpperCase().includes('VOC'));
            }

            if (defaultChartIndex !== -1) {
                chartSelector.value = defaultChartIndex;
            }

            let dynamicBarChart;
            const ctxBar = document.getElementById('dynamicBarChart').getContext('2d');

            function updateBarChart(colIndex) {
                let counts = {};
                rows.forEach(row => {
                    const val = (row[colIndex] || '').trim();
                    if(val && val !== '-' && val.toLowerCase() !== '#n/a') {
                        counts[val] = (counts[val] || 0) + 1;
                    }
                });
                const sorted = Object.entries(counts).sort((a,b) => b[1] - a[1]).slice(0, 5);

                const labels = sorted.map(v => v[0].length > 25 ? v[0].substring(0, 25) + '...' : v[0]);
                const dataVals = sorted.map(v => v[1]);

                if(dynamicBarChart) {
                    dynamicBarChart.data.labels = labels;
                    dynamicBarChart.data.datasets[0].data = dataVals;
                    dynamicBarChart.update();
                } else {
                    dynamicBarChart = new Chart(ctxBar, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: dataVals,
                                backgroundColor: ['#0ea5e9', '#10b981', '#be123c', '#d97706', '#8b5cf6'],
                                borderRadius: 4
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true, maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: { x: { grid: { display: false } }, y: { grid: { display: false } } }
                        }
                    });
                }
            }

            // Eksekusi chart pertama kali menggunakan nilai default yang sudah dikunci
            updateBarChart(chartSelector.value);

            chartSelector.addEventListener('change', function() {
                updateBarChart(this.value);
            });

            // ================= DONUT CHART =================
            const ctxSegmen = document.getElementById('segmenChart').getContext('2d');
            new Chart(ctxSegmen, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(segmenCounts),
                    datasets: [{
                        data: Object.values(segmenCounts),
                        backgroundColor: ['#dc2626', '#16a34a', '#2563eb', '#d97706', '#9333ea', '#475569'],
                        borderWidth: 2, hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8 } } }
                }
            });

            // ================= DATATABLES =================
            let theadHtml = '<tr>';
            headers.forEach(h => { theadHtml += `<th>${h}</th>`; });
            theadHtml += '</tr>';
            document.getElementById('tableHead').innerHTML = theadHtml;

            const defaultVisibleCols = [idxID, idxNama, idxAM, idxSegmen, idxDatel, idxVocDefault, idxBayarCR, idxStatusCR, idxL11CR, idxL11CYC];

            const table = $('#mainTable').DataTable({
                data: rows,
                scrollX: true,
                autoWidth: false, // PERBAIKAN: Mematikan paksaan lebar DataTables agar HTML murni yang bekerja merapatkan tabel
                pageLength: 15,
                dom: '<"flex justify-between items-center p-4 border-b border-slate-100"B>rt<"flex justify-between items-center p-4"ip>',
                buttons: [
                    { extend: 'colvis', text: '⚙️ Sembunyikan/Tampilkan Kolom', className: 'dt-custom-colvis' }
                ],
                columnDefs: headers.map((h, i) => ({
                    targets: i,
                    visible: defaultVisibleCols.includes(i),
                    className: 'text-left', // Memaksa agar konten sejajar rata kiri
                    render: function (data, type, row) {
                        if (i === idxStatusCR && data) {
                            if (data.toUpperCase().trim() === 'LUNAS') return `<span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-md">LUNAS</span>`;
                            if (data.toUpperCase().trim() === 'BELUM LUNAS') return `<span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-md">BELUM LUNAS</span>`;
                        }
                        if (i === idxSegmen && data) {
                            return `<span class="px-2 py-1 bg-slate-200 text-slate-700 text-xs font-bold rounded-md">${data}</span>`;
                        }
                        if (i === idxBayarCR && data) {
                            return `<span class="text-blue-600 font-bold">${data}</span>`;
                        }
                        return data || '-';
                    }
                })),
                language: {
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: { next: "Next &raquo;", previous: "&laquo; Prev" },
                    emptyTable: "Data tidak ditemukan"
                }
            });

            Array.from(amSet).sort().forEach(am => $('#filter_am').append(new Option(am, am)));
            Array.from(datelSet).sort().forEach(d => $('#filter_datel').append(new Option(d, d)));

            $('#filter_id').on('keyup', function () { table.search(this.value).draw(); });
            $('#filter_am').on('change', function () {
                let val = $.fn.dataTable.util.escapeRegex(this.value);
                table.column(idxAM).search(val ? '^' + val + '$' : '', true, false).draw();
            });
            $('#filter_datel').on('change', function () {
                let val = $.fn.dataTable.util.escapeRegex(this.value);
                table.column(idxDatel).search(val ? '^' + val + '$' : '', true, false).draw();
            });
            $('#filter_status').on('change', function () {
                let val = $.fn.dataTable.util.escapeRegex(this.value);
                table.column(idxStatusCR).search(val ? '^' + val + '$' : '', true, false).draw();
            });

            document.getElementById('btn_download').addEventListener('click', function() {
                const captureArea = document.getElementById('capture_area');
                const btn = this;
                btn.style.display = 'none';
                html2canvas(captureArea, { scale: 2, backgroundColor: "#ffffff", logging: false }).then(canvas => {
                    btn.style.display = 'block';
                    const link = document.createElement('a');
                    link.download = 'Rasio_Pelunasan_C-MON.png';
                    link.href = canvas.toDataURL('image/png');
                    link.click();
                });
            });

        });
    </script>
@endsection
