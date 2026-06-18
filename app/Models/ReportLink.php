<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportLink extends Model
{
    use HasFactory;

    // Mengizinkan penyimpanan massal ke kolom ini
    protected $fillable = [
        'kategori',
        'periode_bulan',
        'spreadsheet_url',
        'spreadsheet_id',
    ];
}
