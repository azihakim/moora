<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianPerbulan extends Model
{
    use HasFactory;
    protected $fillable = [
        'periode',
        'id_user',
        'id_kriteria',
        'nilai',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
