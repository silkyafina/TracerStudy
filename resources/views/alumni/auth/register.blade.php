<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Alumni</title>
    <link rel="stylesheet" href="{{ asset('alumni/css/auth.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-univ2.png') }}">

</head>
<body>

<div class="login-container">

    <div class="login-left">
        <img src="{{ asset('images/logo-alumni.png') }}" class="logo">
        <h2>Universitas Harkat Negeri</h2>
    </div>

    <div class="login-right">
        <div class="form-box">

            <h2>Registrasi</h2>

            @if ($errors->any())
                <div class="alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('alumni.register.process') }}">
                @csrf

                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" required>

                <label>NIM</label>
                <input type="text"
                name="nim"
                maxlength="8"
                oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                required>

                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" required>

                <label> NIK </label>
                <input type="text" name="nik" maxlength="16" inputmode="numeric">

                <label>Program Studi</label>
                <select name="prodi_id" required>
                    <option value="">-- Pilih Prodi --</option>
                    @foreach($prodi as $p)
                        <option value="{{ $p->id }}">{{ $p->nama_prodi }}</option>
                    @endforeach
                </select>

                <label>Tahun Lulus</label>
                <input type="number" name="tahun_lulus">

                <label>No HP</label>
                <input type="text" name="no_hp" oninput="this.value=this.value.replace(/[^0-9]/g,'')">

                <label>Desa / Kelurahan</label>
                <input type="text" name="desa" placeholder="Contoh: Debong Kidul" required>

                <label>Kecamatan</label>
                <input type="text" name="kecamatan" placeholder="Contoh: Dukuhturi" required>

                <label>Kota / Kaupaten</label>
                <input type="text" name="kota" placeholder="Contoh: Tegal" required>

                <button type="submit">Daftar</button>
            </form>

            <p style="margin-top:10px;">
                Sudah punya akun?
                <a href="{{ route('alumni.login') }}">Login</a>
            </p>

        </div>
    </div>

</div>

</body>
</html>