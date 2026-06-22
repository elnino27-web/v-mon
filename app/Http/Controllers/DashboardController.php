<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleSheetService;

class DashboardController extends Controller
{
    protected $sheetService;

    // Menyuntikkan GoogleSheetService ke dalam controller
    public function __construct(GoogleSheetService $sheetService)
    {
        $this->sheetService = $sheetService;
    }

    // Fungsi pembantu untuk mengambil ID dari URL panjang Google Sheets
    private function extractSpreadsheetId($url)
    {
        preg_match('/\/d\/([a-zA-Z0-9-_]+)/', $url, $matches);
        return $matches[1] ?? null;
    }

    // ==========================================
    // MODUL 1: NON POTS
    // ==========================================

    // 1. Halaman Utama: Tabel Rincian Data
    public function nonPotsDashboard()
    {
        $spreadsheetUrl = session('spreadsheet_url');
        $periodeBulan = session('periode_bulan');

        // Cek apakah sesi masih ada
        if (!$spreadsheetUrl) {
            return redirect('/')->withErrors(['spreadsheet_url' => 'Sesi berakhir atau data tidak valid. Silakan masukkan link kembali.']);
        }

        $spreadsheetId = $this->extractSpreadsheetId($spreadsheetUrl);
        if (!$spreadsheetId) {
            return redirect('/')->withErrors(['spreadsheet_url' => 'Link Spreadsheet tidak valid.']);
        }

        // Tarik Data dari Tab "MASTER DATA NONPOTS"
        $data = $this->sheetService->readSheet($spreadsheetId, 'MASTER DATA NONPOTS!A:BE');

        if (!$data || count($data) == 0) {
            return redirect('/')->withErrors(['spreadsheet_url' => 'Gagal membaca data. Pastikan nama tab "MASTER DATA NONPOTS" benar.']);
        }

        return view('nonpots.index', compact('data', 'periodeBulan'));
    }

    // 2. Halaman Kedua: Performa Account Manager (AM)
    public function nonPotsPerformaAm()
    {
        $spreadsheetUrl = session('spreadsheet_url');
        $periodeBulan = session('periode_bulan');

        // Sama seperti di atas, kita pastikan sesi masih terjaga
        if (!$spreadsheetUrl) {
            return redirect('/')->withErrors(['spreadsheet_url' => 'Sesi berakhir atau data tidak valid.']);
        }

        $spreadsheetId = $this->extractSpreadsheetId($spreadsheetUrl);

        // Membaca dari sumber yang sama dengan halaman utama
        $data = $this->sheetService->readSheet($spreadsheetId, 'MASTER DATA NONPOTS!A:BE');

        if (!$data || count($data) == 0) {
            return redirect('/')->withErrors(['spreadsheet_url' => 'Gagal membaca data MASTER DATA NONPOTS.']);
        }

        return view('nonpots.performa_am', compact('data', 'periodeBulan'));
    }

    // ==========================================
    // MODUL 2: VISIT PANPC
    // ==========================================

    public function visitPanpcDashboard()
    {
        $spreadsheetUrl = session('spreadsheet_url');
        $periodeBulan = session('periode_bulan');

        if (!$spreadsheetUrl) {
            return redirect('/')->withErrors(['spreadsheet_url' => 'Sesi berakhir atau data tidak valid. Silakan masukkan link kembali.']);
        }

        $spreadsheetId = $this->extractSpreadsheetId($spreadsheetUrl);
        if (!$spreadsheetId) {
            return redirect('/')->withErrors(['spreadsheet_url' => 'Link Spreadsheet tidak valid.']);
        }

        // PERBAIKAN: Menggunakan nama tab "VISIT PRANPC AR" dengan rentang A:ZZ untuk menangkap semua kolom
        $data = $this->sheetService->readSheet($spreadsheetId, 'VISIT PRANPC AR!A:ZZ');

        if (!$data || count($data) == 0) {
            return redirect('/')->withErrors(['spreadsheet_url' => 'Gagal membaca data. Pastikan nama tab "VISIT PRANPC AR" benar dan memiliki data.']);
        }

        return view('visitpranpc.index', compact('data', 'periodeBulan'));
    }
}
