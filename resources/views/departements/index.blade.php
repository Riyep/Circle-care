@extends('app')

@section('content')
<div class="container">
    <h1>Departements</h1>
    <a href="{{ route('departements.create') }}" class="btn btn-primary">Add Departement</a>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">{{ $message }}</div>
    @endif

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($departements as $departement)
                <tr>
                    <td>{{ $departement->id }}</td>
                    <td>{{ $departement->mt_departements_name }}</td>
                    <td>
                        <a href="{{ route('departements.edit', $departement) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('departements.destroy', $departement) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
