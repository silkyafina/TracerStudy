@extends('admin.layouts.app')

@section('title', 'Detail Hasil Tracer')

@section('content')
<div class="container">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <a href="{{ route('admin.tracer.results.index') }}"
       class="btn btn-sm btn-outline-secondary mb-3">
        ← Kembali
    </a>

    {{-- DATA ALUMNI --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
           
            <h6>  <i class="bi bi-people-fill me-1"></i> Data Alumni</h6>
        

            <table class="table table-sm mb-0">
                <tr>
                    <th width="180">Nama</th>
                    <td>{{ $alumni->nama_lengkap }}</td>
                </tr>
                <tr>
                    <th>NIM</th>
                    <td>{{ $alumni->nim }}</td>
                </tr>
                <tr>
                    <th>Program Studi</th>
                    <td>{{ $alumni->prodi->nama_prodi ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Total Tracer</th>
                    <td>{{ $sessions->count() }}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- TAB TRACER --}}
    <ul class="nav nav-pills mb-4 tracer-tabs">
        @foreach($sessions as $index => $session)
            <li class="nav-item">
                <a class="nav-link {{ $index === 0 ? 'active' : '' }}"
                   data-bs-toggle="pill"
                   href="#tracer-{{ $session->id }}">
                    Tracer {{ $sessions->count() - $index }}
                    @if($index === 0)
                        <span class="badge bg-light text-dark ms-1">Terbaru</span>
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
    


    {{-- ISI TAB --}}
    <div class="tab-content">
        @foreach($sessions as $index => $session)
            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                 id="tracer-{{ $session->id }}">
    
                 <div class="d-flex justify-content-between align-items-center mb-3">

                    <div class="text-muted">
                        <strong>Tanggal Isi:</strong>
                        {{ $session->created_at->format('d M Y H:i') }}
                    </div>
    
                    <div class="d-flex gap-2">
    
                        {{-- EDIT --}}
                        <a href="{{ route('admin.tracer.results.edit', $session->id) }}"
                           class="btn btn-sm btn-cream">
                            <i class="bi bi-pencil-square"></i>
                            Edit
                        </a>
    
                        {{-- DELETE --}}
                        <form action="{{ route('admin.tracer.results.destroy', $session->id) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus tracer ini?')">
    
                            @csrf
                            @method('DELETE')
    
                            <button class="btn btn-sm btn-maroon">
                                <i class="bi bi-trash"></i>
                                Hapus
                            </button>
                        </form>
    
                    </div>
    
                </div>
                @foreach(
                    $session->answers
                        ->filter(fn($a) => $a->question && $a->question->section)
                        ->groupBy(fn($a) => $a->question->section->nama_section)
                    as $section => $answers
                )
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-maroon text-white">
                            <strong>{{ $section }}</strong>
                        </div>
                        <div class="card-body">
    
                            @foreach($answers as $answer)
                                <div class="mb-3">
                                    <strong>{{ $answer->question->pertanyaan }}</strong>
    
                                    @php
                                        $decoded = json_decode($answer->value, true);
                                    @endphp
    
                                    @if(is_array($decoded) && $answer->question->items->count())
                                        <ul class="mb-0 mt-2">
                                            @foreach($answer->question->items as $item)
                                                <li>
                                                    {{ $item->label }} :
                                                    <strong>{{ $decoded[$item->id] ?? '-' }}</strong>
                                                </li>
                                            @endforeach
                                        </ul>
                                        @else

                                        @php
                                            $displayValue = $answer->value;
                                      use PhpOffice\PhpSpreadsheet\Shared\Date;

    if (
        str_contains(strtolower($answer->question->pertanyaan), 'tanggal')
        && is_numeric($displayValue)
    ) {
        $displayValue = Date::excelToDateTimeObject($displayValue)
            ->format('d F Y');
    }
                                            $option = $answer->question
                                                ->options()
                                                ->where('id', $answer->value)
                                                ->first();
                                    
                                            if ($option) {
                                                $displayValue = $option->label;
                                            }
                                        @endphp
                                    
                                        <p class="mb-0 mt-1 text-muted">
                                            {{ $displayValue ?? '-' }}
                                        </p>
                                    
                                    @endif
                                </div>
                            @endforeach
    
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
    
</div>
@endsection
