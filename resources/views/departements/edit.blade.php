@extends('app')

@section('content')
<div class="container">
    <h1>Edit Departement</h1>
    <form action="{{ route('departements.update', $departement) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="mt_departements_name" class="form-label">Name</label>
            <input type="text" name="mt_departements_name" class="form-control" id="mt_departements_name" value="{{ $departement->mt_departements_name }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
