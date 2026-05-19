@extends('admin.layouts.app')

@section('title', 'Upload Tracer')

@section('content')

<div class="container">

    <h4 class="mb-3">
        <i class="bi bi-upload me-1"></i>
        Upload Data Tracer Study
    </h4>



    {{-- FORM --}}
    <div class="card">
        <div class="card-body">

            <form action="{{ route('admin.tracer.import') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Pilih File Excel</label>
                    <input type="file" name="file" class="form-control" required>
                </div>

                <div class="d-flex gap-2">

                    <button class="btn btn-maroon">
                        <i class="bi bi-upload me-1"></i>
                        Upload
                    </button>
                
                    <a href="{{ route('admin.tracer.template') }}"
                       class="btn btn-cream">
                        <i class="bi bi-download me-1"></i>
                        Download Template
                    </a>
                
                    <a href="{{ route('admin.tracer.results.index') }}"
                       class="btn btn-secondary">
                       <i class="bi bi-arrow-left">
                        Kembali
                    </a>
                
                </div>

            </form>

        </div>
    </div>

</div>

@endsection