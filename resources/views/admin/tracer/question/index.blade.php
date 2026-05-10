@extends('admin.layouts.app')
@section('title','Pertanyaan Tracer')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>
        <i class="bi bi-question-circle"></i>
        Pertanyaan - {{ $section->nama_section ?? 'Semua Section' }}
    </h4>

    @isset($section)
    <a href="{{ route('admin.tracer-section.index') }}"
       class="btn btn-cream">
       <i class="bi bi-arrow-left"></i> Kembali ke Section
    </a>
    @endisset
</div>

<a href="{{ route('admin.tracer-question.create', ['section_id' => $section->id ?? null]) }}"
   class="btn btn-maroon mb-3">
   <i class="bi bi-plus-circle"></i> Tambah Pertanyaan
</a>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
    <thead>
        <tr>
            <th>Section</th>
            <th>Kode</th>
            <th>Pertanyaan</th>
            <th>Tipe</th>
            <th width="180">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($questions as $q)
        <tr>
            <td>{{ $q->section->nama_section }}</td>
            <td>{{ $q->kode_pertanyaan ?? '-' }}</td>
            <td>{{ $q->pertanyaan }}</td>
            <td>
                <span class="badge bg-maroon">
                    {{ $q->tipe_jawaban }}
                </span>
            </td>
            <td>
                <div class="d-flex align-items-center gap-2 flex-wrap">
            
                    {{-- ITEM --}}
                    @if($q->tipe_jawaban=='matrix_likert')
                    <a href="{{ route('admin.tracer-item.index',['question_id'=>$q->id]) }}"
                       class="btn btn-sm btn-maroon"
                       data-bs-toggle="tooltip"
                       title="Kelola Item">
                       <i class="bi bi-list-check"></i>
                    </a>
                    @endif
            
                    {{-- OPTION --}}
                    @if(in_array($q->tipe_jawaban, ['radio','checkbox','select','likert','matrix_likert']))
                    <a href="{{ route('admin.tracer-option.index', ['question_id'=>$q->id]) }}"
                       class="btn btn-sm btn-cream"
                       data-bs-toggle="tooltip"
                       title="Kelola Option">
                       <i class="bi bi-ui-checks"></i>
                    </a>
                    @endif
            
                    {{-- EDIT --}}
                    <a href="{{ route('admin.tracer-question.edit',$q->id) }}"
                       class="btn btn-sm btn-maroon"
                       data-bs-toggle="tooltip"
                       title="Edit">
                       <i class="bi bi-pencil"></i>
                    </a>
            
                    {{-- DELETE --}}
                    <form action="{{ route('admin.tracer-question.destroy',$q->id) }}"
                          method="POST"
                          onsubmit="return confirm('Yakin hapus data ini?')">
                        @csrf 
                        @method('DELETE')
                        <button type="submit"
                                class="btn btn-sm btn-cream"
                                data-bs-toggle="tooltip"
                                title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
            
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center text-muted">
                Belum ada pertanyaan
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
        </div>
    </div>
@endsection
