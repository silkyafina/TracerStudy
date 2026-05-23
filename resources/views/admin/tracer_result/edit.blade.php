@extends('admin.layouts.app')

@section('title', 'Edit Hasil Tracer')

@section('content')

<div class="container">

    <a href="{{ route('admin.tracer.results.show', $session->alumni_id) }}"
       class="btn btn-outline-secondary btn-sm mb-3">
        ← Kembali
    </a>

    <form method="POST"
          action="{{ route('admin.tracer.results.update', $session->id) }}">

        @csrf
        @method('PUT')

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

                        <div class="mb-4">

                            <label class="form-label fw-bold">
                                {{ $answer->question->pertanyaan }}
                            </label>

                            @php
                                $decoded = json_decode($answer->value, true);
                            @endphp

                            {{-- MATRIX --}}
                            @if(is_array($decoded) && $answer->question->items->count())

                                @foreach($answer->question->items as $item)

                                    <div class="mb-2">

                                        <label>
                                            {{ $item->label }}
                                        </label>

                                        <input type="text"
                                               class="form-control"
                                               name="answers[{{ $answer->id }}][{{ $item->id }}]"
                                               value="{{ $decoded[$item->id] ?? '' }}">

                                    </div>

                                @endforeach

                            {{-- OPTION --}}
                            @elseif($answer->question->options->count())

                                <select
                                    name="answers[{{ $answer->id }}]"
                                    class="form-select">

                                    @foreach($answer->question->options as $option)

                                        <option value="{{ $option->id }}"
                                            {{ $answer->value == $option->id ? 'selected' : '' }}>

                                            {{ $option->label }}

                                        </option>

                                    @endforeach

                                </select>

                            {{-- TEXT --}}
                            @else

                                <input type="text"
                                       class="form-control"
                                       name="answers[{{ $answer->id }}]"
                                       value="{{ $answer->value }}">

                            @endif

                        </div>

                    @endforeach

                </div>

            </div>

        @endforeach

        <button class="btn btn-maroon">
            <i class="bi bi-save"></i>
            Simpan Perubahan
        </button>

    </form>

</div>

@endsection