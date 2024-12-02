<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapPenilaian extends Model
{
    use HasFactory;
    protected $fillable = [
        'data',
        'periode',
        'rekap_pdf'
    ];
}
