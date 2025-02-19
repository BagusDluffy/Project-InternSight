<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\MuridImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use App\Models\Murid;
use App\Models\Jurusan;

class MuridController extends Controller
{
    public function index()
    {
        $murid = Murid::with('jurusan')->get();
        return view('murid.index', compact('murid'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new MuridImport, $request->file('file'));

            return redirect()->route('murid.index')
                ->with('success', 'Data Murid berhasil diimpor');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $jurusan = Jurusan::all();  // Ambil semua data jurusan
        $kelas = ['XI', 'XII'];  // Contoh data kelas
        return view('murid.create', compact('kelas', 'jurusan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_murid' => 'required|string|max:255',
            'nis' => 'required|string|unique:murid,nis|max:255',
            'kelas' => 'required|string',
            'jurusan_id' => 'required|exists:jurusan,id',  // Kolom jurusan sekarang berupa nama jurusan
        ]);

        Murid::create([
            'nama_murid' => $request->nama_murid,
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'jurusan_id' => $request->jurusan_id, // Menyimpan nama jurusan
        ]);

        return redirect()->route('murid.index')->with('success', 'Murid berhasil ditambahkan.');
    }

    public function edit(Murid $murid)
    {
        $jurusan = Jurusan::all();  // Ambil semua data jurusan
        $kelas = ['XI', 'XII'];  // Contoh data kelas
        return view('murid.edit', compact('murid', 'kelas', 'jurusan'));
    }

    public function update(Request $request, Murid $murid)
    {
        $request->validate([
            'nama_murid' => 'required|string|max:255',
            'nis' => 'required|string|unique:murid,nis,' . $murid->id . '|max:255',
            'kelas' => 'required|string',
            'jurusan_id' => 'required|exists:jurusan,id',
        ]);

        $murid->update([
            'nama_murid' => $request->nama_murid,
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'jurusan_id' => $request->jurusan_id,
        ]);

        return redirect()->route('murid.index')->with('success', 'Murid berhasil diperbarui.');
    }

    public function destroy(Murid $murid)
    {
        $murid->delete();
        return redirect()->route('murid.index')->with('success', 'Murid berhasil dihapus.');
    }
}
