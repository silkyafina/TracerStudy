<table border="1" width="100%" cellspacing="0" cellpadding="4">
    <thead>
        <tr>
            <th>Tahun</th>

            {{-- MATRIX --}}
            @if($isMatrix)
                @foreach($categories as $label)
                    <th>{{ $label }}</th>
                @endforeach

            {{-- NON MATRIX --}}
            @else
                @foreach($categories as $value => $label)
                    <th>{{ $label }}</th>
                @endforeach
                <th>Total</th>
            @endif
        </tr>
    </thead>

    <tbody>
        @foreach($table as $row)
            <tr>
                <td>{{ $row['tahun'] }}</td>

                {{-- MATRIX --}}
                @if($isMatrix)
                    @foreach($categories as $label)
                        <td>{{ $row[$label] ?? 0 }}</td>
                    @endforeach

                {{-- NON MATRIX --}}
                @else
                @foreach($categories as $label)
                <td>{{ $row[$label] ?? 0 }}</td>
            @endforeach
            <td>{{ $row['total'] ?? 0 }}</td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>