@extends('admin.layouts.app')

@section('title','Tambah Section')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>
        <i class="bi bi-plus-circle"></i>
        Tambah Section Kuesioner
    </h4>
    <a href="{{ route('admin.tracer-section.index') }}"
       class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">

        {{-- ERROR VALIDATION --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.tracer-section.store') }}">
            @csrf

            {{-- NAMA SECTION --}}
            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-ui-checks-grid"></i>
                    Nama Section
                </label>
                <input type="text"
                       name="nama_section"
                       class="form-control"
                       value="{{ old('nama_section') }}"
                       placeholder="Contoh: Identitas Alumni"
                       required>
            </div>

            {{-- URUTAN --}}
            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-list-ol"></i>
                    Urutan
                </label>
                <input type="number"
                       name="urutan"
                       class="form-control"
                       value="{{ old('urutan') }}"
                       placeholder="Contoh: 1"
                       required>
            </div>

            {{-- DESKRIPSI --}}
            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-card-text"></i>
                    Deskripsi
                </label>
                <textarea name="deskripsi"
                          rows="4"
                          class="form-control"
                          placeholder="Deskripsi section (opsional)">{{ old('deskripsi') }}</textarea>
            </div>

            {{-- AKSI --}}
            <div class="d-flex gap-2">
                <button class="btn btn-maroon">
                    <i class="bi bi-save"></i> Simpan
                </button>

                <a href="{{ route('admin.tracer-section.index') }}"
                   class="btn btn-outline-secondary">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
