@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Jurusan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('jurusan.index') }}">Data Jurusan</a></li>
                        <li class="breadcrumb-item active">Tambah Jurusan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <form action="{{ route('jurusan.store') }}" method="POST">
                @csrf
                <div class="card shadow-sm">
                    <div class="card-body">
                        <!-- Input untuk Nama Jurusan -->
                        <div class="form-group">
                            <label for="jurusan">Nama Jurusan <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="jurusan" 
                                   id="jurusan" 
                                   class="form-control @error('jurusan') is-invalid @enderror" 
                                   placeholder="Masukkan Nama Jurusan (misal: RPL 1)" 
                                   value="{{ old('jurusan') }}"
                                   required>
                            @error('jurusan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input untuk Deskripsi Jurusan -->
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi Jurusan <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="deskripsi" 
                                   id="deskripsi" 
                                   class="form-control @error('deskripsi') is-invalid @enderror" 
                                   placeholder="Masukkan Deskripsi Jurusan (misal: Rekayasa Perangkat Lunak)" 
                                   value="{{ old('deskripsi') }}"
                                   required>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="{{ route('jurusan.index') }}" class="btn btn-secondary">
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