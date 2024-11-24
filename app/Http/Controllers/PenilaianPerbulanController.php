<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\PenilaianPerbulan;
use App\Models\User;
use Illuminate\Http\Request;

class PenilaianPerbulanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where(['role' => 'Pegawai'])->get();
        return view('penilaianPerbulan.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kriteria = Kriteria::with('sub_kriteria')->get();
        $user = User::where('role', '=', 'Pegawai')->get();
        return view('penilaianPerbulan.create', compact('kriteria', 'user'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal_penilaian' => 'required|date', // Validasi untuk tanggal penilaian
            'karyawan' => 'required|exists:users,id', // Validasi karyawan
            'penilaian' => 'required|array', // Penilaian harus berupa array
            'penilaian.*' => 'required|numeric', // Setiap penilaian harus berupa angka
        ]);

        try {
            // Looping untuk menyimpan setiap penilaian berdasarkan kriteria
            foreach ($request->penilaian as $idKriteria => $nilai) {
                PenilaianPerbulan::create([
                    'periode' => $request->tanggal_penilaian, // Tanggal penilaian
                    'id_user' => $request->karyawan, // ID karyawan
                    'id_kriteria' => $idKriteria, // ID kriteria
                    'nilai' => $nilai, // Nilai penilaian
                ]);
            }

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Penilaian berhasil disimpan!');
        } catch (\Exception $e) {
            // Tangani jika ada error
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }




    /**
     * Display the specified resource.
     */
    public function show(PenilaianPerbulan $penilaianPerbulan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PenilaianPerbulan $penilaianPerbulan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PenilaianPerbulan $penilaianPerbulan)
    {
        //
    }
}
