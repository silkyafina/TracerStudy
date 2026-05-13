@extends('admin.layouts.app')
@section('title','Section Tracer')

@section('content')
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">
    <i class="bi bi-ui-checks"></i>
    Section Tracer Study </h4>

<a href="{{ route('admin.tracer-section.create') }}"
   class="btn btn-maroon mb-3">
   <i class="bi bi-plus-circle"></i> Tambah Section
</a>
</div>
<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">

    <tr>
        <th>Urutan</th>
        <th>Nama Section</th>
        <th>Deskripsi</th>
        <th>Aksi</th>
    </tr>
    @foreach($sections as $s)
    <tr>
        <td>{{ $s->urutan }}</td>
        <td>{{ $s->nama_section }}</td>
        <td>{{ $s->deskripsi}}</td>
        <td width="160">
            @php
                $isAdmin = auth()->guard('admin')->user()->role == 'admin';
            @endphp
        
            <div class="d-flex align-items-center gap-2 flex-wrap">
        
                {{-- KELOLA PERTANYAAN --}}
                <a href="{{ route('admin.tracer-question.index', ['section_id'=>$s->id]) }}"
                   class="btn btn-sm btn-maroon"
                   data-bs-toggle="tooltip"
                   title="Kelola Pertanyaan">
                   <i class="bi bi-list-check"></i>
                </a>
        
                {{-- EDIT --}}
                @if($isAdmin)
                    <a href="{{ route('admin.tracer-section.edit',$s->id) }}"
                       class="btn btn-sm btn-cream"
                       data-bs-toggle="tooltip"
                       title="Edit Section">
                       <i class="bi bi-pencil"></i>
                    </a>
                @else
                    <button class="btn btn-sm btn-secondary"
                            disabled
                            data-bs-toggle="tooltip"
                            title="Tidak memiliki akses Edit">
                        <i class="bi bi-lock"></i>
                    </button>
                @endif
        
                {{-- DELETE --}}
                @if($isAdmin)
                    <form action="{{ route('admin.tracer-section.destroy',$s->id) }}"
                          method="POST"
                          onsubmit="return confirm('Hapus section ini?')">
                        @csrf 
                        @method('DELETE')
                        <button type="submit"
                                class="btn btn-sm btn-maroon"
                                data-bs-toggle="tooltip"
                                title="Hapus Section">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                @else
                    <button class="btn btn-sm btn-secondary"
                            disabled
                            data-bs-toggle="tooltip"
                            title="Tidak memiliki akses Delete">
                        <i class="bi bi-lock"></i>
                    </button>
                @endif
        
            </div>
        </td>
    </tr>
    @endforeach
</table>
        </div>
    </div>
<script>
     document.addEventListener("DOMContentLoaded", function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (el) {
            return new bootstrap.Tooltip(el)
        })
    });
    setTimeout(() => {
    let alert = document.querySelector('.alert');
    if(alert){
        alert.classList.remove('show');
        alert.classList.add('fade');
    }
}, 3000);

    document.addEventListener("DOMContentLoaded", function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (el) {
            return new bootstrap.Tooltip(el)
        })
    });
</script>
@endsection
