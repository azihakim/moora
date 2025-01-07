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
        // Menyimpan sesi untuk menandai metode request
        Session::flash('method', 'store');

        // Validasi input form
        $data = $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required',
            'kode_alternatif' => 'nullable|unique:users,kode_alternatif',
            'role' => 'required',
            'tgl_masuk' => 'required|date',
            'no_hp' => 'nullable|numeric',
            'alamat' => 'nullable|string',
            'nik' => 'nullable|numeric',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
        ], [
            'kode_alternatif.unique' => 'Kode Alternatif sudah digunakan, silakan pilih kode yang lain.',
            'username.unique' => 'Username sudah ada, silakan pilih username yang lain.',
            'tgl_masuk.required' => 'Tanggal Masuk wajib diisi.',
            'tgl_masuk.date' => 'Tanggal Masuk tidak valid.',
            'no_hp.numeric' => 'No Telepon harus berupa angka.',
            'nik.numeric' => 'NIK harus berupa angka.',
        ]);

        // Hash password sebelum disimpan
        $data['password'] = Hash::make($data['password']);

        // Simpan data ke dalam database
        User::create($data);

        // Redirect ke halaman index users dengan session flash pesan sukses
        return redirect()->route('users.index')->with('status', 'Pengguna berhasil ditambahkan!');
    }




    public function update(Request $request, $id)
    {
        Session::flash('method', 'update');
        Session::flash('id', $id);
        $rules = [
            'name' => 'required',
            'username' => '',
            'role' => 'required',
            'tgl_masuk' => 'required|date',
            'no_hp' => 'nullable|numeric',
            'alamat' => 'nullable|string',
            'nik' => 'nullable|numeric',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
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
    public function generateKodeUser(Request $request)
    {
        // Ambil data terakhir dari tabel user berdasarkan kode alternatif
        $lastUser = User::latest('id')->first();

        if ($lastUser) {
            // Ambil angka terakhir dari kode alternatif dan tambahkan 1
            $lastNumber = (int) str_replace('A', '', $lastUser->kode_alternatif);
            $newKode = 'A' . ($lastNumber + 1);
        } else {
            // Jika belum ada data, mulai dari A1
            $newKode = 'A1';
        }

        // Kirim data sebagai respon JSON
        return response()->json(['kode_alternatif' => $newKode]);
    }
}
