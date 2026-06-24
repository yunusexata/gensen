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
                <th class="text-center">TANGGAL INPUT</th>
                <th class="text-center">ID CUSTOMER</th>
                <th class="text-center">TANGGAL LENGKAP</th>
                <th class="text-center">TANGGAL VERIFIED</th>
                <th class="text-center">NO INPUT JEPANG</th>
                <th class="text-center">TANGGAL PENGAJUAN</th>
                <th class="text-center">TANGGAL Tarik Data</th>
                <th class="text-center">Label</th>
                <th class="text-center">TANGGAL CAIR</th>
                <th class="text-center">NOMINAL CAIR</th>
                <th class="text-center">STATUS</th>
                <th class="text-center">KETERANGAN</th>
                <th class="text-center">NAMA LENGKAP</th>
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
            @if ($collection)
                @foreach ($collection as $index => $data)
                    <tr>
                        <td>{{ $data['created_at'] ? Carbon\Carbon::parse($data['created_at'])->format('d-m-Y') : '' }}</td>
                        <td>{{ $data['id_customer'] }}</td>
                        <td>{{ $data['tanggal_lengkap'] ? Carbon\Carbon::parse($data['tanggal_lengkap'])->format('Ymd') : '' }}</td>
                        <td>{{ $data['tanggal_verified'] ? Carbon\Carbon::parse($data['tanggal_verified'])->format('Ymd') : '' }}</td>
                        <td>{{ $data['no_input_jepang']}}</td>
                        <td>{{ $data['tanggal_pengajuan'] ? Carbon\Carbon::parse($data['tanggal_pengajuan'])->format('Ymd') : '' }}</td>
                        <td>{{ $data['tanggal_tarik_data_detail'] ? Carbon\Carbon::parse($data['tanggal_tarik_data_detail'])->format('Ymd') : '' }}</td>
                        <td>{{ $data['label_detail'] }}</td>
                        <td>{{ $data['tanggal_cair'] ? Carbon\Carbon::parse($data['tanggal_cair'])->format('Ymd') : '' }}</td>
                        <td>'{{ numberFormat($data['nominal_cair']) }}</td>
                        <td>{{ $data['status']}}</td>
                        <td>{{ $data['keterangan']}}</td>
                        <td>{{ $data['nama_lengkap'] }}</td>
                        <td>{{ $data['tanggal_lahir'] ? Carbon\Carbon::parse($data['tanggal_lahir'])->format('Ymd') : '' }}</td>
                        <td>{{ $data['tanggal_kepulangan'] ? Carbon\Carbon::parse($data['tanggal_kepulangan'])->format('ymd') : '' }}</td>
                        <td>{{ $data['no_rekening_penerima'] }}</td>
                        <td>{{ $data['nama_bank_penerima'] }}</td>
                        <td>{{ $data['tahun_gensen_detail'] }}</td>
                        <td>{{ $data['has_my_number'] ? 'O' : 'X' }}</td>
                        <td>{{ $data['has_kartu_keluarga'] ? 'O' : 'X' }}</td>
                        <td>'{{ numberFormat($data['nominal_gensen_detail']) }}</td>
                        @php
                            $total_amounts = explode(';', $data['remittance_total_amounts']);
                            $receiver_names = explode(';', $data['remittance_receiver_names']);
                        @endphp
                        <td>@foreach ($total_amounts as $total)
                            {{ numberFormat($total) }}/
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
            @endif
        </tbody>
    </table>
</body>

</html>
