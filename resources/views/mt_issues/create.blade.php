@extends('app') 

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Open Thread</h4>
                    </div>
                    <div class="card-body">
                        @if ($showForm ?? true)
                        <form action="{{ route('mt_issues.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="issue_title" class="font-weight-bold">Judul Keluhan</label>
                                    <input type="text" name="issue_title" id="issue_title" class="form-control"
                                        placeholder="Masukkan judul keluhan Anda" required>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="issue_description" class="font-weight-bold">Detail Keluhan</label>
                                    <textarea name="issue_description"  class="form-control" rows="5"
                                        placeholder="Deskripsikan keluhan Anda secara detail" required></textarea>
                                </div>
                                
                                <div class="form-group mt-3">
                                    <label for="department" class="font-weight-bold">Pilih Departemen Yang Dituju</label>
                                    <select name="department" id="department" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Departemen --</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->mt_departements_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>             

                                <div class="form-group mt-3">
                                    <label for="tagged_users" class="font-weight-bold">Tag Pengguna (Opsional)</label>
                                    <input id="tagged_users" name="tagged_users[]" class="form-control" 
                                    placeholder="Cari User yang dituju"></textarea>
                                </div>
                                
                                <div class="form-group mt-3">
                                    <label for="issue_image" class="font-weight-bold">Unggah Gambar (Opsional)</label>
                                    <input type="file" name="issue_image" id="issue_image" class="form-control-file">
                                    <small class="form-text text-muted">Unggah gambar yang relevan untuk mendukung keluhan Anda. (Maks. 2MB)</small>
                                </div>
                                
                                <div class="form-group text-right mt-4">
                                    <button type="submit" class="btn btn-success">Buat Thread</button>
                                </div>
                            </form>
                        @else
                            <p>Formulir ini tidak tersedia saat ini.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new TomSelect('#tagged_users', {
                valueField: 'id', 
                labelField: 'mt_username', 
                searchField: 'mt_username',
                load: function(query, callback) {
                    if (query.length < 2) return callback(); 
    
                    fetch(`{{ route('users.search') }}?q=${query}`)
                        .then(response => response.json())
                        .then(callback)
                        .catch(() => callback());
                },
                plugins: ['remove_button'], 
                create: false, 
            });
        });
    </script>
@endsection
