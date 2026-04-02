@extends('app')

@section('content')
<div class="container">
    <h1>Edit Position</h1>
    <form action="{{ route('positions.update', $position) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="mt_positions_name" class="form-label">Name</label>
            <input type="text" name="mt_positions_name" class="form-control" id="mt_positions_name" value="{{ $position->mt_positions_name }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
