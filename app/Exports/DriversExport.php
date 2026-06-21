<?php


namespace App\Exports;

use App\Models\Driver;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DriversExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Driver::with('user')->get();
    }
    
    public function headings(): array
    {
        return [
            'No',
            'Nama Driver',
            'Email',
            'No SIM',
            'NIK',
            'Nomor Kontak',
            'No Rekening',
            'Status',
            'Tanggal Dibuat'
        ];
    }
    
    public function map($driver): array
    {
        static $no = 0;
        $no++;
        
        return [
            $no,
            $driver->nama,
            $driver->user->email ?? '-',
            $driver->no_sim,
            $driver->nik,
            $driver->nomor_kontak,
            $driver->no_rek ?? '-',
            $driver->status == 'aktif' ? 'Aktif' : 'Nonaktif',
            $driver->created_at->format('d/m/Y H:i')
        ];
    }
}