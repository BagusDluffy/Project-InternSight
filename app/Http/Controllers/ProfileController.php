<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    // Menampilkan form edit profil
    public function edit()
    {
        $user = Auth::user(); // Ambil data user yang sedang login
        return view('profile.edit', compact('user'));
    }

    // Menyimpan perubahan profil
    public function update(Request $request)
    {
        $user = User::find(Auth::id());
    
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'cropped_avatar' => 'nullable|string',
        ]);
    
        // Update nama user
        $user->name = $request->name;
    
        // Proses gambar yang di-crop (dalam format base64)
        if ($request->has('cropped_avatar')) {
            // Simpan path avatar lama sebelum diupdate
            $oldAvatarPath = null;
            if ($user->avatar) {
                $oldAvatarPath = public_path('storage/avatars/' . $user->avatar);
            }
    
            // Generate nama file baru
            $imageName = 'avatar_' . time() . '.png';
            $path = public_path('storage/avatars/' . $imageName);
    
            // Decode dan simpan gambar baru
            $imageData = $request->input('cropped_avatar');
            $image = str_replace('data:image/png;base64,', '', $imageData);
            $image = str_replace(' ', '+', $image);
            
            // Pastikan direktori tersedia
            if (!is_dir(public_path('storage/avatars'))) {
                mkdir(public_path('storage/avatars'), 0755, true);
            }
    
            // Simpan gambar baru
            file_put_contents($path, base64_decode($image));
    
            // Hapus avatar lama jika ada
            if ($oldAvatarPath && file_exists($oldAvatarPath)) {
                unlink($oldAvatarPath);
            }
    
            // Update nama avatar pada user
            $user->avatar = $imageName;
        }
    
        // Simpan perubahan pada user
        $user->save();
    
        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }

}