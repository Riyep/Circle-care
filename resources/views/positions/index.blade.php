@extends('app')

@section('content')
<div class="container">
    <h1>Positions</h1>
    <a href="{{ route('positions.create') }}" class="btn btn-primary">Add Position</a>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-2">{{ $message }}</div>
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
            @foreach ($positions as $position)
                <tr>
                    <td>{{ $position->id }}</td>
                    <td>{{ $position->mt_positions_name }}</td>
                    <td>
                        <a href="{{ route('positions.edit', $position) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('positions.destroy', $position) }}" method="POST" style="display:inline;">
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
