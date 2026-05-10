@extends('admin.layouts.app')

@section('title','Edit Pertanyaan')

@section('content')
<h4 class="mb-3">
    <i class="bi bi-pencil-square"></i> Edit Pertanyaan
</h4>

<form method="POST"
      action="{{ route('admin.tracer-question.update', $question->id) }}">
@csrf
@method('PUT')

{{-- SECTION --}}
<div class="mb-3">
    <label class="form-label">Section <span class="text-danger">*</span></label>
    <select name="tracer_section_id"
            class="form-control"
            required>
        <option value="">-- Pilih Section --</option>
        @foreach($sections as $s)
            <option value="{{ $s->id }}"
                {{ $question->tracer_section_id == $s->id ? 'selected' : '' }}>
                {{ $s->urutan }}. {{ $s->nama_section }}
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
           value="{{ $question->kode_pertanyaan }}"
           placeholder="contoh: f1201">
</div>

{{-- PERTANYAAN --}}
<div class="mb-3">
    <label class="form-label">Pertanyaan <span class="text-danger">*</span></label>
    <textarea name="pertanyaan"
              class="form-control"
              rows="3"
              required>{{ $question->pertanyaan }}</textarea>
</div>

{{-- TIPE --}}
<div class="mb-3">
    <label class="form-label">Tipe Jawaban <span class="text-danger">*</span></label>
    <select name="tipe_jawaban"
            class="form-control"
            required>
        <option value="text"
            {{ $question->tipe_jawaban=='text'?'selected':'' }}>
            Isian Teks
        </option>
        <option value="radio"
            {{ $question->tipe_jawaban=='radio'?'selected':'' }}>
            Pilihan (Radio)
        </option>
        <option value="skala"
            {{ $question->tipe_jawaban=='skala'?'selected':'' }}>
            Skala 1–5
        </option>
        <option value="matrix_likert"
            {{ $question->tipe_jawaban=='matrix_likert'?'selected':'' }}>
            Matrix Likert
        </option>
    </select>
</div>

{{-- URUTAN --}}
<div class="mb-3">
    <label class="form-label">Urutan <span class="text-danger">*</span></label>
    <input type="number"
           name="urutan"
           class="form-control"
           value="{{ $question->urutan }}"
           required>
</div>

<div class="mt-4">
    <button class="btn btn-maroon">
        <i class="bi bi-save"></i> Update
    </button>

    <a href="{{ route('admin.tracer-question.index', ['section_id'=>$question->tracer_section_id]) }}"
        class="btn btn-cream">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

</form>
@endsection
