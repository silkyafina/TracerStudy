@extends('admin.layouts.app')

@section('title', 'Kuesioner Tracer Study')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Kuesioner Tracer Study</h4>
    <a href="{{ route('admin.kuesioner.create') }}" class="btn btn-maroon">
        <i class="bi bi-plus-circle"></i> Tambah Pertanyaan
    </a>
</div>

{{-- Flash Message --}}
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card shadow-sm">

    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th width="5%">No</th>
                    <th width="10%">Section</th>
                    <th width="15%">Kode</th>
                    <th>Pertanyaan</th>
                    <th width="15%">Tipe Jawaban</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kuesioner as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <span class="badge bg-info">
                            Section {{ $item->section }}
                        </span>
                    </td>
                    <td>{{ $item->kode_pertanyaan ?? '-' }}</td>
                    <td>{{ $item->pertanyaan }}</td>
                    <td>
                        <span class="badge bg-secondary">
                            {{ strtoupper($item->tipe_jawaban) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.kuesioner.edit', $item->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <form action="{{ route('admin.kuesioner.destroy', $item->id) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus pertanyaan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        Data pertanyaan kuesioner belum tersedia
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
