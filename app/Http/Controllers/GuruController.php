<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Imports\GuruImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::all();
        return view('guru.index', compact('guru'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            $file = $request->file('file');
            
            Excel::import(new GuruImport, $file);

            Log::info('Berhasil mengimpor data guru');
            
            return redirect()->route('guru.index')
                ->with('success', 'Data guru berhasil diimpor');
        } catch (\Exception $e) {
            Log::error('Gagal impor guru: ' . $e->getMessage());
            
            return back()
                ->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('guru.create');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama_guru' => 'required|string|max:255',
                'email' => 'required|email|unique:guru,email',
                'password' => 'required|string|min:6',
                'nip' => 'required|string|max:50',
                'no_hp' => 'required|string|max:15',
            ]);
    
            $plainPassword = $validatedData['password'];
    
            $guru = Guru::create([
                'nama_guru' => $validatedData['nama_guru'],
                'email' => $validatedData['email'],
                'password' => Hash::make($plainPassword),
                'encrypted_password' => Crypt::encryptString($plainPassword), // Simpan encrypted password
                'nip' => $validatedData['nip'],
                'no_hp' => $validatedData['no_hp'],
            ]);
    
            Log::info('Guru berhasil ditambahkan: ' . $guru->id);
    
            return redirect()->route('guru.index')
                ->with('success', 'Guru berhasil ditambahkan.')
                ->with('password_plain', $plainPassword);
        } catch (ValidationException $e) {
            Log::error('Validasi gagal: ' . $e->getMessage());
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan guru: ' . $e->getMessage());
            return back()->with('error', 'Gagal menambahkan guru');
        }
    }    

    public function edit(Guru $guru)
    {
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        try {
            $validatedData = $request->validate([
                'nama_guru' => 'required|string|max:255',
                'email' => 'required|email|unique:guru,email,' . $guru->id,
                'password' => 'nullable|min:6',
                'nip' => 'nullable|string|max:50', // Validasi NIP
                'no_hp' => 'nullable|string|max:15', // Validasi No HP
            ]);

            // Update data yang tidak termasuk password
            $guru->nama_guru = $validatedData['nama_guru'];
            $guru->email = $validatedData['email'];
            $guru->nip = $validatedData['nip'] ?? null; // Update NIP
            $guru->no_hp = $validatedData['no_hp'] ?? null; // Update No HP

            // Update password jika diisi
            if ($request->filled('password')) {
                $plainPassword = $request->password;
                $guru->password = Hash::make($plainPassword);
                $guru->encrypted_password = Crypt::encryptString($plainPassword);
            }

            $guru->save();

            Log::info('Guru berhasil diupdate: ' . $guru->id);

            return redirect()->route('guru.index')
                ->with('success', 'Data guru berhasil diperbarui.');
        } catch (ValidationException $e) {
            Log::error('Validasi update gagal: ' . $e->getMessage());
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Gagal update guru: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui data guru');
        }
    }

    
    public function destroy(Guru $guru)
    {
        try {
            $guruId = $guru->id;
            $guru->delete();

            Log::info('Guru berhasil dihapus: ' . $guruId);

            return redirect()->route('guru.index')
                ->with('success', 'Guru berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus guru: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus guru');
        }
    }
}