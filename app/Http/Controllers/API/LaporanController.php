<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\Magang;

class LaporanController extends Controller
{
    // LaporanController.php

    public function store(Request $request)
    {
        // Validasi request
        $validated = $request->validate([
            'magang_id' => 'required|exists:magang,id',
            'tanggal_kunjungan' => 'required|date',
            'keterangan' => 'required|string',
            'laporan_siswa' => 'required|json',
            'foto' => 'required|image|max:5120', // max 5MB
            'tanda_tangan' => 'required|image|max:5120', // max 5MB
        ]);

        try {
            // Handle foto
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('laporan_foto', 'public');
            }

            // Handle tanda tangan
            if ($request->hasFile('tanda_tangan')) {
                $tandaTanganPath = $request->file('tanda_tangan')->store('tanda_tangan', 'public');
            } else {
                Log::error('Tanda tangan tidak ditemukan dalam request', [
                    'files' => $request->allFiles(),
                    'has_file' => $request->hasFile('tanda_tangan'),
                    'content' => $request->all()
                ]);
                return response()->json(['message' => 'Tanda tangan tidak ditemukan'], 422);
            }

            // Buat record laporan
            $laporan = Laporan::create([
                'magang_id' => $validated['magang_id'],
                'tanggal_kunjungan' => $validated['tanggal_kunjungan'],
                'keterangan' => $validated['keterangan'],
                'laporan_siswa' => $validated['laporan_siswa'],
                'foto' => $fotoPath,
                'tanda_tangan' => $tandaTanganPath
            ]);

            return response()->json([
                'message' => 'Laporan berhasil disimpan',
                'data' => $laporan
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error saving laporan: ' . $e->getMessage());
            return response()->json([
                'message' => 'Gagal menyimpan laporan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getDudika(Request $request)
    {
        $user = $request->user(); // Mendapatkan user yang login
        $guruId = $user->id; // Asumsikan user adalah guru

        // Cari magang yang terkait dengan guru ini
        $magang = Magang::with('dudika')
            ->where('guru_id', $guruId)
            ->get();

        // Ambil data dudika dari magang
        $dudikaList = $magang->pluck('dudika');

        return response()->json([
            'data' => $dudikaList,
        ]);
    }

    public function getMagangId(Request $request)
    {
        $validated = $request->validate([
            'dudika_id' => 'required|exists:dudika,id',
        ]);

        $magang = Magang::where('dudika_id', $validated['dudika_id'])->first();

        if (!$magang) {
            return response()->json(['message' => 'Magang tidak ditemukan'], 404);
        }

        return response()->json(['data' => $magang], 200);
    }
}
