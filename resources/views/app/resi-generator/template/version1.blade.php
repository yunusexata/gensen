<!-- /receipts/bca.html -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $data->email->email_subject }}</title>
    <style>
        body { margin: 0; padding: 30px; font-family: Arial, sans-serif; background-color: #ffffff; color: #000000; }
        .container { max-width: 950px; margin: 0 auto; }
        .header-table { width: 100%; border-bottom: 2px solid #ccc; padding-bottom: 15px; margin-bottom: 20px; }
        .gmail-logo { height: 32px; vertical-align: middle; }
        .group-name { font-size: 15px; font-weight: bold; text-align: right; }
        .subject { font-size: 22px; font-weight: bold; margin: 20px 0; border-bottom: 1px solid #ccc; padding-bottom: 20px; }
        .meta-table { width: 100%; font-size: 14px; margin-bottom: 30px; border-bottom: 1px solid #ccc; padding-bottom: 20px; }
        .meta-table strong { font-size: 14px; }
        .receipt-body { font-family: 'Courier New', Courier, monospace; font-size: 14px; line-height: 1.3; white-space: pre-wrap; margin-top: 30px; color: #000; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Gmail Header -->
        <table class="header-table" cellpadding="0" cellspacing="0">
            <tr>
                <td width="50%"><img src="{{ $gmail_logo }}" alt="Gmail" class="gmail-logo"></td>
                <td width="50%" class="group-name">Transaksi Exata Group &lt;transaksi.exatagroup@gmail.com&gt;</td>
            </tr>
        </table>

        <!-- Subject -->
        <div class="subject">{{ $data->email->email_subject }}</div>

        <!-- Meta Info -->
        <table class="meta-table" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <strong>{{ $data->email->email_sender }}</strong> &lt;{{ $data->email->email_sender }}&gt;<br>
                    Kepada: transaksi.exatagroup@gmail.com
                </td>
                <td align="right" valign="top">    
                    {{ \Carbon\Carbon::parse($data->email->email_received_at)->translatedFormat('d M Y, H.i') }}
                </td>
            </tr>
        </table>

        <!-- Receipt Content -->
     {!! $data->email->email_html !!}
    </div>
</body>
</html>