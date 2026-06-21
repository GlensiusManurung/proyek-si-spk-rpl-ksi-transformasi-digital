<!DOCTYPE html>
<html>
<head>
    <title>Reset Password - OPR Optiroute</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            max-width: 150px;
            height: auto;
        }
        .header {
            text-align: center;
            background: #ff9800;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }
        .warning-box {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .btn {
            display: inline-block;
            background: #ff9800;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #999;
            text-align: center;
        }
        .info {
            background: #e7f3ff;
            padding: 10px;
            border-radius: 5px;
            margin: 15px 0;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img src="{{ url('/img/OPR-optiroute.png') }}" alt="OPR Optiroute" class="logo">
        </div>
        
        <div class="header">
            <h2>Reset Password</h2>
        </div>
        
        <h3>Halo,</h3>
        
        <p>Kami menerima permintaan untuk mereset password akun Anda.</p>
        
        <div class="warning-box">
            <p><strong>⚠️ PENTING:</strong></p>
            <ul>
                <li>Link reset password hanya <strong>berlaku 60 detik</strong></li>
                <li>Link hanya bisa digunakan <strong>sekali</strong></li>
                <li>Link hanya valid dari <strong>perangkat dan browser yang sama</strong> saat meminta reset</li>
            </ul>
        </div>
        
        <center>
            <a href="{{ $reset_link }}" class="btn">Reset Password Sekarang</a>
        </center>
        
        <div class="info">
            <p>Atau copy link berikut:</p>
            <p style="word-break: break-all; font-size: 12px;">{{ $reset_link }}</p>
        </div>
        
        <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>
        
        <div class="footer">
            <p>Email ini dikirim secara otomatis. Harap jangan membalas email ini.</p>
            <p>&copy; {{ date('Y') }} OPR Optiroute. All rights reserved.</p>
        </div>
    </div>
</body>
</html>