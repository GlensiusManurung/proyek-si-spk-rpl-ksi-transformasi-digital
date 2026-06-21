<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Driver</title>
    <style>
        body { font-family: 'Calibri', sans-serif; font-size: 12pt; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #e0e0e0; font-weight: bold; }
        .footer { margin-top: 20px; text-align: right; }
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
                <tr>{{ $index + 1 }}</td>
                <td>{{ $driver->nama }}</td>
                <td>{{ $driver->user->email ?? '-' }}</td>
                <td>{{ $driver->no_sim }}</td>
                <td>{{ $driver->nik }}</td>
                <td>{{ $driver->nomor_kontak }}</td>
                <td>{{ $driver->no_rek ?? '-' }}</td>
                <td>{{ $driver->status == 'aktif' ? 'Aktif' : 'Nonaktif' }}</table>
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