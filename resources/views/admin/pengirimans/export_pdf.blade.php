<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Pengiriman</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 11px; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #333; }
        .header h2 { margin: 0; color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #3c8dbc; color: white; font-weight: bold; }
        .footer { margin-top: 20px; text-align: right; font-size: 10px; border-top: 1px solid #ddd; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN DATA PENGIRIMAN</h2>
        <p>Perusahaan OPR</p>
        <p>Tanggal: {{ date('d/m/Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Surat Jalan</th>
                <th>Driver</th>
                <th>Mobil</th>
                <th>Tgl Pengiriman</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengirimans as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $p->nomor_surat_jalan }}</td>
                <td>{{ $p->pengajuan->driver->nama ?? '-' }}</td>
                <td>{{ $p->pengajuan->mobil->no_plat ?? '-' }}</td>
                <td>{{ date('d/m/Y', strtotime($p->tanggal_pengiriman)) }}</td>
                <td>{{ $p->status == 'proses' ? 'Proses' : ($p->status == 'dikirim' ? 'Dikirim' : 'Selesai') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>Dicetak oleh: {{ Auth::user()->nama }}</p>
    </div>
</body>
</html>