@extends('app')

@section('content')
<div class="container">
    <h1>Create Position</h1>
    <form action="{{ route('positions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="mt_positions_name" class="form-label">Name</label>
            <input type="text" name="mt_positions_name" class="form-control" id="mt_positions_name" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
