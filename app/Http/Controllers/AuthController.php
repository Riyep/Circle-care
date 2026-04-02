<?php

namespace App\Http\Controllers;

use App\Models\Departements;
use App\Models\Positions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function login()
    {
        return view('auth.login');
    }

    // Proses login
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'mt_useremail' => 'required|email',
            'mt_userpass' => 'required',
        ]);

        if (Auth::attempt(['mt_useremail' => $credentials['mt_useremail'], 'password' => $credentials['mt_userpass']])) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'mt_useremail' => 'Email atau Password yang anda masukkan salah.',
        ]);
    }

    // Tampilkan halaman register
    public function register()
    {
        $departements = Departements::all();
        $positions = Positions::all();

        return view('auth.register', compact('departements', 'positions'));
    }

    // Proses registrasi
    public function store(Request $request)
    {
        $request->validate([
            'mt_username' => 'required',
            'mt_useremail' => 'required',
            'mt_userpass' => 'required',
        ]);

        User::create([
            'mt_username' => $request->mt_username,
            'mt_useremail' => $request->mt_useremail,
            'mt_userpass' => bcrypt($request->mt_userpass),
            'mt_role_id' => 2,
            'mt_positions_id' => $request->mt_positions_id,
            'mt_departements_id' => $request->mt_departements_id
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
