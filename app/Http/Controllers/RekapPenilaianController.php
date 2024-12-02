<?php

namespace App\Http\Controllers;

use App\Models\PenilaianPerbulan;
use App\Models\RekapPenilaian;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Storage;

class RekapPenilaianController extends Controller
{
    // function rekapHrd()
    // {
    //     return view('rekap.pdf-rekapHrd');
    // }

    public function rekapHrd($id)
    {
        // Ambil data berdasarkan periode yang sama
        $rekap = RekapPenilaian::find($id);
        $periode = $rekap->periode;
        $tglDari = Carbon::createFromFormat('Y-m', explode(' / ', $periode)[0])->format('F Y');
        $tglSampai = Carbon::createFromFormat('Y-m', explode(' / ', $periode)[1])->format('F Y');


        $countKehadiran = FacadesDB::table('penilaian_perbulans')
            ->join('users', 'penilaian_perbulans.id_user', '=', 'users.id')
            ->where('penilaian_perbulans.periode', $periode)
            ->where('penilaian_perbulans.id_kriteria', 4)
            ->select('penilaian_perbulans.id_user', 'users.kode_alternatif', FacadesDB::raw('SUM(penilaian_perbulans.nilai) as total_kehadiran'))
            ->groupBy('penilaian_perbulans.id_user', 'users.kode_alternatif') // Tambahkan id_user ke dalam GROUP BY
            ->get();

        // Pastikan nilai total_kehadiran adalah angka, bukan string
        $countKehadiran = $countKehadiran->map(function ($item) {
            $item->total_kehadiran = (int) $item->total_kehadiran; // Ubah menjadi integer
            return $item;
        });

        if ($rekap) {
            // Decode data JSON yang ada di rekap
            $data = json_decode($rekap->data, true);

            // Ambil data kriteria dari objek atau array yang ada
            $kriteria = $data['kriteria'];  // Menambahkan kriteria yang dibutuhkan

            // Buat map total kehadiran berdasarkan kode_alternatif
            $totalKehadiranMap = $countKehadiran->pluck('total_kehadiran', 'kode_alternatif')->toArray();

            // Update nilai C4 pada matriks keputusan
            foreach ($data['matriks_keputusan'] as &$alternatif) {
                $kodeAlternatif = $alternatif['kode_alternatif'] ?? null;
                if ($kodeAlternatif && isset($totalKehadiranMap[$kodeAlternatif])) {
                    foreach ($alternatif['nilai'] as $index => &$kriteria) {
                        if ($index === 3 && $kriteria[1] === "Benefit") {
                            $kriteria[0] = $totalKehadiranMap[$kodeAlternatif];
                        }
                    }
                }
            }
            // $data = json_encode($data);
            // dd($data);

            $pdf = Pdf::loadView('rekap.pdf-rekapHrd', compact('data', 'tglDari', 'tglSampai'))
                ->setPaper('a4', 'landscape');
            // return $pdf->stream('rekap.pdf');
            $fileName = 'rekap_' . time() . '_' . uniqid() . '.pdf';
            // dd($fileName);
            $path = Storage::disk('public')->put($fileName, $pdf->output());
            // Cek apakah file berhasil disimpan
            if ($path) {
                $rekap->rekap_pdf = $fileName;
                $rekap->save();
            }

            return response()->download(Storage::disk('public')->path($fileName));
            // return view('rekap.pdf-rekapHrd', compact('data', 'tglDari', 'tglSampai'));
        } else {
            return response()->json(['error' => 'Data not found'], 404);
        }
    }
    // public function rekapHrd($tglDari, $tglSampai)
    // {
    //     // Parse $tglDari dan $tglSampai sebagai objek Carbon dengan format Y-m
    //     $startDate = Carbon::createFromFormat('Y-m', $tglDari)->format('Y-m');
    //     $endDate = Carbon::createFromFormat('Y-m', $tglSampai)->format('Y-m');

    //     // Membuat periode yang ingin dicari dalam format "YYYY-MM / YYYY-MM"
    //     $periode = $startDate . ' / ' . $endDate;

    //     // Ambil data berdasarkan periode yang sama
    //     $rekap = RekapPenilaian::where('periode', $periode)->first();

