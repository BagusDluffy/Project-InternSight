<?php

namespace App\Imports;

use App\Models\Dudika;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DudikaImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Dudika([
            'dudika' => $row['dudika'],
            'alamat' => $row['alamat'],
            'kontak' => $row[2] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'dudika' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:255',
        ];
    }
}