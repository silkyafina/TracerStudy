<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
body { font-family: sans-serif; font-size: 12px; }
table { border-collapse: collapse; width: 100%; }
th, td {
    border: 1px solid #000;
    padding: 6px;
    text-align: center;
}
th {
    background-color: #2f3542;
    color: #fff;
}
.sub-header {
    background-color: #57606f;
    color: #fff;
}
.total-row {
    background-color: #dfe4ea;
    font-weight: bold;
}
table {
    width: 100%;
    border-collapse: collapse;
    font-size: 9px; /* kecilkan font */
}

th, td {
    border: 1px solid #000;
    padding: 3px;
    text-align: center;
}

body {
    font-family: sans-serif;
}


</style>
</head>
<body>

<h3 style="text-align:center">LAPORAN TRACER STUDY</h3>
<p><strong>Pertanyaan:</strong> {{ $question->pertanyaan}}</p>

<table>
    
    @if($isMatrix)

    <thead>
        <tr>
            <th>Tahun Lulus</th>
            @foreach($categories as $cat)
                <th>{{ $cat }}</th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach($table as $row)
            <tr>
                <td>{{ $row['tahun'] }}</td>
                @foreach($categories as $label)
                    <td>{{ $row[$label] ?? 0 }}%</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>

@else

    <thead>
        <tr>
            <th rowspan="2">Tahun Lulus</th>

            @foreach($categories as $cat)
                <th colspan="2">{{ $cat }}</th>
            @endforeach

            <th rowspan="2">Total</th>
        </tr>
        <tr>
            @foreach($categories as $value => $label)
                <th>Jumlah</th>
                <th>%</th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach($table as $row)
            <tr @if($row['tahun'] == 'Total') style="font-weight:bold; background:#f2f2f2;" @endif>
                <td>{{ $row['tahun'] }}</td>

                @foreach($categories as $value)
                    <td>{{ $row[$value] ?? 0 }}</td>
                    <td>{{ $row['percent'][$value] ?? '0%' }}</td>
                @endforeach

                <td>{{ $row['total'] ?? 0 }}</td>
            </tr>
        @endforeach
    </tbody>

@endif
</table>

</body>
</html>