    //     $countKehadiran = FacadesDB::table('penilaian_perbulans')
    //         ->join('users', 'penilaian_perbulans.id_user', '=', 'users.id')
    //         ->whereBetween('penilaian_perbulans.periode', [$tglDari, $tglSampai])
    //         ->where('penilaian_perbulans.id_kriteria', 4)
    //         ->select('penilaian_perbulans.id_user', 'users.kode_alternatif', FacadesDB::raw('SUM(penilaian_perbulans.nilai) as total_kehadiran'))
    //         ->groupBy('penilaian_perbulans.id_user', 'users.kode_alternatif') // Tambahkan id_user ke dalam GROUP BY
    //         ->get();

    //     // Pastikan nilai total_kehadiran adalah angka, bukan string
    //     $countKehadiran = $countKehadiran->map(function ($item) {
    //         $item->total_kehadiran = (int) $item->total_kehadiran; // Ubah menjadi integer
    //         return $item;
    //     });

    //     if ($rekap) {
    //         // Decode data JSON yang ada di rekap
    //         $data = json_decode($rekap->data, true);

    //         // Ambil data kriteria dari objek atau array yang ada
    //         $kriteria = $data['kriteria'];  // Menambahkan kriteria yang dibutuhkan

    //         // Buat map total kehadiran berdasarkan kode_alternatif
    //         $totalKehadiranMap = $countKehadiran->pluck('total_kehadiran', 'kode_alternatif')->toArray();

    //         // Update nilai C4 pada matriks keputusan
    //         foreach ($data['matriks_keputusan'] as &$alternatif) {
    //             $kodeAlternatif = $alternatif['kode_alternatif'] ?? null;
    //             if ($kodeAlternatif && isset($totalKehadiranMap[$kodeAlternatif])) {
    //                 foreach ($alternatif['nilai'] as $index => &$kriteria) {
    //                     if ($index === 3 && $kriteria[1] === "Benefit") {
    //                         $kriteria[0] = $totalKehadiranMap[$kodeAlternatif];
    //                     }
    //                 }
    //             }
    //         }
    //         // $data = json_encode($data);
    //         // dd($data);

    //         $pdf = Pdf::loadView('rekap.pdf-rekapHrd', compact('data', 'tglDari', 'tglSampai'))
    //             ->setPaper('a4', 'landscape');
    //         // return $pdf->stream('rekap.pdf');
    //         $fileName = 'rekap_' . time() . '_' . uniqid() . '.pdf';
    //         // dd($fileName);
    //         $path = Storage::disk('public')->put($fileName, $pdf->output());
    //         // Cek apakah file berhasil disimpan
    //         if ($path) {
    //             $rekap->rekap_pdf = $fileName;
    //             $rekap->save();
    //         }

    //         return response()->download(Storage::disk('public')->path($fileName));
    //         // return view('rekap.pdf-rekapHrd', compact('data', 'tglDari', 'tglSampai'));
    //     } else {
    //         return response()->json(['error' => 'Data not found'], 404);
    //     }
    // }

    public function rekapPerbulan($id)
    {
        // Cari Rekap Penilaian berdasarkan ID
        $rekap = RekapPenilaian::find($id);

        // Validasi apakah data ditemukan
        if (!$rekap) {
            abort(404, 'Data Rekap Penilaian tidak ditemukan.');
        }

        // Ambil periode dari rekap
        $periode = $rekap->periode;

        // Validasi format periode
        $periodeParts = explode(' / ', $periode);
        if (count($periodeParts) !== 2) {
            abort(400, 'Format periode tidak valid.');
        }

        // Format tanggal dari dan sampai
        $tglDari = Carbon::createFromFormat('Y-m', $periodeParts[0])->format('F Y');
        $tglSampai = Carbon::createFromFormat('Y-m', $periodeParts[1])->format('F Y');

        // Ambil data penilaian berdasarkan periode dan eager load relasi dengan user dan kriteria
        $data = PenilaianPerbulan::with(['user', 'kriteria']) // Eager load relasi ke user dan kriteria
            ->whereBetween('periode', [$periodeParts[0], $periodeParts[1]])
            ->orderBy('periode')
            ->get()
            ->groupBy('periode');
        // dd($getPerbulan);

        // Generate PDF
        $pdf = Pdf::loadView('rekap.pdf-rekapPerbulan', compact('data', 'tglDari', 'tglSampai'));
        return $pdf->stream('data_penilaian.pdf');
    }




    public function index()
    {
        $data = RekapPenilaian::all();
        // dd($data);
        return view('rekap.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RekapPenilaian $rekapPenilaian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RekapPenilaian $rekapPenilaian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RekapPenilaian $rekapPenilaian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RekapPenilaian $rekapPenilaian)
    {
        //
    }
}
