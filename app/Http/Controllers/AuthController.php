<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        $auth = Auth::attempt($request->only('username', 'password'));

        if (!$auth) {
            return back()->with('error', 'Username atau password salah!');
        }

        $request->session()->regenerate(); // tambah ini

        $user = Auth::user();
        if ($user->status_akun == 'nonaktif') {
            Auth::logout();
            return 'Akun tidak aktif';
        }

        // Redirect berdasarkan role
        switch ($user->role) {
            case 'admin':
                return redirect()->intended(route('dashboardAdmin.index'));
            case 'siswa':
                return redirect()->intended(route('dashboardSiswa.index'));
            case 'kabeng':
                return redirect()->intended(route('dashboardKabeng.index'));
            default:
                Auth::logout();
                return 'Role tidak dikenali';
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
    // $akun_user = DB::table('akun_user')->where('username', $username)->first();
    // $akuns = AkunUser::where('username', $request->username)->get();
    // dd($akun_user, $akun, $akuns);
}
