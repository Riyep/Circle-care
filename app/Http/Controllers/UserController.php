<?php

namespace App\Http\Controllers;

use App\Models\Departements;
use App\Models\Positions;
use App\Models\Roles;
use App\Models\User;
use App\Models\Role;
use App\Models\Departement;
use App\Models\Position;
use App\Models\Users;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role->mt_roles_name === 'Admin') {
            // Admin melihat semua pengguna
            $users = User::all();
        } else {
            // User biasa hanya melihat dirinya sendiri
            $users = User::where('id', auth()->user()->id)->get();
        }
    
        return view('users.index', compact('users'));
    }
    public function redirectBasedOnRole()
    {
        $user = auth()->user(); // Ambil data pengguna yang sedang login

        if ($user->role && $user->role->mt_roles_name === 'Admin') {
            // Jika pengguna adalah Admin, arahkan ke halaman index
            return redirect()->route('users.index');
        }

        // Jika pengguna bukan Admin, arahkan ke halaman edit profil miliknya sendiri
        return redirect()->route('users.edit', $user->id);
    }
    public function role()
    {
        return $this->belongsTo(Roles::class, 'mt_role_id'); // Sesuaikan dengan kolom foreign key
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Roles::all();
        $departements = Departements::all();
        $positions = Positions::all();
        return view('users.create', compact('roles', 'departements', 'positions'));
    }
    
    public function search(Request $request)
    {
        $query = $request->get('q'); // Ambil query dari parameter
        $users = User::where('mt_username', 'LIKE', "%{$query}%")
        ->where('mt_username', '!=', 'Admin')
        ->select('id', 'mt_username') // Hanya ambil ID dan username
        ->get();
        return response()->json($users); // Kembalikan hasil pencarian dalam format JSON
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mt_role_id' => 'required|exists:roles,id',
            'mt_departements_id' => 'required|exists:departements,id',
            'mt_positions_id' => 'required|exists:positions,id',
            'mt_username' => 'required|string|max:255',
            'mt_useremail' => 'required|email|unique:users,mt_useremail',
            'mt_userpass' => 'required|string|min:6',
        ]);

        User::create($request->all());
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }
    public function show($id){}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
{
    $loggedInUser = auth()->user();

    // Tangani pengguna tanpa role
    $userRoleName = $loggedInUser->role->mt_roles_name ?? 'User'; // Default ke 'User' jika role null

    // Jika bukan Admin, pastikan hanya bisa mengedit akun miliknya sendiri
    if ($userRoleName !== 'Admin' && $loggedInUser->id !== $user->id) {
        return redirect()->route('users.edit', $loggedInUser->id)
            ->with('error', 'You are only allowed to edit your own profile.');
    }

    // Data untuk form
    $roles = $userRoleName === 'Admin' ? Roles::all() : [];
    $departements = Departements::all();
    $positions = Positions::all();

    return view('users.edit', compact('user', 'roles', 'departements', 'positions'));
}



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
{
    // Validasi input
    $request->validate([
        'mt_username' => 'required|string|max:255',
        'mt_departements_id' => 'required|exists:departements,id',
        'mt_positions_id' => 'required|exists:positions,id',
        'mt_useremail' => 'nullable|email|unique:users,mt_useremail,' . $user->id,
        'mt_userpass' => 'nullable|string|min:6',
        'mt_role_id' => 'required_if:role,Admin|exists:roles,id', // Hanya jika admin
    ]);

    // Hanya Admin yang bisa mengupdate semua kolom
    if (auth()->user()->role->mt_roles_name === 'Admin') {
        $user->update([
            'mt_username' => $request->mt_username,
            'mt_departements_id' => $request->mt_departements_id,
            'mt_positions_id' => $request->mt_positions_id,
            'mt_useremail' => $request->mt_useremail,
            'mt_role_id' => $request->mt_role_id,
            'mt_userpass' => $request->filled('mt_userpass') ? bcrypt($request->mt_userpass) : $user->mt_userpass,
        ]);
    } else {
        // User biasa hanya bisa mengupdate username, departemen, dan posisi
        $user->update([
            'mt_username' => $request->mt_username,
            'mt_departements_id' => $request->mt_departements_id,
            'mt_positions_id' => $request->mt_positions_id,
        ]);
    }

    return redirect()->route('users.index')->with('success', 'Profile updated successfully.');
}

    



}
