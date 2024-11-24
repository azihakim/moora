<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKriteria extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'sub_kriteria';

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria');
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'id_penilaian');
    }
}
