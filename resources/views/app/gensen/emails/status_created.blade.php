<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penerimaan Formulir Pengajuan Gensen</title>
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
            background-color: #2c3e50; /* Professional Charcoal */
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
        .success-box {
            background-color: #f0fdf4;
            border-left: 4px solid #16a34a;
            padding: 20px;
            margin: 20px 0;
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
            <h1>FORMULIR BERHASIL TERSIMPAN</h1>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="greeting">Halo {{ $form->nama_lengkap }},</div>

            <p>Terima kasih telah mempercayakan pengajuan Gensen Anda kepada <strong>Exata Indonesia</strong>. Kami menginformasikan bahwa data pengajuan Anda telah berhasil kami terima dalam sistem kami.</p>

            <div class="success-box">
                <strong>Apa langkah selanjutnya?</strong><br>
                Tim Admin kami akan segera melakukan verifikasi terhadap data dan kelengkapan dokumen yang telah Anda kirimkan. Kami akan memberikan pembaruan (update) secara berkala kepada Anda melalui email ini terkait status pengajuan Anda.
            </div>

            <p>Mohon simpan email ini sebagai bukti bahwa Anda telah berhasil mengirimkan formulir.</p>
                  
            <div class="btn-container">
                <a target="_blank"
                href="https://api.whatsapp.com/send/?phone={{ $form->getPicAttribute()->no_whatsapp }}&type=phone_number&app_absent=0&text=Halo%20kak,%20saya%20akan%20mau%20tanya%20perihal%20gensen"
                class="btn-action">

                    <img src="{{ asset('assets/media/logos/whatsapp_logo.svg') }}"
                        alt="WhatsApp"
                        width="20"
                        height="20"
                        style="vertical-align: middle; border: 0; margin-right: 8px;">

                    <span style="vertical-align: middle;">
                        Hubungi Sales
                    </span>
                </a>
            </div>

            <div class="signature">
                Terima kasih atas kerja sama Anda.<br><br>
                Best Regards,<br>
                <strong>Tim Exata Indonesia</strong>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} Exata Indonesia. All Rights Reserved.
        </div>
    </div>
</body>
</html>