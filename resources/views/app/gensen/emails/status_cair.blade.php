<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Pencairan Gensen</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f4f4;
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
            background-color: #1a2a6c; /* Corporate Dark Blue */
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            letter-spacing: 1px;
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
        .status-box {
            background-color: #f8fff9;
            border-left: 4px solid #28a745;
            padding: 15px;
            margin-bottom: 20px;
        }
        .footer {
            background-color: #f9f9f9;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777777;
            border-top: 1px solid #eeeeee;
        }
        .signature {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px section #eeeeee;
        }
        .referral-note {
            font-size: 14px;
            font-style: italic;
            color: #555555;
            background-color: #f0f7ff;
            padding: 15px;
            border-radius: 5px;
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
            <h1>PEMBERITAHUAN PENCAIRAN GENSEN</h1>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="greeting">Yth. Sdr/i {{ $form->nama_lengkap }},</div>

            <p>Selamat (Omedetou Gozaimasu), kami sampaikan bahwa proses <strong>pencairan Gensen</strong> Anda telah berhasil diproses ke rekening yang telah Anda lampirkan sebelumnya. Mohon kesediaan Anda untuk segera melakukan pengecekan pada saldo rekening tersebut.</p>

            <div class="status-box">
                <strong>Tahap Selanjutnya:</strong><br>
                Tim Exata Indonesia akan segera mengirimkan dokumen fisik sebagai bukti transparansi layanan kami, yang terdiri dari:
                <ul style="margin-top: 10px;">
                    <li>Hagaki (Kwitansi resmi dari kantor pajak Jepang)</li>
                    <li>Kwitansi resmi dari Exata Indonesia</li>
                    <li>Bukti transfer dana</li>
                </ul>
            </div>

            <p>Terima kasih atas kepercayaan Anda menggunakan jasa <strong>Exata Indonesia</strong>.</p>

            <div class="referral-note">
                <strong>Rekomendasikan Kami:</strong><br>
                Bantu rekan, keluarga, <em>kohai</em>, atau <em>senpai</em> Anda untuk mendapatkan kemudahan pencairan gensen serta potensi keringanan pajak daerah (Juminzei) bagi mereka yang masih berada di Jepang dengan merekomendasikan layanan kami.
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
                Otsukaresamadeshita. Arigatou gozaimashita.<br><br>
                <strong>Best Regards,</strong><br>
                <span style="color: #1a2a6c; font-weight: bold;">{{ $form->getPicAttribute()->name }} Exata</span><br>
                Exata Indonesia
            </div>
            
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} Exata Indonesia. All Rights Reserved.<br>
            Layanan Konsultasi Pajak & Gensen Terpercaya.
        </div>
    </div>
</body>
</html>