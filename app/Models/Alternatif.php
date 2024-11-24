<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'alternatif';

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'id_alternatif');
    }
}
