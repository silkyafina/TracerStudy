@extends('alumni.layouts.app')

@section('title', 'Detail Tracer Study')

@section('content')
<div class="container">

    <a href="{{ route('alumni.tracer.riwayat') }}"
       class="btn btn-sm btn-outline-secondary mb-3">
        ← Kembali
    </a>

    <h5 class="mb-4">
        Tracer Study –
        {{ $session->submitted_at->format('d M Y H:i') }}
    </h5>

    @php
        $answersGrouped = $session->answers
            ->filter(fn ($a) => $a->question && $a->question->section)
            ->groupBy(fn ($a) => $a->question->section->nama);
    @endphp

    @foreach($answersGrouped as $sectionName => $answers)
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-maroon text-white">
                <strong>{{ $sectionName }}</strong>
            </div>

            <div class="card-body">
                @foreach($answers as $answer)

                    @php
                        $raw = $answer->value;
                        $decoded = json_decode($raw, true);
                        $question = $answer->question;
                    @endphp

                    <div class="mb-4">
                        <strong>{{ $question->pertanyaan }}</strong><br>

                        {{-- ===============================
                            MATRIX / ITEM
                        =============================== --}}
                        @if(is_array($decoded) && $question->items->count())
                        <ul class="mb-0 mt-2">
                            @foreach($question->items as $item)
                                <li>
                                    {{ $item->label }} :
                                    <strong>{{ $decoded[$item->id] ?? '-' }}</strong>

                                </li>
                            @endforeach
                        </ul>



                        {{-- ===============================
                            SELECT / RADIO / CHECKBOX
                        =============================== --}}
                        @elseif($question->options->count())

                            @php
                                if (is_array($decoded)) {
                                    $labels = $question->options
                                        ->whereIn('value', $decoded)
                                        ->pluck('label')
                                        ->toArray();
                                } else {
                                    $labels = $question->options
                                        ->where('value', $raw)
                                        ->pluck('label')
                                        ->toArray();
                                }
                            @endphp

                            <span class="text-muted">
                                {{ $labels ? implode(', ', $labels) : $raw }}
                            </span>

                        {{-- ===============================
                            TEXT / NUMBER
                        =============================== --}}
                        @else
                            <span class="text-muted">{{ $raw }}</span>
                        @endif
                    </div>

                @endforeach
            </div>
        </div>
    @endforeach

</div>
@endsection
