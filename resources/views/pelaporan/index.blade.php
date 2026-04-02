@extends('app')

@section('content')
    <div class="container">
        <h1>Laporan Thread</h1>
        <form action="{{ route('pelaporan.download') }}" method="GET">
            <div class="form-group">
                <label for="department_id">Pilih Departemen:</label>
                <select name="department_id" id="department_id" class="form-control" required>
                    <option value="" disabled selected>Pilih Departemen</option>

                    @if(auth()->user()->role->mt_roles_name === 'Admin')
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->mt_departements_name }}</option>
                        @endforeach
                    @elseif(auth()->user()->role->mt_roles_name === 'Mod')
                        @if(auth()->user()->department)  
                            <option value="{{ auth()->user()->mt_departements_id }}" selected>
                                {{ auth()->user()->department->mt_departements_name }}
                            </option>
                        @else
                            <option value="" disabled>Departemen tidak ditemukan</option>
                        @endif
                    @endif
                </select>
            </div>

            <div class="form-group">
                <label for="start_date">Tanggal Mulai:</label>
                <input type="date" name="start_date" id="start_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="end_date">Tanggal Akhir:</label>
                <input type="date" name="end_date" id="end_date" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Unduh Laporan</button>
        </form>
    </div>
@endsection
