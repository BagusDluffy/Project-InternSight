<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Exports\MagangExport;
use App\Models\Magang;
use App\Models\Jurusan;
use App\Models\Murid;
use App\Models\Dudika;
use App\Models\Guru;
use Illuminate\Http\Request;

class MagangController extends Controller
{
    public function index()
    {
        $magang = Magang::with('jurusan', 'murid', 'dudika', 'guru')->paginate(10); // Gunakan pagination untuk menghindari query berat
        return view('magang.index', compact('magang'));
    }

    public function create()
    {
        $jurusan = Jurusan::all();
        $kelas = Murid::select('kelas')->distinct()->orderBy('kelas')->get();
        $dudika = Dudika::all();
        $guru = Guru::all();
        $murid = Murid::all();

        return view('magang.create', compact('jurusan', 'kelas', 'dudika', 'guru', 'murid'));
    }

    public function getMurid(Request $request)
    {
        $jurusanId = $request->get('jurusan_id');
        $kelas = $request->get('kelas');

        if (!$jurusanId || !$kelas) {
            return response()->json([
                'status' => 'error',
                'message' => 'Jurusan dan kelas wajib dipilih.',
                'data' => [],
            ], 400);
        }

        $murid = Murid::where('jurusan_id', $jurusanId)
            ->where('kelas', $kelas)
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data murid berhasil diambil.',
            'data' => $murid,
        ]);
    }

    public function store(Request $request)
    {
        Log::info('Received data:', $request->all());

        $validatedData = $request->validate([
            'jurusan_id' => 'required|exists:jurusan,id',
            'kelas' => 'required|string',
            'dudika_id' => 'required|exists:dudika,id',
            'guru_id' => 'required|exists:guru,id',
            'periode' => 'required|string',
            'murid_id' => 'required|array',
            'murid_id.*' => 'exists:murid,id'
        ]);

        DB::beginTransaction();
        try {
            $magangData = $request->only(['jurusan_id', 'kelas', 'dudika_id', 'guru_id', 'periode']);
            $magang = Magang::create($magangData);

            $muridIds = $request->input('murid_id', []);
            if (!empty($muridIds)) {
                $magang->murid()->attach($muridIds);
            }

            DB::commit();
            return redirect()->route('magang.index')->with('success', 'Data magang berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Error saving magang at ' . __METHOD__ . ': ' . $e->getMessage(), [
                'data' => $request->all(),
                'exception' => $e,
            ]);

            return back()->withInput()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function edit(Magang $magang)
    {
        $jurusan = Jurusan::all();
        $kelas = Murid::select('kelas')->distinct()->orderBy('kelas')->get();
        $muridOptions = Murid::where('jurusan_id', $magang->jurusan_id)
            ->where('kelas', $magang->kelas)
            ->get();

        return view('magang.edit', compact('magang', 'jurusan', 'kelas', 'muridOptions'));
    }

    public function update(Request $request, Magang $magang)
    {
        $validatedData = $request->validate([
            'jurusan_id' => 'required|exists:jurusan,id',
            'kelas' => 'required|string',
            'murid_id' => 'required|array',
            'murid_id.*' => 'exists:murid,id'
        ]);

        DB::beginTransaction();
        try {
            // Update magang data
            $magang->update([
                'jurusan_id' => $request->jurusan_id,
                'kelas' => $request->kelas
            ]);

            // Sync murid relationships
            $magang->murid()->sync($request->murid_id);

            DB::commit();
            return redirect()->route('magang.index')
                ->with('success', 'Data magang berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating magang: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Gagal mengupdate data']);
        }
    }

    public function getPrintData(Magang $magang)
    {
        try {
            // Load relasi yang dibutuhkan
            $magang->load([
                'jurusan',
                'murid' => function ($query) use ($magang) {
                    // Filter murid sesuai dengan magang spesifik ini
                    $query->where('magang_id', $magang->id);
                },
                'dudika',
                'guru',
                'laporan' => function ($query) use ($magang) {
                    // Filter laporan sesuai dengan magang spesifik ini
                    $query->where('magang_id', $magang->id);
                }
            ]);

            // Pastikan relasi ada
            if (!$magang->jurusan || !$magang->dudika || !$magang->guru) {
                return response()->json([
                    'error' => 'Data tidak lengkap'
                ], 404);
            }

            // Siapkan data untuk ditampilkan di popup
            return response()->json([
                'id' => sprintf('%04d/MAGANG/%s/%d', $magang->id, date('m'), date('Y')),
                'periode' => $magang->periode ?? 'Tidak ditentukan',
                'jurusan' => $magang->jurusan->jurusan ?? 'Tidak diketahui',
                'kelas' => $magang->kelas ?? 'Tidak diketahui',
                'dudika' => $magang->dudika->dudika ?? 'Tidak diketahui',
                'alamat' => $magang->dudika->alamat ?? 'Tidak diketahui',
                'kontak' => $magang->dudika->kontak ?? 'Tidak diketahui',
                'guru' => $magang->guru->nama_guru ?? 'Tidak diketahui',
                'nip' => $magang->guru->nip ?? 'Tidak diketahui',
                'laporan' => $magang->laporan->map(function ($lap, $key) {
                    // Periksa dan pastikan path untuk foto laporan
                    $fotoPath = $lap->foto ? asset('storage/' . ltrim($lap->foto, '/')) : null;

                    // Periksa dan pastikan path untuk tanda tangan
                    $tandaTanganPath = $lap->tanda_tangan ? asset('storage/' . ltrim($lap->tanda_tangan, '/')) : null;

                    return [
                        'no' => $key + 1,
                        'hari_tanggal' => $this->getHariIndonesia(\Carbon\Carbon::parse($lap->tanggal_kunjungan)->format('l')) . ', ' . \Carbon\Carbon::parse($lap->tanggal_kunjungan)->format('d F Y'),
                        'keterangan' => $lap->keterangan,
                        'laporan_siswa' => $lap->laporan_siswa ? json_decode($lap->laporan_siswa, true) : [],
                        'foto' => $fotoPath, // URL foto laporan
                        'tanda_tangan' => $tandaTanganPath // URL tanda tangan
                    ];
                })->toArray(),
                'tanggal' => date('d F Y'),
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getPrintData: ' . $e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan saat mengambil data'
            ], 500);
        }
    }

    protected function getHariIndonesia($namaHari)
    {
        $hariIndonesia = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];

        return array_key_exists($namaHari, $hariIndonesia) ? $hariIndonesia[$namaHari] : $namaHari;
    }

    public function destroy(Magang $magang)
    {
        DB::beginTransaction();
        try {
            // Detach all students from this internship
            $magang->murid()->detach();

            // Delete the internship record
            $magang->delete();

            DB::commit();
            return redirect()->route('magang.index')
                ->with('success', 'Data magang berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error deleting magang: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menghapus data']);
        }
    }
}
