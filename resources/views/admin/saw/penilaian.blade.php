@vite(['resources/css/admin-saw.css', 'resources/js/admin-saw.js'])
@extends('layoutadmin.dashboard')

@section('title', 'Penilaian Driver')

@push('styles')
    @vite(['resources/css/admin-saw.css'])
@endpush

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5><i class="bi bi-star-fill me-2"></i> Input Penilaian Driver</h5>
            <small>Masukkan nilai untuk setiap kriteria</small>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            
            <form method="POST" action="{{ route('admin.saw.penilaian.store') }}">
                @csrf
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Driver</th>
                                <th colspan="{{ $kriterias->whereNotIn('kode_kriteria', ['C1', 'C2', 'C3'])->count() }}" class="text-center">
                                    Nilai Kriteria Manual
                                </th>
                            </tr>
                            <tr>
                                @foreach($kriterias as $k)
                                    @if(!in_array($k->kode_kriteria, ['C1', 'C2', 'C3']))
                                    <th class="text-center">
                                        {{ $k->kode_kriteria }}<br>
                                        <small>{{ $k->nama_kriteria }}</small><br>
                                        @if($k->jenis == 'benefit')
                                            <small class="text-success">(Benefit: 0-100)</small>
                                        @else
                                            <small class="text-danger">(Cost: 1-5)</small>
                                        @endif
                                    </th>
                                    @endif
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($drivers as $index => $driver)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $driver->nama }}</strong><br>
                                    <small class="text-muted">{{ $driver->user->email ?? '-' }}</small>
                                </td>
                                @foreach($kriterias as $kriteria)
                                    @if(!in_array($kriteria->kode_kriteria, ['C1', 'C2', 'C3']))
                                    @php
                                        $key = $driver->driver_id . '_' . $kriteria->kriteria_id;
                                        $nilai = $penilaians[$key]->nilai ?? ($kriteria->jenis == 'cost' ? 1 : 0);
                                    @endphp
                                    <td class="text-center">
                                        @if($kriteria->jenis == 'cost')
                                            <select name="nilai[{{ $driver->driver_id }}][{{ $kriteria->kriteria_id }}]" 
                                                    class="form-control form-control-sm nilai-input-cost"
                                                    style="width: 120px; margin: 0 auto;" required>
                                                <option value="">Pilih Nilai</option>
                                                <option value="1" {{ $nilai == 1 ? 'selected' : '' }}>1 - Sangat Baik</option>
                                                <option value="2" {{ $nilai == 2 ? 'selected' : '' }}>2 - Baik</option>
                                                <option value="3" {{ $nilai == 3 ? 'selected' : '' }}>3 - Cukup</option>
                                                <option value="4" {{ $nilai == 4 ? 'selected' : '' }}>4 - Kurang</option>
                                                <option value="5" {{ $nilai == 5 ? 'selected' : '' }}>5 - Sangat Kurang</option>
                                            </select>
                                        @else
                                            <input type="number" 
                                                   name="nilai[{{ $driver->driver_id }}][{{ $kriteria->kriteria_id }}]" 
                                                   class="form-control form-control-sm nilai-input-benefit"
                                                   style="width: 80px; margin: 0 auto;"
                                                   value="{{ $nilai }}" 
                                                   min="0" 
                                                   max="100"
                                                   step="1"
                                                   required>
                                        @endif
                                    </td>
                                    @endif
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Semua Penilaian
                    </button>
                    <a href="{{ route('admin.saw.ranking') }}" class="btn btn-info">
                        <i class="bi bi-trophy"></i> Lihat Ranking
                    </a>
                </div>
            </form>
            
            <div class="alert alert-info mt-3">
                <i class="bi bi-info-circle"></i>
                <strong>Keterangan Skala Penilaian:</strong>
                <ul class="mb-0 mt-1">
                    <li><span class="text-success">✅ Benefit (0-100)</span> - Semakin tinggi semakin baik (contoh: produktivitas, kecepatan)</li>
                    <li><span class="text-danger">⚠️ Cost (1-5)</span> - Semakin kecil semakin baik:
                        <ul>
                            <li><strong>1 = Sangat Baik</strong> (nilai terbaik)</li>
                            <li><strong>2 = Baik</strong></li>
                            <li><strong>3 = Cukup</strong></li>
                            <li><strong>4 = Kurang</strong></li>
                            <li><strong>5 = Sangat Kurang</strong> (nilai terburuk)</li>
                        </ul>
                    </li>
                    <li><strong class="text-primary">Otomatis dari Sistem (C1, C2, C3)</strong> - Tidak perlu input manual:
                        <ul>
                            <li>C1 - Jumlah pengiriman selesai (dihitung otomatis)</li>
                            <li>C2 - Persentase upload bukti (dihitung otomatis)</li>
                            <li>C3 - Pengiriman tertunda (dikonversi ke skala 1-5 otomatis)</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    .nilai-input-benefit:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }
    
    .nilai-input-cost:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
    }
    
    select.nilai-input-cost option {
        padding: 5px;
    }
</style>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Highlight untuk benefit (angka)
            $('.nilai-input-benefit').on('change', function() {
                $(this).css('background-color', '#d4edda');
                setTimeout(() => {
                    $(this).css('background-color', '');
                }, 500);
            });
            
            // Highlight untuk cost (select dropdown)
            $('.nilai-input-cost').on('change', function() {
                $(this).css('background-color', '#d4edda');
                setTimeout(() => {
                    $(this).css('background-color', '');
                }, 500);
            });
            
            // Validasi input benefit tidak boleh kosong
            $('form').on('submit', function(e) {
                let valid = true;
                $('.nilai-input-benefit').each(function() {
                    if ($(this).val() === '' || $(this).val() === null) {
                        $(this).css('border', '2px solid red');
                        valid = false;
                    }
                });
                
                $('.nilai-input-cost').each(function() {
                    if ($(this).val() === '' || $(this).val() === null) {
                        $(this).css('border', '2px solid red');
                        valid = false;
                    }
                });
                
                if (!valid) {
                    alert('Harap isi semua nilai penilaian!');
                    e.preventDefault();
                }
            });
        });
    </script>
@endpush