<!DOCTYPE html>
<html>

<head>
    <title>{{ $request['title'] }}</title>
    <style>
        .table-border {
            border-collapse: collapse;
            font-size: 7px;
        }

        .table-border td {
            border: 1px solid;
            padding: 3px;
        }

        .table-border th {
            border: 1px solid;
            font-weight: bold;
            padding: 3px;
        }
    </style>
</head>

<body>

    <table class="table-border" style="width: 100%">
        <thead>
            <tr>
                <th class="text-center">FILE</th>
                <th class="text-center">NO NENKIN</th>
                <th class="text-center">NAMA LENGKAP</th>
                <th class="text-center">KOKUMIN</th>
                <th class="text-center">NENKIN 100</th>
                <th class="text-center">NENKIN 80</th>
                <th class="text-center">NENKIN 20</th>
                <th class="text-center">LAMA KERJA</th>
                <th class="text-center">ALAMAT</th>
                <th class="text-center">TIPE</th>
                <th class="text-center">NILAI</th>
                <th class="text-center">CATATAN</th>
            </tr>
        </thead>
        <tbody>

            @php
                $isNumberFormat = $request['type'] == App\Helpers\ExportHelper::TYPE_PDF;
            @endphp
            @foreach ($collection as $index => $data)
                <tr>
                    <td>{{ $data['file_stored_name'] }}</td>
                    <td>{{ $data['no_nenkin'] }}</td>
                    @php
                        $kokumin = $data['kokumin'] < 1000 ? 0 : $data['kokumin'];
                        $nenkin_100 = $data['nenkin_100'] < 1000 ? 0 : $data['nenkin_100'];

                        $color = '#000000'; // Black

                        if ($kokumin && ! $nenkin_100) {
                            $color = '#B331F1'; // Purple
                        }

                        if ($kokumin && $nenkin_100) {
                            $color = '#00CC31'; // Green
                        }
                    @endphp

                    <td style="color: {{ $color }};">
                        {{ $data['nama_lengkap'] }}
                    </td>
                    <td>{{ $kokumin }}</td>
                    <td>{{ $nenkin_100 }}</td>
                    <td>{{ $data['nenkin_80'] }}</td>
                    <td>{{ $data['nenkin_20'] }}</td>
                    @php
                        $lama_kerja = 0;

                        if ($nenkin_100) {
                            $lama_kerja = $data['lama_kerja'];
                        } elseif ($kokumin) {
                            $lama_kerja = $data['lama_kerja_kokumin'];
                        }
                    @endphp
                    <td>{{ $lama_kerja }}</td>
                    <td>{{ $data['alamat'] }}</td>
                    <td>{{ $data['type'] }}</td>
                    <td>{{ $data['confidence_score'] }}</td>
                    <td>{{ $data['confidence_note'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
