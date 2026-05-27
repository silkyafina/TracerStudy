@extends('admin.layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">
            <i class="bi bi-person-check"></i> Penilaian Pengguna Alumni
        </h4>
    </div>
    <div class="d-flex gap-2">

        {{-- IMPORT --}}
        <a href="{{ route('admin.user_survey_answers.import.form') }}"
           class="btn btn-cream">
            <i class="bi bi-upload me-1"></i> Import
        </a>

        {{-- EXPORT --}}
        <a href="{{ route('admin.user_survey_answers.export', request()->all()) }}"
           class="btn btn-maroon">
            <i class="bi bi-file-earmark-excel me-1"></i> Export
        </a>

    </div>

</div>
    {{-- =======================
        FILTER
    ======================== --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">

                <div class="col-md-3">
                    <label class="form-label">Cari</label>
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Nama / NIM"
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Program Studi</label>
                    <select name="prodi_id" class="form-control">
                        <option value="">Semua Prodi</option>
                        @foreach ($prodi as $p)
                            <option value="{{ $p->id }}"
                                {{ request('prodi_id')==$p->id ? 'selected':'' }}>
                                {{ $p->nama_prodi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Tahun Dari</label>
                    <select name="tahun_dari" class="form-control">
                        <option value="">-</option>
                        @foreach ($tahun as $t)
                            <option value="{{ $t }}"
                                {{ request('tahun_dari')==$t ? 'selected':'' }}>
                                {{ $t }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Tahun Sampai</label>
                    <select name="tahun_sampai" class="form-control">
                        <option value="">-</option>
                        @foreach ($tahun as $t)
                            <option value="{{ $t }}"
                                {{ request('tahun_sampai')==$t ? 'selected':'' }}>
                                {{ $t }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-maroon">
                        <i class="bi bi-funnel-fill me-1"></i> Filter
                    </button>

                    <a href="{{ route('admin.user_survey_answers.index') }}"
                       class="btn btn-cream">
                        <i class="bi bi-arrow-clockwise me-1"></i> Reset
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- =======================
        TABLE
    ======================== --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Alumni</th>
                        <th>Nama Atasan</th>
                        <th>Perusahaan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Link</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($surveys as $key => $survey)
                    <tr>
                        <td>{{ $surveys->firstItem() + $key }}</td>

                        <td>{{ $survey->alumni->nama_lengkap }}</td>

                        <td>{{ $survey->answer->nama_atasan ?? '-' }}</td>

                        <td>{{ $survey->answer->nama_perusahaan ?? '-' }}</td>

                        <td>
                            {{ $survey->answer?->created_at?->format('d M Y') ?? '-' }}
                        </td>

                        {{-- STATUS --}}
                        <td>
                            @if($survey->is_filled)
                                <span class="badge bg-maroon">Sudah Isi</span>
                            @else
                                <span class="badge bg-cream">Belum Isi</span>
                            @endif
                        </td>

                        {{-- LINK TOKEN --}}
                        <td style="min-width:200px;">
                            <div class="d-flex gap-1">
                                <input type="text"
                                       id="link-{{ $survey->id }}"
                                       value="{{ url('/survey/pengguna/'.$survey->token) }}"
                                       class="form-control form-control-sm"
                                       readonly>
                        
                                <button onclick="copyLink('{{ $survey->id }}')"
                                        class="btn btn-sm btn-cream">
                                    Copy
                                </button>
                            </div>
                        </td>

                        {{-- AKSI --}}
                        <td>
                            @if($survey->is_filled && $survey->answer)
                                <a href="{{ route('admin.user_survey_answers.show', $survey->answer->id) }}"
                                   class="btn btn-sm btn-maroon">
                                   <i class="bi bi-eye-fill"></i> Detail
                                </a>
                            @else
                                <span class="text-muted">Belum ada</span>
                            @endif
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
            {{-- PAGINATION --}}
            <div class="mt-3">
                {{ $surveys->links() }}
            </div>

      

</div>
<script>
    function copyLink(id) {
    
        let input = document.getElementById('link-' + id);
    
        navigator.clipboard.writeText(input.value)
            .then(() => {
                alert('Link berhasil disalin');
            })
            .catch(() => {
                alert('Gagal menyalin link');
            });
    }
    </script>
@endsection