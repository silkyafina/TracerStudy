@extends('admin.layouts.app')

@section('title','Edit Section Tracer')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="bi bi-pencil-square"></i> Edit Section Tracer Study</h4>
    <a href="{{ route('admin.tracer-section.index') }}"
       class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">

        <form method="POST"
              action="{{ route('admin.tracer-section.update', $section->id) }}">
            @csrf
            @method('PUT')

            {{-- URUTAN --}}
            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-list-ol"></i> Urutan
                </label>
                <input type="number"
                       name="urutan"
                       class="form-control @error('urutan') is-invalid @enderror"
                       value="{{ old('urutan', $section->urutan) }}"
                       required>
                @error('urutan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- NAMA SECTION --}}
            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-ui-checks-grid"></i> Nama Section
                </label>
                <input type="text"
                       name="nama_section"
                       class="form-control @error('nama_section') is-invalid @enderror"
                       value="{{ old('nama_section', $section->nama_section) }}"
                       required>
                @error('nama_section')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- DESKRIPSI --}}
            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-card-text"></i> Deskripsi
                </label>
                <textarea name="deskripsi"
                          rows="4"
                          class="form-control @error('deskripsi') is-invalid @enderror"
                          placeholder="Deskripsi section (opsional)">{{ old('deskripsi', $section->deskripsi) }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- AKSI --}}
            <div class="d-flex gap-2">
                <button class="btn btn-maroon">
                    <i class="bi bi-save"></i> Update
                </button>
                <a href="{{ route('admin.tracer-section.index') }}"
                   class="btn btn-outline-cream">
                    Batal
                </a>
            </div>

        </form>

    </div>
</div>
@endsection
