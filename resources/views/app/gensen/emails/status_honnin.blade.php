<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Status: Mekanisme Pencairan Honnin Kouza</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
        }
        .header {
            background-color: #008080; /* Teal - Professional & Clear */
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .content {
            padding: 30px;
            line-height: 1.6;
        }
        .greeting {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .highlight-box {
            background-color: #e0f2f1;
            border-left: 4px solid #008080;
            padding: 20px;
            margin: 20px 0;
        }
        .action-requirement {
            background-color: #fff9c4; /* Soft Yellow for action items */
            border: 1px solid #fff176;
            padding: 15px;
            border-radius: 5px;
            font-size: 14px;
            margin-top: 20px;
        }
        .signature {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eeeeee;
        }
        .footer {
            background-color: #f9f9f9;
            padding: 20px;
            text-align: center;
            font-size: 11px;
            color: #888888;
        }
        .no-reply {
            font-style: italic;
            font-size: 12px;
            color: #999999;
            margin-top: 15px;
            text-align: center;
        }
        
        .btn-container {
            text-align: center;
            margin: 25px 0 15px 0;
        }

        .btn-action {
            display: inline-block;
            background-color: #1DAA61;
            color: white !important;
            padding: 12px 30px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            font-size: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Update Mekanisme Pencairan Gensen</h1>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="greeting">Yth. Sdr/i {{ $form->nama_lengkap }},</div>

            <p>Berdasarkan informasi terbaru dari kantor pajak Jepang, kami menginformasikan bahwa proses pencairan Gensen Anda masuk ke dalam kategori <strong>Honnin Kouza</strong>.</p>

            <div class="highlight-box">
                <strong>Apa itu Honnin Kouza?</strong><br>
                Dalam mekanisme ini, dana pencairan Gensen akan <strong>ditransfer secara langsung</strong> oleh pihak kantor pajak ke rekening pribadi yang Anda lampirkan, tanpa melalui pihak Exata Indonesia.
            </div>

            <div class="action-requirement">
                <strong>Tindak Lanjut Administrasi:</strong><br>
                Sehubungan dengan mekanisme transfer langsung tersebut, kami memohon kesediaan Anda untuk melakukan <strong>penyelesaian biaya administrasi di muka</strong>. Hal ini diperlukan agar tim kami dapat memvalidasi dan mengawal proses hingga dana berhasil masuk ke rekening Anda.
            </div>

            <p>Rincian mengenai detail biaya dan prosedur selanjutnya akan disampaikan oleh <strong>Tim Exata Indonesia melalui WhatsApp</strong>. Mohon kesediaan Anda untuk menunggu informasi resmi dari tim kami.</p>
  
            <div class="btn-container">
                <a target="_blank"
                href="{{ route('gensen_form.faq') }}"
                class="btn-action">
                    <span style="vertical-align: middle;">
                        FAQ
                    </span>
                </a>
            </div>

            <div class="signature">
                Terima kasih atas kerja sama dan kepercayaan Anda.<br><br>
                Best Regards,<br>
                <strong>{{ $form->getPicAttribute()->name }} Exata</strong><br>
                Exata Indonesia
            </div>
            

            <div class="no-reply">
                Pesan ini dikirimkan secara otomatis oleh sistem, mohon untuk tidak membalas email ini.
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} Exata Indonesia. All Rights Reserved.<br>
            Layanan Administrasi Pajak & Gensen Jepang Terpercaya.
        </div>
    </div>
</body>
</html>