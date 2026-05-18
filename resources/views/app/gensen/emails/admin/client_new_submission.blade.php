<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi: Form Submission Berhasil</title>
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
            background-color: #34495e;
            /* Slate Blue - Clean & Database Oriented */
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
            color: #34495e;
        }

        .submission-card {
            background-color: #f8f9fa;
            border: 1px solid #e2e8f0;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
        }

        .data-row {
            margin-bottom: 10px;
            font-size: 15px;
        }

        .data-label {
            color: #718096;
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }

        .data-value {
            color: #2d3748;
            font-weight: bold;
        }

        .btn-container {
            text-align: center;
            margin: 25px 0 15px 0;
        }

        .btn-action {
            display: inline-block;
            background-color: #34495e;
            color: #ffffff !important;
            padding: 12px 30px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            font-size: 15px;
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
            <h1>Notifikasi Pendaftaran Baru</h1>
        </div>

        <div class="content">
            <div class="greeting">Yth. {{ $form->getPicAttribute()->name }},</div>

            <p>Sistem mendeteksi adanya pengisian formulir pengajuan Gensen baru yang telah berhasil diselesaikan oleh client.</p>

            <div class="submission-card">
                <div class="data-row">
                    <span class="data-label">Nama Client:</span>
                    <span class="data-value">{{ $form->nama_lengkap }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Nomor Whatsapp:</span>
                    <span class="data-value">{{ $form->nomor_whatsapp }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Tanggal Lahir:</span>
                    <span class="data-value">{{ $form->tanggal_lahir }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Email:</span>
                    <span class="data-value">{{ $form->email }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Status Form:</span>
                    <span class="data-value" style="color: #2e7d32;">Berhasil Dikirim (Belum Lengkap)</span>
                </div>
            </div>

            <p>Mohon segera melakukan pengecekan berkas dan validasi data awal pada dashboard CRM Exata Indonesia untuk memproses ke tahap berikutnya.</p>

            <div class="btn-container">
                <a href="{{route('gensen_data.attachment', ['id' => Crypt::encrypt($form->id)])}}" class="btn-action">Lihat Detail Client</a>
            </div>
        </div>

        <div class="footer">
            Email ini dikirimkan secara otomatis oleh Sistem CRM Exata Indonesia.<br>
            &copy; {{ date('Y') }} Exata Indonesia. All Rights Reserved.
        </div>
    </div>
</body>

</html>