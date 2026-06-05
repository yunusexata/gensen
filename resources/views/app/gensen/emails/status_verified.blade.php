<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Status: Verifikasi Dokumen Berhasil</title>
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
            background-color: #0d47a1; /* Royal Blue - Authority & Trust */
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
            background-color: #e3f2fd;
            color: #0d47a1;
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 20px;
            border: 1px solid #bbdefb;
        }
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #0d47a1;
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
            <h1>Update Verifikasi Administrasi</h1>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="greeting">Yth. Sdr/i {{ $form->nama_lengkap }},</div>

            <div class="status-badge">Status: Dokumen Terverifikasi & Valid</div>

            <p>Kami memberikan apresiasi atas kesabaran Anda menunggu proses ini. Melalui email ini, kami menginformasikan bahwa dokumen pengajuan Gensen Anda telah <strong>berhasil diverifikasi</strong> oleh tim Admin Exata Indonesia dan dinyatakan <strong>Valid</strong>.</p>

            <div class="info-box">
                <strong>Tahap Berikutnya:</strong><br>
                Seluruh berkas Anda telah siap secara administrasi untuk diajukan ke Kantor Pajak Jepang. Saat ini, tim kami sedang memproses persiapan dokumen pendukung lainnya guna memastikan seluruh paket dokumen terkirim dengan lengkap dan sesuai prosedur.
            </div>

            <div class="instruction-note">
                <strong>Pemberitahuan Penting:</strong>
                <ul style="margin-top: 10px; padding-left: 20px;">
                    <li>Jika terdapat perubahan nomor WhatsApp yang terdaftar pada sistem kami, mohon segera melakukan pembaruan melalui nomor: <strong>+62 811-9989-6308</strong> atau hubungi tim pendamping Anda sebelumnya.</li>
                </ul>
            </div>
  
            <div class="btn-container">
                <a target="_BLANK" href="https://api.whatsapp.com/send/?phone={{ $form->getPicAttribute()->no_whatsapp }}&type=phone_number&app_absent=0&text=Halo%20kak,%20saya%20akan%20mau%20tanya%20perihal%20gensen" class="btn-action">
                        <img src="https://cloudflare.com" alt="WhatsApp" width="24" height="24" style="display: block; border: 0;"
                    Hubungi Sales</a>
            </div>

            <div class="signature">
                Terima kasih atas kepercayaan Anda menggunakan layanan kami.<br><br>
                Best Regards,<br>
                <strong>{{ $form->getPicAttribute()->name }} Exata</strong><br>
                Exata Indonesia
            </div>

            <div class="no-reply">
                Pesan ini dikirimkan secara otomatis oleh sistem, mohon untuk tidak membalas email ini secara langsung.
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} Exata Indonesia. All Rights Reserved.<br>
            Spesialis Administrasi Gensen & Pajak Jepang Terpercaya.
        </div>
    </div>
</body>
</html>