@extends('app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary font-weight-bold">MyThread</h1>
        @if(Auth::user()->mt_roles_name == 1)
        <a href="{{ route('mt_issues.create') }}" class="btn btn-success shadow-sm">+ Open Thread</a>
        @endif
    </div>

    @if (session('success'))
        <div class="alert alert-success shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <style>
        .bg-darkblue {
            background-color: #003366; /* Warna biru gelap */
        }
    </style>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse ($issues as $issue)
            <div class="col">
                <!-- Link seluruh card -->
                <a href="{{ route('mt_issues.show', $issue->id) }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-darkblue text-white">
                            <!-- Judul dengan font hitam -->
                            <h5 class="card-title mb-0 text-black">{{ $issue->issue_title }}</h5>
                        </div>
                        <div class="card-body">
                            <!-- Deskripsi dengan font hitam -->
                            <p class="card-text text-black">
                                {!! Str::limit($issue->issue_description, 150) !!}
                            </p>
                            <p class="card-text">
                                <small class="text-info font-italic">{{ $issue->department->mt_departements_name ?? 'No department assigned' }}</small>
                            </p>
                            <p class="card-text">
                                @if ($issue->taggedUsers->isNotEmpty())
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($issue->taggedUsers as $user)
                                            <li class="text-primary">{{ $user->mt_username }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <em class="text-muted">No tagged users</em>
                                @endif
                            </p>
                        </div>
                        <div class="card-footer text-muted text-center">
                            {{ $issue->created_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Anda belum memposting Thread.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
