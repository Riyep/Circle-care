@extends('app')

@section('content')
<div class="container">
    <h1>Create User</h1>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="mt_role_id" class="form-label">Role</label>
            <select name="mt_role_id" id="mt_role_id" class="form-control" required>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->mt_roles_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="mt_departements_id" class="form-label">Departement</label>
            <select name="mt_departements_id" id="mt_departements_id" class="form-control" required>
                @foreach($departements as $departement)
                    <option value="{{ $departement->id }}">{{ $departement->mt_departements_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="mt_positions_id" class="form-label">Position</label>
            <select name="mt_positions_id" id="mt_positions_id" class="form-control" required>
                @foreach($positions as $position)
                    <option value="{{ $position->id }}">{{ $position->mt_positions_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="mt_username" class="form-label">Username</label>
            <input type="text" name="mt_username" id="mt_username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="mt_useremail" class="form-label">Email</label>
            <input type="email" name="mt_useremail" id="mt_useremail" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="mt_userpass" class="form-label">Password</label>
            <input type="password" name="mt_userpass" id="mt_userpass" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
