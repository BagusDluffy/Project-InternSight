@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Magang</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Data Magang</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
        </div>

        <!-- Add Magang Button and Export Button -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('magang.create') }}" class="btn btn-primary mr-2">
                            <i class="fas fa-plus"></i> Tambah Magang
                        </a>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('magang.export') }}" class="btn btn-success">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered table-striped" id="magangTable">
                    <thead>
                        <tr>
                            <th class="text-center align-middle">No</th>
                            <th class="text-center align-middle">Jurusan</th>
                            <th class="text-center align-middle">Kelas</th>
                            <th class="text-center align-middle">Nama Murid</th>
                            <th class="text-center align-middle">DUDIKA</th>
                            <th class="text-center align-middle">Guru Pembimbing</th>
                            <th class="text-center align-middle">Periode</th>
                            <th class="text-center align-middle">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($magang as $key => $item)
                        <tr>
                            <td class="text-center align-middle">{{ $key + 1 }}</td>
                            <td class="text-center align-middle">{{ $item->jurusan->jurusan }}</td>
                            <td class="text-center align-middle">{{ $item->kelas }}</td>
                            <td class="text-start">
                                @if ($item->murid->count() > 0)
                                <ul class="list-unstyled">
                                    @foreach ($item->murid as $murid)
                                    <li>• {{ $murid->nama_murid }}</li>
                                    @endforeach
                                </ul>
                                @else
                                @foreach ($item->murid as $murid)
                                {{ $murid->nama_murid }}
                                @endforeach
                                @endif
                            </td>
                            <td class="text-center align-middle">{{ $item->dudika->dudika }}</td>
                            <td class="text-center align-middle">{{ $item->guru->nama_guru }}</td>
                            <td class="text-center align-middle">{{ $item->periode }}</td>
                            <td class="text-center align-middle">
                                <div class="btn-group" role="group">
                                    <a href="#" class="btn btn-info btn-sm mr-1 btn-print"
                                        data-print-url="{{ route('magang.print-data', $item) }}">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <a href="{{ route('magang.edit', $item) }}"
                                        class="btn btn-warning btn-sm mr-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('magang.destroy', $item) }}" method="POST"
                                        class="delete-form d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm delete-button">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.28/dist/sweetalert2.min.css" rel="stylesheet">
