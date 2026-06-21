@vite(['public/css/adminlte.css', 'public/js/adminlte.js'])
@vite(['resources/css/admin-saw.css', 'resources/js/admin-saw.js'])
@extends('layoutadmin.dashboard')

@section('title', 'Ranking Driver SAW')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5><i class="bi bi-trophy-fill me-2"></i> Ranking Driver SAW</h5>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <strong>Kriteria & Bobot:</strong><br>
                @foreach($kriterias as $k)
                    • {{ $k->kode_kriteria }} ({{ $k->nama_kriteria }}) : {{ rtrim(rtrim(str_replace('.', ',', $k->bobot), '0'), ',') }} ({{ $k->jenis }})<br>
                @endforeach
                <strong>Total Bobot: {{ rtrim(rtrim(str_replace('.', ',', $kriterias->sum('bobot')), '0'), ',') }}</strong>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Driver</th>
                            @foreach($kriterias as $k)
                                <th>{{ $k->kode_kriteria }}<br><small>{{ $k->nama_kriteria }}</small></th>
                            @endforeach
                            <th>Nilai SAW</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ranking as $d)
                        <tr>
                            <td class="text-center">
                                @if($d['peringkat'] == 1) 🏆 @endif
                                <strong>{{ $d['peringkat'] }}</strong>
                            </td>
                            <td>
                                <strong>{{ $d['nama'] }}</strong><br>
                                <small>{{ $d['email'] }}</small>
                            </td>
                            @foreach($kriterias as $k)
                                <td class="text-center">
                                    {{ $d['detail'][$k->kode_kriteria]['nilai'] ?? 0 }}
                                </td>
                            @endforeach
                            <td class="text-center">
                                <strong class="text-primary">{{ str_replace('.', ',', number_format($d['nilai'], 4)) }}</strong>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection