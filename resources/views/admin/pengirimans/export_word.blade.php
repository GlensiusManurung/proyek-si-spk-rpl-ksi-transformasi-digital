<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Pengiriman</title>
    <style>
        body { font-family: 'Calibri', sans-serif; font-size: 12pt; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #e0e0e0; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN DATA PENGIRIMAN</h2>
        <p>Perusahaan OPR | Tanggal: {{ date('d/m/Y H:i:s') }}</p>
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
</body>
</html>