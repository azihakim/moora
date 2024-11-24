<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            $user = User::where('username', $credentials['username'])->first();
            Auth::login($user);
            if ($user->role == "HRD") {
                return redirect()->route('dashboard.index');
            } else if ($user->role == "Pegawai") {
                return redirect()->route('rangking.index');
            } else if ($user->role == "Direktur") {
                return redirect()->route('dashboard.index');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
