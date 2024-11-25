<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        Session::flash('method', 'store');
        $data = $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required',
            'kode_alternatif' => 'nullable|unique:users,kode_alternatif',
            'role' => 'required',
            'tgl_masuk' => 'required',
        ], [
            'kode_alternatif.unique' => 'Kode Alternatif sudah digunakan, silakan pilih kode yang lain.',
            'username.unique' => 'Username sudah ada, silakan pilih username yang lain.',
        ]);

        // Hash password sebelum disimpan
        $data['password'] = Hash::make($data['password']);

        // Simpan data ke dalam database
        User::create($data);

        // Redirect ke halaman index users
        return redirect()->route('users.index');
    }



    public function update(Request $request, $id)
    {
        Session::flash('method', 'update');
        Session::flash('id', $id);
        $rules = [
            'name' => 'required',
            'username' => 'required',
            'role' => 'required',
            'tgl_masuk' => 'required',
        ];
        $user = User::find($id);
        if ($user->kode_alternatif !== $request->kode_alternatif) {
            $rules['kode_alternatif'] = 'nullable|unique:users,kode_alternatif';
        }
        $messages = [
            'kode_alternatif.unique' => 'Kode Alternatif sudah digunakan, silakan pilih kode yang lain.',
            'username.unique' => 'Username sudah ada, silakan pilih username yang lain.',
        ];


        $data = $request->validate($rules, $messages);

        $user = User::find($id);
        if ($user->username !== $request->username) {
            $rules['username'] = 'required|unique:users,username';
        }
        $data = $request->validate($rules);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);
        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('users.index');
    }
}
