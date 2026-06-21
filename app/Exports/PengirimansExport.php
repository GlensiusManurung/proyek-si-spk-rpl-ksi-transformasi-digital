<?php


namespace App\Exports;

use App\Models\Pengiriman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PengirimansExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Pengiriman::with(['pengajuan.driver', 'pengajuan.mobil'])->orderBy('created_at', 'desc')->get();
    }
    
    public function headings(): array
    {
        return [
            'No',
            'No Surat Jalan',
            'Driver',
            'Mobil',
            'Tanggal Pengiriman',
            'Status',
            'Deskripsi',
            'Tanggal Dibuat'
        ];
    }
    
    public function map($pengiriman): array
    {
        static $no = 0;
        $no++;
        
        $statusText = match($pengiriman->status) {
            'proses' => 'Proses',
            'dikirim' => 'Dikirim',
            'selesai' => 'Selesai',
            default => '-'
        };
        
        return [
            $no,
            $pengiriman->nomor_surat_jalan,
            $pengiriman->pengajuan->driver->nama ?? '-',
            $pengiriman->pengajuan->mobil->no_plat ?? '-',
            date('d/m/Y', strtotime($pengiriman->tanggal_pengiriman)),
            $statusText,
            $pengiriman->deskripsi ?? '-',
            $pengiriman->created_at->format('d/m/Y H:i')
        ];
    }
}