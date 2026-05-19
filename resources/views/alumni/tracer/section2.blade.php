@extends('alumni.layouts.app')
@section('title','Tracer Study - Section 2')

@section('content')
<div class="container-fluid mt-4">

<div class="card shadow-sm">
    <div class="card-header bg-maroon text-white">
        <h5 class="mb-0">
            {{ $section->nama_section }}
        </h5>
        <small>{{ $section->deskripsi }}</small>
    </div>

    <div class="card-body">
        <form method="POST"
              action="{{ route('alumni.tracer.section2.store') }}">
        @csrf
        @foreach($section->questions as $q)
        <div class="mb-4">
        
            <label class="fw-semibold mb-2 d-block">
                {{ $q->kode_pertanyaan ? "({$q->kode_pertanyaan})" : '' }}
                {{ $q->pertanyaan }} 
                <span class="text-danger">*</span>
            </label>
            @if(in_array($q->tipe_jawaban, ['radio','select']))
            @foreach($q->options as $opt)
            <div class="form-check">
                <input class="form-check-input"
                       type="radio"
                       name="answers[{{ $q->id }}]"
                       value="{{ $opt->value }}"
                       required>
                <label class="form-check-label">
                        {{ $opt->value }} – {{ $opt->label }}
                </label>
                    
            </div>
            @endforeach
        @endif
        @if($q->tipe_jawaban == 'matrix_likert')
        
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center table-likert">
    <thead class="table-light">
        <tr>
            <th class="text-start">Pernyataan</th>
            @foreach($q->options as $opt)
                <th>
                    {{ $opt->value }} <br>
                    <small class="text-muted">{{ $opt->label }}</small>
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
                       class="form-check-input"
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

    </div>
    @endforeach
    
    <div class="d-flex gap-2 justify-content-between">
        <a href="{{ route('alumni.tracer.section1') }}" class="btn btn-secondary">
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
                            