<?php

namespace App\Exports;

use App\Models\Magang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MagangExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Magang::with(['jurusan', 'murid', 'dudika', 'guru'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Jurusan',
            'Kelas',
            'Nama Murid',
            'DUDIKA',
            'Guru Pembimbing',
            'Periode'
        ];
    }

    public function map($magang): array
    {
        $muridNames = $magang->murid->pluck('nama_murid')->implode(', ');

        return [
            $magang->id,
            $magang->jurusan->jurusan,
            $magang->kelas,
            $muridNames,
            $magang->dudika->dudika,
            $magang->guru->nama_guru,
            $magang->periode
        ];
    }
}