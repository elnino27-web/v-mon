<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportLink;

class ReportController extends Controller
{
    // Menampilkan halaman Welcome V-MON
    public function index()
    {
        return view('welcome');
    }

    // Memproses form saat tombol diklik
    public function process(Request $request)
    {
        // 1. Validasi Input agar data tidak kosong atau salah format
        $request->validate([
            'periode_bulan' => 'required|string',
            'spreadsheet_url' => 'required|url',
            'kategori' => 'required|in:visit,non_pots',
        ], [
            'periode_bulan.required' => 'Periode bulan wajib diisi.',
            'spreadsheet_url.required' => 'Link spreadsheet wajib diisi.',
            'spreadsheet_url.url' => 'Format link yang dimasukkan tidak valid.',
        ]);

        // 2. Ekstraksi Spreadsheet ID dari URL panjang
        $url = $request->spreadsheet_url;
        $spreadsheetId = $this->extractSpreadsheetId($url);

        if (!$spreadsheetId) {
            return back()->withErrors(['spreadsheet_url' => 'ID Google Sheets tidak ditemukan dari URL tersebut. Pastikan link lengkap.'])->withInput();
        }

        // 3. Simpan Riwayat ke Database (Update jika periode & kategori sudah ada)
        ReportLink::updateOrCreate(
            [
                'kategori' => $request->kategori,
                'periode_bulan' => $request->periode_bulan,
            ],
            [
                'spreadsheet_url' => $url,
                'spreadsheet_id' => $spreadsheetId,
            ]
        );

        // 4. Simpan ke Session untuk mempermudah navigasi Dashboard
        session([
            'spreadsheet_id' => $spreadsheetId,
            'periode_bulan' => $request->periode_bulan,
            'kategori' => $request->kategori
        ]);

        // 5. Alihkan ke halaman dashboard masing-masing
        if ($request->kategori === 'visit') {
            return redirect()->route('visit.dashboard');
        } else {
            return redirect()->route('nonpots.dashboard');
        }
    }

    // Fungsi private untuk mengambil ID Spreadsheet pakai Regex
    private function extractSpreadsheetId($url)
    {
        if (preg_match('/\/d\/([a-zA-Z0-9-_]+)/', $url, $matches)) {
            return $matches[1];
        }
        return null;
    }
}
