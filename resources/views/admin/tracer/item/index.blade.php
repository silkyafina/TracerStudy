@extends('admin.layouts.app')
@section('title','Item Pertanyaan')

@section('content')

<h4 class="mb-3">
    <i class="bi bi-list-check"></i> Item Pertanyaan Matrix
</h4>

<div class="card mb-4">
    <div class="card-body">
        <form method="POST"
              action="{{ route('admin.tracer-item.store') }}"
              class="row g-2">
        @csrf

        <input type="hidden"
        name="tracer_question_id"
        value="{{ $questionId }}">
 
        <div class="col-md-2">
            <input type="text"
                   name="kode_item"
                   class="form-control"
                   placeholder="f1761">
        </div>

        <div class="col-md-6">
            <input type="text"
                   name="label"
                   class="form-control"
                   placeholder="Etika"
                   required>
        </div>

        <div class="col-md-2">
            <input type="number"
                   name="urutan"
                   class="form-control"
                   placeholder="Urutan">
        </div>

        <div class="col-md-2">
            <button class="btn btn-maroon w-100">
                <i class="bi bi-plus-circle"></i> Tambah
            </button>
        </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
    <thead>
        <tr>
            <th width="120">Kode</th>
            <th>Label</th>
            <th width="80">Urutan</th>
            <th width="140">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $i)
        <tr>
            <td>{{ $i->kode_item ?? '-' }}</td>
            <td>{{ $i->label }}</td>
            <td>{{ $i->urutan }}</td>
            <td>
                <a href="{{ route('admin.tracer-item.edit',$i->id) }}"
                   class="btn btn-sm btn-cream">
                   <i class="bi bi-pencil"></i>
                </a>

                <form method="POST"
                      action="{{ route('admin.tracer-item.destroy',$i->id) }}"
                      style="display:inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-maroon"
                            onclick="return confirm('Hapus item?')">
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
    'section_id' => $sectionId
]) }}"
   class="btn btn-cream mt-3">
   <i class="bi bi-arrow-left"></i> Kembali ke Pertanyaan
</a>


@endsection
