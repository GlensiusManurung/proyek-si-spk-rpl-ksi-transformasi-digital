<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Mobil</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #333;
        }
        .header h2 {
            margin: 0;
            color: #2c3e50;
        }
        .header p {
            margin: 5px 0;
            color: #7f8c8d;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #3c8dbc;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
            color: #7f8c8d;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .badge-aktif { color: #00a65a; font-weight: bold; }
        .badge-perbaikan { color: #f39c12; font-weight: bold; }
        .badge-nonaktif { color: #dd4b39; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN DATA MOBIL</h2>
        <p>Perusahaan OPR - Sistem Informasi Pengiriman</p>
        <p>Tanggal Cetak: {{ date('d/m/Y H:i:s') }}</p>
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
                <td><strong>{{ $mobil->no_plat }}</strong></td>
                <td>{{ $mobil->merk ?? '-' }}</td>
                <td>{{ $mobil->jenis_mobil }}</td>
                <td>{{ $mobil->pajak_stnk ? date('d/m/Y', strtotime($mobil->pajak_stnk)) : '-' }}</td>
                <td>{{ $mobil->pajak_plat ? date('d/m/Y', strtotime($mobil->pajak_plat)) : '-' }}</td>
                <td>{{ $mobil->kir ? date('d/m/Y', strtotime($mobil->kir)) : '-' }}</td>
                <td>
                    @if($mobil->status == 'aktif')
                        <span class="badge-aktif">Aktif</span>
                    @elseif($mobil->status == 'perbaikan')
                        <span class="badge-perbaikan">Perbaikan</span>
                    @else
                        <span class="badge-nonaktif">Nonaktif</span>
                    @endif
                </td>
                <td>{{ $mobil->keterangan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>Dicetak oleh: {{ Auth::user()->nama }}</p>
        <p>Sistem Informasi Pengiriman - OPR</p>
    </div>
</body>
</html>