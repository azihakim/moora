<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::all();
        return view('kriteria.index', [
            'kriteria' => $kriteria
        ]);
    }

    public function store(Request $request)
    {
        Session::flash('method', 'store');
        $data = $request->validate([
            'kode_kriteria' => 'required',
            'nama_kriteria' => 'required',
            'bobot' => 'required',
            'jenis' => 'required',
        ]);
        Kriteria::create($data);
        return redirect()->route('kriteria.index');
    }

    public function update(Request $request, $id)
    {
        Session::flash('method', 'update');
        Session::flash('id', $id);
        $rules = [
            'kode_kriteria' => 'required',
            'nama_kriteria' => 'required',
            'bobot' => 'required',
            'jenis' => 'required',
        ];

        $kriteria = Kriteria::find($id);
        $data = $request->validate($rules);
        $kriteria->update($data);
        return redirect()->route('kriteria.index');
    }

    public function destroy($id)
    {
        $kriteria = Kriteria::find($id);
        $kriteria->delete();
        return redirect()->route('kriteria.index');
    }
}
