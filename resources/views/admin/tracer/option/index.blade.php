@extends('admin.layouts.app')
@section('title','Option Jawaban')

@section('content')

<h4 class="mb-3">
    <i class="bi bi-ui-radios"></i>
    Option Jawaban
</h4>

<div class="alert alert-info">
    <strong>Pertanyaan:</strong> {{ $question->pertanyaan }}
</div>

{{-- FORM TAMBAH --}}
<div class="card mb-4">
    <div class="card-body">
        <form method="POST"
              action="{{ route('admin.tracer-option.store') }}"
              class="row g-2">
        @csrf

        <input type="hidden"
               name="tracer_question_id"
               value="{{ $questionId }}">

        <div class="col-md-5">
            <input type="text"
                   name="label"
                   class="form-control"
                   placeholder="Beasiswa ADIK"
                   required>
        </div>

        <div class="col-md-2">
            <input type="text"
                   name="value"
                   class="form-control"
                   placeholder="2"
                   required>
        </div>

        <div class="col-md-2">
            <input type="number"
                   name="urutan"
                   class="form-control"
                   placeholder="Urutan"
                   required>
        </div>

        <div class="col-md-3">
            <button class="btn btn-maroon w-100">
                <i class="bi bi-plus-circle"></i> Tambah
            </button>
        </div>
        </form>
    </div>
</div>

{{-- TABLE --}}
<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
    <thead>
        <tr>
            <th width="60">No</th>
            <th>Label</th>
            <th width="100">Value</th>
            <th width="80">Urutan</th>
            <th width="140">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($options as $o)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $o->label }}</td>
            <td>{{ $o->value }}</td>
            <td>{{ $o->urutan }}</td>
            <td>
                <a href="{{ route('admin.tracer-option.edit',$o->id) }}"
                   class="btn btn-sm btn-cream">
                   <i class="bi bi-pencil"></i>
                </a>

                <form method="POST"
                      action="{{ route('admin.tracer-option.destroy',$o->id) }}"
                      style="display:inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-maroon"
                            onclick="return confirm('Hapus option?')">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
</div>
</div>

<a href="{{ route('admin.tracer-question.index', [
    'section_id' => $question->tracer_section_id
]) }}"
class="btn btn-cream mt-3">
<i class="bi bi-arrow-left"></i> Kembali ke Pertanyaan
</a>
      
@endsection
