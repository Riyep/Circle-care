@extends('app')

@section('content')
<div class="container mt-4">
    <h1 class="text-primary font-weight-bold">Edit User Profile</h1>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Username bisa diedit oleh semua user -->
        <div class="mb-3">
            <label for="mt_username" class="form-label">Username</label>
            <input type="text" name="mt_username" id="mt_username" class="form-control" 
                value="{{ old('mt_username', $user->mt_username) }}" required
                @if(auth()->user()->role && auth()->user()->role->mt_roles_name !== 'Admin') 
                     
                @endif>
        </div>

        <!-- Jika admin, tampilkan role -->
        @if(auth()->user()->role && auth()->user()->role->mt_roles_name === 'Admin')
            <div class="form-group mt-3">
                <label for="mt_role_id" class="form-label">Role</label>
                <select name="mt_role_id" id="mt_role_id" class="form-control" required>
                    <option value="" disabled>-- Pilih Role --</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" 
                            {{ old('mt_role_id', $user->mt_role_id) == $role->id ? 'selected' : '' }}>{{ $role->mt_roles_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        <!-- Departemen dan Posisi bisa diedit oleh semua -->
        @if(auth()->user()->role && auth()->user()->role->mt_roles_name === 'Admin')
        <div class="form-group mt-3">
            <label for="mt_departements_id" class="font-weight-bold">Pilih Departemen</label>
            <select name="mt_departements_id" id="department" class="form-control" required>
                <option value="" disabled>-- Pilih Departemen --</option>
                @foreach ($departements as $departement)
                    <option value="{{ $departement->id }}" 
                        {{ old('mt_departements_id', $user->mt_departements_id) == $departement->id ? 'selected' : '' }}>{{ $departement->mt_departements_name }}
                    </option>
                @endforeach
            </select>
        </div>
        @endif

        <div class="form-group mt-3">
            <label for="mt_positions_id" class="font-weight-bold">Pilih Posisi</label>
            <select name="mt_positions_id" id="mt_positions_id" class="form-control" required>
                <option value="" disabled>-- Pilih Posisi --</option>
                @foreach($positions as $position)
                    <option value="{{ $position->id }}" 
                        {{ old('mt_positions_id', $user->mt_positions_id) == $position->id ? 'selected' : '' }}>{{ $position->mt_positions_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Tampilkan email jika admin -->
        @if(auth()->user()->role && auth()->user()->role->mt_roles_name === 'Admin')
            <div class="form-group mt-3">
                <label for="mt_useremail" class="form-label">Email</label>
                <input type="email" name="mt_useremail" id="mt_useremail" class="form-control" 
                value="{{ old('mt_useremail', $user->mt_useremail) }}" required>
            </div>
        @endif

        <!-- Password -->
        <div class="form-group mt-3">
            <label for="mt_userpass" class="form-label">Password</label>
            <input type="password" name="mt_userpass" id="mt_userpass" class="form-control" 
                placeholder="Masukkan password baru (Kosongkan jika tidak ingin mengganti)">
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-success">Update Profile</button>
        </div>
    </form>
</div>
@endsection
