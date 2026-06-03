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
                <th class="text-center">NAMA LENGKAP</th>
                <th class="text-center">NO NENKIN</th>
                <th class="text-center">LAMA KERJA</th>
                <th class="text-center">KOKUMIN</th>
                <th class="text-center">NENKIN 100</th>
                <th class="text-center">NENKIN 80</th>
                <th class="text-center">NENKIN 20</th>
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
                    <td>{{ $data['nama_lengkap'] }}</td>
                    <td>{{ $data['no_nenkin'] }}</td>
                    <td>{{ $data['lama_kerja'] }}</td>
                    <td>{{ $data['kokumin'] }}</td>
                    <td>{{ $data['nenkin_100'] }}</td>
                    <td>{{ $data['nenkin_80'] }}</td>
                    <td>{{ $data['nenkin_20'] }}</td>
                    <td>{{ $data['type'] }}</td>
                    <td>{{ $data['confidence_score'] }}</td>
                    <td>{{ $data['confidence_note'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
