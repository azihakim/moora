<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\PenilaianPerbulan;
use App\Models\SubKriteria;
use App\Models\User;
use Illuminate\Http\Request;

class PerhitunganController extends Controller
{
    // public function index()
    // {
    //     $alternatif = User::where(['role' => 'Pegawai'])->get();
    //     $kriteria = Kriteria::orderBy('id')->get();
    //     $matriks_keputusan = $alternatif->map(function ($a) use ($kriteria) {
    //         return [
    //             "kode_alternatif" => $a->kode_alternatif,
    //             "nama_alternatif" => $a->name,
    //             "nilai" => $kriteria->map(function ($k) use ($a) {
    //                 $penilaian = Penilaian::where([
    //                     'id_user' => $a->id,
    //                     'id_kriteria' => $k->id,
    //                 ])->first();
    //                 return [$penilaian->sub_kriteria->nilai, $penilaian->kriteria->jenis];
    //             })
    //         ];
    //     });

    //     $matriks_ternormalisasi = $matriks_keputusan->map(function ($mk) use ($matriks_keputusan) {
    //         $mk['nilai'] = $mk['nilai']->map(function ($n, $i) use ($matriks_keputusan) {
    //             $akar_nilai_per_kriteria = sqrt($matriks_keputusan->reduce(function ($carry, $mk) use ($i) {
    //                 return $carry + pow($mk['nilai'][$i][0], 2);
    //             }, 0));
    //             $n[0] = $n[0] / $akar_nilai_per_kriteria;
    //             return $n;
    //         });
    //         return $mk;
    //     });

    //     $matriks_normalisasi_terbobot = $matriks_ternormalisasi->map(function ($mk) use ($kriteria) {
    //         $mk['nilai'] = $mk['nilai']->map(function ($n, $i) use ($kriteria) {
    //             $n[0] *= $kriteria[$i]->bobot;
    //             return $n;
    //         });
    //         return $mk;
    //     });

    //     $nilai_yi = $matriks_normalisasi_terbobot->map(function ($mnt) {
    //         $fn = function ($collection, $jenis) {
    //             return $collection->reduce(function ($carry, $n) use ($jenis) {
    //                 if ($n[1] == $jenis) {
    //                     return $carry + $n[0];
    //                 }
    //                 return $carry;
    //             });
    //         };
    //         $mnt['max'] = $fn($mnt['nilai'], 'Benefit');
    //         $mnt['min'] = $fn($mnt['nilai'], 'Cost');
    //         $mnt['yi'] = $mnt['max'] - $mnt['min'];
    //         return $mnt;
    //     });

    //     return view("perhitungan.index", compact('matriks_keputusan', 'matriks_ternormalisasi', 'matriks_normalisasi_terbobot', 'nilai_yi', 'kriteria'));
    // }

    public function index()
    {
        return view('perhitungan.index');
    }

    public function countPenilaianPerbulan($tglDari, $tglSampai)
    {
        // Ambil data penilaian berdasarkan periode
        $nilaiPerbulan = PenilaianPerbulan::whereBetween('periode', [$tglDari, $tglSampai])->get();

        // Loop untuk menghitung nilai dan menyimpan ke tabel penilaian
        $nilaiPerbulan
            ->groupBy('id_kriteria') // Kelompokkan berdasarkan kriteria
            ->each(function ($items, $kriteriaId) use ($tglDari) {

                $totalNilai = $items->sum('nilai'); // Hitung total nilai

                // Tentukan sub-kriteria berdasarkan nilai total
                $subKriteria = null;

                // Cek setiap kriteria dan tentukan sub-kriteria berdasarkan nilai
                if ($kriteriaId == 4) { // Kriteria Kehadiran
                    if ($totalNilai >= 95) {
                        $subKriteria = SubKriteria::where('id_kriteria', $kriteriaId)
                            ->where('nama_sub_kriteria', '>95%')
                            ->first();
                    } elseif ($totalNilai >= 80) {
                        $subKriteria = SubKriteria::where('id_kriteria', $kriteriaId)
                            ->where('nama_sub_kriteria', '<95%')
                            ->first();
                    } elseif ($totalNilai >= 60) {
                        $subKriteria = SubKriteria::where('id_kriteria', $kriteriaId)
                            ->where('nama_sub_kriteria', '≥80%')
                            ->first();
                    } else {
                        $subKriteria = SubKriteria::where('id_kriteria', $kriteriaId)
                            ->where('nama_sub_kriteria', '<80%')
                            ->first();
                    }
                }

                // Tentukan sub-kriteria untuk kriteria lainnya seperti "Kualitas Kerja", "Kerjasama", dll
                if ($kriteriaId == 1) { // Kriteria Kualitas Kerja
                    if ($totalNilai >= 80) {
                        $subKriteria = SubKriteria::where('id_kriteria', $kriteriaId)
                            ->where('nama_sub_kriteria', 'Sangat Baik')
                            ->first();
                    } elseif ($totalNilai >= 60) {
                        $subKriteria = SubKriteria::where('id_kriteria', $kriteriaId)
                            ->where('nama_sub_kriteria', 'Baik')
                            ->first();
                    } elseif ($totalNilai >= 40) {
                        $subKriteria = SubKriteria::where('id_kriteria', $kriteriaId)
                            ->where('nama_sub_kriteria', 'Cukup')
                            ->first();
                    } else {
                        $subKriteria = SubKriteria::where('id_kriteria', $kriteriaId)
                            ->where('nama_sub_kriteria', 'Kurang')
                            ->first();
                    }
                }

                // Proses penyimpanan data ke tabel penilaian
                if ($subKriteria) {
                    Penilaian::create([
                        'id_user' => $items->first()->id_user, // ID pengguna yang dinilai
                        'id_kriteria' => $kriteriaId,
                        'id_sub_kriteria' => $subKriteria->id, // ID sub-kriteria yang dipilih
                    ]);
                }
            });

        return response()->json([
            'message' => 'Penilaian berhasil disimpan',
        ]);
    }
}
