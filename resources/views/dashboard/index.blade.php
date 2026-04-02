@extends('app')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3>All Thread</h3>
                    <span>{{ $countIssue }} Total Threads</span>
                </div>
            </div>
        </div>

        <!-- Card untuk menampilkan jumlah thread per departemen -->
        <div class="col-md-6">
            <div class="card" id="departmentThreadCard">
                <div class="card-body">
                    <h3>Thread Departemen</h3>
                    <span id="departmentThreadCount">{{ $departments->first()->issues->count() }} threads</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Bar untuk mencari thread -->
    <div class="row mt-3">
        <div class="col-md-12">
            <form method="GET" action="{{ route('dashboard.index') }}">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" value="{{ $search }}" placeholder="Search by thread title...">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Tambahkan namespace untuk membatasi gaya hanya untuk elemen nav-tab */
        #departmentTabs .nav-link {
            color: white; /* Warna teks default */
            background-color: #00448d; /* Warna background default */
            border-radius: 5px; /* Membuat sudut melengkung */
            box-shadow: 2px 4px 6px rgba(0, 0, 0, 0.2); /* Memberikan efek shadow */
            margin-right: 5px; /* Memberikan jarak antar tab */
            padding: 10px 15px; /* Menambah padding untuk memperbesar area klik */
            transition: all 0.3s ease-in-out; /* Efek transisi saat hover */
        }

        #departmentTabs .nav-link:hover {
            background-color: #0056b3; /* Warna saat hover */
            color: #fff; /* Warna teks saat hover */
            transform: translateY(-3px); /* Efek hover terangkat */
            box-shadow: 2px 6px 8px rgba(0, 0, 0, 0.3); /* Shadow lebih intensif saat hover */
        }

        #departmentTabs .nav-link.active {
            background-color: #000000; /* Warna khusus untuk tab aktif */
            box-shadow: 2px 6px 10px rgba(0, 0, 0, 0.4); /* Shadow lebih gelap untuk tab aktif */
            color: #fff; /* Warna teks tab aktif */
        }
    </style>

    <ul class="nav nav-tabs mt-3" id="departmentTabs" role="tablist">
        @foreach ($departments as $index => $department)
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $index === 0 ? 'active' : '' }}" id="tab-{{ $department->id }}" 
                   data-toggle="tab" href="#content-{{ $department->id }}" 
                   role="tab" aria-controls="content-{{ $department->id }}" 
                   aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                   onclick="updateDepartmentThreadCount({{ $department->issues->count() }})">
                    {{ $department->mt_departements_name }}
                    {{-- ({{ $department->issues->count() }} threads) --}}
                </a>
            </li>
        @endforeach
    </ul>

    <div class="tab-content mt-3" id="departmentTabsContent">
        @foreach ($departments as $index => $department)
            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="content-{{ $department->id }}"
                role="tabpanel" aria-labelledby="tab-{{ $department->id }}">
                <div class="row mt-3">
                    @forelse ($department->issues as $issue)
                    <div class="col-md-3 mb-4">
                        <a href="{{ route('mt_issues.show', $issue->id) }}" class="card-link">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title font-weight-bold text-black">{{ $issue->issue_title }}</h5>
                                    <hr class="my-0">
                                    <p class="card-text text-black">{!! Str::limit($issue->issue_description, 100) !!}</p>
                                    <hr class="my-0">
                                    @if ($issue->user)
                                        <ul class="list-unstyled mb-1">
                                            <li class="d-flex justify-content-between align-items-center">
                                                <span style="color: rgb(2, 2, 136);">{{ $issue->user->mt_username }}</span>
                                                <span class="text-muted" style="font-size: 0.8rem;">{{ $issue->created_at->format('d M Y') }}</span>
                                            </li>
                                        </ul>
                                    @else
                                        <p class="text-muted mb-1"><strong>User not found.</strong></p>
                                        <p class="text-muted" style="font-size: 0.8rem;">{{ $issue->created_at->format('d M Y') }}</p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                Belum ada Thread untuk departemen ini.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>

    <script>
        // Fungsi untuk mengupdate jumlah thread berdasarkan departemen yang dipilih
        function updateDepartmentThreadCount(count) {
            document.getElementById('departmentThreadCount').innerText = count + " threads";
        }
    </script>
@endsection
