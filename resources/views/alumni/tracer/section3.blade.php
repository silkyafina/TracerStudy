@extends('alumni.layouts.app')
@section('title','Tracer Study - Section 3')

@section('content')
<div class="container mt-4">

<div class="card shadow-sm">
    <div class="card-header bg-maroon text-white">
        <h5 class="mb-0">{{ $section->nama_section }}</h5>
        <small>{{ $section->deskripsi }}</small>
    </div>

    <div class="card-body">
        <form method="POST"
              action="{{ route('alumni.tracer.section3.store') }}">
        @csrf

        @foreach($section->questions as $q)
        <div class="mb-4">

            <label class="fw-semibold mb-2 d-block">
                {{ $q->kode_pertanyaan ? "({$q->kode_pertanyaan})" : '' }}
                {{ $q->pertanyaan }}
            </label>

            {{-- RADIO --}}
            @if($q->tipe_jawaban == 'radio')
                @foreach($q->options as $opt)
                <div class="form-check">
                    <input class="form-check-input radio-red"
                           type="radio"
                           name="answers[{{ $q->id }}]"
                           value="{{ $opt->value }}"
                           required>
                    <label class="form-check-label">
                        {{ $opt->label }}
                    </label>
                </div>
                @endforeach
            @endif

            {{-- SELECT --}}
            

            @if($q->tipe_jawaban == 'select')

    @php
        $isProvinsi = $q->kode_pertanyaan == 'f5a1';
        $isKota = $q->kode_pertanyaan == 'f5a2';
    @endphp

    <select class="form-select"
            name="answers[{{ $q->id }}]"
            {{ $isProvinsi ? 'id=provinsi' : '' }}
            {{ $isKota ? 'id=kota' : '' }}
            required>

        <option value="">-- Pilih Jawaban --</option>

        @foreach($q->options as $opt)
            <option value="{{ $opt->value }}">
                {{ $opt->label }}
            </option>
        @endforeach
    </select>

@endif
           
                        
            {{-- TEXT --}}
            @if($q->tipe_jawaban == 'text')
                <input type="text"
                       class="form-control"
                       name="answers[{{ $q->id }}]"
                       required>
            @endif

            {{-- NUMBER --}}
            @if($q->tipe_jawaban == 'number')
                <input type="number"
                       class="form-control"
                       name="answers[{{ $q->id }}]"
                       required>
            @endif

            {{-- TEXTAREA --}}
            @if($q->tipe_jawaban == 'textarea')
                <textarea class="form-control"
                          rows="3"
                          name="answers[{{ $q->id }}]"
                          required></textarea>
            @endif

        </div>
        @endforeach


        <div class="d-flex gap-2 justify-content-between">
            <a href="{{ route('alumni.tracer.section2') }}"
               class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

            <button type="submit" class="btn btn-maroon">
                Lanjut ke Section Berikutnya
                <i class="bi bi-arrow-right"></i>
            </button>
        </div>

        </form>
    </div>
</div>

</div>
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {

$('#kota').prop('disabled', true);

$('#provinsi').on('change', function() {
    let provinsi_id = $(this).val();

    if(!provinsi_id){
        $('#kota').html('<option value="">Pilih Kota</option>');
        $('#kota').prop('disabled', true);
        return;
    }

    $('#kota').prop('disabled', false);
    $('#kota').html('<option>Loading...</option>');

    $.ajax({
        url: "{{ url('get-kota') }}/" + provinsi_id,
        type: 'GET',
        success: function(data) {
            let options = '<option value="">Pilih Kota</option>';

            data.forEach(function(item) {
                options += `<option value="${item.id}">${item.label}</option>`;
            });

            $('#kota').html(options);
        }
    });
});

});
</script>
@endpush

@endsection
