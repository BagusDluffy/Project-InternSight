@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Magang</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('magang.index') }}">Magang</a></li>
                        <li class="breadcrumb-item active">Tambah Magang</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <form action="{{ route('magang.store') }}" method="POST">
                @csrf
                <div class="card shadow-sm">
                    <div class="card-body">
                        <!-- Input untuk Jurusan -->
                        <div class="form-group">
                            <label for="jurusan_id">Jurusan <span class="text-danger">*</span></label>
                            <select
                                name="jurusan_id"
                                id="jurusan_id"
                                class="form-control @error('jurusan_id') is-invalid @enderror"
                                required>
                                <option value="" disabled selected>Pilih Jurusan</option>
                                @foreach($jurusan as $item)
                                <option
                                    value="{{ $item->id }}"
                                    {{ old('jurusan_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->jurusan }}
                                </option>
                                @endforeach
                            </select>
                            @error('jurusan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input untuk Kelas -->
                        <div class="form-group">
                            <label for="kelas">Kelas <span class="text-danger">*</span></label>
                            <select
                                name="kelas"
                                id="kelas"
                                class="form-control @error('kelas') is-invalid @enderror"
                                required>
                                <option value="" disabled selected>Pilih Kelas</option>
                                @foreach($kelas as $k)
                                <option
                                    value="{{ $k->kelas }}"
                                    {{ old('kelas') == $k->kelas ? 'selected' : '' }}>
                                    {{ $k->kelas }}
                                </option>
                                @endforeach
                            </select>
                            @error('kelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input untuk Murid -->
                        <div class="form-group">
                            <label>Nama Murid <span class="text-danger">*</span></label>
                            <div id="murid-container">
                                <div class="input-group mb-2">
                                    <select
                                        class="form-control murid-select @error('murid_id.0') is-invalid @enderror"
                                        name="murid_id[]"
                                        required>
                                        <option value="" disabled selected>Pilih Murid</option>
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-success add-murid">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    @error('murid_id.0')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Input untuk DUDIKA -->
                        <div class="form-group">
                            <label for="dudika_id">DUDIKA <span class="text-danger">*</span></label>
                            <select
                                name="dudika_id"
                                id="dudika_id"
                                class="form-control @error('dudika_id') is-invalid @enderror"
                                required>
                                <option value="" disabled selected>Pilih DUDIKA</option>
                                @foreach($dudika as $item)
                                <option
                                    value="{{ $item->id }}"
                                    {{ old('dudika_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->dudika }}
                                </option>
                                @endforeach
                            </select>
                            @error('dudika_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input untuk Guru Pembimbing -->
                        <div class="form-group">
                            <label for="guru_id">Guru Pembimbing <span class="text-danger">*</span></label>
                            <select
                                name="guru_id"
                                id="guru_id"
                                class="form-control @error('guru_id') is-invalid @enderror"
                                required>
                                <option value="" disabled selected>Pilih Guru Pembimbing</option>
                                @foreach($guru as $item)
                                <option
                                    value="{{ $item->id }}"
                                    {{ old('guru_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_guru }}
                                </option>
                                @endforeach
                            </select>
                            @error('guru_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input untuk Periode -->
                        <div class="form-group">
                            <label for="periode">Periode <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                name="periode"
                                id="periode"
                                class="form-control @error('periode') is-invalid @enderror"
                                value="{{ old('periode') }}"
                                placeholder="Masukkan Periode Magang"
                                required>
                            @error('periode')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="{{ route('magang.index') }}" class="btn btn-secondary">
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
    document.addEventListener('DOMContentLoaded', function() {
        const jurusanSelect = document.getElementById('jurusan_id');
        const kelasSelect = document.getElementById('kelas');
        const muridContainer = document.getElementById('murid-container');
        const addMuridButton = document.querySelector('.add-murid');
        let selectedMuridIds = [];

        // Function to get murid based on jurusan and kelas
        function getMurid(jurusanId, kelas, selectElement) {
    if (!jurusanId || !kelas) {
        selectElement.innerHTML = '<option value="" disabled selected>Pilih Murid</option>';
        return;
    }

    // Get murid that matches jurusan and kelas
    fetch(`/get-murid?jurusan_id=${jurusanId}&kelas=${kelas}`)
        .then(response => response.json())
        .then(response => {
            selectElement.innerHTML = '<option value="" disabled selected>Pilih Murid</option>';

            // Use response.data instead of directly using data
            const availableMurid = response.data.filter(murid => !selectedMuridIds.includes(murid.id));

            availableMurid.forEach(murid => {
                selectElement.add(new Option(murid.nama_murid, murid.id));
            });

            // Enable the murid dropdown and add button
            selectElement.disabled = false;
            addMuridButton.disabled = false;
        })
        .catch(error => {
            console.error('Error:', error);
            selectElement.innerHTML = '<option value="" disabled selected>Gagal memuat murid</option>';
        });
}

        // Function to update selected murid IDs
        function updateSelectedMuridIds() {
            selectedMuridIds = Array.from(
                    muridContainer.querySelectorAll('.murid-select')
                )
                .map(select => select.value)
                .filter(value => value !== '');
        }

        // Event listeners
        jurusanSelect.addEventListener('change', function() {
            const muridSelects = muridContainer.querySelectorAll('.murid-select');
            muridSelects.forEach(select => {
                getMurid(this.value, kelasSelect.value, select);
            });
        });

        kelasSelect.addEventListener('change', function() {
            const muridSelects = muridContainer.querySelectorAll('.murid-select');
            muridSelects.forEach(select => {
                getMurid(jurusanSelect.value, this.value, select);
            });
        });

        // Listener untuk update selected murid IDs
        muridContainer.addEventListener('change', function(e) {
            if (e.target.classList.contains('murid-select')) {
                updateSelectedMuridIds();
            }
        });

        // Function to add new murid select field
        addMuridButton.addEventListener('click', function() {
            const newMuridEntry = document.createElement('div');
            newMuridEntry.classList.add('input-group', 'mb-2');
            newMuridEntry.innerHTML = `
            <select class="form-control murid-select" name="murid_id[]" required>
                <option value="" disabled selected>Pilih Murid</option>
            </select>
            <div class="input-group-append">
                <button type="button" class="btn btn-danger remove-murid">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        `;

            // Tambahkan event listener untuk tombol hapus
            newMuridEntry.querySelector('.remove-murid').addEventListener('click', function() {
                newMuridEntry.remove();
                updateSelectedMuridIds();
            });

            // Tambahkan ke container
            muridContainer.appendChild(newMuridEntry);

            // Ambil murid untuk dropdown baru
            const newSelect = newMuridEntry.querySelector('.murid-select');
            getMurid(jurusanSelect.value, kelasSelect.value, newSelect);
        });

        // Inisialisasi dropdown pertama
        const initialSelect = document.querySelector('.murid-select');
        getMurid(jurusanSelect.value, kelasSelect.value, initialSelect);
    });
</script>
@endpush
@endsection