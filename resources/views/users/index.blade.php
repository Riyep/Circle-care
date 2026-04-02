@extends('app')

@section('content')
<div class="container mt-4">
    <h1 class="text-primary font-weight-bold">Daftar Pengguna</h1>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Role</th>
                <th>Departemen</th>
                <th>Posisi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->mt_username }}</td>
                    <td>{{ $user->role ? $user->role->mt_roles_name : 'Tidak Ada Role' }}</td>
                    <td>{{ $user->departement ? $user->departement->mt_departements_name : 'Tidak Ada Departemen' }}</td>
                    <td>{{ $user->position ? $user->position->mt_positions_name : 'Tidak Ada Posisi' }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
