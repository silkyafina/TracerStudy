@extends('alumni.layouts.app')
@section('title','Tracer Study - Section 8')

@section('content')
<div class="container mt-4">

<div class="card shadow-sm">
    <div class="card-header bg-maroon text-white">
        <h5 class="mb-0">{{ $section->nama_section }}</h5>
        <small>{{ $section->deskripsi }}</small>
    </div>

    <div class="card-body">
        <form method="POST"
              action="{{ route('alumni.tracer.section8.store') }}">
        @csrf

        @foreach($section->questions as $q)
        <div class="mb-4">

            <label class="fw-semibold mb-2 d-block">
                {{ $q->kode_pertanyaan ? "({$q->kode_pertanyaan})" : '' }}
                {{ $q->pertanyaan }} 
                <span class="text-danger">*</span>
            </label>

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
                            {{ $opt->value }} - {{ $opt->label }}
                        </option>
                    @endforeach
                </select>
            @endif

            {{-- MATRIX LIKERT --}}
            @if($q->tipe_jawaban == 'matrix_likert')
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <th class="text-start">Pernyataan</th>
                        @foreach($q->options as $opt)
                            <th>
                                {{ $opt->value }}<br>
                                <small>{{ $opt->label }}</small>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($q->items as $item)
                    <tr>
                        <td class="text-start">{{ $item->label }}</td>
                        @foreach($q->options as $opt)
                        <td>
                            <input type="radio"
                                   name="answers[{{ $q->id }}][{{ $item->id }}]"
                                   value="{{ $opt->value }}"
                                   required>
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
                          rows="3"
                          name="answers[{{ $q->id }}]"
                          required></textarea>
            @endif

        </div>
        @endforeach

        <div class="d-flex justify-content-between">
            <a href="{{ route('alumni.tracer.section7') }}"
               class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

            <button type="submit" class="btn btn-maroon">
                Lanjut ke Section Berikutnya
                <i class="bi bi-arrow-right"></i>
            </button>
        </div>

        </form>
    </div>
</div>

</div>
@endsection
