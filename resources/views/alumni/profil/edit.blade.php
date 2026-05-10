@extends('alumni.layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="container">

    <h5 class="mb-4">
        <i class="bi bi-pencil-square me-2"></i>
        Edit Profil Alumni
    </h5>

    <form method="POST" action="{{ route('alumni.profil.update') }}">
        @csrf
        @method('PUT')

        @include('alumni.profil._form')

        <button class="btn btn-maroon">
            <i class="bi bi-save me-1"></i> Simpan
        </button>
        <a href="{{ route('alumni.profil') }}" class="btn btn-outline-secondary">
            Batal
        </a>

    </form>
</div>
@endsection
