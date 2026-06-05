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
                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>WhatsApp icon</title><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52s.198-.298.298-.497c.099-.198.05-.371-.025-.52s-.669-1.612-.916-2.207c-.242-.579-.487-.5-.669-.51a13 13 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074s2.096 3.2 5.077 4.487c.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413s.248-1.289.173-1.413c-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.82 9.82 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.82 11.82 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.9 11.9 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.82 11.82 0 0 0-3.48-8.413"/></svg>
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