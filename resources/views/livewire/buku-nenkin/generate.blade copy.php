<!-- Administrative Data Grid -->
<div class="bg-primary rounded-xl overflow-hidden shadow-2xl p-0.5 space-y-0.5 border-4 border-primary">
    <table class="report-container">
            <thead class="report-header">
                <tr>
                    <th class="report-header-cell">
                    </th>
                </tr>
            </thead>
            <tbody class="report-content">
                <tr>
                    <td class="report-content-cell">

    <!-- Row 1: Name -->
    <div class="flex flex-col md:flex-row gap-0.5">
    <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
        <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Nama</span>
        <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">氏名</span>
    </div>
    <div class="bg-primary-container-lowest flex-1 p-6 flex items-center">
        <span class="text-white text-xl font-bold tracking-wide">{{$nama}}</span>
    </div>
    </div>
    <!-- Row 2: Birth Date -->
    <div class="flex flex-col md:flex-row gap-0.5">
    <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
        <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Tanggal lahir</span>
        <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">生年月日</span>
    </div>
    <div class="bg-surface-container-lowest flex-1 p-6 flex items-center">
        <span class="text-on-surface text-lg">{{Carbon\Carbon::parse($tanggal_lahir)->format('Y')}}年 {{Carbon\Carbon::parse($tanggal_lahir)->format('m')}}月 {{Carbon\Carbon::parse($tanggal_lahir)->format('d')}}日</span>
    </div>
    </div>
    <!-- Row 3: Address in Japan -->
    <div class="flex flex-col md:flex-row gap-0.5">
    <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
        <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Alamat tinggal ketika di Jepang</span>
        <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">日本における最終居: 住居地</span>
    </div>
    <div class="bg-surface-container-lowest flex-1 p-6 flex flex-col justify-center">
        <span class="text-on-surface text-lg leading-relaxed">{{$alamat_jepang}}</span>
    </div>
    </div>
    <!-- Row 4: Departure Date -->
    <div class="flex flex-col md:flex-row gap-0.5">
    <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
        <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Tanggal kepulangan</span>
        <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">日本出国日</span>
    </div>
    <div class="bg-surface-container-lowest flex-1 p-6 flex items-center">
        <span class="text-on-surface text-lg">{{Carbon\Carbon::parse($tanggal_kepulangan)->format('Y')}}年 {{Carbon\Carbon::parse($tanggal_kepulangan)->format('m')}}月 {{Carbon\Carbon::parse($tanggal_kepulangan)->format('d')}}日</span>
    </div>
    </div>

    @for ($i = 0; $i < 2; $i++)
        @foreach ($companies as $company)
            <!-- Row 5: Company Name -->
            <div class="flex flex-col md:flex-row gap-0.5">
            <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Nama Perusahaan</span>
                <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">所属会社名</span>
            </div>
            <div class="bg-primary-container-lowest flex-1 p-6 flex items-center">
                <span class="text-on-surface text-lg font-bold text-white">{{$company['nama_perusahaan']}}</span>
            </div>
            </div>
            <!-- Row 6: Company Address -->
            <div class="flex flex-col md:flex-row gap-0.5">
            <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Alamat Perusahaan</span>
                <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">所属会社居住地</span>
            </div>
            <div class="bg-surface-container-lowest flex-1 p-6 flex flex-col justify-center">
                <span class="text-on-surface text-lg">{{$company['alamat_perusahaan']}}</span>
            </div>
            </div>
            <!-- Row 7: Phone Number -->
            <div class="flex flex-col md:flex-row gap-0.5">
            <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Nomor Telepon</span>
                <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">同電話番号</span>
            </div>
            <div class="bg-surface-container-lowest flex-1 p-6 flex items-center">
                <span class="text-on-surface text-lg font-mono tracking-wider">{{$company['no_telp']}}</span>
            </div>
            </div>
            <!-- Row 8: Working Period -->
            <div class="flex flex-col md:flex-row gap-0.5">
            <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Jangka waktu bekerja</span>
                <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">勤務期間または国民年金の加入期間</span>
            </div>
            <div class="bg-surface-container-lowest flex-1 p-6 flex items-center">
                <div class="flex items-center gap-3">
                    <span class="text-on-surface text-lg">{{Carbon\Carbon::parse($company['tanggal_kerja_awal'])->format('Y')}}年 {{Carbon\Carbon::parse($company['tanggal_kerja_awal'])->format('m')}}月 {{Carbon\Carbon::parse($company['tanggal_kerja_awal'])->format('d')}}日</span>
                    <span class="text-outline-variant">—</span>
                    <span class="text-on-surface text-lg">{{Carbon\Carbon::parse($company['tanggal_kerja_akhir'])->format('Y')}}年 {{Carbon\Carbon::parse($company['tanggal_kerja_akhir'])->format('m')}}月 {{Carbon\Carbon::parse($company['tanggal_kerja_akhir'])->format('d')}}日</span>
                </div>
            </div>
            </div>
            <!-- Row 9: Nenkin Type -->
            <div class="flex flex-col md:flex-row gap-0.5">
            <div class="bg-primary md:w-1/3 p-6 flex flex-col justify-center">
                <span class="text-white font-label text-xs uppercase tracking-widest font-bold">Jenis Nenkin</span>
                <span class="text-secondary-fixed-dim japanese-text font-medium mt-1">加入していた年金制度の種別</span>
            </div>
            <div class="bg-surface-container-lowest flex-1 p-6 flex items-center">
                <span class="text-on-surface text-lg">{{$company['jenis_nenkin']}} </span>
            </div>
            </div>
        @endforeach
    @endfor
                        
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th class="report-footer-cell border border-danger">
                    </th>
                </tr>
            </tfoot>
        </table>
        {{-- FOOTER --}}
        <div class="footer">        
            <div class="mt-12 px-12 pb-0 w-full">
                <div class="flex flex-col w-full gap-0">
                    <p class="font-bold text-lg text-center mb-0 pb-0">Contact Person:</p>
                    <p class="font-extrabold text-xl text-center text-primary tracking-tight mt-0 pt-0">Tanjung - 0812 2000 4752</p>
                </div>
            </div>
        </div>

    <div class="row mt-5" id="input">
        <button class="bg-green-600  mb-2 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200" onclick="printPDF()">
            Save PDF
        </button>
    </div>
