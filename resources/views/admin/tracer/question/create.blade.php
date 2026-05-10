@extends('admin.layouts.app')

@section('title','Tambah Pertanyaan')

@section('content')
<h4 class="mb-3">
    <i class="bi bi-question-circle"></i> Tambah Pertanyaan
</h4>

<form method="POST" action="{{ route('admin.tracer-question.store') }}">
@csrf

{{-- SECTION --}}
<div class="mb-3">
    <label class="form-label">Section <span class="text-danger">*</span></label>
    <select name="tracer_section_id"
            class="form-control"
            required>
        <option value="">-- Pilih Section --</option>
        @foreach($sections as $s)
            <option value="{{ $s->id }}"
                {{ request('section_id') == $s->id ? 'selected' : '' }}>
               {{ $s->nama_section }}
            </option>
        @endforeach
    </select>
</div>

{{-- KODE --}}
<div class="mb-3">
    <label class="form-label">
        Kode Pertanyaan <small class="text-muted">(opsional)</small>
    </label>
    <input type="text"
           name="kode"
           class="form-control"
           placeholder="contoh: f1201">
</div>

{{-- PERTANYAAN --}}
<div class="mb-3">
    <label class="form-label">Pertanyaan <span class="text-danger">*</span></label>
    <textarea name="pertanyaan"
              class="form-control"
              rows="3"
              required></textarea>
</div>

{{-- TIPE --}}
<div class="mb-3">
    <label class="form-label">Tipe Jawaban <span class="text-danger">*</span></label>
    <select name="tipe_jawaban" class="form-control" required>
        <option value="text">Isian Teks</option>
        <option value="radio">Pilihan (Radio)</option>
        <option value="select">Select</option>
        <option value="checkbox">Checkbox</option>
        <option value="matrix_likert">Matrix Likert</option>
    </select>
</div>

{{-- URUTAN --}}
<div class="mb-3">
    <label class="form-label">Urutan <span class="text-danger">*</span></label>
    <input type="number"
           name="urutan"
           class="form-control"
           required>
</div>

<div class="mt-4">
    <button class="btn btn-primary">
        <i class="bi bi-save"></i> Simpan
    </button>

    <a href="{{ route('admin.tracer-question.index', ['section_id'=>request('section_id')]) }}"
        class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

</form>
@endsection
