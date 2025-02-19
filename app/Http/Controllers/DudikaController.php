<?php

namespace App\Http\Controllers;

use App\Models\Dudika;
use App\Imports\DudikaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class DudikaController extends Controller
{
    public function index()
    {
        $dudika = Dudika::all();
        return view('dudika.index', compact('dudika'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new DudikaImport, $request->file('file'));

            return redirect()->route('dudika.index')
                ->with('success', 'Data DUDIKA berhasil diimpor');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('dudika.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'dudika' => 'required',
            'alamat' => 'required',
            'kontak' => 'nullable|string', // Validasi opsional
        ]);

        Dudika::create($request->all());
        return redirect()->route('dudika.index')->with('success', 'Data DUDIKA berhasil ditambahkan');
    }

    public function edit(Dudika $dudika)
    {
        return view('dudika.edit', compact('dudika'));
    }

    public function update(Request $request, Dudika $dudika)
    {
        $request->validate([
            'dudika' => 'required',
            'alamat' => 'required',
            'kontak' => 'nullable|string', // Validasi opsional
        ]);

        $dudika->update($request->all());
        return redirect()->route('dudika.index')->with('success', 'Data DUDIKA berhasil diperbarui');
    }

    public function destroy(Dudika $dudika)
    {
        $dudika->delete();
        return redirect()->route('dudika.index')->with('success', 'Data DUDIKA berhasil dihapus');
    }
}
