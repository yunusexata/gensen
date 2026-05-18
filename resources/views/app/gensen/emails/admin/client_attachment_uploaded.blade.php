<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi: Upload Dokumen Customer</title>
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
            background-color: #1565c0; /* Vibrant Royal Blue - Action & Alert */
            color: #ffffff;
            padding: 25px;
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
            margin-bottom: 15px;
            color: #1565c0;
        }
        .info-box {
            background-color: #e3f2fd;
            border-left: 4px solid #1565c0;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 4px 4px 0;
        }
        .btn-container {
            text-align: center;
            margin: 25px 0;
        }
        .btn-action {
            display: inline-block;
            background-color: #1565c0;
            color: #ffffff !important;
            padding: 12px 30px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            font-size: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .instruction {
            font-size: 14px;
            color: #666666;
            border-top: 1px solid #eeeeee;
            padding-top: 15px;
            margin-top: 20px;
        }
        .footer {
            background-color: #f9f9f9;
            padding: 15px;
            text-align: center;
            font-size: 11px;
            color: #888888;
            border-top: 1px solid #eeeeee;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Notifikasi Sistem Exata</h1>
        </div>

        <div class="content">
            <div class="greeting">Yth. {{ $form->getPicAttribute()?->name ?? 'Tim Sales' }},</div>

            <p>Menginformasikan bahwa customer atas nama <strong>{{ $form->nama_lengkap }}</strong> telah berhasil mengunggah dokumen baru melalui tautan <em>reupload</em>.</p>

            <div class="info-box">
                <strong>Dokumen yang Diunggah:</strong><br>
                @foreach ($attachments as $attachment)
                    <span style="font-size: 16px; color: #0d47a1; font-weight: bold;">
                        {{ $attachment->type->label() }}
                    </span><br>
                @endforeach
            </div>

            <div class="btn-container">
                <a href="{{route('gensen_data.attachment', ['id' => Crypt::encrypt($form->id)])}}" class="btn-action">Lihat Detail Customer</a>
            </div>

            <p class="instruction">
                <strong>Langkah Selanjutnya:</strong><br>
                Silakan lakukan verifikasi terhadap dokumen yang telah diunggah dan hubungi customer yang bersangkutan apabila diperlukan tindakan lebih lanjut.
            </p>
        </div>

        <div class="footer">
            Email ini dikirimkan secara otomatis oleh Sistem Exata Indonesia.<br>
            &copy; {{ date('Y') }} Exata Indonesia.
        </div>
    </div>
</body>
</html>