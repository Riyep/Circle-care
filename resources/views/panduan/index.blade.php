@extends('app')

@section('content')
<div class="container mt-5">
    <h1 class="text-primary font-weight-bold mb-4">Panduan Pengguna</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Buku Panduan</h5>
            <p class="card-text">Silakan lihat atau unduh buku panduan pengguna untuk mempelajari lebih lanjut tentang cara menggunakan aplikasi Circle Care.</p>
            <div class="mb-3">
                <a href="{{ asset('/assets/pdf/panduan.pdf') }}" class="btn btn-primary" target="_blank">
                    <i class="fas fa-download"></i> Unduh Panduan
                </a>
            </div>
            <iframe src="{{ asset('/assets/pdf/panduan.pdf') }}" width="100%" height="600px" style="border: none;"></iframe>
        </div>
    </div>
</div>
@endsection
