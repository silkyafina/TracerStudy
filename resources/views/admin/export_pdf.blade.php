<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>

        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        h2 {
            text-align: center;
        }

    </style>
</head>

<body>

    <h2>
        Rekap Responden Tracer Study
    </h2>

    <table>

        <thead>
            <tr>
                <th>Program Studi</th>
                <th>Jumlah Alumni</th>
                <th>Jumlah Responden</th>
                <th>Persentase</th>
            </tr>
        </thead>

        <tbody>

            @php
                $totalAlumni = 0;
                $totalResponden = 0;
            @endphp

            @foreach($rekapProdi as $row)

                @php
                    $totalAlumni += $row['jumlah_alumni'];
                    $totalResponden += $row['jumlah_responden'];
                @endphp

                <tr>
                    <td>{{ $row['nama_prodi'] }}</td>
                    <td>{{ $row['jumlah_alumni'] }}</td>
                    <td>{{ $row['jumlah_responden'] }}</td>
                    <td>{{ $row['persentase'] }}%</td>
                </tr>

            @endforeach

            <tr>
                <td><strong>TOTAL</strong></td>

                <td>
                    <strong>{{ $totalAlumni }}</strong>
                </td>

                <td>
                    <strong>{{ $totalResponden }}</strong>
                </td>

                <td>
                    <strong>
                        {{
                            $totalAlumni > 0
                            ? round(($totalResponden / $totalAlumni) * 100, 2)
                            : 0
                        }}%
                    </strong>
                </td>
            </tr>

        </tbody>

    </table>

</body>
</html>