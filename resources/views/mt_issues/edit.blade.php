@extends('app')

@section('content')
    <div class="container">
        <h1>Edit Thread</h1>
        <form action="{{ route('mt_issues.update', $issue->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="issue_title">Judul Thread</label>
                <input type="text" name="issue_title" id="issue_title" class="form-control" value="{{ $issue->issue_title }}"
                    required>
            </div>
            <div class="form-group">
                <label for="issue_description">Deskripsi Thread</label>
                <textarea name="issue_description" id="description" class="form-control" rows="5" required>{{ $issue->issue_description }}</textarea>
            </div>
            <div class="form-group">
                <label for="department_id">Department</label>
                <select name="department_id" id="department_id" class="form-control" required>
                    <option value="" disabled>Select Department</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}"
                            {{ $issue->department_id == $department->id ? 'selected' : '' }}>
                            {{ $department->mt_departements_name }}
                        </option>
                    @endforeach
                </select>
            {{-- </div>
            <div class="form-group">
                <label for="tagged_users">Tag Users</label>
                <select name="tagged_users[]" id="tagged_users" class="form-control" multiple>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" 
                            {{ $issue->taggedUsers->contains($user->id) ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach --}}
                </select>
            </div>            
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    
@endsection
