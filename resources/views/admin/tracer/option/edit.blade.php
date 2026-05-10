@extends('admin.layouts.app')
@section('title','Edit Option')

@section('content')

<h4 class="mb-3">
    <i class="bi bi-pencil-square"></i> Edit Option
</h4>

<div class="card">
    <div class="card-body">
        <form method="POST"
              action="{{ route('admin.tracer-option.update',$option->id) }}">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Label</label>
            <input type="text"
                   name="label"
                   class="form-control"
                   value="{{ $option->label }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Value</label>
            <input type="text"
                   name="value"
                   class="form-control"
                   value="{{ $option->value }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Urutan</label>
            <input type="number"
                   name="urutan"
                   class="form-control"
                   value="{{ $option->urutan }}"
                   required>
        </div>

        <button class="btn btn-primary">
            <i class="bi bi-save"></i> Simpan
        </button>

        <a href="{{ route('admin.tracer-option.index', [
            'question_id' => $option->tracer_question_id
        ]) }}"
        class="btn btn-secondary">
            Kembali
        </a>
        </form>
    </div>
</div>

@endsection
