@extends('app') 

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Detail Thread - Komentar</h4>
                </div>
                <div class="card-body">
                    <!-- Judul Keluhan -->
                    <div class="form-group">
                        <label class="font-weight-bold">Judul Keluhan</label>
                        <p class="form-control-plaintext text-primary font-weight-bold">{{ $issue->issue_title }}</p>
                    </div>

                    <!-- Detail Keluhan -->
                    <div class="form-group mt-3">
                        <label class="font-weight-bold">Detail Keluhan</label>
                        <div class="form-control-plaintext">{!! nl2br(strip_tags($issue->issue_description, '<p><br>')) !!}</div>
                    </div>

                    <!-- Komentar yang Sudah Diposting -->
                    <div class="form-group mt-3">
                        <label class="font-weight-bold">Komentar Sebelumnya</label>
                        @if ($comments->count() > 0)
                            <ul class="list-group">
                                @foreach ($comments as $comment)
                                    <li class="list-group-item">
                                        <p><strong>{{ $comment->user->mt_username }}</strong> <span class="text-muted">- {{ $comment->created_at->format('d M Y, H:i') }}</span></p>
                                        <p>{!! nl2br(e($comment->mt_comment)) !!}</p>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="form-control-plaintext text-muted">Belum ada komentar pada masalah ini.</p>
                        @endif
                    </div>

                    <!-- Formulir untuk Menambahkan Komentar -->
                    <div class="form-group mt-3">
                        <label for="mt_comment" class="font-weight-bold">Tambah Komentar</label>
                        <form method="POST" action="{{ route('comments.store', $issue->id) }}">
                            @csrf
                            <div class="form-group">
                                <textarea name="mt_comment" id="mt_comment" class="form-control" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
