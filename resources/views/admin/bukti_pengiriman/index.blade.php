


@vite(['resources/css/bukti-pengiriman.css', 'resources/js/bukti-pengiriman.js'])
@extends('layoutadmin.dashboard')

@section('title', 'Daftar Bukti Pengiriman')



@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-receipt me-2"></i> Daftar Bukti Pengiriman</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="buktiTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Surat Jalan</th>
                                    <th>Driver</th>
                                    <th>Mobil</th>
                                    <th>Tanggal Bukti</th>
                                    <th>Uploader</th>
                                    <th>Gambar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($buktis as $index => $bukti)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $bukti->pengiriman->nomor_surat_jalan ?? '-' }}</td>
                                    <td>{{ $bukti->pengiriman->pengajuan->driver->nama ?? '-' }}</td>
                                    <td>{{ $bukti->pengiriman->pengajuan->mobil->no_plat ?? '-' }}</td>
                                    <td>{{ date('d/m/Y', strtotime($bukti->tanggal_bukti)) }}</td>
                                    <td>{{ $bukti->uploaded_by ?? '-' }}</td>
                                    <td>
                                        <a href="{{ Storage::url($bukti->gambar) }}" target="_blank" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>
                                     </td>
                                    <td>
                                        <form action="{{ route('admin.bukti-pengiriman.delete', $bukti->bukti_pengiriman_id) }}" method="POST" onsubmit="return confirm('Yakin hapus bukti ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                     </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="bi bi-receipt fs-1 text-secondary"></i>
                                        <p class="mt-3">Belum ada bukti pengiriman</p>
                                     </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

