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
    public function index(Request $req)
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
        });

        return view("perhitungan.index", compact('matriks_keputusan', 'matriks_ternormalisasi', 'matriks_normalisasi_terbobot', 'nilai_yi', 'kriteria'));
    }

    public function perhitunganMoora()
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
        });

        $moora = True;
        // return view("perhitungan.index", compact('matriks_keputusan', 'matriks_ternormalisasi', 'matriks_normalisasi_terbobot', 'nilai_yi', 'kriteria', 'moora'));
    }

    public function countPenilaianPerbulan($tglDari, $tglSampai)
    {
        // Ambil data penilaian dalam periode yang ditentukan
        $nilaiPerbulan = PenilaianPerbulan::whereBetween('periode', [$tglDari, $tglSampai])
            ->get();

        // Kelompokkan data berdasarkan user_id dan kriteria_id
        $nilaiPerbulan = $nilaiPerbulan->groupBy(['id_user', 'id_kriteria']); // Group by user_id dan id_kriteria

        // Tempat untuk menyimpan hasil penilaian
        $penilaianData = [];

        // Iterasi melalui setiap user dan kriteria
        foreach ($nilaiPerbulan as $userId => $kriterias) {
            foreach ($kriterias as $kriteriaId => $items) {
                // Hitung total nilai untuk kriteria tertentu dari periode yang ditentukan
                $totalNilai = $items->sum('nilai');
                if ($kriteriaId != 4) {
                    $totalNilai /= 2;
                }

                // Tentukan sub-kriteria berdasarkan total nilai
                $subKriteria = $this->getSubKriteria($kriteriaId, $totalNilai, $userId);

                // Simpan data penilaian yang telah diproses (hanya satu data untuk setiap kombinasi user dan kriteria)
                $penilaianData[] = [
                    'id_user' => $userId,
                    'id_kriteria' => $kriteriaId,
                    'id_sub_kriteria' => $subKriteria ? $subKriteria->id : null,
                    // 'id_sub_kriteria' => $totalNilai,
                ];
            }
        }

        // Pastikan tidak ada duplikasi data (jika ada user yang sama dan kriteria yang sama)
        // $penilaianData = collect($penilaianData)->unique(function ($item) {
        //     return $item['id_user'] . '-' . $item['id_kriteria']; // Menghindari duplikasi berdasarkan kombinasi user dan kriteria
        // })->values()->all();

        // dd($penilaianData);

        // Simpan semua penilaian untuk user pada periode tertentu
        Penilaian::truncate();

        foreach ($penilaianData as $data) {
            Penilaian::create($data);
        }

        $this->perhitunganMoora();


        // return response()->json([
        //     'status' => 'success', // Add this status to check in AJAX
        //     'message' => 'Penilaian berhasil disimpan',
        // ]);
    }




    private function getSubKriteria($kriteriaId, $totalNilai, $userId)
    {
        // kehadiran: absensi dalam persen
        if ($kriteriaId == 4) {
            $absenPercentage = ($totalNilai / 312) * 100; // hitung persentase absensi berdasarkan 312 hari kerja
            if ($absenPercentage > 95) {
                return SubKriteria::where('id_kriteria', $kriteriaId)
                    ->where('nama_sub_kriteria', '>95%')
                    ->first();
            } elseif ($absenPercentage >= 90) {
                return SubKriteria::where('id_kriteria', $kriteriaId)
                    ->where('nama_sub_kriteria', '<95%')
                    ->first();
            } elseif ($absenPercentage >= 80) {
                return SubKriteria::where('id_kriteria', $kriteriaId)
                    ->where('nama_sub_kriteria', '≥80%')
                    ->first();
            } else {
                return SubKriteria::where('id_kriteria', $kriteriaId)
                    ->where('nama_sub_kriteria', '<80%')
                    ->first();
            }
        }

        // masa kerja: tahun kerja
        if ($kriteriaId == 6) {
            $tglMasuk = User::find($userId)->tgl_masuk;
            $tglSekarang = now()->toDateString();
            $masaKerja = date_diff(date_create($tglMasuk), date_create($tglSekarang))->y;

            if ($masaKerja > 5) {
                return SubKriteria::where('id_kriteria', $kriteriaId)
                    ->where('nama_sub_kriteria', '> 5 tahun')
                    ->first();  // Sangat Baik
            } elseif ($masaKerja > 3) {
                return SubKriteria::where('id_kriteria', $kriteriaId)
                    ->where('nama_sub_kriteria', '3 < Masa Kerja ≤ 5')
                    ->first();  // Baik
            } elseif ($masaKerja > 1) {
                return SubKriteria::where('id_kriteria', $kriteriaId)
                    ->where('nama_sub_kriteria', '1 < Masa Kerja ≤ 3')
                    ->first();  // Cukup
            } else {
                return SubKriteria::where('id_kriteria', $kriteriaId)
                    ->where('nama_sub_kriteria', '≤ 1 tahun')
                    ->first();  // Kurang
            }
        }

        // Skala nilai untuk kriteria lain
        if ($totalNilai > 85) {
            return SubKriteria::where('id_kriteria', $kriteriaId)
                ->whereIn('nama_sub_kriteria', ['Sangat Baik', 'Sangat Tinggi'])
                ->first();
        } elseif ($totalNilai >= 80) {
            return SubKriteria::where('id_kriteria', $kriteriaId)
                ->whereIn('nama_sub_kriteria', ['Baik', 'Tinggi'])
                ->first();
        } elseif ($totalNilai >= 70) {
            return SubKriteria::where('id_kriteria', $kriteriaId)
                ->where('nama_sub_kriteria', 'Cukup')
                ->first();
        } else {
            return SubKriteria::where('id_kriteria', $kriteriaId)
                ->whereIn('nama_sub_kriteria', ['Kurang', 'Rendah'])
                ->first();
        }
    }


    public function countMoora(Request $req)
    {
        $tglDari = $req->tglDari;
        $tglSampai = $req->tglSampai;
        // Ambil data penilaian dalam periode yang ditentukan
        $nilaiPerbulan = PenilaianPerbulan::whereBetween('periode', [$tglDari, $tglSampai])
            ->get();

        // Kelompokkan data berdasarkan user_id dan kriteria_id
        $nilaiPerbulan = $nilaiPerbulan->groupBy(['id_user', 'id_kriteria']); // Group by user_id dan id_kriteria

        // Tempat untuk menyimpan hasil penilaian
        $penilaianData = [];

        // Iterasi melalui setiap user dan kriteria
        foreach ($nilaiPerbulan as $userId => $kriterias) {
            foreach ($kriterias as $kriteriaId => $items) {
                // Hitung total nilai untuk kriteria tertentu dari periode yang ditentukan
                $totalNilai = $items->sum('nilai');
                if ($kriteriaId != 4) {
                    $totalNilai /= 2;
                }

                // Tentukan sub-kriteria berdasarkan total nilai
                $subKriteria = $this->getSubKriteria($kriteriaId, $totalNilai, $userId);

                // Simpan data penilaian yang telah diproses (hanya satu data untuk setiap kombinasi user dan kriteria)
                $penilaianData[] = [
                    'id_user' => $userId,
                    'id_kriteria' => $kriteriaId,
                    'id_sub_kriteria' => $subKriteria ? $subKriteria->id : null,
                    // 'id_sub_kriteria' => $totalNilai,
                ];
            }
        }

        // dd($penilaianData);

        // Simpan semua penilaian untuk user pada periode tertentu
        Penilaian::truncate();

        foreach ($penilaianData as $data) {
            Penilaian::create($data);
        }

        $this->perhitunganMoora();

        return redirect()->route('perhitungan.index');
    }
}
