<?php

namespace App\Imports;

use App\Models\Murid;
use App\Models\Jurusan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MuridImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // Cari jurusan berdasarkan nama
        $jurusan = Jurusan::where('jurusan', $row['jurusan'])->first();

        if (!$jurusan) {
            throw new \Exception("Jurusan tidak ditemukan: " . $row['jurusan']);
        }

        return new Murid([
            'nama_murid' => $row['nama_murid'],
            'nis' => $row['nis'],
            'kelas' => $row['kelas'],
            'jurusan_id' => $jurusan->id
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_murid' => 'required|string|max:255',
            'nis' => 'required|unique:murid,nis',
            'kelas' => 'required|string|max:255',
            'jurusan' => 'required|exists:jurusan,jurusan'
        ];
    }
}