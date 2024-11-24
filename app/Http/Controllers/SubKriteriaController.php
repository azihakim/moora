<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubKriteriaController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::with(['sub_kriteria.kriteria'])->get();
        $sub_kriteria = SubKriteria::all();
        return view('sub_kriteria.index', [
            'kriteria' => $kriteria,
            'sub_kriteria' => $sub_kriteria
        ]);
    }

    public function store(Request $request)
    {
        Session::flash('method', 'store');
        $data = $request->validate([
            'id_kriteria' => 'required',
            'nama_sub_kriteria' => 'required',
            'nilai' => 'required',
        ]);
        SubKriteria::create($data);
        return redirect()->route('sub_kriteria.index');
    }

    public function update(Request $request, $id)
    {
        Session::flash('method', 'update');
        Session::flash('id', $id);
        $rules = [
            'id_kriteria' => 'required',
            'nama_sub_kriteria' => 'required',
            'nilai' => 'required',
        ];

        $sub_kriteria = SubKriteria::find($id);
        $data = $request->validate($rules);
        $sub_kriteria->update($data);
        return redirect()->route('sub_kriteria.index');
    }

    public function destroy($id)
    {
        $sub_kriteria = SubKriteria::find($id);
        $sub_kriteria->delete();
        return redirect()->route('sub_kriteria.index');
    }
}
