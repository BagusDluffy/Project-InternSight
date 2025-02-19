<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\JurusanImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use App\Models\Jurusan;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::all();
        return view('jurusan.index', compact('jurusan'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new JurusanImport, $request->file('file'));

            return redirect()->route('jurusan.index')
                ->with('success', 'Data Jurusan berhasil diimpor');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('jurusan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jurusan' => 'required|string|max:10|unique:jurusan,jurusan',
            'deskripsi' => 'required|string|max:255',
        ]);

        Jurusan::create([
            'jurusan' => $request->jurusan,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function edit(Jurusan $jurusan)
    {
        return view('jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'jurusan' => 'required|string|max:255|unique:jurusan,deskripsi,' . $jurusan->id,
            'deskripsi' => 'required|string|max:255' . $jurusan->id,
        ]);

        $jurusan->update([
            'jurusan' => $request->jurusan,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();
        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil dihapus.');
    }
}
