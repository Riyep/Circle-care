<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Roles::all();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mt_roles_name' => 'required|string|max:255',
        ]);

        Roles::create($request->all());
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Roles $role)
    {
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Roles $role)
    {
        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
{
    $isAdmin = Auth::user()->role->name === 'admin';

    if (Auth::user()->role->name != 'admin') {
        $request->validate([
            'mt_username' => 'required|string|max:255',
            'mt_departements_id' => 'required|exists:departements,id',
            'mt_positions_id' => 'required|exists:positions,id',
        ]);
        
        $user->update($request->only(['mt_username', 'mt_departements_id', 'mt_positions_id']));
    } else {
        $request->validate([
            'mt_username' => 'required|string|max:255',
            'mt_departements_id' => 'required|exists:departements,id',
            'mt_positions_id' => 'required|exists:positions,id',
            'mt_useremail' => 'required|email',
        ]);
    
        $user->update($request->all());
        
    }

    return redirect()->route('users.index')->with('success', 'User updated successfully.');
}

}
