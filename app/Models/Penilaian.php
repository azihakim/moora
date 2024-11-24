<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'penilaian';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria');
    }

    public function sub_kriteria()
    {
        return $this->belongsTo(SubKriteria::class, 'id_sub_kriteria');
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'id_alternatif');
    }
}
