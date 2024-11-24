<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AlternatifController extends Controller
{
    public function index()
    {
        $alternatif = Alternatif::all();
        return view('alternatif.index', [
            'alternatif' => $alternatif
        ]);
    }

    public function store(Request $request)
    {
        Session::flash('method', 'store');
        $data = $request->validate([
            'kode_alternatif' => 'required',
            'nama_alternatif' => 'required',
        ]);
        Alternatif::create($data);
        return redirect()->route('alternatif.index');
    }

    public function update(Request $request, $id)
    {
        Session::flash('method', 'update');
        Session::flash('id', $id);
        $rules = [
            'kode_alternatif' => 'required',
            'nama_alternatif' => 'required',
        ];
        $alternatif = Alternatif::find($id);
        $data = $request->validate($rules);
        $alternatif->update($data);
        return redirect()->route('alternatif.index');
    }

    public function destroy($id)
    {
        $alternatif = Alternatif::find($id);
        $alternatif->delete();
        return redirect()->route('alternatif.index');
    }
}
