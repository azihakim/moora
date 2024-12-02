<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\PenilaianPerbulan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PenilaianPerbulanController extends Controller
{
    public function index()
    {
        $users = User::where(['role' => 'Pegawai'])->get();
        return view('penilaianPerbulan.index', compact('users'));
    }

    public function create()
    {
        $kriteria = Kriteria::with('sub_kriteria')->get();
        $user = User::where('role', '=', 'Pegawai')->get();
        $userById = false;
        return view('penilaianPerbulan.create', compact('kriteria', 'user', 'userById'));
    }

    public function createByUser($id)
    {
        $kriteria = Kriteria::with('sub_kriteria')->get();
        $userById = User::find($id);
        return view('penilaianPerbulan.create', compact('kriteria', 'userById'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_penilaian' => 'required|date',
            'karyawan' => 'required|exists:users,id',
            'penilaian' => 'required|array',
            'penilaian.*' => 'required|numeric',
        ]);

        try {
            $periode = \Carbon\Carbon::createFromFormat('Y-m', $request->tanggal_penilaian)->startOfMonth();

            // Periksa jika ada data yang sudah ada
            $dataExists = false;
            foreach ($request->penilaian as $idKriteria => $nilai) {
                $existingPenilaian = PenilaianPerbulan::where('id_user', $request->karyawan)
                    ->where('id_kriteria', $idKriteria)
                    ->where('periode', $periode->format('Y-m'))
                    ->exists();

                if ($existingPenilaian) {
                    $dataExists = true;
                    break;
                }
            }

            // Kirim konfirmasi jika data sudah ada
            if ($dataExists && !$request->has('confirm')) {
                return response()->json([
                    'status' => 'confirm',
                    'message' => 'Data untuk periode ini sudah ada. Apakah Anda ingin memperbarui?',
                ]);
            }

            // Lanjutkan untuk memperbarui atau menyimpan data
            foreach ($request->penilaian as $idKriteria => $nilai) {
                if ($idKriteria == 6) {
                    $tglMasuk = User::find($request->karyawan)->tgl_masuk;
                    $masaKerja = \Carbon\Carbon::parse($tglMasuk)->diffInYears(\Carbon\Carbon::now());
                    $nilai = $masaKerja;
                }

                $existingPenilaian = PenilaianPerbulan::where('id_user', $request->karyawan)
                    ->where('id_kriteria', $idKriteria)
                    ->whereMonth('periode', $periode->month)
                    ->whereYear('periode', $periode->year)
                    ->first();

                if ($existingPenilaian) {
                    $existingPenilaian->update([
                        'nilai' => $nilai,
                        'periode' => $request->tanggal_penilaian,
                    ]);
                } else {
                    PenilaianPerbulan::create([
                        'periode' => $request->tanggal_penilaian,
                        'id_user' => $request->karyawan,
                        'id_kriteria' => $idKriteria,
                        'nilai' => $nilai,
                    ]);
                }
            }

            $message = 'Penilaian berhasil disimpan!';
            $redirectRoute = $request->has('formUserById')
                ? route('penilaianPerbulan.cek', $request->karyawan)
                : route('penilaianPerbulan.index');

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => $message,
                    'redirect_url' => $redirectRoute,
                ]);
            }

            return redirect($redirectRoute)->with('success', $message);
        } catch (\Exception $e) {
            $errorMessage = 'Terjadi kesalahan: ' . $e->getMessage();

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $errorMessage,
                ], 500);
            }

            return back()->withErrors(['error' => $errorMessage]);
        }
    }

    public function cekPenilaianPerbulan($id)
    {
        $user = User::find($id);
        $penilaian = PenilaianPerbulan::where('id_user', $id)
            ->select('periode', 'id_user')
            ->groupBy('periode', 'id_user')
            ->get();
        // Map over the penilaian to format periode
        // $penilaian = $penilaian->map(function ($item) {
        //     // Convert to Carbon instance and format
        //     $item->periode = \Carbon\Carbon::parse($item->periode)->format('d-M-Y');
        //     setlocale(LC_TIME, 'id_ID');
        //     $item->periode = strftime('%d %B %Y', strtotime($item->periode));
        //     return $item;
        // });

        return view('penilaianPerbulan.cek', compact('user', 'penilaian'));
    }


    public function edit($periode, $id_user)
    {
        // Retrieve the kriteria (criteria) along with their sub_kriteria
        $kriteria = Kriteria::with('sub_kriteria')->get();

        // Retrieve all PenilaianPerbulan for the given periode
        $penilaian = PenilaianPerbulan::where('periode', $periode)
            ->where('id_user', $id_user)
            ->get();
        // Return the 'edit' view with kriteria and penilaian data
        return view('penilaianPerbulan.edit', compact('kriteria', 'penilaian', 'periode', 'id_user'));
    }

    public function update(Request $request, $periode)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'tanggal_penilaian' => 'required|date',
            'karyawan' => 'required|exists:users,id',  // Ensure the selected karyawan exists
            'penilaian' => 'required|array',
        ]);

        // Update the PenilaianPerbulan based on periode
        foreach ($validated['penilaian'] as $kriteria_id => $nilai) {
            PenilaianPerbulan::where('periode', $periode)
                ->where('id_user', $validated['karyawan'])
                ->where('id_kriteria', $kriteria_id)
                ->update([
                    'nilai' => $nilai,
                ]);
        }

        // Redirect or return response after update
        return redirect()->route('penilaianPerbulan.index')->with('success', 'Penilaian berhasil diperbarui');
    }
}
