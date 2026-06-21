<?php


namespace App\Exports;

use App\Models\Mobil;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MobilsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Mobil::orderBy('created_at', 'desc')->get();
    }
    
    public function headings(): array
    {
        return [
            'No',
            'No Plat',
            'Merk',
            'Jenis Mobil',
            'Pajak STNK',
            'Pajak Plat',
            'KIR',
            'Status',
            'Keterangan',
            'Tanggal Dibuat'
        ];
    }
    
    public function map($mobil): array
    {
        static $no = 0;
        $no++;
        
        return [
            $no,
            $mobil->no_plat,
            $mobil->merk ?? '-',
            $mobil->jenis_mobil,
            $mobil->pajak_stnk ? date('d/m/Y', strtotime($mobil->pajak_stnk)) : '-',
            $mobil->pajak_plat ? date('d/m/Y', strtotime($mobil->pajak_plat)) : '-',
            $mobil->kir ? date('d/m/Y', strtotime($mobil->kir)) : '-',
            $mobil->status == 'aktif' ? 'Aktif' : ($mobil->status == 'perbaikan' ? 'Perbaikan' : 'Nonaktif'),
            $mobil->keterangan ?? '-',
            $mobil->created_at->format('d/m/Y H:i')
        ];
    }
}