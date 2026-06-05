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
                <a target="_BLANK" href="https://api.whatsapp.com/send/?phone={{ $form->getPicAttribute()->no_whatsapp }}&type=phone_number&app_absent=0&text=Halo%20kak,%20saya%20akan%20mau%20tanya%20perihal%20gensen" class="btn-action">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path d="M476.9 161.1C435 119.1 379.2 96 319.9 96C197.5 96 97.9 195.6 97.9 318C97.9 357.1 108.1 395.3 127.5 429L96 544L213.7 513.1C246.1 530.8 282.6 540.1 319.8 540.1L319.9 540.1C442.2 540.1 544 440.5 544 318.1C544 258.8 518.8 203.1 476.9 161.1zM319.9 502.7C286.7 502.7 254.2 493.8 225.9 477L219.2 473L149.4 491.3L168 423.2L163.6 416.2C145.1 386.8 135.4 352.9 135.4 318C135.4 216.3 218.2 133.5 320 133.5C369.3 133.5 415.6 152.7 450.4 187.6C485.2 222.5 506.6 268.8 506.5 318.1C506.5 419.9 421.6 502.7 319.9 502.7zM421.1 364.5C415.6 361.7 388.3 348.3 383.2 346.5C378.1 344.6 374.4 343.7 370.7 349.3C367 354.9 356.4 367.3 353.1 371.1C349.9 374.8 346.6 375.3 341.1 372.5C308.5 356.2 287.1 343.4 265.6 306.5C259.9 296.7 271.3 297.4 281.9 276.2C283.7 272.5 282.8 269.3 281.4 266.5C280 263.7 268.9 236.4 264.3 225.3C259.8 214.5 255.2 216 251.8 215.8C248.6 215.6 244.9 215.6 241.2 215.6C237.5 215.6 231.5 217 226.4 222.5C221.3 228.1 207 241.5 207 268.8C207 296.1 226.9 322.5 229.6 326.2C232.4 329.9 268.7 385.9 324.4 410C359.6 425.2 373.4 426.5 391 423.9C401.7 422.3 423.8 410.5 428.4 397.5C433 384.5 433 373.4 431.6 371.1C430.3 368.6 426.6 367.2 421.1 364.5z"/></svg>
                    Hubungi Sales</a>
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