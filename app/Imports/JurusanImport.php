<?php

namespace App\Imports;

use App\Models\Jurusan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class JurusanImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Jurusan([
            'jurusan' => $row['jurusan'],
            'deskripsi' => $row['deskripsi'] ?? ''
        ]);
    }

    public function rules(): array
    {
        return [
            'jurusan' => 'required|string|max:255|unique:jurusan,jurusan',
            'deskripsi' => 'nullable|string|max:255'
        ];
    }
}