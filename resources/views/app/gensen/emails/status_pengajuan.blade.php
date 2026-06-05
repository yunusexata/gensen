<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Status Pengajuan Gensen</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f7f9;
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
            background-color: #3949ab; /* Indigo - Profesional & Trustworthy */
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
        .info-box {
            background-color: #e8eaf6;
            border-left: 4px solid #3949ab;
            padding: 15px;
            margin: 20px 0;
        }
        .note-section {
            background-color: #fffde7; /* Soft yellow for attention */
            border: 1px solid #fff59d;
            padding: 15px;
            border-radius: 5px;
            font-size: 14px;
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
            color: #1D2121 !important;
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
            <h1>Update Progres: Dokumen Telah Dikirim</h1>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="greeting">Yth. Sdr/i {{ $form->nama_lengkap }},</div>

            <p>Kami ingin menginformasikan bahwa dokumen pengajuan Gensen Anda <strong>telah resmi dikirimkan</strong> ke Kantor Pajak di wilayah domisili Anda di Jepang.</p>

            <div class="info-box">
                <strong>Estimasi Proses:</strong><br>
                Proses pencairan umumnya memakan waktu sekitar <strong>3 hingga 4 bulan</strong> terhitung sejak dokumen diterima oleh kantor pajak. Durasi ini dapat berlangsung lebih cepat bergantung pada volume antrean dokumen di kantor pajak terkait.
            </div>

            <div class="note-section">
                <strong>Catatan Penting:</strong>
                <ul style="margin-top: 10px; padding-left: 20px;">
                    <li>Jika terdapat perubahan nomor WhatsApp yang terdaftar pada sistem kami, mohon segera menginformasikannya melalui nomor: <strong>+62 811-9989-6308</strong> atau menghubungi tim Exata Indonesia yang sebelumnya terhubung dengan Anda.</li>
                </ul>
            </div>

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
                Terima kasih atas kesabaran dan kepercayaan Anda.<br><br>
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
            Solusi Terpercaya untuk Pencairan Gensen & Administrasi Pajak Jepang.
        </div>
    </div>
</body>
</html>