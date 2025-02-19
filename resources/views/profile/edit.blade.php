@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Profil</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <!-- Form Edit Profil -->
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="avatar">Avatar</label>
                    <input type="file" class="form-control-file" id="avatar" name="avatar">
                    @if ($user->avatar)
                    <br>
                    <img src="{{ $user->avatar && Storage::exists('public/avatars/' . $user->avatar) 
    ? asset('storage/avatars/' . $user->avatar) 
    : asset('AdminLTE/dist/img/user2-160x160.jpg') }}"
                        alt="Avatar" width="100">
                    @endif
                </div>

                <!-- Cropper Image Container -->
                <div id="cropper-container" class="clearfix" style="display: none; margin-bottom: 20px;">
                    <h4>Crop Avatar</h4>
                    <img id="image" src="" alt="Image to crop" style="max-width: 100%; height: auto;">
                    <div id="preview" style="margin-top: 10px;">
                        <h5>Preview</h5>
                        <img src="" id="preview-image" alt="Preview" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                    </div>
                    <input type="hidden" id="cropped-avatar" name="cropped_avatar">
                </div>

                <!-- Tombol Simpan Perubahan -->
                <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
            </form>
        </div>
    </section>
</div>

<!-- Include Cropper.js -->
<link href="https://cdn.jsdelivr.net/npm/cropperjs@1.5.12/dist/cropper.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/cropperjs@1.5.12/dist/cropper.min.js"></script>

<script>
    const avatarInput = document.getElementById('avatar');
    const cropperContainer = document.getElementById('cropper-container');
    const imageElement = document.getElementById('image');
    const previewImage = document.getElementById('preview-image');
    const croppedAvatarInput = document.getElementById('cropped-avatar');
    let cropper;

    avatarInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imageElement.src = e.target.result;

                // Gunakan event `load` untuk memastikan gambar telah dimuat
                imageElement.onload = function() {
                    cropperContainer.style.display = 'block'; // Tampilkan area cropper
                    cropperContainer.style.width = `${imageElement.naturalWidth}px`; // Sesuaikan lebar dengan gambar
                    cropperContainer.style.maxWidth = '100%'; // Pastikan tidak melampaui area layar

                    // Initialize Cropper
                    if (cropper) {
                        cropper.destroy(); // Hancurkan cropper lama jika ada
                    }
                    cropper = new Cropper(imageElement, {
                        aspectRatio: 1, // Rasio 1:1 (persegi)
                        viewMode: 2, // Agar gambar tidak melampaui container
                        responsive: true,
                        autoCropArea: 0.6,
                        background: false, // Menonaktifkan background agar tidak ada
                        cropBoxResizable: true, // Menambahkan kotak kecil untuk resize
                        ready: function() {
                            // Update crop box jika sudah siap
                            updatePreview();
                        },
                        cropend: function() {
                            // Update preview setelah crop
                            updatePreview();
                        }
                    });
                };
            };
            reader.readAsDataURL(file);
        }
    });

    // Function untuk memperbarui preview gambar setelah di-crop
    function updatePreview() {
        const canvas = cropper.getCroppedCanvas({
            width: 100, // Ukuran preview
            height: 100
        });
        const base64Image = canvas.toDataURL(); // Gambar dalam format base64
        previewImage.src = base64Image; // Update preview
        croppedAvatarInput.value = base64Image; // Simpan gambar yang sudah di-crop
    }
</script>
@endsection