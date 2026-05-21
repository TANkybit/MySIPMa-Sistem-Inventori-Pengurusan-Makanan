<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maklumat Akaun Pengguna - Sistem MySIPMa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #1e3a8a;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9fafb;
            padding: 30px;
            border: 1px solid #e5e7eb;
            border-radius: 0 0 5px 5px;
        }
        .credentials {
            background-color: white;
            padding: 20px;
            border-left: 4px solid #1e3a8a;
            margin: 20px 0;
        }
        .credentials p {
            margin: 10px 0;
        }
        .warning {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            font-size: 12px;
            color: #6b7280;
        }
        strong {
            color: #1e3a8a;
        }
        .button {
            display: inline-block;
            background-color: #1e3a8a;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="margin: 0;">Sistem MySIPMa</h2>
        <p style="margin: 5px 0 0 0; font-size: 14px;">Jabatan Penjara Malaysia</p>
    </div>
    
    <div class="content">
        <p>Yang Berbahagia Tuan/Puan,</p>
        
        <p>Dengan segala hormatnya, sukacita dimaklumkan bahawa akaun anda di Sistem MySIPMa telah berjaya didaftarkan.</p>
        
        <div class="credentials">
            <h3 style="margin-top: 0; color: #1e3a8a;">Maklumat Akaun</h3>
            <p><strong>Nama Pengguna (Username):</strong> {{ $email }}</p>
            <p><strong>Kata Laluan Sementara:</strong> {{ $password }}</p>
        </div>
        
        <div class="warning">
            <p style="margin: 0;"><strong>⚠ PENTING:</strong></p>
            <p style="margin: 5px 0 0 0;">Sila tukar kata laluan sementara ini kepada kata laluan peribadi anda selepas log masuk buat kali pertama. Kata laluan hendaklah mengandungi sekurang-kurangnya 8 aksara untuk keselamatan akaun anda.</p>
        </div>
        
        <p>Untuk log masuk ke sistem, sila klik pautan di bawah:</p>
        <a href="https://mysipma.com/" class="button">Log Masuk ke Sistem</a>
        
        <p style="margin-top: 25px;">Kerjasama dan perhatian pihak tuan/puan terhadap perkara ini amatlah dihargai.</p>
        
        <p>Sekian, terima kasih.</p>
        
        <div style="margin-top: 30px;">
            <p style="margin: 5px 0;"><strong>Admin MySIPMa</strong></p>
            <p style="margin: 5px 0;">Bahagian Korektif</p>
            <p style="margin: 5px 0;">Jabatan Penjara Malaysia</p>
        </div>
        
        <div class="footer">
            <p><strong>NOTIS:</strong> Email ini dijana secara automatik melalui Sistem MySIPMa. Sila tidak membalas email ini.</p>
            <p style="margin-top: 10px;"><strong>AMARAN KESELAMATAN:</strong> Jangan kongsikan maklumat kata laluan anda dengan sesiapa. Jika anda tidak membuat permohonan ini, sila hubungi pentadbir sistem dengan segera.</p>
        </div>
    </div>
</body>
</html>
