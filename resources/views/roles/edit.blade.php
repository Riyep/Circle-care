@extends('app')

@section('content')
<div class="container">
    <h1>Edit Role</h1>
    <form action="{{ route('roles.update', $role) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="mt_roles_name" class="form-label">Name</label>
            <input type="text" name="mt_roles_name" class="form-control" id="mt_roles_name" value="{{ $role->mt_roles_name }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
