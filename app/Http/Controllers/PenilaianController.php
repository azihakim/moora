<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\User;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index()
    {
        $users = User::where(['role' => 'Pegawai'])->get();
        $kriteria = Kriteria::with('sub_kriteria')->get();
        return view('penilaian.index', [
            'users' => $users,
            'kriteria' => $kriteria,
        ]);
    }

    public function store(Request $request)
    {
        foreach ($request->penilaian as $id_kriteria => $id_sub_kriteria) {
            $penilaian = new Penilaian;
            $penilaian->id_user = $request->id_user;
            $penilaian->id_kriteria = $id_kriteria;
            $penilaian->id_sub_kriteria = $id_sub_kriteria;
            $penilaian->save();
        }
        return redirect()->route('penilaian.index');
    }

    public function update(Request $request, $id)
    {
        foreach ($request->penilaian as $id_kriteria => $id_sub_kriteria) {
            $penilaian = Penilaian::where([
                'id_user' => $id,
                'id_kriteria' => $id_kriteria,
            ])->first();
            if ($penilaian) {
                $penilaian->id_sub_kriteria = $id_sub_kriteria;
                $penilaian->save();
            } else {
                $penilaian = new Penilaian;
                $penilaian->id_user = $id;
                $penilaian->id_kriteria = $id_kriteria;
                $penilaian->id_sub_kriteria = $id_sub_kriteria;
                $penilaian->save();
            }
        }
        return redirect()->route('penilaian.index');
    }
}
