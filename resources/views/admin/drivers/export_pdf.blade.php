
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Driver</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        .header p { margin: 5px 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f0f0f0; font-weight: bold; }
        .footer { margin-top: 20px; text-align: right; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN DATA DRIVER</h2>
        <p>Perusahaan OPR</p>
        <p>Tanggal: {{ date('d/m/Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Driver</th>
                <th>Email</th>
                <th>No SIM</th>
                <th>NIK</th>
                <th>Kontak</th>
                <th>No Rekening</th>
                <th>Status</th>
                <th>Tgl Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($drivers as $index => $driver)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $driver->nama }}</td>
                <td>{{ $driver->user->email ?? '-' }}</td>
                <td>{{ $driver->no_sim }}</td>
                <td>{{ $driver->nik }}</td>
                <td>{{ $driver->nomor_kontak }}</td>
                <td>{{ $driver->no_rek ?? '-' }}</td>
                <td>{{ $driver->status == 'aktif' ? 'Aktif' : 'Nonaktif' }}</td>
                <td>{{ $driver->created_at->format('d/m/Y') }}</td>
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