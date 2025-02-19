@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Murid</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('murid.index') }}">Data Murid</a></li>
                        <li class="breadcrumb-item active">Tambah Murid</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <form action="{{ route('murid.store') }}" method="POST">
                @csrf
                <div class="card shadow-sm">
                    <div class="card-body">
                        <!-- Input untuk Nama Murid -->
                        <div class="form-group">
                            <label for="nama_murid">Nama Murid <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="nama_murid" 
                                   id="nama_murid" 
                                   class="form-control @error('nama_murid') is-invalid @enderror" 
                                   placeholder="Masukkan Nama Murid" 
                                   value="{{ old('nama_murid') }}"
                                   required>
                            @error('nama_murid')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input untuk NIS -->
                        <div class="form-group">
                            <label for="nis">NIS <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="nis" 
                                   id="nis" 
                                   class="form-control @error('nis') is-invalid @enderror" 
                                   placeholder="Masukkan NIS Murid" 
                                   value="{{ old('nis') }}"
                                   required>
                            @error('nis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input untuk Kelas -->
                        <div class="form-group">
                            <label for="kelas">Kelas <span class="text-danger">*</span></label>
                            <select class="form-control @error('kelas') is-invalid @enderror" 
                                    id="kelas" 
                                    name="kelas" 
                                    required>
                                <option value="" disabled selected>Pilih Kelas</option>
                                @foreach($kelas as $k)
                                <option value="{{ $k }}" {{ old('kelas') == $k ? 'selected' : '' }}>
                                    {{ $k }}
                                </option>
                                @endforeach
                            </select>
                            @error('kelas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input untuk Jurusan -->
                        <div class="form-group">
                            <label for="jurusan_id">Jurusan <span class="text-danger">*</span></label>
                            <select class="form-control @error('jurusan_id') is-invalid @enderror" 
                                    id="jurusan_id" 
                                    name="jurusan_id" 
                                    required>
                                <option value="" disabled selected>Pilih Jurusan</option>
                                @foreach($jurusan as $j)
                                <option value="{{ $j->id }}" {{ old('jurusan_id') == $j->id ? 'selected' : '' }}>
                                    {{ $j->jurusan }}
                                </option>
                                @endforeach
                            </select>
                            @error('jurusan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="{{ route('murid.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Validasi real-time untuk input
        const inputs = document.querySelectorAll('input, select');
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