<style>
    @page {
        size: A4 portrait;
        margin: 20mm;
        /* Sesuaikan margin sesuai kebutuhan */
    }

    .print-section {
        font-family: 'Times New Roman', Times, serif;
        font-size: 12pt;
        line-height: 1.5;
        width: 210mm;
        /* Lebar kertas A4 */
        max-width: 100%;
        margin: auto;
        padding: 10mm;
        /* Beri padding agar tidak mepet ke tepi */
    }

    .print-section .header {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        margin-bottom: 10px;
    }

    .print-section .header img {
        max-width: 120px;
    }

    .print-section hr {
        border-top: 3px double #000;
        margin: 10px 0;
    }

    .print-section table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
    }

    .print-section table th,
    .print-section table td {
        border: 1px solid #000;
        padding: 5px;
        text-align: left;
    }

    @media print {
        body * {
            visibility: hidden;
        }

        .print-section,
        .print-section * {
            visibility: visible;
        }

        .print-section {
            position: relative;
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.28/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        // DataTable configuration stays the same
        $('#magangTable').DataTable({
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ada data ditemukan",
                "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                "infoEmpty": "Tidak ada data tersedia",
                "infoFiltered": "(disaring dari _MAX_ total data)",
                "search": "Cari:",
                "paginate": {
                    "next": "Berikutnya",
                    "previous": "Sebelumnya"
                }
            }
        });

        $('.btn-print').on('click', function(e) {
            e.preventDefault();
            const url = $(this).data('print-url');
            const dudikaId = $(this).data('dudika-id');

            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    dudika_id: dudikaId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.error
                        });
                        return;
                    }

                    const printWindow = window.open('', '_blank');
                    printWindow.document.write(`
                        <!DOCTYPE html>
                        <html>
                            <head>
                                <meta charset="UTF-8">
                                <title>Cetak Laporan Magang</title>
                                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                                <style>
                                    @page {
                                        size: A4;
                                        margin: 0;
                                    }
                                    
                                    * {
                                        margin: 0;
                                        padding: 0;
                                        box-sizing: border-box;
                                    }

                                    body {
                                        width: 100%;
                                        display: flex;
                                        justify-content: center;
                                        background-color: #f0f0f0;
                                        padding: 20px;
                                    }

                                    .print-wrapper {
                                        background: white;
                                        width: 210mm;
                                        min-height: 297mm;
                                        margin: 0 auto;
                                        box-shadow: 0 0 10px rgba(0,0,0,0.1);
                                        position: relative;
                                    }

                                    .print-content {
                                        padding: 15mm 15mm 15mm;
                                        position: relative;
                                    }

                                    .header {
                                        display: flex;
                                        align-items: flex-start;
                                        margin-bottom: 20px;
                                        position: relative;
                                        padding-bottom: 10px;
                                    }

                                    .logo-container {
                                        width: 100px;
                                        margin-right: 20px;
                                    }

                                    .logo-container img {
                                        width: 100%;
                                        height: auto;
                                        margin-left:65px;
                                    }

                                    .header-text {
                                        flex: 1;
                                        text-align: center;
                                    }

                                    .header-divider {
                                        border-top: 2px solid black;
                                        margin: 10px 0;
                                    }

                                    .table-bordered th, 
                                    .table-bordered td {
                                        border: 1px solid black !important;
                                        padding: 8px;
                                    }

                                    .borderless-table td {
                                        border: none !important;
                                        padding: 5px 0;
                                    }

                                    .findings {
                                        border: 1px solid black;
                                        border-top: none;
                                        padding: 15px;
                                        margin-top: -1px;
                                    }

                                    .findings ol {
                                        margin: 0;
                                        padding-left: 20px;
                                    }

                                    .findings li {
                                        padding: 5px 0;
                                    }

                                    @media print {
                                        body {
                                            background: none;
                                            padding: 0;
                                            margin: 0;
                                        }

                                        .print-wrapper {
                                            box-shadow: none;
                                            margin: 0;
                                            width: 100%;
                                            min-height: auto;
                                        }

                                        .print-content {
                                            padding: 10mm;
                                        }
                                        
                                        @-moz-document url-prefix() {
                                            body {
                                                size: A4;
                                                margin: 0;
                                            }
                                        }
                                    }
                                </style>
                            </head>
                            <body>
                                <div class="print-wrapper">
                                    <div class="print-content">
                                        <div class="header">
                                            <div class="logo-container">
                                                <img src="{{ asset('assets/laporan-icon.png') }}" alt="Logo SMKN 10">
                                            </div>
                                            <div class="header-text">
                                                <h2 class="font-weight-bold mb-0">PEMERINTAH PROVINSI JAWA TIMUR</h2>
                                                <h2 class="font-weight-bold mb-2">DINAS PENDIDIKAN</h2>
                                                <h5 class="mb-1">SEKOLAH MENENGAH KEJURUAN NEGERI 10 SURABAYA</h5>
                                                <h6 class="mb-2">JL. KEPUTIH TEGAL TELP.FAX 5939581 EMAIL info@smkn10surabaya.sch.id</h6>
                                            </div>
                                        </div>
                                        
                                        <div class="header-divider"></div>

                                        <h2 class="text-center font-weight-bold mt-4 mb-2">DAFTAR MONITORING</h2>
                                        <h2 class="text-center font-weight-bold mb-4">PRAKTIK KERJA LAPANGAN</h2>

                                        <table class="borderless-table w-100 mb-4">
                                            <tr>
                                                <td width="30%">Nama Perusahaan</td>
                                                <td>: ${response.dudika}</td>
                                            </tr>
                                            <tr>
                                                <td>Alamat Perusahaan</td>
                                                <td>: ${response.alamat}</td>
                                            </tr>
                                            <tr>
                                                <td>Contact Person</td>
                                                <td>: ${response.kontak}</td>
                                            </tr>
                                        </table>

                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-center align-middle" width="5%">No</th>
                                                    <th class="text-center align-middle" width="20%">HARI/TANGGAL</th>
                                                    <th class="text-center align-middle" width="30%">TUJUAN/KETERANGAN</th>
                                                    <th class="text-center align-middle" width="22.5%">FOTO KUNJUNGAN</th>
                                                    <th class="text-center align-middle" width="22.5%">TANDA TANGAN & CAP INSTANSI</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                ${generateLaporanHtml(response.laporan)}
                                            </tbody>
                                        </table>

                                        ${generateFindingsHtml(response.laporan)}

                                        <div class="row mt-5">
                                            <div class="col-8"></div>
                                            <div class="col-4 text-center">
                                                <p>Surabaya,.........................</p>
                                                <p>Guru Pembimbing,</p>
                                                <div style="height: 100px;"></div>
                                                <p><u>${response.guru}</u></p>
                                                <p>NIP. ${response.nip || '-'}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    window.onload = function() {
                                        const mediaQueryList = window.matchMedia('print');
                                        mediaQueryList.addListener(function(mql) {
                                            if (mql.matches) {
                                                document.title = ""; // Menghapus judul dokumen saat mencetak
                                            }
                                        });
                                        
                                        window.print();
                                        setTimeout(function() {
                                            window.close();
                                        }, 100);
                                    }
                                <\/script>
                            </body>
                        </html>
                    `);
                    printWindow.document.close();

                    function generateLaporanHtml(laporan) {
                        if (!laporan || laporan.length === 0) {
                            return Array(4).fill().map((_, i) => `
                                <tr>
                                    <td class="text-center">${i + 1}</td>
                                    <td>Belum diisi</td>
                                    <td>Belum ada keterangan</td>
                                    <td class="text-center">Tidak ada foto</td>
                                    <td class="text-center">Tidak ada tanda tangan</td>
                                </tr>
                            `).join('');
                        }

                        return laporan.map((lap, index) => {
                            let keteranganDetail = lap.keterangan || 'Belum ada keterangan';
                            return `
                                <tr>
                                    <td class="text-center align-middle">${index + 1}</td>
                                    <td class="text-center align-middle">${lap.hari_tanggal || 'Belum diisi'}</td>
                                    <td class="text-center align-middle">${keteranganDetail}</td>
                                    <td class="text-center">
                                        ${lap.foto ? `<img src="${lap.foto}" alt="Foto Kunjungan" class="img-fluid" style="max-width: 100px; max-height: 100px; object-fit: cover;">` : 'Tidak ada foto'}
                                    </td>
                                    <td class="text-center">
                                        ${lap.tanda_tangan ? `<img src="${lap.tanda_tangan}" alt="Tanda Tangan" class="img-fluid" style="max-width: 100px; max-height: 100px; object-fit: cover;">` : 'Tidak ada tanda tangan'}
                                    </td>
                                </tr>`;
                        }).join('');
                    }

                    function generateFindingsHtml(laporan) {
                        let findingsContent = '';
                        if (laporan && laporan.length > 0) {
                            const groupedFindings = laporan.reduce((acc, lap) => {
                                if (lap.laporan_siswa && lap.laporan_siswa.length > 0) {
                                    acc.push(lap.laporan_siswa.filter(item => item).join(', '));
                                }
                                return acc;
                            }, []);

                            findingsContent = groupedFindings.length > 0 ?
                                groupedFindings.map((finding, index) => `<li>${finding}</li>`).join('') :
                                Array(4).fill('<li>....................................................</li>').join('');
                        } else {
                            findingsContent = Array(4).fill('<li>....................................................</li>').join('');
                        }

                        return `
                            <div class="findings">
                                <h5 class="font-weight-bold">Temuan Waktu Kunjungan</h5>
                                <ol>${findingsContent}</ol>
                            </div>
                        `;
                    }
                }
            });
        });

        // Delete confirmation stays the same
        $('.delete-button').on('click', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');

            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Data jurusan akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
@endsection