@extends('admin.layouts.app')
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.user_survey_answers.import') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="mb-3">
                    <label class="form-label">File Excel</label>

                    <input type="file"
                           name="file"
                           class="form-control"
                           accept=".xlsx,.xls,.csv"
                           required>

                    <small class="text-muted">
                        Format file: .xlsx, .xls, atau .csv
                    </small>
                </div>

                <div class="alert alert-warning">
                    <strong>Perhatian:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Pastikan NIM alumni sudah terdaftar.</li>
                        <li>Gunakan template yang disediakan.</li>
                        <li>Email wajib diisi.</li>
                        <li>Nilai kompetensi diisi 1–5.</li>
                    </ul>
                </div>

                <button type="submit" class="btn btn-maroon">
                    <i class="bi bi-upload"></i> Import Data
                </button>

                <a href="{{ route('admin.user_survey_answers.index') }}"
                   class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>
    </div>
</div>
@endsection