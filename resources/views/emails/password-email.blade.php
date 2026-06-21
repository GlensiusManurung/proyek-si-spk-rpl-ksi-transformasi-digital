<!DOCTYPE html>
<html>
<head>
    <title>Password Akun Superadmin</title>
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
        .header {
            text-align: center;
            background: #4CAF50;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }
        .password-box {
            background: #f4f4f4;
            padding: 15px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 2px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .btn {
            display: inline-block;
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Selamat Datang di OPR Optiroute!</h2>
        </div>
        
        <h3>Halo {{ $nama }},</h3>
        
        <p>Akun Superadmin Anda telah berhasil dibuat.</p>
        
        <p>Berikut adalah password Anda:</p>
        
        <div class="password-box">
            {{ $password }}
        </div>
        
        <p><strong>Cara Login:</strong></p>
        <ul>
            <li>Login menggunakan <strong>Nama ({{ $nama }})</strong> atau <strong>Email</strong> + Password di atas</li>
            <li>Email Anda adalah email Google yang digunakan untuk daftar</li>
        </ul>
        
        <center>
            <a href="{{ $login_url }}" class="btn">Login Sekarang</a>
        </center>
        
        <div class="footer">
            <p>Setelah login, segera ganti password Anda di halaman profil.</p>
            <p>&copy; {{ date('Y') }} OPR Optiroute. All rights reserved.</p>
        </div>
    </div>
</body>
</html>