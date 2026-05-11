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
                <th class="text-center">ID CUSTOMER</th>
                <th class="text-center">NAMA</th>
                <th class="text-center">TGL LAHIR</th>
                <th class="text-center">TGL PULANG</th>
                <th class="text-center">NOMOR REKENING</th>
                <th class="text-center">BANK</th>
                <th class="text-center">TAHUN GENSEN</th>
                <th class="text-center">MY NUMBER</th>
                <th class="text-center">KK LEGAS</th>
                <th class="text-center">NOMINAL GENSEN</th>
                <th class="text-center">JUMLAH KIRIM UANG</th>
                <th class="text-center">HUBUNGAN KELUARGA</th>
                <th class="text-center">FACEBOOK</th>
                <th class="text-center">INSTAGRAM</th>
                <th class="text-center">NO HP</th>
                <th class="text-center">EMAIL</th>
                <th class="text-center">PIC</th>
                <th class="text-center">LPK</th>
                <th class="text-center">PIC</th>
                <th class="text-center">KODEPOS</th>
            </tr>
        </thead>
        <tbody>

            @php
                $isNumberFormat = $request['type'] == App\Helpers\ExportHelper::TYPE_PDF;
            @endphp
            @foreach ($collection as $index => $data)
                <tr>
                    <td>{{ $data['id_customer'] }}</td>
                    <td>{{ $data['nama_lengkap'] }}</td>
                    <td>{{ $data['tanggal_lahir'] ? Carbon\Carbon::parse($data['tanggal_lahir'])->format('Ymd') : '' }}</td>
                    <td>{{ $data['tanggal_kepulangan'] ? Carbon\Carbon::parse($data['tanggal_kepulangan'])->format('Ymd') : '' }}</td>
                    <td>{{ $data['no_rekening_penerima'] }}</td>
                    <td>{{ $data['nama_bank_penerima'] }}</td>
                    <td>{{ $data['tahun_gensen'] }}</td>
                    <td>{{ $data['has_my_number'] ? 'O' : 'X' }}</td>
                    <td>{{ $data['has_kartu_keluarga'] ? 'O' : 'X' }}</td>
                    <td></td>
                    @php
                        $total_amounts = explode(';', $item->remittance_total_amounts);
                        $receiver_names = explode(';', $item->remittance_receiver_names);
                    @endphp
                    <td>@foreach ($total_amounts as $total)
                        {{ $total }}/
                    @endforeach</td>
                    <td>@foreach ($receiver_names as $name)
                        {{ $name }},
                    @endforeach</td>
                    <td></td>
                    <td>{{$data['nama_instagram']}}</td>
                    <td>{{$data['nomor_whatsapp']}}</td>
                    <td>{{$data['email']}}</td>
                    <td>{{$data['pic_code']}}</td>
                    <td>{{$data['nama_lpk']}}</td>
                    <td>{{$data['pic_code']}}</td>
                    <td>{{$data['kode_pos_jepang']}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
