@extends('alumni.layouts.app')

@section('title', 'Ubah Password')

@section('content')
<div class="container">

    <h5 class="mb-4">Ubah Password</h5>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('alumni.password.update') }}">
        @csrf

        <div class="mb-3">
            <label>Password Lama</label>
            <input type="password" name="old_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password Baru</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button class="btn btn-maroon">Simpan</button>
        <a href="{{ route('alumni.profil') }}" class="btn btn-secondary">Batal</a>
    </form>

</div>
@endsection