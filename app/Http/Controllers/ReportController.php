<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Menampilkan halaman awal (Welcome Page / Form Input)
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Memproses data form dari halaman Welcome dan mengarahkan ke Dashboard
     */
    public function process(Request $request)
    {
        // 1. Validasi Input Ketat dengan Pesan Kustom
        $request->validate([
            'spreadsheet_url' => 'required|url',
            'periode_bulan'   => 'required|string|max:50',
            'kategori'        => 'required|in:nonpots,visitpranpc', // Disesuaikan dengan "visitpranpc"
        ], [
            // Kustomisasi pesan error agar lebih rapi di frontend
            'spreadsheet_url.required' => 'Link Spreadsheet wajib diisi.',
            'spreadsheet_url.url'      => 'Format Link Spreadsheet tidak valid. Harap masukkan URL penuh.',
            'periode_bulan.required'   => 'Periode (Bulan & Tahun) wajib diisi.',
            'kategori.required'        => 'Silakan pilih Kategori Dashboard terlebih dahulu.',
            'kategori.in'              => 'Pilihan Kategori tidak valid. Silakan pilih dari menu yang tersedia.',
        ]);

        // 2. Simpan Data ke dalam Session (Sesi Server)
        session([
            'spreadsheet_url' => $request->spreadsheet_url,
            'periode_bulan'   => $request->periode_bulan,
        ]);

        // 3. Logika Pengalihan (Redirect) sesuai Kategori yang dipilih
        if ($request->kategori === 'nonpots') {
            return redirect()->route('nonpots.dashboard');
        } elseif ($request->kategori === 'visitpranpc') {
            return redirect()->route('visitpranpc.dashboard');
        }

        // 4. Fallback/Pengaman jika ada error yang terlewat
        return redirect()->back()->withErrors(['kategori' => 'Kategori tidak dikenali oleh sistem.']);
    }
}
