@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h5>Upload Data Alumni (Excel)</h5>

        <form action="{{ route('admin.alumni.import') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">File Excel</label>
                <input type="file" name="file" class="form-control" required>
            </div>

            <button class="btn btn-success">
                <i class="bi bi-upload"></i> Upload
            </button>
            <a href="{{ route('admin.alumni.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </form>
    </div>
</div>
@endsection