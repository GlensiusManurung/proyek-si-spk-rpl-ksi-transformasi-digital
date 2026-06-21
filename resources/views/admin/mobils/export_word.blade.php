<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Mobil</title>
    <style>
        body {
            font-family: 'Calibri', sans-serif;
            font-size: 12pt;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #e0e0e0;
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN DATA MOBIL</h2>
        <p>Perusahaan OPR</p>
        <p>Tanggal: {{ date('d/m/Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Plat</th>
                <th>Merk</th>
                <th>Jenis Mobil</th>
                <th>Pajak STNK</th>
                <th>Pajak Plat</th>
                <th>KIR</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mobils as $index => $mobil)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $mobil->no_plat }}</td>
                <td>{{ $mobil->merk ?? '-' }}</td>
                <td>{{ $mobil->jenis_mobil }}</td>
                <td>{{ $mobil->pajak_stnk ? date('d/m/Y', strtotime($mobil->pajak_stnk)) : '-' }}</td>
                <td>{{ $mobil->pajak_plat ? date('d/m/Y', strtotime($mobil->pajak_plat)) : '-' }}</td>
                <td>{{ $mobil->kir ? date('d/m/Y', strtotime($mobil->kir)) : '-' }}</td>
                <td>{{ $mobil->status == 'aktif' ? 'Aktif' : ($mobil->status == 'perbaikan' ? 'Perbaikan' : 'Nonaktif') }}</td>
                <td>{{ $mobil->keterangan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>Dicetak oleh: {{ Auth::user()->nama }}</p>
        <p>{{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>