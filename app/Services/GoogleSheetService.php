<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;

class GoogleSheetService
{
    protected $client;
    protected $service;

    public function __construct()
    {
        // 1. Inisialisasi Klien Google API
        $this->client = new Client();
        $this->client->setApplicationName('C-MON System Telkom');

        // 2. Beri izin untuk membaca spreadsheet
        $this->client->setScopes([Sheets::SPREADSHEETS_READONLY]);

        // 3. Panggil kunci rahasia JSON dari folder storage/app/
        $this->client->setAuthConfig(storage_path('app/google-credentials.json'));

        // 4. Jalankan layanan Google Sheets
        $this->service = new Sheets($this->client);
    }

    // Fungsi inti untuk membaca data berdasarkan ID dan Nama Tab
    public function readSheet($spreadsheetId, $range)
    {
        try {
            $response = $this->service->spreadsheets_values->get($spreadsheetId, $range);
            return $response->getValues(); // Mengembalikan data dalam bentuk Array murni
        } catch (\Exception $e) {
            // Jika ada error (misal file tidak ditemukan/kredensial salah), kembalikan null
            return null;
        }
    }
}
