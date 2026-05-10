@extends('survey.app')

@section('content')

<div class="d-flex justify-content-center align-items-center" style="min-height:60vh;">
    <div class="card shadow-sm text-center" style="max-width:600px; width:100%;">

        <div class="card-body p-5">

            <div class="mb-4">
                <i class="bi bi-check-circle-fill text-success" style="font-size:60px;"></i>
            </div>

            <h4 class="mb-3 fw-semibold">
                Survey Sudah Diisi
            </h4>

            <p class="text-muted mb-4">
                Terima kasih atas partisipasi Anda dalam mengisi
                <strong>Survey Evaluasi Pengguna Lulusan</strong>.
                <br><br>
                Data yang telah dikirim tidak dapat diubah kembali.
            </p>

            <hr class="my-4">

            <p class="small text-muted mb-0">
                Tim Tracer Study <br>
                Universitas Harkat Negeri
            </p>

        </div>

    </div>
</div>

@endsection