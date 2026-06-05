<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Status Pengajuan Gensen</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-top: 5px solid #d9534f; /* Warna merah gelap untuk indikasi status */
            border-radius: 8px;
            overflow: hidden;
        }
        .header {
            background-color: #ffffff;
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid #f0f0f0;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #d9534f;
            text-transform: uppercase;
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
        .status-card {
            background-color: #fff5f5;
            border: 1px solid #fab1a0;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .info-next-step {
            font-size: 14px;
            color: #555555;
            background-color: #f9f9f9;
            padding: 15px;
            border-left: 4px solid #1a2a6c;
            margin-top: 20px;
        }
        .signature {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eeeeee;
        }
        .footer {
            background-color: #f4f4f4;
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
        <div class="header">
            <h1>Update Status Pengajuan Gensen</h1>
        </div>

        <div class="content">
            <div class="greeting">Yth. Bapak/Ibu/Sdr/i {{ $form->nama_lengkap }},</div>

            <p>Melalui email ini, kami bermaksud menyampaikan informasi terbaru mengenai proses pengajuan pencairan Gensen Anda yang telah kami ajukan ke kantor pajak terkait.</p>

            <div class="status-card">
                <strong>Informasi Penting:</strong><br>
                Berdasarkan hasil peninjauan dari kantor pajak, pengajuan Anda saat ini <strong>tidak dapat dilanjutkan (Dibatalkan)</strong>. Hal ini dikarenakan pengajuan tersebut belum memenuhi kriteria persyaratan administratif atau terdapat kendala teknis lainnya pada sistem perpajakan.
            </div>

            <div class="info-next-step">
                <strong>Langkah Selanjutnya:</strong><br>
                Tim Exata Indonesia yang sebelumnya mendampingi Anda akan segera menghubungi Anda kembali untuk memberikan penjelasan lebih terperinci serta langkah-langkah alternatif yang mungkin dapat dilakukan.
            </div>
              
            <div class="btn-container">
                <a target="_BLANK" href="https://api.whatsapp.com/send/?phone={{ $form->getPicAttribute()->no_whatsapp }}&type=phone_number&app_absent=0&text=Halo%20kak,%20saya%20akan%20mau%20tanya%20perihal%20gensen" class="btn-action">
                        <img src="{{ asset('assets/media/logos/whatsapp_logo.svg') }}" alt="WhatsApp" width="24" height="24" style="display: block; border: 0;">
                    Hubungi Sales</a>
            </div>

            <div class="signature">
                Hormat kami,<br><br>
                <strong>{{ $form->getPicAttribute()->name }} Exata</strong><br>
                Exata Indonesia
            </div>
            

            <div class="no-reply">
                Pesan ini dikirimkan secara otomatis oleh sistem, mohon untuk tidak membalas email ini.
            </div>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Exata Indonesia. All Rights Reserved.<br>
            Penyedia Layanan Administrasi Gensen & Perpajakan Jepang.
        </div>
    </div>
</body>
</html>