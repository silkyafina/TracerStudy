@extends('alumni.layouts.app')

@section('title', 'Riwayat Tracer Study')

@section('content')
<div class="container">

    <div class="page-header mb-4">
        <h4 class="page-title mb-1">Riwayat Tracer Study</h4>
        <p class="page-subtitle">
            Data pengisian tracer study yang telah Anda submit.
        </p>
    </div>

    @if($sessions->isEmpty())
        <div class="alert alert-info">
            Belum ada riwayat tracer study.
        </div>
    @else

    <div class="history-wrapper">
        <div class="table-responsive">
            <table class="table history-table mb-0 align-middle">

                <thead>
                    <tr>
                        <th width="8%">No</th>
                        <th width="42%">Tanggal Pengisian</th>
                        <th width="20%">Status</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($sessions as $i => $session)
                    <tr>
                        <td>{{ $i + 1 }}</td>

                        <td>
                            {{ $session->submitted_at->format('d M Y, H:i') }}
                        </td>

                        <td>
                            <span class="status-complete">
                                Selesai
                            </span>
                        </td>

                        <td>
                            <a href="{{ route('alumni.tracer.riwayat.detail', $session) }}"
                               class="btn-history-detail">
                                <i class="bi bi-eye"></i>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

    @endif

</div>
@endsection