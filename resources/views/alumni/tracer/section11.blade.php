@extends('alumni.layouts.app')
@section('title','Tracer Study - Section 11')

@section('content')
<div class="container mt-4">

<div class="card shadow-sm border-success">
    <div class="card-header bg-maroon text-white">
        <h5 class="mb-0">{{ $section->nama_section }}</h5>
        <small>{{ $section->deskripsi }}</small>
    </div>

    <div class="card-body">
        <form method="POST"
              action="{{ route('alumni.tracer.section11.store') }}">
        @csrf

        @foreach($section->questions as $q)
        <div class="mb-4">

            <label class="fw-semibold mb-2 d-block">
                {{ $q->kode_pertanyaan ? "({$q->kode_pertanyaan})" : '' }}
                {{ $q->pertanyaan }} 
                <span class="text-danger">*</span>
            </label>
            {{-- CHECKBOX --}}
            @if($q->tipe_jawaban == 'checkbox')
                @foreach($q->options as $opt)
                <div class="form-check">
                    <input type="checkbox"
                           class="form-check-input checkbox-red"
                           name="answers[{{ $q->id }}][]"
                           value="{{ $opt->value }}">
                    <label class="form-check-label">
                        {{ $opt->label }}
                    </label>
                </div>
                @endforeach
            @endif
            {{-- RADIO --}}
            @if($q->tipe_jawaban == 'radio')
                @foreach($q->options as $opt)
                <div class="form-check">
                    <input class="form-check-input radio-red"
                           type="radio"
                           name="answers[{{ $q->id }}]"
                           value="{{ $opt->value }}"
                           required>
                    <label class="form-check-label">
                        {{ $opt->value }} - {{ $opt->label }}
                    </label>
                </div>
                @endforeach
            @endif

            {{-- SELECT --}}
            @if($q->tipe_jawaban == 'select')
                <select class="form-select"
                        name="answers[{{ $q->id }}]"
                        required>
                    <option value="">-- Pilih Jawaban --</option>
                    @foreach($q->options as $opt)
                        <option value="{{ $opt->value }}">
                            {{ $opt->value }}
                        </option>
                    @endforeach
                </select>
            @endif

            {{-- TEXT --}}
            @if($q->tipe_jawaban == 'text')
                <input type="text"
                       class="form-control"
                       name="answers[{{ $q->id }}]"
                       required>
            @endif

            {{-- TEXTAREA --}}
            @if($q->tipe_jawaban == 'textarea')
                <textarea class="form-control"
                          rows="4"
                          name="answers[{{ $q->id }}]"
                          required></textarea>
            @endif

        </div>
        @endforeach

        <div class="alert alert-warning">
            <strong>Perhatian:</strong><br>
            Setelah dikirim, data tracer study <b>tidak dapat diubah kembali</b>.
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('alumni.tracer.section10') }}"
               class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

            <button type="submit"
                    class="btn btn-success"
                    onclick="return confirm('Yakin ingin mengirim tracer study?')">
                Kirim Tracer Study
                <i class="bi bi-check-circle"></i>
            </button>
        </div>

        </form>
    </div>
</div>

</div>
@endsection
