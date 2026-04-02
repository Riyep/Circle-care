@extends('app') 
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">

                <!-- Header Card -->
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-start">
                    <div class="d-flex align-items-center">
                        <h4 class="mb-0">
                            {{ $issue->department->mt_departements_name ?? 'Tidak ada departemen' }}
                        </h4>
                    </div>
                    <div class="text-right">
                        @if($issue->user)
                            <p class="mb-0 font-weight-bold" style="font-size: 0.8rem;">{{ $issue->user->mt_username }}</p>
                            <p class="mb-0 text-light" style="font-size: 0.7rem;">{{ $issue->created_at->format('d M Y, H:i') }}</p>
                        @else
                            <p class="mb-0 font-italic text-muted" style="font-size: 0.8rem;">User tidak ditemukan</p>
                        @endif

                    </div>

                </div>

                <!-- Body Card -->
                <div class="card-body">
                    <!-- Judul Keluhan -->
                    <div class="form-group mb-2">
                        <p class="form-control-plaintext text-primary font-weight-bold text-left" 
                           style="font-size: 1.5rem; color:black; margin-bottom: 0.5rem;">
                            {{ $issue->issue_title }}
                        </p>
                    </div>
                    <hr class="my-0">

                    @if(
                        optional(auth()->user()->role)->mt_roles_name === 'Admin' ||
                        (optional(auth()->user()->role)->mt_roles_name === 'Mod' && $issue->department_id == auth()->user()->department_id) ||
                        (auth()->user()->id === $issue->user_id)
                    )
                    <div class="d-flex gap-2 mt-3 flex-wrap">
                        <!-- Tombol Close Thread -->
                        @if($issue->status !== 'closed')
                            <form action="{{ route('issues.close', $issue->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-warning"
                                    onclick="return confirm('Anda yakin ingin menutup Thread ini?')">
                                    <i class="fas fa-lock"></i> Close Thread
                                </button>
                            </form>
                        @endif


                        @if(
                            optional(auth()->user()->role)->mt_roles_name === 'Admin' ||
                            (optional(auth()->user()->role)->mt_roles_name === 'Mod' && $issue->department_id == auth()->user()->department_id)
                        )
                        <!-- Tombol Edit Thread -->
                        <a href="{{ route('issues.edit', $issue->id) }}" class="btn btn-primary">
                            <i class="fas fa-cog"></i> Edit Thread
                        </a>

                        <!-- Tombol Delete Thread -->
                        <form action="{{ route('issues.destroy', $issue->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Anda yakin untuk menghapus Thread?')">
                                <i class="fas fa-trash"></i> Delete Thread
                            </button>
                        </form>
                        @endif
                    </div>
                    @endif

                    <!-- Detail Keluhan -->
                    <div class="form-group mt-2">
                        <div class="form-control-plaintext text-left" style="font-size: 1rem; margin-top: 0.5rem;">
                            {!! nl2br(strip_tags($issue->issue_description, '<p><br>')) !!}
                        </div>
                        <hr class="my-0">
                    </div>

                    <!-- Gambar -->
                    @if ($issue->issue_image)
                    <div class="form-group mt-3">
                        <div class="text-center mt-2">
                            <img src="{{ asset('uploads/issues/' . $issue->issue_image) }}" 
                                 alt="Gambar Keluhan" 
                                 class="img-fluid rounded" 
                                 style="max-height: 400px; max-width: 100%;">
                        </div>
                    </div>
                    @else
                    <p class="text-muted">Gambar tidak tersedia.</p>
                    @endif

                    <!-- Pengguna yang Ditag -->
                    <div class="form-group mt-3">
                        @if ($issue->taggedUsers->isNotEmpty())
                            <ul class="list-unstyled mb-0">
                                @foreach ($issue->taggedUsers as $user)
                                    <li class="text-primary">{{ $user->mt_username }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="form-control-plaintext text-muted">Tidak ada pengguna yang ditag.</p>
                        @endif
                    </div>

                    <!-- Komentar -->
                    <div class="card-footer">
    <h5>Komentar</h5>

    @if($issue->status !== 'closed')
        <!-- Form Komentar -->
        <form action="{{ route('comments.store', $issue->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <textarea name="content" class="form-control" rows="2" placeholder="Tulis komentar Anda..."></textarea>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Kirim Komentar</button>
            </div>
        </form>
    @else
        <!-- Notifikasi jika thread sudah ditutup -->
        <div class="alert alert-warning mt-2" role="alert">
            Thread telah ditutup. Anda tidak dapat memberikan komentar lagi.
        </div>
    @endif

    <hr>

    <!-- Daftar Komentar -->
    @if($issue->comments->isNotEmpty())
        <ul class="list-unstyled mt-4">
            @foreach($issue->comments->sortByDesc('created_at') as $comment)
                <li class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span class="font-weight-bold">
                            {{ $comment->user->mt_username ?? 'Anonim' }}
                            @if($comment->user && $comment->user->position)
                                <span class="badge bg-secondary text-light ml-2" style="opacity: 0.7;">
                                    {{ $comment->user->position->mt_positions_name }}
                                </span>
                            @endif
                        </span>
                        <small class="text-muted">
                            {{ $comment->created_at->format('d M Y, H:i') }}
                        </small>
                    </div>
                    <p class="mb-0">{{ $comment->content }}</p>
                    <hr>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-muted mt-4">Belum ada komentar.</p>
    @endif
</div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
