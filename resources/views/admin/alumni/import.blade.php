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

                <div class="d-flex gap-2">
    
                    <button class="btn btn-maroon">
                        <i class="bi bi-upload"></i>
                        Upload
                    </button>
                
                    <a href="{{ route('admin.alumni.template') }}"
                       class="btn btn-cream">
                        <i class="bi bi-download"></i>
                        Download Template
                    </a>
                
                    <a href="{{ route('admin.alumni.index') }}"
                       class="btn btn-secondary">
                       <i class="bi bi-arrow-left">
                        Kembali
                    </a>
                
                </div>
        </form>
    </div>
</div>
@endsection