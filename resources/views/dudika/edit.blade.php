@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit DUDIKA</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('dudika.index') }}">DUDIKA</a></li>
                        <li class="breadcrumb-item active">Edit DUDIKA</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('dudika.update', $dudika) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Input untuk Nama DUDIKA -->
                        <div class="form-group">
                            <label for="dudika">Nama DUDIKA <span class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control @error('dudika') is-invalid @enderror"
                                id="dudika"
                                name="dudika"
                                value="{{ old('dudika', $dudika->dudika) }}"
                                placeholder="Masukkan Nama DUDIKA"
                                required>
                            @error('dudika')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input untuk Alamat -->
                        <div class="form-group">
                            <label for="alamat">Alamat <span class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control @error('alamat') is-invalid @enderror"
                                id="alamat"
                                name="alamat"
                                value="{{ old('alamat', $dudika->alamat) }}"
                                placeholder="Masukkan Alamat DUDIKA"
                                required>
                            @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tambahkan field kontak -->
                        <div class="form-group">
                            <label for="kontak">Kontak</label>
                            <input type="text"
                                class="form-control"
                                id="kontak"
                                name="kontak"
                                value="{{ old('kontak', $dudika->kontak) }}"
                                placeholder="Masukkan nomor telepon/kontak">
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fas fa-save"></i> Update
                            </button>
                            <a href="{{ route('dudika.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validasi real-time untuk input
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('invalid', function() {
                this.classList.add('is-invalid');
            });

            input.addEventListener('input', function() {
                this.classList.remove('is-invalid');
            });
        });
    });
</script>
@endpush
@endsection