</div>

@push('css')
    <style>
        
        @media print {

            table {
                width: 100% !important;
                table-layout: auto !important;
            }

        }

        .print-page {
            page-break-before: always;
        }
        body {
            color: black;
        }

        .report-content-cell {
            /* padding: 32px; */
        }

        .report-header-cell {
            height: 100px;
        }

        .report-footer-cell {
            height: 80px;
        }

        .report-container {
            width: 100%;
        }

        .report-header {
            display: table-header-group;
        }

        .report-footer {
            display: table-footer-group;
        }

        .image-header {
            width: 100%;
            margin-top: 16px;
            height: auto;
            object-fit: scale-down;
        }

        .image-footer {
            width: 100%;
            height: auto;
            object-fit: scale-down;
        }

        .header {
            position: fixed;
            width: 100%;
            height: auto;
        }

        .footer {
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed;
            bottom: 16px;
            width: 100%;
            height: 100px;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            line-height: 1;
            text-transform: none;
            letter-spacing: normal;
            word-wrap: normal;
            white-space: nowrap;
            direction: ltr;
        }
        @page {

            @bottom-right {
                content: '* Data updated as of {{ \Carbon\Carbon::now()->format('F d, Y'); }}';
                margin-bottom: 15px;                  
                font-style: italic;

            }
            @bottom-center {
                content: '' counter(page) ' of ' counter(pages);
                margin-bottom: 15px;
            }
        }
        @media print {

            @page {
                size: A4 landscape;
                margin: 10mm;
            }

        }
        .watermark-container {
        position: relative;
        overflow: hidden;
        }
        .watermark-bg {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 0;
        opacity: 0.05;
        width: 60%;
        pointer-events: none;
        }
        .content-layer {
        position: relative;
        z-index: 1;
        }
    </style>
@endpush
@push('js')
    <script>
        function printPDF(){
            $('#input').hide()
            $(() => {
                window.print();
                const afterPrint = setTimeout(() => {
                    window.close()
                }, 500);
            });
        }
    </script>
@endpush