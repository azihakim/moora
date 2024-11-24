<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\User;
use Illuminate\Http\Request;

class RangkingController extends Controller
{
    public function index()
    {
        $alternatif = User::where(['role' => 'Pegawai'])->get();
        $kriteria = Kriteria::orderBy('id')->get();
        $matriks_keputusan = $alternatif->map(function ($a) use ($kriteria) {
            return [
                "kode_alternatif" => $a->kode_alternatif,
                "nama_alternatif" => $a->name,
                "nilai" => $kriteria->map(function ($k) use ($a) {
                    $penilaian = Penilaian::where([
                        'id_user' => $a->id,
                        'id_kriteria' => $k->id,
                    ])->first();
                    return [$penilaian->sub_kriteria->nilai, $penilaian->kriteria->jenis];
                })
            ];
        });

        $matriks_ternormalisasi = $matriks_keputusan->map(function ($mk) use ($matriks_keputusan) {
            $mk['nilai'] = $mk['nilai']->map(function ($n, $i) use ($matriks_keputusan) {
                $akar_nilai_per_kriteria = sqrt($matriks_keputusan->reduce(function ($carry, $mk) use ($i) {
                    return $carry + pow($mk['nilai'][$i][0], 2);
                }, 0));
                $n[0] = $n[0] / $akar_nilai_per_kriteria;
                return $n;
            });
            return $mk;
        });

        $matriks_normalisasi_terbobot = $matriks_ternormalisasi->map(function ($mk) use ($kriteria) {
            $mk['nilai'] = $mk['nilai']->map(function ($n, $i) use ($kriteria) {
                $n[0] *= $kriteria[$i]->bobot;
                return $n;
            });
            return $mk;
        });

        $nilai_yi = $matriks_normalisasi_terbobot->map(function ($mnt) {
            $fn = function ($collection, $jenis) {
                return $collection->reduce(function ($carry, $n) use ($jenis) {
                    if ($n[1] == $jenis) {
                        return $carry + $n[0];
                    }
                    return $carry;
                });
            };
            $mnt['max'] = $fn($mnt['nilai'], 'Benefit');
            $mnt['min'] = $fn($mnt['nilai'], 'Cost');
            $mnt['yi'] = $mnt['max'] - $mnt['min'];
            return $mnt;
        })->sortByDesc('yi');

        return view('rangking.index', compact('nilai_yi'));
    }
}
