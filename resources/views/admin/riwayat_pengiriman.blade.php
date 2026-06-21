

@vite(['resources/css/admin-riwayat.css', 'resources/js/admin-riwayat.js'])
@extends('layoutadmin.dashboard')

@section('title', 'Riwayat Pengiriman')



@section('content')


    <div class="card">
        <div class="card-header">
            <h5><i class="bi bi-clock-history me-2"></i> Riwayat Pengiriman Selesai</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="riwayatTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Surat Jalan</th>
                            <th>Driver</th>
                            <th>Mobil</th>
                            <th>Tgl Pengiriman</th>
                            <th>Tgl Selesai</th>
                            <th>Bukti</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengirimans as $index => $pengiriman)
                        <tr>
                            <td>{{ $pengirimans->firstItem() + $index }}</td>
                            <td><strong>{{ $pengiriman->nomor_surat_jalan }}</strong></td>
                            <td>
                                {{ $pengiriman->pengajuan->driver->nama ?? '-' }}<br>
                                <small>{{ $pengiriman->pengajuan->driver->nomor_kontak ?? '-' }}</small>
                            </td>
                            <td>
                                {{ $pengiriman->pengajuan->mobil->no_plat ?? '-' }}<br>
                                <small>{{ $pengiriman->pengajuan->mobil->jenis_mobil ?? '-' }}</small>
                            </td>
                            <td>{{ date('d/m/Y', strtotime($pengiriman->tanggal_pengiriman)) }}</td>
                            <td>{{ $pengiriman->updated_at ? date('d/m/Y H:i', strtotime($pengiriman->updated_at)) : '-' }}</td>
                            <td>
                                @if($pengiriman->bukti)
                                    <a href="{{ Storage::url($pengiriman->bukti->gambar) }}" target="_blank" class="btn btn-info btn-sm">
                                        <i class="bi bi-eye"></i> Lihat
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                             </td>
                            <td>
                                <a href="{{ route('admin.pengirimans.edit', $pengiriman->pengiriman_id) }}" class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                             </td>
                         </tr>
                        @empty
                         <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-secondary"></i>
                                <p class="mt-3">Belum ada riwayat pengiriman selesai</p>
                             </td>
                         </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            
        </div>
    </div>
</div>
@endsection

