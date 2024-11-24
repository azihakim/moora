<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'kriteria';

    public function sub_kriteria()
    {
        return $this->hasMany(SubKriteria::class, 'id_kriteria');
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'id_alternatif');
    }
}
