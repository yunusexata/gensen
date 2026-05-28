<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Status: Berkas Diterima & Lengkap</title>
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
            background-color: #2e7d32; /* Forest Green - Success & Professional */
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
        .status-badge {
            display: inline-block;
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .process-box {
            background-color: #f1f8e9;
            border-left: 4px solid #2e7d32;
            padding: 15px;
            margin: 20px 0;
        }
        .instruction-note {
            background-color: #fffde7;
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
            background-color: #25D366;
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
            <h1>Update Status Pengajuan Gensen</h1>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="greeting">Yth. Sdr/i {{ $form->nama_lengkap }},</div>

            <div class="status-badge">Status: Berkas Lengkap</div>

            <p>Kami menginformasikan bahwa seluruh dokumen pengajuan Gensen Anda telah kami terima dengan status <strong>Lengkap</strong>.</p>

            <div class="process-box">
                <strong>Tahap Verifikasi Internal:</strong><br>
                Saat ini, Tim Administrasi Exata Indonesia tengah melakukan pemeriksaan akhir (<em>final review</em>) secara menyeluruh. Hal ini bertujuan untuk memastikan akurasi data sebelum berkas diajukan ke tahap verifikasi resmi agar proses pengajuan Anda dapat berjalan optimal tanpa kendala administratif.
            </div>

            <p>Mohon pastikan alamat email ini tetap aktif, karena seluruh pembaruan (<em>update</em>) mengenai setiap tahap proses pencairan akan dikirimkan secara otomatis ke sistem ini.</p>

            <div class="instruction-note">
                <strong>Informasi Tambahan:</strong>
                <ul style="margin-top: 10px; padding-left: 20px;">
                    <li>Apabila terdapat perubahan nomor WhatsApp yang terdaftar, mohon segera hubungi kami melalui nomor: <strong>+62 811-9989-6308</strong> atau tim Exata Indonesia yang mendampingi Anda sebelumnya.</li>
                </ul>
            </div>

            <div class="signature">
                Terima kasih atas kerja sama Anda.<br><br>
                Best Regards,<br>
                <strong>{{ $form->getPicAttribute()->name }} Exata</strong><br>
                Exata Indonesia
            </div>
            
            <div class="btn-container">
                <a target="_BLANK" href="https://api.whatsapp.com/send/?phone={{ $form->getPicAttribute()->no_whatsapp }}&type=phone_number&app_absent=0" class="btn-action">Hubungi Sales</a>
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