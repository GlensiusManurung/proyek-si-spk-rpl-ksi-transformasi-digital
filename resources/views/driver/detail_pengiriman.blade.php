@extends('layoutdriver.dashboard')

@section('title', 'Detail Pengiriman')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-info-circle me-2"></i> Detail Pengiriman</h5>
                </div>
                <div class="card-body">
                    @if($pengiriman->status == 'dikirim')
                        <div class="alert alert-info mb-3">
                            <i class="bi bi-truck"></i> <strong>Pengiriman Sedang Berlangsung</strong><br>
                            Segera kirim barang ke alamat customer di bawah ini.
                        </div>
                    @endif
                    
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">No Surat Jalan</th>
                            <td><strong>{{ $pengiriman->nomor_surat_jalan }}</strong></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($pengiriman->status == 'proses')
                                    <span class="badge-warning">Proses</span>
                                @elseif($pengiriman->status == 'dikirim')
                                    <span class="badge-info">Dikirim</span>
                                @else
                                    <span class="badge-success">Selesai</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Pengiriman</th>
                            <td>{{ date('d/m/Y', strtotime($pengiriman->tanggal_pengiriman)) }}</td>
                        </tr>
                        
                        <!-- TUJUAN / CUSTOMER -->
                        @if($pengiriman->pengajuan && $pengiriman->pengajuan->customer)
                        <tr>
                            <th class="bg-info text-white">📍 TUJUAN PENGIRIMAN</th>
                            <td>
                                <div class="p-2">
                                    <strong class="fs-5">{{ $pengiriman->pengajuan->customer->nama_perusahaan }}</strong><br>
                                    <hr class="my-2">
                                    <i class="bi bi-geo-alt"></i> <strong>Alamat:</strong> {{ $pengiriman->pengajuan->customer->alamat }}<br>
                                    <i class="bi bi-telephone"></i> <strong>Kontak:</strong> {{ $pengiriman->pengajuan->customer->nomor_kontak }}<br>
                                    @if($pengiriman->pengajuan->customer->pic)
                                        <i class="bi bi-person"></i> <strong>PIC:</strong> {{ $pengiriman->pengajuan->customer->pic }}
                                    @endif
                                    @if($pengiriman->pengajuan->customer->email)
                                        <br><i class="bi bi-envelope"></i> <strong>Email:</strong> {{ $pengiriman->pengajuan->customer->email }}
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @else
                        <tr>
                            <th class="bg-danger text-white">⚠️ TUJUAN PENGIRIMAN</th>
                            <td class="text-danger">
                                <i class="bi bi-exclamation-triangle"></i> Data tujuan tidak ditemukan.<br>
                                <small>Silakan hubungi admin untuk melengkapi data customer pada pengajuan ini.</small>
                            <td>
                        </tr>
                        @endif
                        
                        <!-- MOBIL -->
                        <tr>
                            <th>🚗 Mobil</th>
                            <td>
                                {{ $pengiriman->pengajuan->mobil->no_plat ?? '-' }}<br>
                                <small>{{ $pengiriman->pengajuan->mobil->jenis_mobil ?? '-' }}</small>
                            </td>
                        </tr>
                        
                        <!-- DESKRIPSI -->
                        <tr>
                            <th>Deskripsi</th>
                            <td>{{ $pengiriman->deskripsi ?? '-' }}</td>
                        </tr>
                        
                        <!-- CATATAN -->
                        <tr>
                            <th>Catatan</th>
                            <td>{{ $pengiriman->catatan ?? '-' }}</td>
                        </tr>
                        
                        <!-- BUKTI PENGIRIMAN -->
                        @if($pengiriman->bukti)
                        <tr>
                            <th>Bukti Pengiriman</th>
                            <td>
                                <a href="{{ Storage::url($pengiriman->bukti->gambar) }}" target="_blank" class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i> Lihat Bukti
                                </a>
                                <br>
                                <small class="text-muted">Diupload oleh: {{ $pengiriman->bukti->uploaded_by ?? '-' }}</small>
                                <br>
                                <small class="text-muted">Tanggal: {{ date('d/m/Y', strtotime($pengiriman->bukti->tanggal_bukti)) }}</small>
                                <br>
                                <small class="text-muted">Deskripsi: {{ $pengiriman->bukti->deskripsi ?? '-' }}</small>
                            </td>
                        </tr>
                        @endif
                    </table>
                    
                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('driver.pengiriman-saya') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <div>
                            @if($pengiriman->status == 'proses')
                                <form action="{{ route('driver.pengiriman.update-status', $pengiriman->pengiriman_id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="status" value="dikirim">
                                    <button type="submit" class="btn btn-primary" onclick="return confirm('Konfirmasi mulai pengiriman?')">
                                        <i class="bi bi-truck"></i> Mulai Kirim
                                    </button>
                                </form>
                            @elseif($pengiriman->status == 'dikirim')
                                <a href="{{ route('driver.bukti-pengiriman.create', $pengiriman->pengiriman_id) }}" class="btn btn-primary">
                                    <i class="bi bi-upload"></i> Upload Bukti Sampai
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .badge-warning { background: #f39c12; color: white; padding: 4px 10px; border-radius: 3px; }
    .badge-info { background: #00c0ef; color: white; padding: 4px 10px; border-radius: 3px; }
    .badge-success { background: #00a65a; color: white; padding: 4px 10px; border-radius: 3px; }
    .alert-info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; padding: 12px; border-radius: 8px; }
    .table th { background: #f9f9f9; width: 200px; }
    .bg-info { background: #17a2b8 !important; color: white; }
    .bg-danger { background: #dc3545 !important; color: white; }
</style>
@endsection